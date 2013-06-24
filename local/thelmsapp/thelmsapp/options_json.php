<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage JSON:Buttons
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

// Check for valid admin user - no guest autologin
//require_login(0, false);
$context = get_context_instance(CONTEXT_SYSTEM);
//require_capability('moodle/site:config', $context);

$PAGE->set_url('/blocks/thelmsapp/options_json.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

if (!isset($_GET['lang'])) {
	$error_str = array('Error' => 'No language selected'); echo json_encode($error_str); exit;
}

$selected_lang = $_GET['lang'];
$options      = $DB->get_records_select('block_thelmsapp_option','id > 0');

if (count($options) == 0) {
    echo json_encode('No options found');
}else {
	
    $row_array = array();
    
    foreach ($options as $option) {

        	 $row              = array();
        	 $row['id']        = $option->id;
        	 $row['coursebtn'] =  $option->is_coursebtn;
        
        	 $options_text = $DB->get_records_select('block_thelmsapp_optiontext','optionid = ' .$option->id . ' AND lang = \'' . $selected_lang . '\'' );        
        
        	 //CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
        	 if (count($options_text) == 0) { $error_str = array('Error' => 'Not all strings for the selected language were found'); echo json_encode($error_str); exit; }
        	 //CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
        	 
        	 foreach ($options_text as $option_text) {
        	
        		 	  $row['name']         =  $option_text->name;
        		 	  $row['help']         =  $option->name;
        		 	  $row['lang']         =  $option_text->lang;
        		 	  $row['desc']         =  $option_text->description;
        		 	  $row['icon']         =  $option_text->icon;
        		 	  $row['pos']          =  $option->position;
        		 	  $row['type']         =  'button';
        		 	  //$row['is_coursebtn'] =  $option->is_coursebtn;
        		 
        		 	 if ($option->hidden == 1) 
        		 	 	 $row['hidden'] = '1';      		 	
        		 	 else
        		 	 	 $row['hidden'] = '0';
        		 	 
        			 $row_array[] = json_encode($row);     
        	}     
    }
    
    $post_string = json_encode($row_array);
    echo $post_string;
}

?>
