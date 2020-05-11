<?php

require_once('webservice_base.php');

class assignment_grades_endpoint
{
    public static function get_assignment_grades_parameters() {
        return new external_function_parameters(
            array(
                't' => new external_value(PARAM_TEXT, 'The user token"', VALUE_DEFAULT, 0),));
    }

    public static function get_assignment_grades_returns() {
        return new external_value(PARAM_RAW, 'JSON mock data');
    }

    public static function get_assignment_grades($t) {

        $credentials = webservice_base::getValidCredentials($t);
        if (empty($credentials)) {
            return json_encode([]);
        }

        $courseData = gradereport_user_external::get_grade_items($credentials->courseId);

        $numOfAssignments = count($courseData['usergrades'][0]['gradeitems']);
        $userGradesByAssignment = [];

        for ($i = 0; $i < $numOfAssignments - 1; $i++) {
            // Create new array for each assignment
            $userGradesByAssignment[$i] = [];

            $j = 0;
            foreach ($courseData['usergrades'] as $user) {
                $selected = (int)$user['userid'] === (int)$credentials->userId;

                $gradeObject = self::generateGradeObject($user['gradeitems'][$i]['gradeformatted'], ($selected ? 'You' : " Student " . (++$j)), $selected);
                array_push($userGradesByAssignment[$i], $gradeObject);
            }
            sort($userGradesByAssignment[$i]);
        }
        return json_encode($userGradesByAssignment);
    }
    public static function generateGradeObject($grade, $studentName, $selected)
    {
        $obj = new StdClass();
        $obj->value = $grade == "-" ? (float)0.0 : (float)$grade;
        $obj->name = $studentName;
        $obj->selected = $selected;
        return $obj;
    }
}