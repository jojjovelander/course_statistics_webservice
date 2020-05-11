<?php

require_once('webservice_base.php');

class user_events
{
    public static function get_user_events_parameters() {
        return new external_function_parameters(
            array(
                't' => new external_value(PARAM_TEXT, 'The user token"', VALUE_DEFAULT, 0),));
    }

    public static function get_user_events_returns() {
        return new external_value(PARAM_RAW, 'Returns a JSON object of all events for a user for a particular course.');
    }

    public static function get_user_events($t)
    {
        $credentials = webservice_base::getValidCredentials($t);
        if (empty($credentials)) {
            return json_encode([]);
        }
        global $DB;
        $results = $DB->get_records_sql('SELECT l.eventname, l.component, COUNT(*) as count
                                    FROM m_logstore_standard_log l
                                    INNER JOIN {user} u ON u.id = l.userid
                                    WHERE l.courseid = :courseid AND l.userid = :userid
                                    GROUP BY l.component, l.eventname ORDER BY count DESC',
            ['courseid' => $credentials->courseId, 'userid' => $credentials->userId]);

        $outputArray = Array();
        $i = 0;

        foreach ($results as $result) {
            $outputArray[$i] = self::generateUserEventObject($result);
            $i++;
        }

        usort($outputArray, function ($a, $b) {
            return $b->value - $a->value;
        });

        return json_encode(array_slice($outputArray, 0, 10));
    }

    public static function generateUserEventObject($record) {
        $obj = new StdClass();
        $spiltArray = explode("\\", $record->eventname);
        $obj->name = $spiltArray[sizeof($spiltArray) - 1];
        $obj->value = (int)$record->count;
        return $obj;
    }
}
