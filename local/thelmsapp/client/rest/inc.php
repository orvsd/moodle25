<?php

/// MOODLE ADMINISTRATION SETUP STEPS
// 1- Install the plugin
// 2- Enable web service advance feature (Admin > Advanced features)
// 3- Enable XMLRPC protocol (Admin > Plugins > Web services > Manage protocols)
// 4- Create a token for a specific user and for the service 'My service' (Admin > Plugins > Web services > Manage tokens)
// 5- Run this script directly from your browser: you should see 'Hello, FIRSTNAME'

/// SETUP - NEED TO BE CHANGED
$token = 'a1678e54ed83cd7bcae95f345ee3ca86';
$domainname = 'http://192.168.1.82';

$restformat = 'json';

/// FUNCTION NAME 
$functionname = 'block_thelmsapp_get_userinfo';

/// PARAMETERS
//$username = 'dmarag';
//$email = 'support@sqlearn.gr';
$params = array('username' => 'dmarag', 'email' => '', 'id' => '');

///// REST CALL
header('Content-Type: text/plain');
$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname;
require_once('./curl.php');
$curl = new curl;

$restformat = ($restformat == 'json')?'&moodlewsrestformat=' . $restformat:'';
$resp = $curl->post($serverurl . $restformat, $params);
//print_r($resp);
$y = json_decode($resp);
//$yy = json_decode($y);
echo var_dump($y);
echo $y->email;