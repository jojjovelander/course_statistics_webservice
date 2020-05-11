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
require_once($CFG->dirroot . '/mod/forum/externallib.php');
require_once($CFG->dirroot . '/grade/report/user/externallib.php');
require_once($CFG->dirroot . '/grade/lib.php');
require_once($CFG->dirroot . '/grade/report/user/lib.php');
require_once('assignment_grades_endpoint.php');
require_once('user_grade_items.php');
require_once('ip_data.php');
require_once('user_events.php');
require_once('user_events_over_time.php');
require_once('general_info.php');
require_once('origin_data.php');

class local_course_statistics_webservice_external extends external_api
{
    public static function get_assignment_grades_parameters(){
        return assignment_grades_endpoint::get_assignment_grades_parameters();
    }

    public static function get_assignment_grades_returns(){
        return assignment_grades_endpoint::get_assignment_grades_returns();
    }

    public static function get_assignment_grades($t) {
        return assignment_grades_endpoint::get_assignment_grades($t);
    }

    public static function get_user_grade_items_by_course_parameters() {
        return user_grade_items::get_user_grade_items_by_course_parameters();
    }

    public static function get_user_grade_items_by_course_returns() {
        return user_grade_items::get_user_grade_items_by_course_returns();
    }

    public static function get_user_grade_items_by_course($t) {
        return user_grade_items::get_user_grade_items_by_course($t);
    }

    public static function get_ip_data_parameters() {
        return ip_data::get_ip_data_parameters();
    }

    public static function get_ip_data_returns() {
        return ip_data::get_ip_data_returns();
    }

    public static function get_ip_data($t) {
        return ip_data::get_ip_data($t);
    }

    public static function get_user_events_parameters() {
        return user_events::get_user_events_parameters();
    }

    public static function get_user_events_returns() {
        return user_events::get_user_events_returns();
    }

    public static function get_user_events($t) {
        return user_events::get_user_events($t);
    }

    public static function get_user_events_over_time_parameters() {
        return user_events_over_time::get_user_events_over_time_parameters();
    }

    public static function get_user_events_over_time_returns() {
        return user_events_over_time::get_user_events_over_time_returns();
    }

    public static function get_user_events_over_time($t) {
        return user_events_over_time::get_user_events_over_time($t);
    }

    public static function get_general_info_parameters() {
        return general_info::get_general_info_parameters();
    }

    public static function get_general_info_returns() {
        return general_info::get_general_info_returns();
    }

    public static function get_general_info($t) {
        return general_info::get_general_info($t);
    }

    public static function get_origin_data_parameters() {
        return origin_data::get_origin_data_parameters();
    }

    public static function get_origin_data_returns() {
        return origin_data::get_origin_data_returns();
    }

    public static function get_origin_data($t) {
        return origin_data::get_origin_data($t);
    }

}