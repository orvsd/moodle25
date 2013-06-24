<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage JSON:CourseFlatTree
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

$selected_lang     = $_GET['lang'];
$course_categories = $DB->get_records_select('block_thelmsapp_coursecat','id > 0');
$courses           = $DB->get_records_select('block_thelmsapp_course', 'id >0' );

if (count($course_categories) == 0) {
    echo json_encode('No course categories found');
}else {
	
    $row_array = array();
    
    //FETCH PLATFORM CATEGORIES
    foreach ($course_categories as $course_category) {

        	 $row = array();
        	 $row['id']    = $course_category->id;
        
        	 $coursescategory_text = $DB->get_record_select('block_thelmsapp_coursecattxt','optionid = ' .$course_category->id . ' AND lang = \'' . $selected_lang . '\'' );        
        
        	 //CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
        	 if (count($coursescategory_text) == 0) { $error_str = array('Error' => 'Not all strings for the selected language were found'); echo json_encode($error_str); exit; }
        	 //CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
        	 
        	 $coursecategory_name = $DB->get_record('block_thelmsapp_coursecattxt', array('id' => $course_category->id), 'name,description');
        	 	      
        	 $row['name']      =  $coursescategory_text->name;       		 
             $row['descr']     =  $coursescategory_text->description;
        	 $row['parent_id'] =  $course_category->cparent;
        	 $row['type']      =  0;
        	 	 	  
        	 array_push($row_array, $row);     
    }
    //FETCH PLATFORM CATEGORIES
    
    //FETCH PLATFORM COURSES
      $courses  = $DB->get_records_select('block_thelmsapp_course', 'id > 0' );
    
      if (count($courses) > 0) {
    	  foreach ($courses as $course) {
    
    		$row              = array();
    		$row['id']        = 'c'.$course->id;
    		
    		//FIND CORRECT CATEGORY PARENTID
    		if ($course->categoryparent > 0) {
    		    $coursescategory2_text = $DB->get_record_select('block_thelmsapp_coursecattxt','id = ' .$course->categoryparent );
    		    $categoryparent        = $coursescategory2_text->optionid;
    		}
    		else
    			$categoryparent = 0;
    		//FIND CORRECT CATEGORY PARENTID
    		
    		$row['parent_id'] = $categoryparent;
    
    		$coursetext = $DB->get_record_select('block_thelmsapp_coursetext','optionid = ' . $course->id . ' AND lang=\'' . $selected_lang . '\'' );
    		
    		$row['name']  = $coursetext->name;
    		$row['code']  = $coursetext->code;
    		$row['descr'] = $coursetext->description;
    		$row['price'] = $coursetext->price;
    		$row['type']  = 1;
    
    		array_push($row_array, $row);
    	  }
      }
    //FETCH PLATFORM COURSES
    
    $post_string = $row_array;
    
}

  echo json_encode($post_string);
  
?>
