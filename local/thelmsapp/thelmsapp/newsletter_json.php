<?php

/**
 * Version details
 *
 * @package    TheLMSapp
 * @subpackage JSON:Newsletter
 * @copyright  2013 TheLMSapp (http://www.thelmsapp.com)
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');

$context = get_context_instance(CONTEXT_SYSTEM);

$PAGE->set_url('/blocks/thelmsapp/newsletter_json.php');
$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));

//GET CURRENT NEWSLETTER SERVICE VALUE
  $newsletter_service_record    = $DB->get_record_select('block_thelmsapp_config', 'name = \'newsletter.service\'');
  $newsletter_service = $newsletter_service_record->value;
//GET CURRENT NEWSLETTER SERVICE VALUE
            
$post_string = json_encode(array('newsletter.service' => $newsletter_service));
echo $post_string;
  
?>
