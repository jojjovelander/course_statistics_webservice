<?php

class general_info
{
    public static function get_general_info_parameters() {
        return new external_function_parameters(
            array(
                'courseid' => new external_value(PARAM_TEXT, 'The course id"', VALUE_DEFAULT, 0),
                'userid' => new external_value(PARAM_TEXT, 'The user id"', VALUE_DEFAULT, 0),));
    }

    public static function get_general_info_returns() {
        return new external_value(PARAM_RAW, 'Returns a JSON object of general course and user data.');
    }

    public static function get_general_info($courseid, $userid)
    {
        global $DB;
        $result = $DB->get_record_sql('SELECT l.shortname FROM m_course l WHERE l.id = :courseid',
            ['courseid' => $courseid]);

       /* print_object($result);*/
        $obj = new StdClass();
        $obj->course = $result->shortname;

        return json_encode($obj);
    }
}
