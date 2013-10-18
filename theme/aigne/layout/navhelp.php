<?php
/**
 * Help pages _ Moodle adaptation
 * 
 * @package    theme_aigne
 * @copyright  1997 Franc Pombal (www.aigne.com)
 * @license    http: *www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../../config.php');
require_once($CFG->libdir.'/filelib.php');
require_once($CFG->libdir.'/resourcelib.php');

$hasnavhelp = $PAGE->theme->settings->navhelp;
$navhelptype = optional_param('type', 0, PARAM_INT);

// Comprobar si esta algo mal con la dirección. En tal caso cargará la página anterior.
if (!empty($SESSION->wantsurl)) {
    $return = $SESSION->wantsurl;
} else {
    $return = $CFG->wwwroot.'/';
}

// Comprobar si esta vacía la dirección en la configuración de navhelp. En tal caso, volver a la página anterior.
if (empty($hasnavhelp)) {
    redirect($return);
}

switch ($navhelptype) {
    case 1:
        $strnavhelp = get_string('webmap','theme_aigne');
        break;
    case 2:
        $strnavhelp = get_string('help','theme_aigne');
        break;
    case 3:
        $strnavhelp = get_string('footsearch','theme_aigne');
        break;
    case 4:
        $strnavhelp = get_string('stats','theme_aigne');
        break;
    case 5:    
        $strnavhelp = get_string('disclaimer','theme_aigne');
        break;
    case 6:
        $strnavhelp = get_string('policies','theme_aigne');
        break;
    case 7:
        $strnavhelp = get_string('privacy','theme_aigne');
        break;
    case 8:
        $strnavhelp = get_string('security','theme_aigne');
        break;
    case 9:
        $strnavhelp = get_string('accessibility','theme_aigne');
        break;                                                        
    default:
        $strnavhelp = get_string('navhelppage','theme_aigne');
        break;
}

// Contexto general de la página
$PAGE->set_context(context_system::instance());
$PAGE->set_url(new moodle_url('/theme/aigne/layout/navhelp.php'));
$PAGE->set_popup_notification_allowed(false);
$PAGE->set_pagelayout('navhelppage');
$PAGE->set_title($SITE->shortname.' _ '.$strnavhelp);
$PAGE->set_heading($strnavhelp);
// Añadir opciones a la barra de navegación breadcumb
$PAGE->navbar->add($SITE->shortname);
$PAGE->navbar->add(get_string('navhelppagetitle','theme_aigne'));
$PAGE->navbar->add($strnavhelp);
// Inciar publicación _ top.php
echo $OUTPUT->header();
// Título principal de la página
// echo $OUTPUT->heading($strnavhelp);

// Comprobar que si se ha identificado en el sitio o si es invitado. En tal caso, mostrar página con las políticas del sitio
if ((!isloggedin()) or (isguestuser())) {
	echo get_string('disclaimerpage','theme_aigne');
    break;
}

// SELECT CASE _ integer optinal param in the page
switch ($navhelptype) {
    case 1:
        $data = new stdClass;
        $data->sitename = format_string($SITE->shortname);	
        echo get_string('webmappage','theme_aigne', $data);
        break;
    case 2:
        $data = new stdClass;
        $data->link = $CFG->wwwroot.'/local/';
        $data->supportemail = get_config('moodle','supportemail');
        $data->sendadminemail = get_string('sendadminemail','theme_aigne');
        echo get_string('helppage','theme_aigne', $data);
        break;
    case 3:
        echo get_string('footsearchpage','theme_aigne');
        break;
    case 4:
        echo get_string('statspage','theme_aigne');
        break;
    case 5:
        $data = new stdClass;
        $data->sitenamelow = strtolower($SITE->shortname);
        $data->sitename = format_string($SITE->shortname);
        $data->supportemail = get_config('moodle','supportemail');
        $data->sendadminemail = get_string('sendadminemail','theme_aigne');
        echo get_string('disclaimerpage','theme_aigne', $data);
        break;
    case 6:
        echo get_string('policiespage','theme_aigne');
        break;
    case 7:
        $data = new stdClass;
        $data->sitenamelow = strtolower($SITE->shortname);
        $data->supportemail = get_config('moodle','supportemail');
        $data->sendadminemail = get_string('sendadminemail','theme_aigne');
		$data->remoteaddr = $_SERVER['REMOTE_ADDR'];
		$data->remotehost = 'equipo';
		$data->remoteuser = 'usuario';
		$data->language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
		$data->useragent = $_SERVER['HTTP_USER_AGENT'];
		$data->referer = $_SERVER['HTTP_REFERER'];
        echo get_string('privacypage','theme_aigne', $data);
        break;
    case 8:
        echo get_string('securitypage','theme_aigne');
        break;
    case 9:
        $data->supportemail = get_config('moodle','supportemail');
        $data->sendadminemail = get_string('sendadminemail','theme_aigne');
        echo get_string('accessibilitypage','theme_aigne', $data);
        break;                                                        
    default:
        echo get_string('disclaimerpage','theme_aigne');
        break;
}

echo $OUTPUT->footer();

?>
