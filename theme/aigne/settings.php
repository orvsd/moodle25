<?php
/**
 * settings
 * 
 * @package    theme_aigne
 * @copyright  2013 Franc Pombal (www.aigne.com)
 * @license    http: *www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

// CSS Settings _ Heading
$settings->add(new admin_setting_heading('csshead', new lang_string('csshead','theme_aigne'), ''));
    // Font Size setting
        $name = 'theme_aigne/bodyfont';
        $title = get_string('bodyfont','theme_aigne');
        $description = get_string('bodyfontdesc', 'theme_aigne');
        $default = '14';
        $choices = array(12=>'12px', 13=>'13px', 14=>'14px', 15=>'15px', 16=>'16px', 18=>'18px', 20=>'20px', 22=>'22px');
        $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Default CSS Colour Scheme <- PENDIENTE ARREGLAR
        $name = 'theme_aigne/colorsch';
        $title = get_string('colorsch' , 'theme_aigne');
        $description = get_string('colorschdesc', 'theme_aigne');
        $css_color1 = get_string('css_color1', 'theme_aigne');
        $css_color2 = get_string('css_color2', 'theme_aigne');
        $css_color3 = get_string('css_color3', 'theme_aigne');
        $css_color4 = get_string('css_color4', 'theme_aigne');
        $css_color5 = get_string('css_color5', 'theme_aigne');
        $default = '1';
        $choices = array('1'=>$css_color1, '2'=>$css_color2, '3'=>$css_color3, '4'=>$css_color4, '5'=>$css_color5);
        $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Background (Body Image) setting
        $name = 'theme_aigne/backbody';
        $title = get_string('backbody','theme_aigne');
        $description = get_string('backbodydesc', 'theme_aigne');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'backbody');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Background (Body Image) Position setting
        $name = 'theme_aigne/bgposition';
        $title = get_string('bgposition','theme_aigne');
        $description = get_string('bgpositiondesc', 'theme_aigne');
        $default = 'no-repeat';
        $choices = array('no-repeat'=>get_string('no-repeat','theme_aigne'), 'repeat'=>get_string('repeat','theme_aigne'), 'repeat-x'=>get_string('repeat-x','theme_aigne'), 'repeat-y'=>get_string('repeat-y','theme_aigne'));
        $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
        $settings->add($setting);
    // Background Colour setting
        $name = 'theme_aigne/backcolor';
        $title = get_string('backcolor', 'theme_aigne');
        $description = get_string('backcolordesc', 'theme_aigne');
        $default = '#FFFFFF';
        $previewconfig = NULL;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);        
    // Custom CSS file
        $name = 'theme_aigne/customcss';
        $title = get_string('customcss','theme_aigne');
        $description = get_string('customcssdesc', 'theme_aigne');
        $default = '';
        $setting = new admin_setting_configtextarea($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);

$settings->add(new admin_setting_heading('separador1', new lang_string('separador_bhr','theme_aigne'), ''));
// Logo Settings
$settings->add(new admin_setting_heading('logohead', new lang_string('logohead','theme_aigne'), ''));
    // Logo file setting
        $name = 'theme_aigne/logo';
        $title = get_string('logo','theme_aigne');
        $description = get_string('logodesc', 'theme_aigne');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Slogan Text (under logo)
        $name = 'theme_aigne/slogan';
        $title = get_string('slogan','theme_aigne');
        $description = get_string('slogandesc', 'theme_aigne');
        $default = get_string('sloganaigne','theme_aigne');
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);        
    // Background Logo file setting
        $name = 'theme_aigne/backlogo';
        $title = get_string('backlogo','theme_aigne');
        $description = get_string('backlogodesc', 'theme_aigne');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'backlogo');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);

$settings->add(new admin_setting_heading('separador2', new lang_string('separador_hr','theme_aigne'), ''));
// Marketing Settings
$settings->add(new admin_setting_heading('marketinghead', new lang_string('marketinghead','theme_aigne'), ''));
    // Header Information Image setting
        $name = 'theme_aigne/headerinfo';
        $title = get_string('headerinfo','theme_aigne');
        $description = get_string('headerinfodesc', 'theme_aigne');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'headerinfo');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
        
$settings->add(new admin_setting_heading('separador3', new lang_string('separador_bhr','theme_aigne'), ''));
// Cutom Menu Settings
$settings->add(new admin_setting_heading('custommenuhead', new lang_string('custommenuhead','theme_aigne'), ''));
    // Navbar Seperator <- PENDIENTE ARREGLAR
        $name = 'theme_aigne/navbarsep';
        $title = get_string('navbarsep' , 'theme_aigne');
        $description = get_string('navbarsepdesc', 'theme_aigne');
        $choices = array('|' => 'barra vertical','/' => 'barra inclinada','_' => 'guión bajo',' ' => 'espacio en blanco','' => 'nada');
        $default = '|';
        $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Menu colour base setting  <- PENDIENTE ARREGLAR
        $name = 'theme_aigne/menucolor';
        $title = get_string('menucolor', 'theme_aigne');
        $description = get_string('menucolordesc', 'theme_aigne');
        $default = '#007EBA';
        $previewconfig = NULL;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Menu colour contrast setting  <- PENDIENTE ARREGLAR
        $name = 'theme_aigne/menucolorhl';
        $title = get_string('menucolorhl', 'theme_aigne');
        $description = get_string('menucolorhldesc', 'theme_aigne');
        $default = '#F3F7FF';
        $previewconfig = NULL;
        $setting = new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);

$settings->add(new admin_setting_heading('separador20', new lang_string('separador_br','theme_aigne'), ''));
$settings->add(new admin_setting_heading('separador21', new lang_string('separador_br','theme_aigne'), ''));
// Bottom of page Settings _ Heading
$settings->add(new admin_setting_heading('bottomphead', new lang_string('bottomphead','theme_aigne'), ''));

$settings->add(new admin_setting_heading('separador22', new lang_string('separador_hr','theme_aigne'), ''));
// Navigation Help Bar Settings
$settings->add(new admin_setting_heading('navhelphead', new lang_string('navhelphead','theme_aigne'), ''));
    // Navigation Help Page url
        $name = 'theme_aigne/navhelp';
        $title = get_string('navhelp','theme_aigne');
        $description = get_string('navhelpdesc', 'theme_aigne');
        $default = '/theme/aigne/layout/navhelp.php';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // webmap Link _ Show
        $name = 'theme_aigne/webmap';
        $title = get_string('webmap','theme_aigne');
        $description = get_string('webmapdesc', 'theme_aigne');
        $default = '1';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // help Link _ Show
        $name = 'theme_aigne/help';
        $title = get_string('help','theme_aigne');
        $description = get_string('helpdesc','theme_aigne');
        $default = '1';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // footsearch Link _ Show
        $name = 'theme_aigne/footsearch';
        $title = get_string('footsearch','theme_aigne');
        $description = get_string('footsearchdesc','theme_aigne');
        $default = '0';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // stats Link _ Show
        $name = 'theme_aigne/stats';
        $title = get_string('stats','theme_aigne');
        $description = get_string('statsdesc','theme_aigne');
        $default = '0';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // disclaimer Link _ Show
        $name = 'theme_aigne/disclaimer';
        $title = get_string('disclaimer','theme_aigne');
        $description = get_string('disclaimerdesc','theme_aigne');
        $default = '1';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // policies Link _ Show
        $name = 'theme_aigne/policies';
        $title = get_string('policies','theme_aigne');
        $description = get_string('policiesdesc','theme_aigne');
        $default = '0';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // privacy Link _ Show
        $name = 'theme_aigne/privacy';
        $title = get_string('privacy','theme_aigne');
        $description = get_string('privacydesc','theme_aigne');
        $default = '1';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // security Link _ Show
        $name = 'theme_aigne/security';
        $title = get_string('security','theme_aigne');
        $description = get_string('securitydesc','theme_aigne');
        $default = '1';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // accessibility Link _ Show
        $name = 'theme_aigne/accessibility';
        $title = get_string('accessibility','theme_aigne');
        $description = get_string('accessibilitydesc','theme_aigne');
        $default = '1';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);

$settings->add(new admin_setting_heading('separador23', new lang_string('separador_bhr','theme_aigne'), ''));
// Contact settings
$settings->add(new admin_setting_heading('contacthead', new lang_string('contacthead','theme_aigne'), ''));
    // email image setting _ To prevent spam copy of email info
        $name = 'theme_aigne/emailimg';
        $title = get_string('emailimg','theme_aigne');
        $description = get_string('emailimgdesc', 'theme_aigne');
        $setting = new admin_setting_configstoredfile($name, $title, $description, 'emailimg');
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Contact note setting
        $name = 'theme_aigne/contactnote';
        $title = get_string('contactnote','theme_aigne');
        $description = get_string('contactnotedesc', 'theme_aigne');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);

$settings->add(new admin_setting_heading('separador24', new lang_string('separador_bhr','theme_aigne'), ''));
// Social Networks settings
$settings->add(new admin_setting_heading('socialhead', new lang_string('socialhead','theme_aigne'), ''));
    // Facebook url setting
        $name = 'theme_aigne/facebook';
        $title = get_string('facebook','theme_aigne');
        $description = get_string('facebookdesc', 'theme_aigne');
        $default = 'http://www.facebook.com/aula.aigne';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Twitter url setting
        $name = 'theme_aigne/twitter';
        $title = get_string('twitter','theme_aigne');
        $description = get_string('twitterdesc', 'theme_aigne');
        $default = 'http://twitter.com/aula_aigne';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Google+ url setting
        $name = 'theme_aigne/googleplus';
        $title = get_string('googleplus','theme_aigne');
        $description = get_string('googleplusdesc', 'theme_aigne');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Flickr url setting
        $name = 'theme_aigne/flickr';
        $title = get_string('flickr','theme_aigne');
        $description = get_string('flickrdesc', 'theme_aigne');
        $default = 'http://www.flickr.com/photos/aigne';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Picasa url setting
        $name = 'theme_aigne/picasa';
        $title = get_string('picasa','theme_aigne');
        $description = get_string('picasadesc', 'theme_aigne');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Instagram url setting
        $name = 'theme_aigne/instagram';
        $title = get_string('instagram','theme_aigne');
        $description = get_string('instagramdesc', 'theme_aigne');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // LinkedIn url setting
        $name = 'theme_aigne/linkedin';
        $title = get_string('linkedin','theme_aigne');
        $description = get_string('linkedindesc', 'theme_aigne');
        $default = 'http://www.linkedin.com/in/aigne';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // YouTube url setting
        $name = 'theme_aigne/youtube';
        $title = get_string('youtube','theme_aigne');
        $description = get_string('youtubedesc', 'theme_aigne');
        $default = 'http://www.youtube.com/aulaaigne';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Vimeo url setting
        $name = 'theme_aigne/vimeo';
        $title = get_string('vimeo','theme_aigne');
        $description = get_string('vimeodesc', 'theme_aigne');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting); 
    // Tumblr url setting
        //$name = 'theme_aigne/tumblr';
        //$title = get_string('tumblr','theme_aigne');
        //$description = get_string('tumblrdesc', 'theme_aigne');
        //$default = '';
        //$setting = new admin_setting_configtext($name, $title, $description, $default);
        //$setting->set_updatedcallback('theme_reset_all_caches');
        //$settings->add($setting);
    // Blogger url setting
        //$name = 'theme_aigne/blogger';
        //$title = get_string('blogger','theme_aigne');
        //$description = get_string('bloggerdesc', 'theme_aigne');
        //$default = '';
        //$setting = new admin_setting_configtext($name, $title, $description, $default);
        //$setting->set_updatedcallback('theme_reset_all_caches');
        //$settings->add($setting);

$settings->add(new admin_setting_heading('separador25', new lang_string('separador_bhr','theme_aigne'), ''));
// Credits settings
    $settings->add(new admin_setting_heading('creditshead', new lang_string('creditshead','theme_aigne'), ''));
    // moodlecredit _ Show
        $name = 'theme_aigne/moodlecredit';
        $title = get_string('moodlecredit','theme_aigne');
        $description = get_string('moodlecreditdesc','theme_aigne');
        $default = '1';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // compatcredit _ Show
        $name = 'theme_aigne/compatcredit';
        $title = get_string('compatcredit','theme_aigne');
        $description = get_string('compatcreditdesc','theme_aigne');
        $default = '1';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // Foot note setting
        $name = 'theme_aigne/footnote';
        $title = get_string('footnote','theme_aigne');
        $description = get_string('footnotedesc', 'theme_aigne');
        $default = '';
        $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);

$settings->add(new admin_setting_heading('separador26', new lang_string('separador_bhr','theme_aigne'), ''));
// Cortesy settings
    $settings->add(new admin_setting_heading('cortesyhead', new lang_string('cortesyhead','theme_aigne'), ''));
    // Copyright setting.
        $name = 'theme_aigne/copyrightstg';
        $title = get_string('copyrightstg', 'theme_aigne');
        $description = get_string('copyrightstgdesc', 'theme_aigne');
        $default = '';
        $setting = new admin_setting_configtext($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // sitelicensemsg message _ Show
        $name = 'theme_aigne/sitelicensemsg';
        $title = get_string('sitelicensemsg','theme_aigne');
        $description = get_string('sitelicensemsgdesc','theme_aigne');
        $default = '1';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // lastmodifiedmsg message _ Show
        $name = 'theme_aigne/lastmodifiedmsg';
        $title = get_string('lastmodifiedmsg','theme_aigne');
        $description = get_string('lastmodifiedmsgdesc','theme_aigne');
        $default = '1';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);
    // thanksvisitmsg message _ Show
        $name = 'theme_aigne/thanksvisitmsg';
        $title = get_string('thanksvisitmsg','theme_aigne');
        $description = get_string('thanksvisitmsgdesc','theme_aigne');
        $default = '1';
        $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
        $setting->set_updatedcallback('theme_reset_all_caches');
        $settings->add($setting);

}
