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
 * siteinfo plugin version information
 *
 * @package    local
 * @subpackage orvsd_siteinfo
 * @copyright  2013 OSU Open Source Lab (http://osuosl.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2013050300;       // The current module version (Date: YYYYMMDDXX)
$plugin->requires  = 2011120502;       // Requires this Moodle version
$plugin->release = 1.0;
$plugin->dependencies = array('local_orvsd_coursemeta' => ANY_VERSION); 
