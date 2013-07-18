<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Leads
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

$context = get_context_instance(CONTEXT_SYSTEM);

$PAGE->set_url('/blocks/thelmsapp/leads_subscribe.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));


//READ NEWSLETTER SUBSCRIPTION PARAMETERS
$name          = required_param('name', PARAM_TEXT);
$surname       = required_param('surname', PARAM_TEXT);
$email         = required_param('email', PARAM_EMAIL);
$interestedin  = required_param('interestedin', PARAM_TEXT);

if ($email == null) {
	
	$err_response = array('action_response' => 'ERROR', 'action_message' => 'Invalid Email!');
	echo json_encode($err_response);
	exit;
}
//END READ NEWSLETTER SUBSCRIPTION PARAMETERS


//FIRST CHECK IF USER ALREADY EXISTS. IF YES DONT INSERT RECORD AND RETURN ERROR TO USER
$subscriber_already_exists  = $DB->get_records_select('block_thelmsapp_leads', 'email =\'' . $email . '\'');

if (count($subscriber_already_exists) == 1) {

	$err_response = array('action_response' => 'ERROR', 'action_message' => 'User already exists!'); 
	echo json_encode($err_response);
	exit;

}
//FIRST CHECK IF USER ALREADY EXISTS. IF YES DONT INSERT RECORD AND RETURN ERROR TO USER

//ELSE INSERT RECORD AND RETURN SUCCESS MESSAGE
$subscriber               = new stdClass();
$subscriber->name         = $name;
$subscriber->surname      = $surname;
$subscriber->email        = $email;
$subscriber->interestedin = $interestedin;
$lastinsertid             = $DB->insert_record('block_thelmsapp_leads', $subscriber, false);

$action_response = array('action_response' => 'OK', 'action_message' => 'User subscribed succefully!');
echo json_encode($action_response);
exit;
//ELSE INSERT RECORD AND RETURN SUCCESS MESSAGE

?>
