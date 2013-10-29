<?php

/*
 * @author    Shaun Daubney
 * @package   theme_orvsd
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Basic Heading
    $name = 'theme_orvsd/basicheading';
    $heading = get_string('basicheading', 'theme_orvsd');
    $information = get_string('basicheadingdesc', 'theme_orvsd');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);
	
// Logo file setting
$name = 'theme_orvsd/logo';
$title = get_string('logo','theme_orvsd');
$description = get_string('logodesc', 'theme_orvsd');
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting);	

// Hide Menu
$name = 'theme_orvsd/hidemenu';
$title = get_string('hidemenu','theme_orvsd');
$description = get_string('hidemenudesc', 'theme_orvsd');
$default = 1;
$choices = array(1=>get_string('yes',''), 0=>get_string('no',''));
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$settings->add($setting);

// Email url setting

$name = 'theme_orvsd/emailurl';
$title = get_string('emailurl','theme_orvsd');
$description = get_string('emailurldesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// Custom CSS file
$name = 'theme_orvsd/customcss';
$title = get_string('customcss','theme_orvsd');
$description = get_string('customcssdesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtextarea($name, $title, $description, $default);
$setting->set_updatedcallback('theme_reset_all_caches');
$settings->add($setting);

	// Frontpage Heading
    $name = 'theme_orvsd/frontpageheading';
    $heading = get_string('frontpageheading', 'theme_orvsd');
    $information = get_string('frontpageheadingdesc', 'theme_orvsd');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);

// Title Date setting

$name = 'theme_orvsd/titledate';
$title = get_string('titledate','theme_orvsd');
$description = get_string('titledatedesc', 'theme_orvsd');
$default = 1;
$choices = array(1=>get_string('yes',''), 0=>get_string('no',''));
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$settings->add($setting);

// General Alert setting
$name = 'theme_orvsd/generalalert';
$title = get_string('generalalert','theme_orvsd');
$description = get_string('generalalertdesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// Snow Alert setting
$name = 'theme_orvsd/snowalert';
$title = get_string('snowalert','theme_orvsd');
$description = get_string('snowalertdesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

    // Colour Heading
    $name = 'theme_orvsd/colourheading';
    $heading = get_string('colourheading', 'theme_orvsd');
    $information = get_string('colourheadingdesc', 'theme_orvsd');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);
	
// Background colour setting
$name = 'theme_orvsd/backcolor';
$title = get_string('backcolor','theme_orvsd');
$description = get_string('backcolordesc', 'theme_orvsd');
$default = '#fafafa';
$previewconfig = NULL;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$settings->add($setting);

// Graphic Wrap (Background Image)
$name = 'theme_orvsd/backimage';
$title=get_string('backimage','theme_orvsd');
$description = get_string('backimagedesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, '', PARAM_URL);
$settings->add($setting);

// Graphic Wrap (Background Position)
$name = 'theme_orvsd/backposition';
$title = get_string('backposition','theme_orvsd');
$description = get_string('backpositiondesc', 'theme_orvsd');
$default = 'no-repeat';
$choices = array('no-repeat'=>get_string('backpositioncentred','theme_orvsd'), 'no-repeat fixed'=>get_string('backpositionfixed','theme_orvsd'), 'repeat'=>get_string('backpositiontiled','theme_orvsd'), 'repeat-x'=>get_string('backpositionrepeat','theme_orvsd'));
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$settings->add($setting);

// Menu hover background colour setting
$name = 'theme_orvsd/menuhovercolor';
$title = get_string('menuhovercolor','theme_orvsd');
$description = get_string('menuhovercolordesc', 'theme_orvsd');
$default = '#f42941';
$previewconfig = NULL;
$setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
$settings->add($setting);	
	
	// Footer Options Heading
    $name = 'theme_orvsd/footeroptheading';
    $heading = get_string('footeroptheading', 'theme_orvsd');
    $information = get_string('footeroptdesc', 'theme_orvsd');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);
	
// Copyright setting

$name = 'theme_orvsd/copyright';
$title = get_string('copyright','theme_orvsd');
$description = get_string('copyrightdesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// CEOP
$name = 'theme_orvsd/ceop';
$title = get_string('ceop','theme_orvsd');
$description = get_string('ceopdesc', 'theme_orvsd');
$default = '';
$choices = array(''=>get_string('ceopnone','theme_orvsd'), 'http://www.thinkuknow.org.au/site/report.asp'=>get_string('ceopaus','theme_orvsd'), 'http://www.ceop.police.uk/report-abuse/'=>get_string('ceopuk','theme_orvsd'));
$setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
$settings->add($setting);

// Disclaimer setting
$name = 'theme_orvsd/disclaimer';
$title = get_string('disclaimer','theme_orvsd');
$description = get_string('disclaimerdesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_confightmleditor($name, $title, $description, $default);
$settings->add($setting);	

	// Social Icons Heading
    $name = 'theme_orvsd/socialiconsheading';
    $heading = get_string('socialiconsheading', 'theme_orvsd');
    $information = get_string('socialiconsheadingdesc', 'theme_orvsd');
    $setting = new admin_setting_heading($name, $heading, $information);
    $settings->add($setting);
	
// Website url setting

$name = 'theme_orvsd/website';
$title = get_string('website','theme_orvsd');
$description = get_string('websitedesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// Facebook url setting

$name = 'theme_orvsd/facebook';
$title = get_string('facebook','theme_orvsd');
$description = get_string('facebookdesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// Twitter url setting

$name = 'theme_orvsd/twitter';
$title = get_string('twitter','theme_orvsd');
$description = get_string('twitterdesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// Google+ url setting

$name = 'theme_orvsd/googleplus';
$title = get_string('googleplus','theme_orvsd');
$description = get_string('googleplusdesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// Flickr url setting

$name = 'theme_orvsd/flickr';
$title = get_string('flickr','theme_orvsd');
$description = get_string('flickrdesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// Pinterest url setting

$name = 'theme_orvsd/pinterest';
$title = get_string('pinterest','theme_orvsd');
$description = get_string('pinterestdesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// Instagram url setting

$name = 'theme_orvsd/instagram';
$title = get_string('instagram','theme_orvsd');
$description = get_string('instagramdesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// LinkedIn url setting

$name = 'theme_orvsd/linkedin';
$title = get_string('linkedin','theme_orvsd');
$description = get_string('linkedindesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// YouTube url setting

$name = 'theme_orvsd/youtube';
$title = get_string('youtube','theme_orvsd');
$description = get_string('youtubedesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// Apple url setting

$name = 'theme_orvsd/apple';
$title = get_string('apple','theme_orvsd');
$description = get_string('appledesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

// Android url setting

$name = 'theme_orvsd/android';
$title = get_string('android','theme_orvsd');
$description = get_string('androiddesc', 'theme_orvsd');
$default = '';
$setting = new admin_setting_configtext($name, $title, $description, $default);
$settings->add($setting);

}

