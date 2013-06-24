<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage JSON:UserInfo
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

$context = get_context_instance(CONTEXT_SYSTEM);

$PAGE->set_url('/blocks/thelmsapp/userinfo_json.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

$query = '';

if (array_key_exists("username",$_POST) && $_POST['username'] != NULL) {
	$query = 'username = \'' . addslashes($_POST['username']) . '\'';
}

if (array_key_exists("email",$_POST) && $_POST['email'] != NULL) {
	$query = 'email = \'' . addslashes($_POST['email']) . '\'';
}

if (array_key_exists("userid",$_POST) && $_POST['userid'] != NULL) {
	$query = 'id = \'' . addslashes($_POST['userid']) . '\'';
}

if ($query != NULL) {

//GET USER INFO
  $userinfo_record = $DB->get_record_select('user', $query);
  
  if (is_object($userinfo_record)) {
  
  	  $userinfo = new stdClass();
  	  $userinfo->id          = $userinfo_record->id;
  	  $userinfo->firstname   = $userinfo_record->firstname;
  	  $userinfo->lastname    = $userinfo_record->lastname;
  	  $userinfo->email       = $userinfo_record->email;
  	  $userinfo->skype       = $userinfo_record->skype;
  	  $userinfo->icq         = $userinfo_record->icq;
  	  $userinfo->yahoo       = $userinfo_record->yahoo;
  	  $userinfo->msn         = $userinfo_record->msn;
  	  $userinfo->phone1      = $userinfo_record->phone1;
  	  $userinfo->institution = $userinfo_record->institution;
      $userinfo->department  = $userinfo_record->department;
  	  $userinfo->address     = $userinfo_record->address;
  	  $userinfo->city        = $userinfo_record->city;
  	  $userinfo->country     = $userinfo_record->country;
  	  $userinfo->lang        = $userinfo_record->lang;
      $userinfo->timezone    = $userinfo_record->timezone;
  	  $userinfo->lastlogin   = $userinfo_record->lastlogin;
  	  if ($userinfo_record->picture == 0)
  	  	  $userinfo->picture = 'http://'. $_SERVER["SERVER_NAME"] .'/theme/image.php?image=u%2Ff1'; 
  	  else {

  	  	  //FIND CONTEXT
  	  	    $context_record = $DB->get_record_select('files', 'component = \'user\' AND id = '. $userinfo_record->picture);
  	  	  //FIND CONTEXT
  	  	  
  	  	  $userinfo->picture = 'http://'. $_SERVER["SERVER_NAME"] .'/pluginfile.php/'.$context_record->contextid.'/user/icon/standard/f1';
  	  }
  }
  else {
  	$userinfo = 'No user found';
  }
//GET USER INFO
            
$post_string = json_encode($userinfo);
echo $post_string;

}

?>
