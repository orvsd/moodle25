<?php
/**
 * theme_aigne config 
 * 
 * @package    theme_aigne
 * @copyright  2013 Franc Pombal (www.aigne.com)
 * @license    http: *www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

// Name of the theme. Most likely the name of the directory in which this file resides.
$THEME->name = 'aigne';

// Which existing theme(s) in the /theme/ directory do you want this theme to extend. A theme can
// extend any number of themes. Rather than creating an entirely new theme and copying all 
// of the CSS, you can simply create a new theme, extend the theme you like and just add the
// changes you want to your theme.
$THEME->parents = array('base');

// Name of the stylesheet(s) you've including in this theme's /styles/ directory.
$THEME->sheets = array(
    //'aigne_fonts',     /** pending **/
    'aigne_pagelayout',  /** Must come first: page layout **/
    'aigne_style',       /** Must come second: default styles **/
    //'aigne_style_'.$THEME->settings->colorsch, /** Aplicación del formato según la configuración en Admin -> Apperance -> Themes -> AIGNE
    //'admin',
    'aigne_block',
    'aigne_mod',
    //'calendar',        /** -> in aigne_mod **/
    //'grade',           /** -> in aigne_mod **/
    //'course',
    'aigne_dock',
    //'message',
    //'question',
    //'user',
    //'filemanager',
    'aigne_menu',
    'aigne_rtl',
    'aigne_custom'
);

// An array of stylesheets not to inherit from the themes parents (We don't want these)
$THEME->parents_exclude_sheets = array(
    'base'=>array(
        'pagelayout',
        'dock'
    ),
);

// An array of stylesheets to include within the body of the editor.
$THEME->editor_sheets = array('editor');

// Do you want to use the new navigation dock?
$THEME->enable_dock = true;

// These are all of the possible layouts in Moodle. The simplest way to do this is to keep the theme and file
// variables the same for every layout. Including them all in this way allows some flexibility down the road
// if you want to add a different layout template to a specific page.
$THEME->layouts = array(
    // ► LOGIN_LOGOUT MESSAGE Most backwards compatible layout without the blocks
    'base' => array(
        'file' => 'default.php',
        'regions' => array(),
        'defaultregion' => '',
        'options' => array('langmenu'=>true, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>true, 
                           'noblocks'=>true, 'nocourseheaderfooter'=>true, 'nofooter'=>true, 'infobanner'=>true),         
    ),
    // DEFAULT _ Standard layout with blocks, this is recommended for most pages with default information
    'standard' => array(
        'file' => 'default.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true, 'nologininfo'=>true, 'nocustommenu'=>false, 'nonavbar'=>false,
                           'noblocks'=>false, 'nocourseheaderfooter'=>false, 'nofooter'=>true, 'infobanner'=>false),
    ),
    // ► LOGIN PAGE
    'login' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('langmenu'=>true, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>true,
                           'noblocks'=>true, 'nocourseheaderfooter'=>true, 'nofooter'=>false, 'infobanner'=>true),
    ),
    // FRONTPAGE _ The site home page when not logged in.
    'frontpagesite' => array(
        'file' => 'default.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>true,
                           'noblocks'=>false, 'nocourseheaderfooter'=>true, 'nofooter'=>false, 'infobanner'=>true),
    ),    
    // ► DEFAULT _ The site home page.
    'frontpage' => array(
        'file' => 'default.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true, 'nologininfo'=>true, 'nocustommenu'=>false, 'nonavbar'=>false,
                           'noblocks'=>false, 'nocourseheaderfooter'=>false, 'nofooter'=>false, 'infobanner'=>false),
    ),
    // ► NAVHELP PAGE _ Navigation Help Menu Content.
    'navhelppage' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('langmenu'=>true, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>false,
                           'noblocks'=>true, 'nocourseheaderfooter'=>true, 'nofooter'=>false, 'infobanner'=>false),
    ), 
    // ► My MOODLE _ My dashboard page
    'mydashboard' => array(
        'file' => 'default.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true, 'nologininfo'=>true, 'nocustommenu'=>false, 'nonavbar'=>false,
                           'noblocks'=>false, 'nocourseheaderfooter'=>false, 'nofooter'=>false, 'infobanner'=>false),
    ),
    // ► My public page
    'mypublic' => array(
        'file' => 'default.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true, 'nologininfo'=>true, 'nocustommenu'=>false, 'nonavbar'=>false,
                           'noblocks'=>false, 'nocourseheaderfooter'=>false, 'nofooter'=>false, 'infobanner'=>false),
    ),    
    // ► COURSE CATEGORY PAGE _ only categories list or courses list in specific category    
    'coursecategory' => array(
        'file' => 'default.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true, 'nologininfo'=>true, 'nocustommenu'=>false, 'nonavbar'=>false,
                           'noblocks'=>false, 'nocourseheaderfooter'=>false, 'nofooter'=>false, 'infobanner'=>false),
    ),
    // ► COUSE PAGE _ Main course page
    'course' => array(
        'file' => 'default.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>false, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>false,
                           'noblocks'=>false, 'nocourseheaderfooter'=>false, 'nofooter'=>true, 'infobanner'=>false),
    ),
    // ► ACTIVITY OR RESOURCE PAGE _ part of course, typical for modules - default page layout if $cm specified in require_login()
    'incourse' => array(
        'file' => 'default.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>false, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>false,
                           'noblocks'=>false, 'nocourseheaderfooter'=>false, 'nofooter'=>true, 'infobanner'=>false),
    ),
    // ► Server administration scripts.
    'admin' => array(
        'file' => 'default.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu'=>false, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>false,
                           'noblocks'=>false, 'nocourseheaderfooter'=>false, 'nofooter'=>true, 'infobanner'=>false),
    ),
    // POPUP _ ADMIN -> REPORTS _ Pages that appear in pop-up windows 
    'popup' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('langmenu'=>false, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>false,
                           'noblocks'=>true, 'nocourseheaderfooter'=>true, 'nofooter'=>true, 'infobanner'=>false),
    ),
    // frametop _ No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('langmenu'=>false, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>true,
                           'noblocks'=>true, 'nocourseheaderfooter'=>true, 'nofooter'=>true, 'infobanner'=>false),
    ),
    // embedded _ Embedded pages, like iframe/object embeded in moodleform - it needs as much space as possible
    'embedded' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('langmenu'=>false, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>true,
                           'noblocks'=>true, 'nocourseheaderfooter'=>true, 'nofooter'=>true, 'infobanner'=>false),
    ),
    // POPUP _ Used during upgrade and install, and for the 'This site is undergoing maintenance' message.
    // This must not have any blocks, and it is good idea if it does not have links to
    // other places - for example there should not be a home link in the footer...
    'maintenance' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('langmenu'=>false, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>true,
                           'noblocks'=>true, 'nocourseheaderfooter'=>true, 'nofooter'=>true, 'infobanner'=>false),
    ),
    // DEFAULT _ Should display the content and basic headers only.
    'print' => array(
        'file' => 'default.php',
        'regions' => array(),
        'options' => array('langmenu'=>false, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>true,
                           'noblocks'=>true, 'nocourseheaderfooter'=>true, 'nofooter'=>false, 'infobanner'=>false),
    ),
    // DEFAULT _ The pagelayout used when a redirection is occuring.
    'redirect' => array(
        'file' => 'embedded.php',
        'regions' => array(),
        'options' => array('langmenu'=>false, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>true,
                           'noblocks'=>true, 'nocourseheaderfooter'=>true, 'nofooter'=>true, 'infobanner'=>false),
    ),     
    // ► REPORTS _ ADMIN -> REPORTS _ The pagelayout used for reports.
    'report' => array(
        'file' => 'default.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
        'options' => array('langmenu'=>false, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>false,
                           'noblocks'=>false, 'nocourseheaderfooter'=>true, 'nofooter'=>false, 'infobanner'=>false),
    ),
    // DEFAULT _ The pagelayout used for safebrowser and securewindow.
    'secure' => array(
        'file' => 'default.php',
        'regions' => array('side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>false, 'nologininfo'=>true, 'nocustommenu'=>true, 'nonavbar'=>true,
                           'noblocks'=>false, 'nocourseheaderfooter'=>true, 'nofooter'=>false, 'infobanner'=>false),
    ),
);

// We don't want the base theme to be shown on the theme selection screen, by setting
// this to true it will only be shown if theme designer mode is switched on.
$THEME->hidefromselector = false;

// An array containing the names of JavaScript files located in /javascript/ to include in the theme. (gets included in the head)
// $THEME->javascripts = array();

// As above but will be included in the page footer.
// $THEME->javascripts_footer = array();

// Overrides the left arrow image used throughout Moodle
// $THEME->larrow

// Overrides the right arrow image used throughout Moodle
// $THEME->rarrow

// An array of JavaScript files NOT to inherit from the themes parents
// $THEME->parents_exclude_javascripts

// An array of plugin sheets to ignore and not include.
// $THEME->plugins_exclude_sheets

// Sets a custom render factory to use with the theme, used when working with custom renderers.
$THEME->rendererfactory = 'theme_overridden_renderer_factory';

// Allows the user to provide the name of a function that all CSS should be passed to before being delivered.
$THEME->csspostprocess = 'theme_aigne_process_css';
