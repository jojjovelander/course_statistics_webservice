<?php

require_once ('webservice_base.php');

class general_info
{
    public static function get_general_info_parameters() {
        return new external_function_parameters(
            array(
                't' => new external_value(PARAM_TEXT, 'The user token"', VALUE_DEFAULT, 0),));
    }

    public static function get_general_info_returns() {
        return new external_value(PARAM_RAW, 'Returns a JSON object of general course and user data.');
    }

    public static function get_general_info($t)
    {
        $obj = new StdClass();
        $credentials = webservice_base::getValidCredentials($t);
        if (empty($credentials)) {
            return json_encode($obj);
        }

        global $DB;
        $result = $DB->get_record_sql('SELECT l.shortname FROM m_course l WHERE l.id = :courseid',
            ['courseid' => $credentials->courseId]);

        $obj->course = $result->shortname;
        return json_encode($obj);
    }
}
