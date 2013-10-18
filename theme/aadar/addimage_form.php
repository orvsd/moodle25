<?php

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once("{$CFG->libdir}/formslib.php");

class dashboard_image_form extends moodleform {
    function definition() {
        $mform = $this->_form;
        $instance = $this->_customdata;

        // visible elements
        $mform->addElement('text', 'url',get_string('thurl','theme_aadar'));
       $mform->addRule('url', get_string('missingurl','theme_aadar'), 'required', null, 'client');
	   $mform->addElement('static', 'urleg','',get_string('urleg','theme_aadar'));
        $mform->addElement('text', 'label',get_string('label','theme_aadar'));
       $mform->addRule('label', get_string('missinglabel','theme_aadar'), 'required', null, 'client');

        $mform->addElement('hidden', 'itemid', get_string('itemid','theme_aadar'));
        $mform->addElement('filepicker', 'dashboard_img',get_string('uploadafile'), null, $instance['options']);

        // hidden params
        $mform->addElement('hidden', 'contextid', $instance['contextid']);
        $mform->setType('contextid', PARAM_INT);
        
        $mform->addElement('hidden', 'userid', $instance['userid']);
        $mform->setType('userid', PARAM_INT);
        $mform->addElement('hidden', 'sectionid', $instance['sectionid']);
        $mform->setType('sectionid', PARAM_INT);
        $mform->addElement('hidden', 'action', 'uploadfile');
        $mform->setType('action', PARAM_ALPHA);

        // buttons
        $this->add_action_buttons(true, get_string('savechanges', 'admin'));
    }
}
