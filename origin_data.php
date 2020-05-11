<?php

require_once ('webservice_base.php');
class origin_data
{
    public static function get_origin_data_parameters() {
        return new external_function_parameters(
            array(
                't' => new external_value(PARAM_TEXT, 'The user token"', VALUE_DEFAULT, 0),));
    }

    public static function get_origin_data_returns() {
        return new external_value(PARAM_RAW, 'Returns a JSON object of all events for a user for a particular course.');
    }

    public static function get_origin_data($t)
    {
        $credentials = webservice_base::getValidCredentials($t);
        if (empty($credentials)) {
            return json_encode([]);
        }
        global $DB;
        $results = $DB->get_records_sql('SELECT l.origin, COUNT(*) as count
                                    FROM m_logstore_standard_log l
                                    WHERE l.courseid = :courseid AND l.userid = :userid
                                    GROUP BY l.origin ORDER BY count DESC',
            ['courseid' => $credentials->courseId, 'userid' => $credentials->userId]);

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
