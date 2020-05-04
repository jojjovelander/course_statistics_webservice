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

/**
 * External Web Service Template
 *
 * @package    localcourse_statistics_webservice
 * @copyright  2011 Moodle Pty Ltd (http://moodle.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->dirroot . '/user/externallib.php');
require_once($CFG->dirroot . '/grade/report/user/externallib.php');
require_once($CFG->dirroot . '/mod/forum/externallib.php');
require_once($CFG->dirroot . '/grade/report/user/externallib.php');
require_once($CFG->dirroot . '/grade/lib.php');
require_once($CFG->dirroot . '/grade/report/user/lib.php');
require_once($CFG->dirroot . '/grade/report/user/lib.php');
require_once('assignment_grades_endpoint.php');
require_once('user_grade_items.php');
require_once('ip_data.php');
require_once('user_events.php');

class local_course_statistics_webservice_external extends external_api
{
    public static function get_assignment_grades_parameters(){
        return assignment_grades_endpoint::get_assignment_grades_parameters();
    }

    public static function get_assignment_grades_returns(){
        return assignment_grades_endpoint::get_assignment_grades_returns();
    }

    public static function get_assignment_grades($courseid, $userid) {
        return assignment_grades_endpoint::get_assignment_grades($courseid, $userid);
    }

    public static function get_user_grade_items_by_course_parameters() {
        return user_grade_items::get_user_grade_items_by_course_parameters();
    }

    public static function get_user_grade_items_by_course_returns() {
        return user_grade_items::get_user_grade_items_by_course_returns();
    }

    public static function get_user_grade_items_by_course($courseid, $userid) {
        return user_grade_items::get_user_grade_items_by_course($courseid,$userid);
    }

    public static function get_ip_data_parameters() {
        return ip_data::get_ip_data_parameters();
    }

    public static function get_ip_data_returns() {
        return ip_data::get_ip_data_returns();
    }

    public static function get_ip_data($courseid, $userid) {
        return ip_data::get_ip_data($courseid, $userid);
    }

    public static function get_user_events_parameters() {
        return user_events::get_user_events_parameters();
    }

    public static function get_user_events_returns() {
        return user_events::get_user_events_returns();
    }

    public static function get_user_events($courseid, $userid) {
        return user_events::get_user_events($courseid, $userid);
    }
}