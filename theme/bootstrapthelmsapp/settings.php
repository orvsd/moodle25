<?php

/**
 * Settings for the TheLMSapp theme
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    
    //This is the note box for all the settings pages
    $name = 'theme_bootstrapthelmsapp/notes';
    $heading = get_string('notes', 'theme_bootstrapthelmsapp');
    $information = get_string('notesdesc', 'theme_bootstrapthelmsapp');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);
	
	$name = 'theme_bootstrapthelmsapp/enablejquery';
    $title = get_string('enablejquery','theme_bootstrapthelmsapp');
    $description = get_string('enablejquerydesc', 'theme_bootstrapthelmsapp');
    $default = '1';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);
    
    $name = 'theme_bootstrapthelmsapp/enableglyphicons';
    $title = get_string('enableglyphicons','theme_bootstrapthelmsapp');
    $description = get_string('enableglyphiconsdesc', 'theme_bootstrapthelmsapp');
    $default = '0';
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);
	
	$name = 'theme_bootstrapthelmsapp/logo_url';
    $title = get_string('logo_url','theme_bootstrapthelmsapp');
    $description = get_string('logo_urldesc', 'theme_bootstrapthelmsapp');
    $setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
    $settings->add($setting);
    
    $name = 'theme_bootstrapthelmsapp/customcss';
    $title = get_string('customcss','theme_bootstrapthelmsapp');
    $description = get_string('customcssdesc', 'theme_bootstrapthelmsapp');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $settings->add($setting);
    
    $name = 'theme_bootstrapthelmsapp/gakey';
	$title = get_string('gakey','theme_bootstrapthelmsapp');
	$description = get_string('gakeydesc', 'theme_bootstrapthelmsapp');
	$setting = new admin_setting_configtext($name, $title, $description, '');
	$settings->add($setting);

}