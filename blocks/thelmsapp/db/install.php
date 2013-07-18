<?php

/**
 * This file replaces the legacy STATEMENTS section in db/install.xml,
 * lib.php/modulename_install() post installation hook and partially defaults.php
 *
 * @package    TheLMSApp
 * @subpackage Install
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Post installation procedure
 */
function xmldb_block_thelmsapp_install() {
    global $DB;
	
	$result = true;
	
	$rec->name  = 'service.newsletter';
	$rec->value = '1';
	$result = $result && $DB->insert_record('block_thelmsapp_config', $rec);

	$rec->name  = 'service.course';
	$rec->value = '1';
	$result = $result && $DB->insert_record('block_thelmsapp_config', $rec);
	
	$rec->name  = 'service.leads';
	$rec->value = '1';
	$result = $result && $DB->insert_record('block_thelmsapp_config', $rec);
	
	$rec->name  = 'service.registration';
	$rec->value = '1';
	$result = $result && $DB->insert_record('block_thelmsapp_config', $rec);
	
	$rec->name  = 'language.md5';
	$rec->value = '';
	$result = $result && $DB->insert_record('block_thelmsapp_config', $rec);
	
	return $result;
}
