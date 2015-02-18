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
 * orvsd plugin function library
 *
 * @package    local
 * @subpackage orvsd_installcourse
 * @copyright  2013 OSU Open Source Lab (http://osuosl.org)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die;

function orvsd_installcourse_init() {
  global $CFG, $DB;

  $event_data = new stdClass();
  $event_data->modulename = 'ORVSD';

  // we can register an event, but for now this is redundant
  //events_trigger('orvsd_updated', $eventdata);
  //
  orvsd_installcourse_update($event_data);
}

function orvsd_installcourse_update($event_data) {
    global $CFG, $DB;

    // turn on webservices and make sure the rest protocol is enabled
    $ws_config = $DB->get_record('config', array('name'=>'enablewebservices'));
    $protocols_config = $DB->get_record('config', array('name'=>'webserviceprotocols'));

    if ($ws_config->value == 0) {
        echo "Web Services is off, turning it on now... ";
        $ws_config->value = 1;
        $success = $DB->update_record('config', $ws_config);
        if ($success) {
            echo "Success!<br>";
        } else {
            echo "Failed!<br>";
        }
    }

    if (!$protocols_config) {
        $protocols_config = new stdClass();
        $protocols_config->name = 'webserviceprotocols';
        $protocols_config->value = 'rest';
        echo "Web Services REST protocol is not enabled, enabling now... ";
        $success = $DB->insert_record('config', $protocols_config);
        if ($success) {
            echo "Success!<br>";
        } else {
            echo "Failed!<br>";
        }

    } else {
        if(strpos($protocols_config->value, "rest") === false) {

            echo "Web Services REST protocol is not enabled, enabling now... ";
            $protocols_config->value .= ',rest';
            $success = $DB->update_record('config', $protocols_config);

            if ($success) {
                echo "Success!<br>";
            } else {
                echo "Failed!<br>";
            }
        }
    }

    // Look up the service, if it doesn't exist, create it
    $service = $DB->get_record('external_services', array('component'=>'local_orvsd_installcourse'));

    if (!$service) {

        $tmp = $DB->get_records_sql('SHOW TABLE STATUS WHERE name = "mdl_external_services"');
        $service_id = $tmp['mdl_external_services']->auto_increment;

        $service = new stdClass();
        $service->id = $service_id;
    }

    // Get the admin account
    $admin = $DB->get_record_sql(
        "SELECT value FROM `mdl_config` WHERE `name` LIKE 'siteadmins'",
        null,
        IGNORE_MISSING
    );

    $admin_user = $DB->get_record('user', array('id' => "$admin->value"));
    $existing_tokens = $DB->get_record('external_tokens', array('userid'=>"$admin_user->id", 'externalserviceid'=>"$service->id"));

    if (!$existing_tokens) {
        require('config.php');
        require_once("$CFG->libdir/externallib.php");

        // Generate a new token for the Admin User
        $token = external_generate_token(
            EXTERNAL_TOKEN_PERMANENT,
            $service,
            $admin->value,
            context_system::instance(),
            $validuntil=0,
            $IP_RESTRICTION
        );

        $DB->set_field('external_tokens', 'creatorid', "$admin->value", array("token"=>"$token"));
    }

    return true;
}
