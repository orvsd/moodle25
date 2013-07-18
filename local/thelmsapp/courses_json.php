<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage JSON:Courses
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

// Check for valid admin user - no guest autologin
//require_login(0, false);
$context = get_context_instance(CONTEXT_SYSTEM);
//require_capability('moodle/site:config', $context);

$PAGE->set_url('/blocks/thelmsapp/courses_json.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

if (!isset($_GET['lang'])) {
	$error_str = array('Error' => 'No language selected'); echo json_encode($error_str); exit;
}

$selected_lang = $_GET['lang'];
$courses       = $DB->get_records_select('block_thelmsapp_course','id > 0');

if (count($courses) == 0) {
    echo json_encode('No courses found');
}else {
	
    $row_array = array();
    
    foreach ($courses as $course) {

        	 $row = array();
        	 $row['id'] = $course->id;
        
        	 $courses_text = $DB->get_records_select('block_thelmsapp_coursetext','optionid = ' .$course->id . ' AND lang = \'' . $selected_lang . '\'' );        
        
        	 //CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
        	 if (count($courses_text) == 0) { $error_str = array('Error' => 'Not all strings for the selected language were found'); echo json_encode($error_str); exit; }
        	 //CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
        	 
        	 foreach ($courses_text as $course_text) {
        	
        	 	      $category_name = $DB->get_record('block_thelmsapp_coursecattxt', array('id' => $course->categoryparent), 'name');
        	 	      
        	 	      if (is_object($category_name))
        	 	      	  $row['category'] = $category_name->name;
        	 	      else
        	 	      	  $row['category'] = '-';
        	 	      	
        		 	  $row['name']     =  $course_text->name;
        		 	  $row['help']     =  $course->name;
        		 	  $row['lang']     =  $course_text->lang;
        		 	  $row['desc']     =  $course_text->description;
        		 	  $row['icon']     =  $course_text->icon;
        		 	  $row['pos']      =  $course->position;
        		 	  $row['type']     =  'button';
        		 
        		 	 if ($course->hidden == 1) 
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
