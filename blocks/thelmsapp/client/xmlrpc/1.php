<?php

require_once('./inc.php');

/// FUNCTION NAME 
$functionname = 'block_thelmsapp_get_userinfo';

/// PARAMETERS
//$username = 'dmarag';
$email = 'dmarag@sqlearn.gr';
$params = array('', $email, '');


///// XML-RPC CALL
$post = xmlrpc_encode_request($functionname, $params);
print_r($post);
$resp = xmlrpc_decode($curl->post($serverurl, $post));
print_r($resp);
