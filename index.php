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
 * @copyright  2025 PakTaleem (https://www.paktaleem.com/)
 * @author     Endush Fairy <endush.fairy@paktaleem.net>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

$PAGE->set_url(new moodle_url('/local/crm_integration/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('plugintitle', 'local_crm_integration'));
$PAGE->set_heading(get_string('pluginheading', 'local_crm_integration'));
$PAGE->navbar->add(get_string('navlink', 'local_crm_integration'));

echo $OUTPUT->header();
$cached_data = $DB->get_records('local_crm_stats_cache', [], '', 'stat_key, stat_value, timemodified');
function get_stat_from_cache($key, $cache) {
return isset($cache[$key]) ? $cache[$key]->stat_value : 0;
}
$stats = [
[
'label' => get_string('happyclients', 'local_crm_integration'),
'value' => get_stat_from_cache('customers', $cached_data)
],
[
'label' => get_string('projects', 'local_crm_integration'),
'value' => get_stat_from_cache('projects', $cached_data)
],
[
'label' => get_string('tasks', 'local_crm_integration'),
'value' => get_stat_from_cache('tasks', $cached_data)
],
[
'label' => get_string('leads', 'local_crm_integration'),
'value' => get_stat_from_cache('leads', $cached_data)
]
];
$lastupdated_time = 0;
if (!empty($cached_data)) {
$first_item = reset($cached_data);
$lastupdated_time = $first_item->timemodified;
}
$template_data = [
'heroheading' => get_string('heroheading', 'local_crm_integration'),
'herosubtext' => get_string('herosubtext', 'local_crm_integration'),
'stats' => $stats,
'lastupdated' => $lastupdated_time > 0 ? userdate($lastupdated_time) : 'Never'
];
$mustache = new Mustache_Engine;
$template = '
<div class="container">
<div class="hero-section text-center p-5">
<h1>{{ heroheading }}</h1>
<p class="lead">{{ herosubtext }}</p>
</div>
<div class="row text-center">
{{#stats}}
<div class="col-md-4 mb-4">
<div class="card">
<div class="card-body">
<h3 class="card-title">{{ value }}</h3>
<p class="card-text">{{ label }}</p>
</div>
</div>
</div>
{{/stats}}
</div>
<div class="text-center text-muted small mt-4">
<p>Last updated: {{ lastupdated }}</p>
</div>
</div>';
echo $mustache->render($template, $template_data);
echo $OUTPUT->footer();