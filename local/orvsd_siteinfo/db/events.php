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
 * Defines events for the siteino plugin. These events will trigger
 * siteinfo database updates
 * @package    local
 * @subpackage iorvsd_siteinfo
 * @copyright  2013 OSU Open Source Lab (http://osuosl.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

global $CFG;
$libfile = $CFG->dirroot . '/local/orvsd_siteinfo/lib.php';

$handlers = array (
    'user_deleted' => array (
         'handlerfile'      => $libfile,
         'handlerfunction'  => 'orvsd_siteinfo_update_db',
         'schedule'         => 'instant'
     ),
    'user_created' => array (
         'handlerfile'      => $libfile,
         'handlerfunction'  => 'orvsd_siteinfo_update_db',
         'schedule'         => 'instant'
     ),
    'course_created' => array (
         'handlerfile'      => $libfile,
         'handlerfunction'  => 'orvsd_siteinfo_update_db',
         'schedule'         => 'instant'
     ),
    'course_deleted' => array (
         'handlerfile'      => $libfile,
         'handlerfunction'  => 'orvsd_siteinfo_update_db',
         'schedule'         => 'instant'
    )
);
