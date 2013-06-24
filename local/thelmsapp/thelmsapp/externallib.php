<?php

/**
 * External Web Service Template
 *
 * @package    block_thelmsapp
 * @copyright  TheLMSapp
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot.'/blocks/thelmsapp/externallib.php');

class block_thelmsapp_external extends external_api {

    ////////// 1.get_userinfo //////////
    
    public static function get_userinfo_parameters() {
        return new external_function_parameters(
                array('username' => new external_value(PARAM_USERNAME, 'The username of the user', VALUE_REQUIRED),
					  'email'    => new external_value(PARAM_EMAIL, 'The email of the user', VALUE_VALUE_REQUIRED),
					  'id'       => new external_value(PARAM_ALPHANUMEXT, 'The id of the user', VALUE_REQUIRED))
        );
    }
    
    public static function get_userinfo($username, $email, $id) {
        global $USER, $DB;
    
        $params = self::validate_parameters(self::get_userinfo_parameters(),
                array('username' => $username, 'email' => $email, 'id' => $id));
	   
	   //GET USER INFO
	   
	    $query = '';

		//ADD. SE PRAGMATIKI XRISI TO WEB SERVICE tha exei mapped pollous xristes kai to $USER object tha ginetai mapped ston loggedin xristi.
		//if ($USER->username == $username)
		if ($username != NULL) {
			if ($username != 'admin' && $username != 'guest')
				$query = 'username = \'' . addslashes(strtolower($username)) . '\'';
			else
				throw new invalid_parameter_exception('Cannot request info for admin or guest');			
		}

		//ADD. SE PRAGMATIKI XRISI TO WEB SERVICE tha exei mapped pollous xristes kai to $USER object tha ginetai mapped ston loggedin xristi.
		//if ($USER->email == $email)
		if ($email != NULL) {
			$query = 'email = \'' . addslashes($email) . '\'';
		}

		//ADD. SE PRAGMATIKI XRISI TO WEB SERVICE tha exei mapped pollous xristes kai to $USER object tha ginetai mapped ston loggedin xristi.
		//if ($USER->id == $id) {
		if ($id != NULL) {
			if ($id != 1 && $id != 2)
			    $query = 'id = \'' . addslashes($id) . '\'';
			else 
				throw new invalid_parameter_exception('Cannot request info for admin or guest');
		}
	   
	    $query.=' AND deleted <> 1 AND suspended <> 1';
		$userinfo_record = $DB->get_record_select('user', $query);
  
		if (is_object($userinfo_record)) {
  
			$userinfo = array();
			$userinfo['id']          = $userinfo_record->id;
			$userinfo['firstname']   = $userinfo_record->firstname;
			$userinfo['lastname']    = $userinfo_record->lastname;
			$userinfo['email']       = $userinfo_record->email;
			$userinfo['skype']       = $userinfo_record->skype;
			$userinfo['icq']         = $userinfo_record->icq;
			$userinfo['yahoo']       = $userinfo_record->yahoo;
			$userinfo['msn']         = $userinfo_record->msn;
			$userinfo['phone1']      = $userinfo_record->phone1;
			$userinfo['institution'] = $userinfo_record->institution;
			$userinfo['department']  = $userinfo_record->department;
			$userinfo['address']     = $userinfo_record->address;
			$userinfo['city']        = $userinfo_record->city;
			$userinfo['country']     = $userinfo_record->country;
			$userinfo['lang']        = $userinfo_record->lang;
			$userinfo['timezone']    = $userinfo_record->timezone;
			$userinfo['lastlogin']   = $userinfo_record->lastlogin;
			if ($userinfo_record->picture == 0)
				$userinfo['picture'] = 'http://'. $_SERVER["SERVER_NAME"] .'/theme/image.php?image=u%2Ff1'; 
			else {

				//FIND CONTEXT
				$context_record = $DB->get_record_select('files', 'component = \'user\' AND id = '. $userinfo_record->picture);
				//FIND CONTEXT
  	  	  
				$userinfo['picture'] = 'http://'. $_SERVER["SERVER_NAME"] .'/pluginfile.php/'.$context_record->contextid.'/user/icon/standard/f1';
			}
		}
		else {
			throw new invalid_parameter_exception('No user found'); //$userinfo = 'No user found';
		}
		//GET USER INFO
            
		return $userinfo;

	}
    
    public static function get_userinfo_returns() {
    	
    	return new external_single_structure(
                array(
                    'id'          => new external_value(PARAM_NUMBER, 'ID of the user'),
                    'firstname'   => new external_value(PARAM_NOTAGS, 'The first name(s) of the user', VALUE_OPTIONAL),
                    'lastname'    => new external_value(PARAM_NOTAGS, 'The family name of the user', VALUE_OPTIONAL),
                    'email'       => new external_value(PARAM_TEXT, 'An email address - allow email as root@localhost', VALUE_OPTIONAL),
                    'skype'       => new external_value(PARAM_NOTAGS, 'Skype id', VALUE_OPTIONAL),
                    'icq'         => new external_value(PARAM_TEXT, 'ICQ', VALUE_OPTIONAL),
                    'yahoo'       => new external_value(PARAM_TEXT, 'Yahoo', VALUE_OPTIONAL),
                	'msn'         => new external_value(PARAM_TEXT, 'MSN', VALUE_OPTIONAL),
                	'phone1'      => new external_value(PARAM_TEXT, 'Phone', VALUE_OPTIONAL),
                	'institution' => new external_value(PARAM_TEXT, 'Institution', VALUE_OPTIONAL),
                	'department'  => new external_value(PARAM_TEXT, 'Department', VALUE_OPTIONAL),
                	'address'     => new external_value(PARAM_TEXT, 'Address', VALUE_OPTIONAL),
                	'city'        => new external_value(PARAM_TEXT, 'City', VALUE_OPTIONAL),
                	'country'     => new external_value(PARAM_TEXT, 'Country', VALUE_OPTIONAL),
                	'lang'        => new external_value(PARAM_TEXT, 'Language', VALUE_OPTIONAL),
                	'timezone'    => new external_value(PARAM_TEXT, 'Timezone', VALUE_OPTIONAL),
                	'lastlogin'   => new external_value(PARAM_TEXT, 'LastLogin', VALUE_OPTIONAL),
                	'picture'     => new external_value(PARAM_TEXT, 'Picture', VALUE_OPTIONAL)
                )
    	);
    }
    
}