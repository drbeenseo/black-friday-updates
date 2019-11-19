<?php 
require("upviral.class.php");

/**
 * API_KEY = Api key one you can get from dashboard.
 * method = 'lists' method is used to fetch all lists
 * 
 */

define(API_KEY, 'xxxxxxxxxxxxxxxxxxxxxxxxx');
$upviral = new Upviral(API_KEY);
$lists = $upviral->getCampaignLists();
echo "<pre>";print_r($lists);
/**
 * method = 'add_contact' method is used to add contact to list
 * args = associative array with required details for example list_id,name,email
 * return user id will be returned.
 */
$contact = $upviral->addContact($list_id,$name,$email);
echo "<pre>";print_r($contact);

/**
 * method = 'get_js_snippet' method is used to get js snippet path
 * return js snippet path will be returned.
 */
$js_snippet = $upviral->getJsSnippetName('191');
echo "<pre>";print_r($js_snippet);
?>