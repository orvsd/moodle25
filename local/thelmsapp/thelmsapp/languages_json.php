<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage JSON:Languages
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');

$context = get_context_instance(CONTEXT_SYSTEM);

$PAGE->set_url('/blocks/thelmsapp/options_json.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

//--------------------------------------------GET ALL LANGUAGES FOR OPTIONS-----------------------------------------//
//GET ALL AVAILABLE LANGUAGES AND STORE IN ARRAY
  $available_languages_array = array();

  $available_languages   = $DB->get_records_select('block_thelmsapp_optiontext','id >0', array(),'','DISTINCT lang');
  foreach ($available_languages as $available_language) {
  		   $available_languages_array[] = $available_language->lang;
  }
//GET ALL AVAILABLE LANGUAGES AND STORE IN ARRAY

$options      = $DB->get_records_select('block_thelmsapp_option','id > 0');
  
if (count($options) == 0) {
    //echo json_encode('No languages found');
	$post_string = array();
}else {
	
    $row_array = array();
    $missing_lang_array = array();
    
    foreach ($options as $option) {
    	
    	foreach ($available_languages as $available_language) {
        
        	 $options_text = $DB->get_records_select('block_thelmsapp_optiontext','optionid = ' .$option->id . ' AND lang = \'' . $available_language->lang . '\'' );        
        
        	 //CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
        	 if (count($options_text) == 0) { $missing_lang_array[] = $available_language->lang; continue;  }
        	 //CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
        	
    	}
    }
    $missing_lang_array = array_unique($missing_lang_array);
    
    //DIFF AVAILABLE LANGUAGES ARRAY WITH MISSING LANGUAGES ARRAY AND RETURN RESULT
      $post_string = array_diff($available_languages_array,$missing_lang_array);
    //DIFF AVAILABLE LANGUAGES ARRAY WITH MISSING LANGUAGES ARRAY AND RETURN RESULT

}
//--------------------------------------------GET ALL LANGUAGES FOR OPTIONS-----------------------------------------//

//--------------------------------------------GET ALL LANGUAGES FOR COURSES----------------------------------------//
//GET ALL AVAILABLE LANGUAGES AND STORE IN ARRAY
$available_languages_course_array = array();

$available_languages_courses   = $DB->get_records_select('block_thelmsapp_coursetext','id >0', array(),'','DISTINCT lang');
foreach ($available_languages_courses as $available_language_course) {
	$available_languages_course_array[] = $available_language_course->lang;
}
//GET ALL AVAILABLE LANGUAGES AND STORE IN ARRAY

$courses      = $DB->get_records_select('block_thelmsapp_course','id > 0');

if (count($courses) == 0) {
	//echo json_encode('No languages found');
	$post_string2 = array();
}else {

	$row_array = array();
	$missing_lang_array = array();

	foreach ($courses as $course) {

		foreach ($available_languages_courses as $available_language_course) {

			$courses_text = $DB->get_records_select('block_thelmsapp_coursetext','optionid = ' .$course->id . ' AND lang = \'' . $available_language_course->lang . '\'' );

			//CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
			if (count($courses_text) == 0) {
				$missing_lang_array[] = $available_language_course->lang; continue;
			}
			//CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND

		}
	}
	$missing_lang_array = array_unique($missing_lang_array);

	//DIFF AVAILABLE LANGUAGES ARRAY WITH MISSING LANGUAGES ARRAY AND RETURN RESULT
	  $post_string2 = array_diff($available_languages_course_array,$missing_lang_array);
	//DIFF AVAILABLE LANGUAGES ARRAY WITH MISSING LANGUAGES ARRAY AND RETURN RESULT

}
//--------------------------------------------GET ALL LANGUAGES FOR COURSES----------------------------------------//

//--------------------------------------GET ALL LANGUAGES FOR COURSE CATEGORIES------------------------------------//

$available_languages_array = array();

$available_languages = $DB->get_records_select('block_thelmsapp_coursecattxt','id >0', array(),'','DISTINCT lang');
foreach ($available_languages as $available_language) {
	$available_languages_array[] = $available_language->lang;
}
//GET ALL AVAILABLE LANGUAGES AND STORE IN ARRAY

$coursecategories      = $DB->get_records_select('block_thelmsapp_coursecat','id > 0');

if (count($coursecategories) == 0) {
	//echo json_encode('No languages found');
	$post_string3 = array();
}else {

	$row_array = array();
	$missing_lang_array = array();

	foreach ($coursecategories as $coursecategory) {

		foreach ($available_languages as $available_language) {

			$coursecategories_text = $DB->get_records_select('block_thelmsapp_coursecattxt','optionid = ' .$coursecategory->id . ' AND lang = \'' . $available_language->lang . '\'' );

			//CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND
			if (count($coursecategories_text) == 0) {
				$missing_lang_array[] = $available_language->lang; continue;
			}
			//CHECK IF ALL STRINGS FOR THE SELECTED LANGUAGE WERE FOUND

		}
	}

	//DIFF AVAILABLE LANGUAGES ARRAY WITH MISSING LANGUAGES ARRAY AND RETURN RESULT
	  $post_string3 = array_diff($available_languages_array,$missing_lang_array);
	//DIFF AVAILABLE LANGUAGES ARRAY WITH MISSING KANGUAGES ARRAY AND RETURN RESULT

}
//--------------------------------------GET ALL LANGUAGES FOR COURSE CATEGORIES------------------------------------//


//MERGE POST_STRING + POST_STRING2 + POST_STRING3 INTO A COMMON ARRAY AND ELIMINATE DUPLICATED
//$post_string_total   = array_merge($post_string, $post_string2, $post_string3);
if ($post_string2 == NULL && $post_string3 == NULL)
	$post_string_total   = $post_string;
else	
	$post_string_total   = array_intersect($post_string, $post_string2, $post_string3);
$post_string_total   = array_values($post_string_total);
//echo json_encode($post_string_total);
//MERGE POST_STRING + POST_STRING2 INTO A COMMON ARRAY AND ELIMINATE DUPLICATED

?>
