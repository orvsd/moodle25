<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage JSON:CourseTree
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

if (count($course_categories) == 0) {
    echo json_encode('No course categories found');
}else {
	
    $row_array = array();
    
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
        	
        	//FIND CORRECT CATEGORY PARENTID	 	  
              $coursescategory2_text = $DB->get_record_select('block_thelmsapp_coursecattxt','optionid = ' .$course_category->id . ' AND lang = \'' . 'en' . '\'' );	 	  
        	  $categoryparent        = $coursescategory2_text->id;	 	  
        	//FIND CORRECT CATEGORY PARENTID
        	
            $courses  = $DB->get_records_select('block_thelmsapp_course','categoryparent = ' .$categoryparent );
            
            if (count($courses) > 0) {
                foreach ($courses as $course) {
            		
            	         $row              = array();
                         $row['id']        = 'c'.$course->id;
                         $row['parent_id'] = $course_category->id;
                     
                         $coursetext = $DB->get_record_select('block_thelmsapp_coursetext','optionid = ' . $course->id . ' AND lang=\'' . $selected_lang . '\'' );
                    
                         $row['name'] = $coursetext->name;
                         $row['descr'] = $coursetext->description;
                         $row['type']  = 1;
                     
                        array_push($row_array, $row);
                }
            }
    }
    
    //ALSO CHECK COURSES WITH NO CATEGORY ASSIGNED
      $courses  = $DB->get_records_select('block_thelmsapp_course', 'categoryparent = 0' );
    
      if (count($courses) > 0) {
    	  foreach ($courses as $course) {
    
    		$row              = array();
    		$row['id']        = 'c'.$course->id;
    		$row['parent_id'] = 0;
    
    		$coursetext = $DB->get_record_select('block_thelmsapp_coursetext','optionid = ' . $course->id . ' AND lang=\'' . $selected_lang . '\'' );
    		
    		$row['name']  = $coursetext->name;
    		$row['descr'] = $coursetext->description;
    		$row['type']  = 1;
    
    		array_push($row_array, $row);
    	  }
      }
    //ALSO CHECK COURSES WITH NO CATEGORY ASSIGNED
    
    $post_string = $row_array;
    
}

//HELPER FUNCTION TO BUILD TREES OF NODES
function buidTree($items) {

	$childs = array();

	foreach($items as &$item) $childs[$item['parent_id']][] = &$item;
	unset($item);

	foreach($items as &$item) if (isset($childs[$item['id']]))
		$item['childs'] = $childs[$item['id']];

	return $childs[0];
}
//HELPER FUNCTION TO BUILD TREES OF NODES

//BUILD TREE OF COURSES/COURSE CATEGORIES AND PRINT THE JSON REPRESENTATION OF IT
  $tree = buidTree($post_string);
  echo json_encode($tree);
//BUILD TREE OF COURSES/COURSE CATEGORIES AND PRINT THE JSON REPRESENTATION OF IT

?>
