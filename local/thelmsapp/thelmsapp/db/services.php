<?php

/**
 * Web service TheLMSApp template external functions and service definitions.
 *
 * @package    TheLMSapp
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// We define the services to install as pre-build services. A pre-build service is not editable by administrator.
$services = array(
        'TheLMSApp Service' => array(
                'functions' => array ('block_thelmsapp_get_userinfo'
                                ),
                'restrictedusers' => 0,
                'enabled'=>1,
				'shortname' => 'thelmsapp',
        )
);

// We defined the web service functions to install.
$functions = array(
        'block_thelmsapp_get_userinfo' => array(
                'classname'   => 'block_thelmsapp_external',
                'methodname'  => 'get_userinfo',
                'classpath'   => 'blocks/thelmsapp/externallib.php',
                'description' => '1.Get the user info',
                'type'        => 'read',
        )
);