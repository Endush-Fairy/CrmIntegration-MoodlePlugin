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

defined('MOODLE_INTERNAL') || die();

$tasks = [
[
'classname' => 'local_crm_integration\task\cache_stats_task',
'blocking' => 0,
'minute'   => '*', // Run at the start of the hour
'hour' => '*', // Every hour
'day' => '*', // Every day
'dayofweek' => '*', // Every day of the week
'month' => '*', // Every month
],
];