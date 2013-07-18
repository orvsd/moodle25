<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Services
 * @copyright  2013 TheLMSApp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

// Check for valid admin user - no guest autologin
require_login(0, false);
$context = get_context_instance(CONTEXT_SYSTEM);
require_capability('moodle/site:config', $context);

$PAGE->set_url('/blocks/thelmsapp/services.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$services_page = get_string('services','block_thelmsapp');

$PAGE->navbar->add($services_page);

$PAGE->set_title($services_page);
$PAGE->set_heading($SITE->fullname);

echo $OUTPUT->header();

echo '<table width="100%"><tr><td><div style="width: 140px;"></div></td><td width="100%">';

//PRINT LOGO
echo '<a href="http://www.thelmsapp.com/"><img src="assets/thelmsapp_logo.png" width="140" align="right" valign="middle" /></a>';
//PRINT LOGO
echo '</td></tr></table>';

	//---------------------------------COURSE SERVICE TABLE----------------------------------//
    
    $GET_courseservice = optional_param('course_service', -1 , PARAM_INT);
    
    //IF SERVICE IS ENABLED -> DISABLE
    if ($GET_courseservice == 0) {
    
    	$courseid             = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.course\'');
    
    	$srv_record           = new stdClass();
    	$srv_record->id       = $courseid->id;
    	$srv_record->name     = 'service.course';
    	$srv_record->value    = '0';
    
    	$updated = $DB->update_record('block_thelmsapp_config', $srv_record, true);
    
    }
    //IF SERVICE IS ENABLED -> DISABLE
    
    //IF SERVICE IS DISABLED -> ENABLE
    else if ($GET_courseservice == 1) {
    
    	$courseid             = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.course\'');
    
    	$srv_record           = new stdClass();
    	$srv_record->id       = $courseid->id;
    	$srv_record->name     = 'service.course';
    	$srv_record->value    = '1';
    
    	$updated = $DB->update_record('block_thelmsapp_config', $srv_record, true);
    
    }
    //IF SERVICE IS DISABLED -> ENABLE
    
    $table_course_options = new html_table();
    $table_course_options->attributes['border'] = '1';
    $table_course_options->width = '100%';
    $table_course_options->align = array('center');
    $table_course_options->head = array(get_string('course_options','block_thelmsapp'));
    
    //GET CURRENT NEWSLETTER SERVICE
    $course_service_record    = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.course\'');
    $course_service           = $course_service_record->value;
    //GET CURRENT NEWSLETTER SERVICE
    
    if ($course_service == 1) {
    	$row = array();
    	$row[] = get_string('course_currentcourse_service_enabled','block_thelmsapp') . html_writer::link(new moodle_url('/blocks/thelmsapp/services.php', array('course_service' => '0')), get_string('course_disable','block_thelmsapp'));
    } else {
    	$row = array();
    	$row[] = get_string('course_currentcourse_service_disabled','block_thelmsapp') . html_writer::link(new moodle_url('/blocks/thelmsapp/services.php', array('course_service' => '1')), get_string('course_enable','block_thelmsapp'));
    }
    
    $table_course_options->data[] = $row;
    
    echo html_writer::table($table_course_options);
    
    //-----------------------------------COURSE SERVICE TABLE----------------------------------//
	
	//------------------------------LEADS SERVICE TABLE----------------------------------//
    
      $GET_leadsservice = optional_param('leads_service', -1 , PARAM_INT);
      
      //IF SERVICE IS ENABLED -> DISABLE
        if ($GET_leadsservice == 0) {
      	
        	$leadid         = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.leads\'');
        	
      	    $srv_record           = new stdClass();
      	    $srv_record->id       = $leadid->id;
      	    $srv_record->name     = 'service.leads';
      	    $srv_record->value    = '0';
      	
      	    $updated = $DB->update_record('block_thelmsapp_config', $srv_record, true);
      	
        }
      //IF SERVICE IS ENABLED -> DISABLE
      
     //IF SERVICE IS DISABLED -> ENABLE
        else if ($GET_leadsservice == 1) {
        	
          $newsletterid         = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.leads\'');
        	
      	  $srv_record           = new stdClass();
      	  $srv_record->id       = $newsletterid->id;
      	  $srv_record->name     = 'service.leads';
      	  $srv_record->value    = '1';
      	
      	  $updated = $DB->update_record('block_thelmsapp_config', $srv_record, true);
     
        }
      //IF SERVICE IS DISABLED -> ENABLE
      
      $table_leads_options = new html_table();
      $table_leads_options->attributes['border'] = '1';
      $table_leads_options->width = '100%';
      $table_leads_options->align = array('center');
      $table_leads_options->head = array(get_string('leads_options','block_thelmsapp'));
    
      //GET CURRENT NEWSLETTER SERVICE
        $leads_service_record  = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.leads\'');
        $leads_service         = $leads_service_record->value;
      //GET CURRENT NEWSLETTER SERVICE
    
      if ($leads_service == 1) {
    	  $row = array();
    	  $row[] = get_string('leads_currentleads_service_enabled','block_thelmsapp') . html_writer::link(new moodle_url('/blocks/thelmsapp/services.php', array('leads_service' => '0')), get_string('leads_disable','block_thelmsapp'));
      } else {
    	  $row = array();
    	  $row[] = get_string('leads_currentleads_service_disabled','block_thelmsapp') . html_writer::link(new moodle_url('/blocks/thelmsapp/services.php', array('leads_service' => '1')), get_string('leads_enable','block_thelmsapp'));
      }
    
      $table_leads_options->data[] = $row;
    
      echo html_writer::table($table_leads_options);
    
    //------------------------------LEADS SERVICE TABLE----------------------------------//  

    //------------------------------NEWSLETTER SERVICE TABLE----------------------------------//
    
      $GET_newsletterservice = optional_param('newsletter_service', -1 , PARAM_INT);
      
      //IF SERVICE IS ENABLED -> DISABLE
        if ($GET_newsletterservice == 0) {
      	
        	$newsletterid         = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.newsletter\'');
        	
      	    $srv_record           = new stdClass();
      	    $srv_record->id       = $newsletterid->id;
      	    $srv_record->name     = 'service.newsletter';
      	    $srv_record->value    = '0';
      	
      	    $updated = $DB->update_record('block_thelmsapp_config', $srv_record, true);
      	
        }
      //IF SERVICE IS ENABLED -> DISABLE
      
     //IF SERVICE IS DISABLED -> ENABLE
        else if ($GET_newsletterservice == 1) {
        	
          $newsletterid         = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.newsletter\'');
        	
      	  $srv_record           = new stdClass();
      	  $srv_record->id       = $newsletterid->id;
      	  $srv_record->name     = 'service.newsletter';
      	  $srv_record->value    = '1';
      	
      	  $updated = $DB->update_record('block_thelmsapp_config', $srv_record, true);
     
        }
      //IF SERVICE IS DISABLED -> ENABLE
      
      $table_newsletter_options = new html_table();
      $table_newsletter_options->attributes['border'] = '1';
      $table_newsletter_options->width = '100%';
      $table_newsletter_options->align = array('center');
      $table_newsletter_options->head = array(get_string('newsletter_options','block_thelmsapp'));
    
      //GET CURRENT NEWSLETTER SERVICE
        $newsletter_service_record    = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.newsletter\'');
        $newsletter_service = $newsletter_service_record->value;
      //GET CURRENT NEWSLETTER SERVICE
    
      if ($newsletter_service == 1) {
    	  $row = array();
    	  $row[] = get_string('newsletter_currentnewsletter_service_enabled','block_thelmsapp') . html_writer::link(new moodle_url('/blocks/thelmsapp/services.php', array('newsletter_service' => '0')), get_string('newsletter_disable','block_thelmsapp'));
      } else {
    	  $row = array();
    	  $row[] = get_string('newsletter_currentnewsletter_service_disabled','block_thelmsapp') . html_writer::link(new moodle_url('/blocks/thelmsapp/services.php', array('newsletter_service' => '1')), get_string('newsletter_enable','block_thelmsapp'));
      }
    
      $table_newsletter_options->data[] = $row;
    
      echo html_writer::table($table_newsletter_options);
    
    //------------------------------NEWSLETTER SERVICE TABLE----------------------------------//
	
	//-----------------------------REGISTRATION SERVICE TABLE----------------------------------//
    
      $GET_registrationservice = optional_param('registration_service', -1 , PARAM_INT);
      
      //IF SERVICE IS ENABLED -> DISABLE
        if ($GET_registrationservice == 0) {
      	
        	$newsletterid         = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.registration\'');
        	
      	    $srv_record           = new stdClass();
      	    $srv_record->id       = $newsletterid->id;
      	    $srv_record->name     = 'service.registration';
      	    $srv_record->value    = '0';
      	
      	    $updated = $DB->update_record('block_thelmsapp_config', $srv_record, true);
      	
        }
      //IF SERVICE IS ENABLED -> DISABLE
      
     //IF SERVICE IS DISABLED -> ENABLE
        else if ($GET_registrationservice == 1) {
        	
          $newsletterid         = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.registration\'');
        	
      	  $srv_record           = new stdClass();
      	  $srv_record->id       = $newsletterid->id;
      	  $srv_record->name     = 'service.registration';
      	  $srv_record->value    = '1';
      	
      	  $updated = $DB->update_record('block_thelmsapp_config', $srv_record, true);
     
        }
      //IF SERVICE IS DISABLED -> ENABLE
      
      $table_newsletter_options = new html_table();
      $table_newsletter_options->attributes['border'] = '1';
      $table_newsletter_options->width = '100%';
      $table_newsletter_options->align = array('center');
      $table_newsletter_options->head = array(get_string('registration_options','block_thelmsapp'));
    
      //GET CURRENT NEWSLETTER SERVICE
        $newsletter_service_record    = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.registration\'');
        $newsletter_service = $newsletter_service_record->value;
      //GET CURRENT NEWSLETTER SERVICE
    
      if ($newsletter_service == 1) {
    	  $row = array();
    	  $row[] = get_string('newsletter_currentnewsletter_service_enabled','block_thelmsapp') . html_writer::link(new moodle_url('/blocks/thelmsapp/services.php', array('registration_service' => '0')), get_string('newsletter_disable','block_thelmsapp'));
      } else {
    	  $row = array();
    	  $row[] = get_string('newsletter_currentnewsletter_service_disabled','block_thelmsapp') . html_writer::link(new moodle_url('/blocks/thelmsapp/services.php', array('registration_service' => '1')), get_string('newsletter_enable','block_thelmsapp'));
      }
    
      $table_newsletter_options->data[] = $row;
      
      //USER REGISTRATION EMAIL LITERALS
        $row = array();
        $row[] = '<table align="center"><tr><td><label for="email_header">Email Header</label></td><td align="center"><code>'.get_string('email_header','block_thelmsapp').'</code></td></tr>';
        $table_newsletter_options->data[] = $row;
      
        $row = array();
        $row[] = '<tr><td><label for="email_header">Email Body</label></td><td align="center" style="max-width: 550px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><code>'.get_string('email_body','block_thelmsapp').'</code></td></tr></table>';
        $table_newsletter_options->data[] = $row;
      //USER REGISTRATION EMAIL LITERALS
    
      echo html_writer::table($table_newsletter_options);
    
    //-----------------------------REGISTRATION SERVICE TABLE----------------------------------//

echo $OUTPUT->footer();

?>
