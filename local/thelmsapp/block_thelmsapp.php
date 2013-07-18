<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage Block
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_thelmsapp extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_thelmsapp');
    }

    function applicable_formats() {
        return array('all' => true, 'tag' => false);   // Needs work to make it work on tags MDL-11960
    }

    function get_content() {
        global $CFG, $DB;

        if ($this->content !== NULL) {
            return $this->content;
        }

        // initalise block content object
        $this->content = new stdClass;
        $this->content->text   = '';
        $this->content->footer = '';

        if (empty($this->instance)) {
            return $this->content;
        }

        if (has_capability('moodle/site:config', $this->context)) {
            $this->content->text = get_string('options', 'block_thelmsapp');
       
            $output = '<ul>';
            
			$optionsurl = new moodle_url('/blocks/thelmsapp/options.php');
            $optionsname = get_string('options', 'block_thelmsapp');
            $output.= '<li>'. html_writer::link($optionsurl, $optionsname, array('title'=>$optionsname)) . '</li>';
			
            $coursesurl = new moodle_url('/blocks/thelmsapp/coursecategories.php');
            $coursesname = get_string('coursecategories', 'block_thelmsapp');
            $output.= '<li>'. html_writer::link($coursesurl, $coursesname, array('title'=>$coursesname)) . '</li>';
            
            $coursesurl = new moodle_url('/blocks/thelmsapp/courses.php');
            $coursesname = get_string('courses', 'block_thelmsapp');
            $output.= '<li>'. html_writer::link($coursesurl, $coursesname, array('title'=>$coursesname)) . '</li>';
            
			$url = new moodle_url('/blocks/thelmsapp/leads.php');
            $optionsname = get_string('leads', 'block_thelmsapp');
            $output.= '<li>' . html_writer::link($url, $optionsname, array('title'=>$optionsname)) . '</li>';
			
            $url = new moodle_url('/blocks/thelmsapp/newsletter.php');
            $optionsname = get_string('newsletter', 'block_thelmsapp');
            $output.= '<li>' . html_writer::link($url, $optionsname, array('title'=>$optionsname)) . '</li>';
            
            $url = new moodle_url('/blocks/thelmsapp/services.php');
            $optionsname = get_string('services', 'block_thelmsapp');
            $output.= '<li>' . html_writer::link($url, $optionsname, array('title'=>$optionsname)) . '</li>';
			
            $output .= '</ul>';
            
            $this->content->text = $output;
        }
        
        return $this->content;
    }


    function instance_allow_multiple() {
        return false;
    }

    function has_config() {
        return false;
    }

    function instance_allow_config() {
        return false;
    }

}