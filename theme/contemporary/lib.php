<?php

/**
 * Makes our changes to the CSS
 *
 * @param string $css
 * @param theme_config $theme
 * @return string 
 */
function contemporary_process_css($css, $theme) {

    // Set the link color
    if (!empty($theme->settings->linkcolor)) {
        $linkcolor = $theme->settings->linkcolor;
    } else {
        $linkcolor = null;
    }
    $css = contemporary_set_linkcolor($css, $linkcolor);
    
     // Set the banner image
    if (!empty($theme->settings->banner)) {
        $banner = $theme->settings->banner;
    } else {
        $banner = null;
    }
    $css = contemporary_set_banner($css, $banner);
    
	// Set the customcss
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
	$css = contemporary_set_customcss($css, $customcss);
    // Return the CSS
    return $css;
}


/**
 * Sets the link color variable in CSS
 *
 */
function contemporary_set_linkcolor($css, $linkcolor) {
    $tag = '[[setting:linkcolor]]';
    $replacement = $linkcolor;
    if (is_null($replacement)) {
        $replacement = '#32529a';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the banner variable in CSS
 *
 */
function contemporary_set_banner($css, $banner) {
	global $OUTPUT;
	$tag = '[[setting:banner]]';
	$replacement = $banner;
	if (is_null($replacement)) {
 		$replacement = $OUTPUT->pix_url('banner', 'theme');
 	}
	$css = str_replace($tag, $replacement, $css);
	return $css;
}

/**
 * Sets the customcss variable in CSS
 *
 */
function contemporary_set_customcss($css, $customcss) {
	global $OUTPUT;
	$tag = '[[setting:customcss]]';
	$replacement = $banner;
	if (is_null($replacement)) {
 		$replacement = '';
 	}
	$css = str_replace($tag, $customcss, $css);
	return $css;
}