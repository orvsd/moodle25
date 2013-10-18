<?php
/**
 * lib
 * 
 * @package    theme_aigne
 * @copyright  2013 Franc Pombal (www.aigne.com)
 * @license    http: *www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 
defined('MOODLE_INTERNAL') || die();

/**
 * Makes our changes to the CSS
 *
 * @param string $css
 * @param theme_config $theme
 * @return string
 */
function theme_aigne_process_css($css, $theme) {

    // Set the font size -> body -> aigne_styles.css
    if (!empty($theme->settings->bodyfont)) {
        $bodyfont = $theme->settings->bodyfont;  
    } else {
        $bodyfont = '14';
    }
    $css =theme_aigne_set_bodyfont($css, $bodyfont);
    
    // Set the image for the logo
    $logo = $theme->setting_file_url('logo', 'logo');
    $css = theme_aigne_set_logo($css, $logo);
    
    // Set the background image for the logo
    $backlogo = $theme->setting_file_url('backlogo', 'backlogo');
    $css = theme_aigne_set_backlogo($css, $backlogo);
    
    // Set the background image for the body
    $backbody = $theme->setting_file_url('backbody', 'backbody');
    $css = theme_aigne_set_backbody($css, $backbody);

    // Set the background image position
    if (!empty($theme->settings->bgposition)) {
       $bgposition = $theme->settings->bgposition;
    } else {
       $bgposition = 'no-repeat';
    }
    $css = theme_aigne_set_bgposition($css, $bgposition);
    
    // Set the background color
    if (!empty($theme->settings->backcolor)) {
        $backcolor = $theme->settings->backcolor;
    } else {
        $backcolor = '#FFFFFF';
    }
    $css = theme_aigne_set_backcolor($css, $backcolor);

    
    // Set the custom menu color
    if (!empty($theme->settings->menucolor)) {
        $menucolor = $theme->settings->menucolor;
    } else {
        $menucolor = '#007EBA';
    }
    $css = theme_aigne_set_menucolor($css, $menucolor);
    
    
    // Set the highlight custom menu color
    if (!empty($theme->settings->menucolorhl)) {
        $menucolorhl = $theme->settings->menucolorhl;
    } else {
        $menucolorhl = '#F3F7FF';
    }
    $css = theme_aigne_set_menucolorhl($css, $menucolorhl);
            
    // Set the frontpage header info image
    $headerinfo = $theme->setting_file_url('headerinfo', 'headerinfo');
    $css = theme_aigne_set_headerinfo($css, $headerinfo);

    // Set the eMail Image _ SPAM Protection
    $emailimg = $theme->setting_file_url('emailimg', 'emailimg');
    $css = theme_aigne_set_emailimg($css, $emailimg);
    
    // Set custom CSS
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    $css = theme_aigne_set_customcss($css, $customcss);
    return $css;
}

/**
 * Adds objects to the CSS before it is cached.
 *
 * @param string $css The CSS.
 * @param string $logo The URL of the logo.
 * @return string The parsed CSS
 */
function theme_aigne_set_bodyfont($css, $bodyfont) {
    $tag = '[[setting:bodyfont]]';
    $css = str_replace($tag, $bodyfont.'px', $css);
    return $css;
}

function theme_aigne_set_logo($css, $logo) {
    global $OUTPUT;
    $tag = '[[setting:logo]]';
    $replacement = $logo;
    if (is_null($replacement)) {
        $replacement = $OUTPUT->pix_url('images/logo','theme');
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_aigne_set_backlogo($css, $backlogo) {
    global $OUTPUT;
    $tag = '[[setting:backlogo]]';
    $replacement = $backlogo;
    if (is_null($replacement)) {
        $replacement = $OUTPUT->pix_url('images/backlogo','theme');
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_aigne_set_backbody($css, $backbody) {
    $tag = '[[setting:backbody]]';
    $replacement = $backbody;
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_aigne_set_bgposition($css, $bgposition) {
    $tag = '[[setting:bgposition]]';
    $replacement = $bgposition;
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_aigne_set_backcolor($css, $backcolor) {
    $tag = '[[setting:backcolor]]';
    $replacement = $backcolor;
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_aigne_set_menucolor($css, $menucolor) {
    $tag = '[[setting:menucolor]]';
    $replacement = $menucolor;
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_aigne_set_menucolorhl($css, $menucolorhl) {
    $tag = '[[setting:menucolorhl]]';
    $replacement = $menucolorhl;
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_aigne_set_headerinfo($css, $headerinfo) {
    global $OUTPUT;
    $tag = '[[setting:headerinfo]]';
    $replacement = $headerinfo;
    if (is_null($replacement)) {
        $replacement = $OUTPUT->pix_url('');
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_aigne_set_emailimg($css, $emailimg) {
    global $OUTPUT;
    $tag = '[[setting:emailimg]]';
    $replacement = $emailimg;
    if (is_null($replacement)) {
        $replacement = $OUTPUT->pix_url('');
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

function theme_aigne_set_customcss($css, $customcss) {
    $tag = '[[setting:customcss]]';
    $css = str_replace($tag, $customcss, $css);
    return $css;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_aigne_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'logo') {
        $theme = theme_config::load('aigne');
        return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
    } else if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'backlogo') {
        $theme = theme_config::load('aigne');
        return $theme->setting_file_serve('backlogo', $args, $forcedownload, $options);
    } else if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'backbody') {
        $theme = theme_config::load('aigne');
        return $theme->setting_file_serve('backbody', $args, $forcedownload, $options);
    } else if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'headerinfo') {
        $theme = theme_config::load('aigne');
        return $theme->setting_file_serve('headerinfo', $args, $forcedownload, $options);                
    } else if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'emailimg') {
        $theme = theme_config::load('aigne');
        return $theme->setting_file_serve('emailimg', $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}
