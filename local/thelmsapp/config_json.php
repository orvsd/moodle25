<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage JSON:Config
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require('languages_json.php');

$context = get_context_instance(CONTEXT_SYSTEM);

$PAGE->set_url('/blocks/thelmsapp/config_json.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

//GET CURRENT NEWSLETTER SERVICE VALUE
  $newsletter_service_record    = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.newsletter\'');
  $newsletter_service = $newsletter_service_record->value;
//GET CURRENT NEWSLETTER SERVICE VALUE

//GET CURRENT COURSE SERVICE VALUE
  $course_service_record    = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.course\'');
  $course_service           = $course_service_record->value;
//GET CURRENT COURSE SERVICE VALUE

//GET CURRENT LEADS SERVICE VALUE
  $leads_service_record    = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.leads\'');
  $leads_service           = $leads_service_record->value;
//GET CURRENT LEADS SERVICE VALUE

//GET CURRENT REGISTRATION SERVICE VALUE
  $registration_service_record = $DB->get_record_select('block_thelmsapp_config', 'name = \'service.registration\'');
  $registration_service        = $registration_service_record->value;
//GET CURRENT REGISTRATION SERVICE VALUE

//GET CURRENT PASSWORD POLICY
  $password_policy      = '';
  $password_policy_more = '';
  
  $password_policy_record = $DB->get_record_select('config', 'name = \'passwordpolicy\'');
  if ($password_policy_record->value == 1) {
  
  	//MIN PASS WORD LENGTH
  	$min_pass_world_length_record = $DB->get_record_select('config', 'name = \'minpasswordlength\'');
  	$min_pass_world_length        = $min_pass_world_length_record->value;
  	//MIN PASS WORD LENGTH
  
  	//MIN PASS WORD DIGITS
  	$min_pass_world_digits_record = $DB->get_record_select('config', 'name = \'minpassworddigits\'');
  	$min_pass_world_digits        = $min_pass_world_digits_record->value;
  	//MIN PASS WORD DIGITS
  
  	//MIN PASS WORD LOWER
  	$min_pass_world_lower_record = $DB->get_record_select('config', 'name = \'minpasswordlower\'');
  	$min_pass_world_lower        = $min_pass_world_lower_record->value;
  	//MIN PASS WORD LOWER
  
  	//MIN PASS WORD UPPER
  	$min_pass_world_upper_record = $DB->get_record_select('config', 'name = \'minpasswordupper\'');
  	$min_pass_world_upper        = $min_pass_world_upper_record->value;
  	//MIN PASS WORD UPPER
  
  	//MIN PASS WORD UPPER
  	$min_pass_world_nonalpha_record = $DB->get_record_select('config', 'name = \'minpasswordnonalphanum\'');
  	$min_pass_world_upper           = $min_pass_world_nonalpha_record->value;
  	//MIN PASS WORD UPPER
  
  	$password_policy      = 1;
  	$password_policy_more = array('minpasswordlength' => $min_pass_world_length, 'minpassworddigits' => $min_pass_world_digits, 'minpasswordlower' => $min_pass_world_lower, 'minpasswordupper' => $min_pass_world_upper, 'minpasswordnonalphanum' => $min_pass_world_upper);
  }
  else {
  	$password_policy      = 0;
  }
//GET CURRENT PASSWORD POLICY
  
//GET LANGUAGE MD5 CHECKSUM VALUE
  $language_timestamp         = md5(implode(",", $post_string_total));
//GET LANGUAGE MD5 CHECKSUM VALUE
  

$post_string_array                        = array();
$post_string_array['ipad.language']       = $post_string_total; //FROM languages_json.php file
$post_string_array['language.md5']        = $language_timestamp;
$post_string_array['service.course']      = $course_service;
$post_string_array['service.leads']       = $leads_service;
$post_string_array['service.newsletter']  = $newsletter_service;
$post_string_array['service.registration']= $registration_service;
$post_string_array['policy.password']     = $password_policy;
if ($password_policy == 1)
$post_string_array['policy.passwordmore'] = $password_policy_more;

$post_string = json_encode($post_string_array);
echo $post_string;
  
?>
