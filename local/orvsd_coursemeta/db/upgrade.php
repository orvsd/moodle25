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
 * coursemeta plugin update actions
 *
 * @package    local
 * @subpackage orvsd_coursemeta
 * @copyright  2013 Kenneth Lett (http://osuosl.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

function xmldb_local_orvsd_coursemeta_upgrade($oldversion = 0) {
    global $CFG;

    require_once("$CFG->dirroot/local/orvsd_coursemeta/lib.php");

    // upgrade from initial version, wipe and redo db
    if($oldversion < 2013022000) {
        orvsd_coursemeta_wipe_table();
    }

    orvsd_coursemeta_update_db();

    return true;
}
