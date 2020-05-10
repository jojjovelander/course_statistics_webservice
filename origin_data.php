<?php

class origin_data
{
    public static function get_origin_data_parameters() {
        return new external_function_parameters(
            array(
                'courseid' => new external_value(PARAM_TEXT, 'The course id"', VALUE_DEFAULT, 0),
                'userid' => new external_value(PARAM_TEXT, 'The user id"', VALUE_DEFAULT, 0),));
    }

    public static function get_origin_data_returns() {
        return new external_value(PARAM_RAW, 'Returns a JSON object of all events for a user for a particular course.');
    }

    public static function get_origin_data($courseid, $userid)
    {
        global $DB;
        $results = $DB->get_records_sql('SELECT l.origin, COUNT(*) as count
                                    FROM m_logstore_standard_log l
                                    WHERE l.courseid = :courseid AND l.userid = :userid
                                    GROUP BY l.origin ORDER BY count DESC',
            ['courseid' => $courseid, 'userid' => $userid]);

        $outputArray = [];
        $i = 0;
        foreach ($results as $result) {
            $outputArray[$i] = self::generateOriginDataObject($result);
            $i++;
        }

        return json_encode($outputArray);
    }

    public static function generateOriginDataObject($record) {
        $obj = new StdClass();
        $obj->name = $record->origin;
        $obj->value = (int)$record->count;
        return $obj;
    }
}
