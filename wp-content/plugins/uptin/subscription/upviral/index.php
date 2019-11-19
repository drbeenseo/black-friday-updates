<?php 
require("upviral.class.php");
/**
 * API_KEY = Api key one you can get from dashboard.
 * method = 'lists' method is used to fetch all lists
 * 
 */
        
$upviral = new Upviral('Uf0sr+mtZw1OBhw4LHZZ0w20p3o1BAoQx88p0vo3D3c=');
$lists = $upviral->getCampaignLists();
$mylist = json_decode($lists);
echo count($mylist);
// echo $mylist[0]->name;
foreach($mylist as $list){
	echo $list->id.'='.$list->name.'<br/>';
}
echo "<pre>";print_r($lists);

/**
 * method = 'add_contact' method is used to add contact to list
 * args = associative array with required details for example list_id,name,email
 * return user id will be returned.
 */
// $contact = $upviral->addContact('9283','markytest','test01@emarky.nl');
// echo "<pre>";print_r($contact);

$contact = $upviral->addContactRefs('9283','markytest','test01@emarky.nl', 'j1282579');
// echo "<script>alert('".$contact."');</script>";
echo "<pre>";print_r($contact);exit();

?>
