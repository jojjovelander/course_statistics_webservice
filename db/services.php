<?php

// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

$functions = array(
    'local_course_statistics_webservice_get_user_events' => array(
        'classname' => 'local_course_statistics_webservice_external',
        'methodname' => 'get_user_events',
        'classpath' => 'local/course_statistics_webservice/externallib.php',
        'description' => 'Returns a JSON object of all events for a user for a particular course.',
        'type' => 'read',
    ),

    'local_course_statistics_webservice_get_assignment_grades' => array(
        'classname' => 'local_course_statistics_webservice_external',
        'methodname' => 'get_assignment_grades',
        'classpath' => 'local/course_statistics_webservice/externallib.php',
        'description' => 'Returns a JSON object of all of a user\'s assignment grades VS average grades in a particular course.',
        'type' => 'read',
    ),

    'local_course_statistics_webservice_get_user_grade_items_by_course' => array(
        'classname' => 'local_course_statistics_webservice_external',
        'methodname' => 'get_user_grade_items_by_course',
        'classpath' => 'local/course_statistics_webservice/externallib.php',
        'description' => 'Returns a JSON object of all of a user\'s assignments\' grades in a particular course.',
        'type' => 'read',
    ),

    'local_course_statistics_webservice_get_ip_data' => array(
        'classname' => 'local_course_statistics_webservice_external',
        'methodname' => 'get_ip_data',
        'classpath' => 'local/course_statistics_webservice/externallib.php',
        'description' => 'Returns a JSON object of all unique IPs of a particular user in a course.',
        'type' => 'read',
    )
);

// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = array(
    'Course Statistics Service' => array(
        'functions' => array('local_course_statistics_webservice_get_user_events', 'local_course_statistics_webservice_get_assignment_grades',
            'local_course_statistics_webservice_get_user_grade_items_by_course', 'local_course_statistics_webservice_get_ip_data'),
        'restrictedusers' => 0,
        'enabled' => 1,
    )
);
