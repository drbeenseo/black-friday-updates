<?php

class uptin_active_campaign_v1 extends uptin_active_campagin
{

    public function __construct($url, $api_key)
    {
        parent::__construct($url, $api_key);
    }

    public function v1_validate_html($xpath)
    {

        $form_fields = array();
        $i           = 0;
        $error       = 0;
        $success     = 1;

        /**
         * Check to see if captcha exist if so automaticlly disqualify form
         */
        $capthca = $xpath->query("//div[@class='_field _type_captcha']");
        if ($capthca->length > 0) {
            return $error;
        }

        /**
         * @description get form submit url
         * @note ended up not being needed, leaving for good measure
         *//*
		$formtag = $form->getElementsByTagName('form');
		foreach($formtag as $tag){
			foreach($tag->attributes as $form_att){
				if($form_att->name == 'action'){
					$form_fields['action'] = $form_att->textContent;
				}
			}
		}*/
        /**
         * get hidden fields to submit
         * @note ended up note being needed as there was a pre-existing api to submit forms, leaving here just incase
         */
        /*$hidden_values = $xpath->query("//input[@type='hidden']");
        foreach ($hidden_values as $hidden_input){
            foreach($hidden_input->attributes as $hidden_input_att){
                //$name = ($hidden_input_att->name == 'name' ? $hidden_input_att->nodeValue : '');
                if($hidden_input_att->name == 'name'){
                    $name = $hidden_input_att->nodeValue;
                }
                if($hidden_input_att->name == 'value'){
                    $value = $hidden_input_att->value;
                }
                //$value = ($hidden_input_att->name == 'value' ? $hidden_input_att->value : '1');
                $hidden_inputs[$name] = $value;
            }
        }
        //for some reason there is always a blank hidden field ie: $hidden_fields[]=> []
        //so this hack removes it from the array
        foreach($hidden_inputs as $key => $value){
            $length = strlen($key);
            if($length == 0){
                unset ($hidden_inputs[$key]);
            }
            $form_fields['hidden'] = $hidden_inputs;
        }*/

        /**
         * check all divs that contain an input and record them in an array for later processing
         */

        //new form builder released Feb 2016


        $divs = $xpath->query("//div[@class='_field _type_input']");


        foreach ($divs as $div) {
            foreach ($div->childNodes as $node) {

                if (count($node->attributes) > 0) {
                    foreach ($node->attributes as $att) {
                        if ($att->name == 'class' && strpos($att->nodeValue,
                            '_label') >= 0
                        ) {
                            preg_match("/[a-z0-9]/i", $node->nodeValue,
                              $matches);
                            if ($matches) {
                                $form_fields[$i]['label'] = trim($node->nodeValue);

                            }
                        }
                        if ($att->name == 'class' && strpos($att->nodeValue, '_option') >= 0
                        ) {
                            foreach ($node->childNodes as $input) {
                                if (@$input->tagName == 'input') {
                                    foreach ($input->attributes as $input_att) {
                                        if ($input_att->name == 'type' && in_array($input_att->nodeValue, $this->supported_types)) {
                                            $form_fields[$i]['input_type'] = trim($input_att->nodeValue);
                                            $approved_type                 = 'approved';
                                        }
                                        if ($input_att->name == 'name') {
                                            $form_fields[$i]['input_name'] = trim($input_att->nodeValue);
                                        }
                                        $approved_type = false;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $i++;
        }

        /**
         * grab checkboxes and record so we can check to see if they are required. if they are it will disqualify form
         */


        $divs = $xpath->query("//div[@class='_field _type_checkbox']");

        foreach ($divs as $div) {
            foreach ($div->childNodes as $node) {
                if (count($node->attributes) > 0) {
                    foreach ($node->attributes as $att) {
                        if ($att->name == 'class' && strpos($att->nodeValue,
                            'label') >= 0 && $att->nodeValue != '_option'
                        ) {
                            preg_match("/[a-z0-9]/i", $node->nodeValue,
                              $matches);
                            if ($matches) {
                                $form_fields[$i]['label'] = trim($node->nodeValue);
                                //know its a checkbox because of the type_checkbox selector
                                $form_fields[$i]['input_type'] = 'checkbox';

                            }
                        }
                    }
                }
            }
            $i++;
        }

        /**
         * loop through all the form fields that have been recorded check for 1. required (if its not the email field it throws the form out) 2.check for name field, not sure what to do with this yet but I know it will have something to do with the form submitting name fields or not
         *
         */
        foreach ($form_fields as $field) {
            if (@!in_array($field['input_name'], $this->supported_fields)) {
                preg_match("/[*]/i", $field['label'], $required);
            }
            if (@$required) {
                $qualified_form = false;
            } else {
                $qualified_form = 'true';
            }
            if ($qualified_form === false) {
                return $error;
            }
        }

        if ($qualified_form = 'true') {
            return $form_fields;
        }

    }

}