<?php  

// This file is NOT a part of Moodle - http://moodle.org/
//
// This client for Moodle 2 is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//

/**
* REST client for Moodle 2
* Return JSON or XML format
*
* @authorr Jerome Mouneyrac
*/

function spaces($num) {
    $output = "";
    for ($i = 0; $i < $num; ++$i) {
        $output .= " ";
    }
    return $output;
}

/** For viewing or debugging the json_encoded output
 ** in a human-readable format.
 ** This function has bugs, it is hacked to make the
 ** output from the response semi-readable.
 */
function formatted_output($input) {
    if ( empty ($input ) ) {
        return $input;
    }

    $prevchar = $input[0];
    $char = $prevchar;
    $input = substr($input, 1); // remove first character
    $INDENT_SIZE = 4;
    $output = "";
    $indent = 0;
    $line = "";
    $char = '';
    $in_fieldname = false;
    $extracted_fieldname = false;
    $char = $input[0];
    for ($pos = 0; $pos < strlen($input); ++$pos) {
        $prevchar = $char;
        $char = $input[$pos];
        if ($pos >= strlen($input))
            $nextchar = '';
        else
            $nextchar = $input[$pos+1];
        
        if (in_array($char, ['{', '['])) {
            $line .= $char."\n";
            $output .= $line;
            $indent += $INDENT_SIZE;
            $line = spaces($indent);
        }
        else if (in_array($char, [','])) {
            $line .= $char."\n";
            $output .= $line;
            $line = spaces($indent);
        }
        else if (in_array($char, [']', '}'])) {
            $output .= $line."\n";
            $indent -= $INDENT_SIZE;
            $line = spaces($indent);
            $line .= $char;
        }
        else if (in_array($char, ['\\'])) {
            // do nothing
        }
        else if (in_array($char, ['"'])) {
            if (in_array($nextchar, ['{', '['])) {
                // do not add the double-quote "
            }
            else if (in_array($prevchar, ['}', ']'])) {
                // do not add the double quote "
            }
            else if ($extracted_fieldname) {
                $line .= $char;
            }
            else {
                if ($in_fieldname) {
                    $extracted_fieldname = true;
                }
                $line .= $char;
            }
        }
        else {
            $line .= $char;
        }

    }

    return $output."}";

}

/// SETUP - NEED TO BE CHANGED
$token = ''; //FILL THIS IN!!!
$domainname = 'http://school27';
$functionname = 'local_orvsd_siteinfo_siteinfo';

// REST RETURNED VALUES FORMAT
$restformat = 'json'; //Also possible in Moodle 2.2 and later: 'json'
                     //Setting it to 'json' will fail all calls on earlier Moodle version

//////// moodle_user_create_users ////////

/// PARAMETERS - NEED TO BE CHANGED IF YOU CALL A DIFFERENT FUNCTION

$course1 = array();
$course1['datetime'] = 14;
$params = array('course1' => $course1);

print "Calling the REST server with parameters:\n";
print_r($course1);

/// REST CALL
//header('Content-Type: text/plain');
$serverurl = $domainname . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$functionname;;
require_once('./curl.php');
$curl = new curl;
//if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2

$restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
$resp = $curl->post($serverurl . '&moodlewsrestformat=json', $course1);
print("\n\n");
print($resp);
print("\n\n");
print(formatted_output($resp)."\n");
