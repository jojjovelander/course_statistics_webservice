<?php

class ip_data {

    public static function get_ip_data_parameters() {
        return new external_function_parameters(
            array(
                'courseid' => new external_value(PARAM_TEXT, 'The course id"', VALUE_DEFAULT, 0),
                'userid' => new external_value(PARAM_TEXT, 'The user id"', VALUE_DEFAULT, 0),));
    }

    public static function get_ip_data_returns() {
        return new external_value(PARAM_RAW, 'Returns a JSON object of all unique IPs of a particular user in a course.');
    }

    public static function get_ip_data($courseid, $userid) {
        global $DB;
        $results = $DB->get_records_sql('SELECT DISTINCT ON (l.ip) l.ip, l.timecreated, t3.count
                    FROM (SELECT ip, MAX(timecreated) AS mx
                          FROM m_logstore_standard_log
                          WHERE courseid = :c1
                            AND userid = :u1
                          GROUP BY ip
                         ) t
                             JOIN m_logstore_standard_log l ON l.ip = t.ip AND t.mx = l.timecreated
                             JOIN (SELECT ip, COUNT(ip) as count
                                   FROM m_logstore_standard_log
                                    WHERE courseid = :c2
                                    AND userid = :u2
                                   GROUP BY ip) t3 ON l.ip = t3.ip
                    WHERE l.courseid = :c3
                      AND l.userid = :u3',
            ['c1' => $courseid, 'u1' => $userid, 'c2' => $courseid, 'u2' => $userid, 'c3' => $courseid, 'u3' => $userid]);

        $outputArray = [];
        foreach ($results as $k => $v) {
            array_push($outputArray, self::generateIPDataObject($v));
        }
        return json_encode($outputArray);
    }

    public static function generateIPDataObject($record) {
        $obj = new StdClass();
        $obj->ip = $record->ip;
        $obj->timecreated = (int)$record->timecreated;
        $obj->count = (int)$record->count;
        return $obj;
    }
}
