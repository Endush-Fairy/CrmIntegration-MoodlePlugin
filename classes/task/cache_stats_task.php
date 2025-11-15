<?php
// This file is part of Moodle - http://moodle.org/
//
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
 *Code for Crm Integration plugin.
 *
 * @package    local_crm_integration
 * @copyright  2025 Endush Fairy <endush.fairy@paktaleem.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_crm_integration\task;
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/local/crm_integration/lib.php');

class cache_stats_task extends \core\task\scheduled_task {
/**
* Get the name of the task.
*
* @return string
*/
public function get_name() {
return get_string('cachename', 'local_crm_integration');
}

/**
* This is the main method that will be executed.
*/
public function execute() {
global $DB;
mtrace('Executing CRM stats caching task...');
$api_token = ''; // Your API token
$endpoints = ['customers', 'projects', 'tasks', 'leads'];
foreach ($endpoints as $endpoint) {
mtrace("Fetching data for: {$endpoint}");
$data = local_crm_integration_call_api($endpoint, $api_token);
$count = (is_array($data) && !isset($data['error'])) ? count($data) : 0;
$existing_record = $DB->get_record('local_crm_stats_cache', ['stat_key' => $endpoint]);
if ($existing_record) {
$existing_record->stat_value = $count;
$existing_record->timemodified = time();
$DB->update_record('local_crm_stats_cache', $existing_record);
mtrace("Updated '{$endpoint}' with value: {$count}");
} else {
$new_record = new \stdClass();
$new_record->stat_key = $endpoint;
$new_record->stat_value = $count;
$new_record->timemodified = time();
$DB->insert_record('local_crm_stats_cache', $new_record);
mtrace("Inserted '{$endpoint}' with value: {$count}");
}
}
mtrace('CRM stats caching task finished.');
}
}