<?php

class user_events_over_time
{
    public static function get_user_events_over_time_parameters()
    {
        return new external_function_parameters(
            array(
                'courseid' => new external_value(PARAM_TEXT, 'The course id"', VALUE_DEFAULT, 0),
                'userid' => new external_value(PARAM_TEXT, 'The user id"', VALUE_DEFAULT, 0),));
    }

    public static function get_user_events_over_time_returns()
    {
        return new external_value(PARAM_RAW, 'Returns a JSON object of the top 5 user events for a particular course over time.');
    }

    public static function get_user_events_over_time($courseid, $userid)
    {
        global $DB;

        $results = $DB->get_records_sql('SELECT uuid_in(md5(random()::text || now()::text)::cstring) as id, l.eventname, TO_CHAR(TO_TIMESTAMP(l.timecreated), \'DD/MM/YYYY\') as date, COUNT(*) AS num
FROM m_logstore_standard_log l
WHERE userid = :u1
  AND courseid = :c1
  AND l.eventname = ANY (SELECT eventname
                         FROM (SELECT eventname, COUNT(*) as count
                               FROM m_logstore_standard_log
                               WHERE courseid = :c2
                                 AND userid = :u2
                               GROUP BY eventname
                               ORDER BY count DESC
                               LIMIT 5) as countedEvents)
GROUP BY l.eventname, TO_CHAR(TO_TIMESTAMP(l.timecreated), \'DD/MM/YYYY\')',
            ['c1' => $courseid, 'u1' => $userid, 'c2' => $courseid, 'u2' => $userid, 'c3' => $courseid, 'u3' => $userid]);

        $outputArray = [];

        $previous = null;
        $i = 0;
        $j = 0;
        foreach ($results as $result) {

            if ($previous != $result->eventname) {
                if ($previous != null) {
                    usort($outputArray[$i]->series, function ($a, $b) {
                        return $a->timestamp - $b->timestamp;
                    });
                    $i++;
                }
                $previous = $result->eventname;
                array_push($outputArray, self::generateEventObject($result->eventname));
                $j = 0;
            }
            array_push($outputArray[$i]->series, self::generateUserEventObject($result));
            $j++;
        }
        return json_encode($outputArray);
    }

    public static function generateUserEventObject($record)
    {
        $obj = new StdClass();
        $dtime = DateTime::createFromFormat("d/m/Y", $record->date);
        if ($dtime) {
            $obj->timestamp = $dtime->getTimestamp();
        }
        $obj->name = $record->date;
        $obj->value = (int)$record->num;
        return $obj;
    }

    private static function generateEventObject(string $eventName)
    {
        $obj = new StdClass();
        $spiltArray = explode("\\", $eventName);
        $obj->name = $spiltArray[sizeof($spiltArray) - 1];
        $obj->series = [];
        return $obj;
    }
}
