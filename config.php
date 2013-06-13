<?PHP
unset($CFG);  // Ignore this line
global $CFG;  // This is necessary here for PHPUnit execution
$CFG = new stdClass();

//=========================================================================
// 1. ORVSD CONFIG
//=========================================================================

// HAProxy is now passing the X-Forwarded-Proto header to Nginx, which maps to the
// fastcgi_param PHP variable HTTPS and triggers it either on or off based on the
// protocol in use.  This lets us use loginhttps, disable the sslproxy and set the
// wwwroot to http:// in order to avoid mixed content warnings with the media
// servers and external resources.
$CFG->sslproxy = false;
$CFG->loginhttps = true;

// ORVSD Performance tweaks
$CFG->dbsessions = false;
$CFG->enablestats = false;
$CFG->themedesignermode = false;
$CFG->loglifetime = 365;
$CFG->gradehistorylifetime = 365;
$CFG->updateautocheck = false;
$CFG->updateautodeploy = false;
$CFG->updatenotifybuilds = false;

// ORVSD variables based on directory structure
$orvsdcwd = explode("/", getcwd());
$orvsduser = $orvsdcwd[3];
$orvsdfqdn = $orvsdcwd[5];

// Now you need to tell Moodle where it is located. Specify the full
// web address to where moodle has been installed.
$CFG->wwwroot   = 'http://' . $orvsdfqdn;
$CFG->dataroot  = '/data/moodledata/' . $orvsduser . '/moodle25/' . $orvsdfqdn;
$CFG->directorypermissions = 02770;

// ORVSD ClamAV config
$CFG->runclamonupload = true;
$CFG->pathtoclam = '/usr/bin/clamscan';
$CFG->quarantinedir = $CFG->dataroot . '/temp';

// Include relevant configuration from glusterfs mount.
require_once('/data/moodledata/' . $orvsduser . '/moodle25/' . $orvsdfqdn . '/config.php');

//=========================================================================
// ALL DONE!  To continue installation, visit your main page with a browser
//=========================================================================

require_once(dirname(__FILE__) . '/lib/setup.php'); // Do not edit

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
