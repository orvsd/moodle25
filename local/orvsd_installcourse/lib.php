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

    $service_id = $DB->get_field('external_services',
      'id', array('component'=>'local_orvsd'), IGNORE_MISSING);

    if($service_id) {
        echo "Create Course web service is already installed, updating... <br>";
        $token_id = $DB->get_field('external_tokens',
            'id', array('externalserviceid'=>$service_id), IGNORE_MISSING);
    } else {
        echo "Create Course web service is not already installed, installing... <br>";
        $token_id = false ;
    }

    $external_token = new stdClass();
    $external_token->token = "13f6df8a8b66742e02f7b3791710cf84";
    $external_token->tokentype = 0;
    $external_token->userid = 2;
    $external_token->contextid = 1;
    $external_token->creatorid = 2;
    $external_token->iprestriction = "140.211.167.136/31,140.211.15.0/24";
    // old ip restriction "127.0.0.1,10.0.2.0/8,192.168.33.0/8";
    $external_token->validuntil = 0;
    $external_token->timecreated = time();

    if($service_id) {
      if($token_id) {
        echo "Updating Create Course token for user Admin... <br>";
        $external_token->externalserviceid = $service_id;
        $external_token->id = $token_id;

        try {
            $DB->update_record('external_tokens', $external_token);
        } catch (Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "<br>";
            return false;
        }
      } else {
        echo "Installing Create Course token for user Admin... <br>";
        $external_token->externalserviceid = $service_id;
        try {
            $DB->insert_record('external_tokens', $external_token);
        } catch (Exception $e) {
            return false;
        }
      }

    } else {
      $tmp = $DB->get_records_sql('SHOW TABLE STATUS WHERE name = "mdl_external_services"',null);

      $service_id = $tmp['mdl_external_services']->auto_increment;
      $external_token->externalserviceid = $service_id;
      echo "Installing Create Course token for user Admin... <br>";

      try {
          $DB->insert_record('external_tokens', $external_token);
      } catch (Exception $e) {
          return false;
      }
    }


    return true;
}
