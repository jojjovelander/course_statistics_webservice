<?php

class assignment_grades_endpoint
{
    public static function get_assignment_grades_parameters() {
        return new external_function_parameters(
            array(
                'courseid' => new external_value(PARAM_TEXT, 'The course id"', VALUE_DEFAULT, 0),
                'userid' => new external_value(PARAM_TEXT, 'The user id"', VALUE_DEFAULT, 0),));
    }

    public static function get_assignment_grades_returns() {
        return new external_value(PARAM_RAW, 'JSON mock data');
    }

    public static function get_assignment_grades($courseId, $userId) {
        $courseData = gradereport_user_external::get_grade_items($courseId);

        $numOfAssignments = count($courseData['usergrades'][0]['gradeitems']);
        $userGradesByAssignment = [];

        for ($i = 0; $i < $numOfAssignments - 1; $i++) {
            // Create new array for each assignment
            $userGradesByAssignment[$i] = [];

            foreach ($courseData['usergrades'] as $user) {
                // Here we have a user
                $test = self::generateGradeObject($user['gradeitems'][$i]['gradeformatted'], $user['userfullname']/*"Student " . ($j + 1)*/);
                array_push($userGradesByAssignment[$i], $test);
            }
        }
        return json_encode($userGradesByAssignment);
    }
    public static function generateGradeObject($grade, $studentName)
    {
        $obj = new StdClass();
        $obj->value = $grade == "-" ? (float)0.0 : (float)$grade;
        $obj->name = $studentName;
        return $obj;
    }
}