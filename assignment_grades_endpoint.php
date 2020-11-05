<?php

require_once('webservice_base.php');

class assignment_grades_endpoint
{
    public static function get_assignment_grades_parameters()
    {
        return new external_function_parameters(
            array(
                't' => new external_value(PARAM_TEXT, 'The user token"', VALUE_DEFAULT, 0),));
    }

    public static function get_assignment_grades_returns() {
        return new external_value(PARAM_RAW, 'JSON mock data');
    }

    public static function get_assignment_grades($t) {

        $filter_by_grade = function($grade) {
            return function($item) use ($grade) {
                return $item->name == $grade;
            };
        };

        $credentials = webservice_base::getValidCredentials($t);
        if (empty($credentials)) {
            return json_encode([]);
        }

        $courseData = gradereport_user_external::get_grade_items($credentials->courseId);
        $numOfAssignments = count($courseData['usergrades'][0]['gradeitems']);
        $userGradesByAssignment = [];
        $currentIndex = 0;

        for ($i = 0; $i < $numOfAssignments - 1; $i++) {
            // Create new array for each assignment

            $assignedGrades = [];
            $userGrade = null;

            foreach ($courseData['usergrades'] as $user) {
                $selected = (int)$user['userid'] === (int)$credentials->userId;
                $gradeFormatted = $user['gradeitems'][$i]['gradeformatted'];
                $grade = !is_numeric($gradeFormatted) ? $gradeFormatted : $user['gradeitems'][$i]['lettergradeformatted'];
                if ($selected){
                    $userGrade = $grade;
                }

                $output = array_filter($assignedGrades, $filter_by_grade($grade));
                if (empty($output)) {
                    $obj = new StdClass();
                    $obj->name = $grade;
                    $obj->value = 1;
                    array_push($assignedGrades, $obj);
                } else {
                    foreach ($assignedGrades as $assignedGrade) {
                        if($assignedGrade->name == $grade){
                            $assignedGrade->value++;
                            break;
                        }
                    }
                }
            }
            if (count($assignedGrades) != 1 && $assignedGrades[0]->value != "-"){
                $userGradesByAssignment[$currentIndex] = [];
                $assignmentResult = new StdClass();
                $assignmentResult->user_grade = $userGrade;
                $assignmentResult->grades = $assignedGrades;
                $userGradesByAssignment[$currentIndex] = $assignmentResult;
                $currentIndex++;
            }
        }
        return json_encode($userGradesByAssignment);
    }
}