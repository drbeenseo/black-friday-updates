<?php
/**
* This is a simple library for getting campaign list and add leads to campaign
* Created by Priyanka Dwivedi (http://upviral.com)
*/
class Upviral 
{
    private $api_key;
    private $method;

    function __construct($api_key)
    {
        $this->api_key = $api_key;
    }
    
    /**
     * This will return all campaign lists
     */
    public function getCampaignLists()
    {
        $this->method = 'lists';
        return $this->processRequest();
    }
    
    /**
     * This will add contact to list id
     * Return will be array with uId and email.
     */
    public function addContact($list_id,$name,$email,$custom_fields = array())
    {
        $this->method = 'add_contact';
        $args = array('list_id'=>$list_id,'name'=>$name,'email' => $email,'custom_fields'=> json_encode($custom_fields));
        return $this->processRequest($args);
    }


    /**
     * Return will be js Snippet name
     */
    public function getJsSnippetName($list_id)
    {
        $this->method = 'get_js_snippet';
        $args = array('list_id'=>$list_id);
        return $this->processRequest($args);
    }

    
    /*
     * This is to process the request for the method called.
     */

    private function processRequest($args=array())
    {      
        $args['uvapikey'] = $this->api_key;
        $args['uvmethod'] = $this->method;
        $url = "http://app.upviral.com/api/index/call/ajax/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST,count($args));
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        @curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch); 
        $curl_info = curl_getinfo($ch);
        curl_close($ch);
        return $result;
    }

    public function addContactRefs($list_id,$name,$email, $reflink,$custom_fields = array())
    {
        $this->method = 'add_contact';
        $args = array('list_id'=>$list_id,'name'=>$name,'email' => $email,'custom_fields'=> json_encode($custom_fields), 'reflink' => $reflink);
        // return $this->processRequest($args);
        return $this->processRequest_Ref($args, $list_id, $reflink);
    }

    //reflink
    //https://app.upviral.com/site/parse_new_users/call/ajax/campId/9283/reflink/r1280914
    private function processRequest_Ref($args=array(), $list_id, $reflink)
    {      
        // $args['uvapikey'] = $this->api_key;
        // $args['uvmethod'] = $this->method;
        foreach($args as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
        rtrim($fields_string, '&');
        $url = "http://app.upviral.com/site/parse_new_users/call/ajax/campId/".$list_id."/reflink/".$reflink;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST,count($args));
        curl_setopt($ch, CURLOPT_POSTFIELDS,$fields_string);
        @curl_setopt($ch,CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch); 
        $curl_info = curl_getinfo($ch);
        curl_close($ch);
        return $result;
        // return 'success';
    }

}