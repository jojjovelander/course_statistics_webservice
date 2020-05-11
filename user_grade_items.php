<?php

require_once('webservice_base.php');

class user_grade_items {

    public static function get_user_grade_items_by_course_parameters()
    {
        return new external_function_parameters(
            array(
                't' => new external_value(PARAM_TEXT, 'The user token"', VALUE_DEFAULT, 0),));
    }

    public static function get_user_grade_items_by_course_returns() {
        return new external_value(PARAM_RAW, 'Returns a JSON object of all of a user\'s assignment grades VS average grades in a particular course.');
    }

    public static function get_user_grade_items_by_course($t) {
        $credentials = webservice_base::getValidCredentials($t);
        if (empty($credentials)) {
            return json_encode([]);
        }

        $courseData = gradereport_user_external::get_grade_items($credentials->courseId, $credentials->userId);
        $gradeItems = $courseData['usergrades'][0]['gradeitems'];
        $jsonGradeResponse = [];
        $i = 1;
        foreach ($gradeItems as $gradeItem) {
            if ($gradeItem['itemtype'] == 'mod') {
                $obj = self::generateAssignmentObject($i);
                array_push($obj->series, self::generateUserAssignmentGradeObject($gradeItem['gradeformatted'], "Grade"));
                array_push($obj->series, self::generateUserAssignmentGradeObject($gradeItem['averageformatted'], "Average"));
                array_push($jsonGradeResponse, $obj);
                $i++;
            }
        }
        return json_encode($jsonGradeResponse, JSON_UNESCAPED_SLASHES);
    }

    public static function generateUserAssignmentGradeObject($grade, $gradeType) {
        $obj = new StdClass();
        $obj->value = $grade == "-" ? (float)0.0 : (float)$grade;
        $obj->name = $gradeType;
        return $obj;
    }

    private static function generateAssignmentObject(int $i) {
        $obj = new StdClass();
        $obj->name = "Assigment $i";
        $obj->series = [];
        return $obj;
    }
}