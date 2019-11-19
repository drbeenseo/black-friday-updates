<?php

if ( ! class_exists( 'EWD_Dash' ) ) {
	require_once( EWD_UPTIN_PLUGIN_DIR . 'uptin.php' );
}

class uptin_hubspot extends EWD_Uptin
{

	public function __contruct(){

	}

	public function draw_hubspot_form($form_fields, $service, $field_values)
	{
		$form_fields .= sprintf( '
					<div class="rad_dashboard_account_row">
						<label for="%1$s">%2$s</label>
						<input type="password" value="%3$s" id="%1$s">%4$s
					</div>',
			esc_attr( 'api_key_' . $service ),
			__( 'API key', 'uptin' ),
			( '' !== $field_values && isset( $field_values['api_key'] ) ) ? esc_attr( $field_values['api_key'] ) : '',
			EWD_Uptin::generate_hint( sprintf(
				'<a href="http://www.uptin.com/docs#'.$service.'" target="_blank">%1$s</a>',
				__( 'Click here for more information', 'uptin' )
			), false
			)
		);
		return $form_fields;
	}
	/**
	 * Retrieves the lists via HubSpot API and updates the data in DB.
	 * @return string
	 */

	public function get_hubspot_lists( $api_key, $name ) {

		//get hubspots lists class
		if ( ! class_exists( 'HubSpot_Lists_Uptin' ) ) {
			require_once( EWD_UPTIN_PLUGIN_DIR . 'subscription/hubspot/class.lists.php' );
		}

		$lists = new HubSpot_Lists_Uptin( $api_key );
		try {

			$some_lists = $lists->get_static_lists(array('offset'=>0));
			$list_array = array();
			foreach ($some_lists->lists as $list) {
				if (!preg_match("/^(Workflow:)/i", $list->name, $matchs)) { //weed out workflows
					$list_array[$list->listId]['name'] = $list->name;
					$list_array[$list->listId]['subscribers_count'] = $list->metaData->size;
					$list_array[$list->listId]['growth_week'] = sanitize_text_field($this->calculate_growth_rate('hubspot_' . $list->listId));

				}
			}
			$this->update_account( 'hubspot', sanitize_text_field( $name ), array(
				'api_key'       => sanitize_text_field( $api_key ),
				'lists'         => $list_array,
				'is_authorized' => 'true',
			));
			$error_message = 'success';
			return $error_message;

		} catch ( exception $e ) {
			$error_message = 'Error getting lists';

			return $error_message;
		}

	}

	public function hubspot_subscribe($api_key, $email, $list_id, $name, $last_name){
		if(!class_exists('HubSpot_Lists_Uptin')) {
			require_once(EWD_UPTIN_PLUGIN_DIR . 'subscription/hubspot/class.lists.php');
		}
		if ( ! class_exists( 'HubSpot_Contacts_Uptin' ) ) {
			require_once( EWD_UPTIN_PLUGIN_DIR . 'subscription/hubspot/class.contacts.php' );
		}

	  	if( !is_email( $email ) ){
		  return 'Email address does not appear to be valid';
		}
		$contacts = new HubSpot_Contacts_Uptin( $api_key );
		$lists    = new HubSpot_Lists_Uptin( $api_key );

		//see if contact exists
		$contact_exists = false;
		$contact_id     = '';
		$error_message  = '';

		$contactByEmail = $contacts->get_contact_by_email( $email );

	  	if(is_object($contactByEmail) && isset($contactByEmail->status ) && $contactByEmail->status == 'error'){
			if($contactByEmail->message != 'contact does not exist') { //dont error on this so it can go through creating the contact;
			  return $contactByEmail->message;
			}
		}

		if ( ! empty( $contactByEmail ) && isset( $contactByEmail->vid ) ) {
			$contact_exists = true;
			$contact_id     = $contactByEmail->vid;
		}

		//add contact
		if($contact_exists == false){

			//try to make a smart guess if they put their first and last name in the name field or if its just a single name form
			$names_array = uptin_name_splitter($name, $last_name);
			$name = $names_array['name'];
			$last_name = $names_array['last_name'];
			$args =  array('email' => $email, 'firstname' => $name, 'lastname' => $last_name );
			$new_contact = $contacts->create_contact($args);
			$contact_id = $new_contact->vid;
		}

		//add contact to list

		$contacts_to_add = array( $contact_id );

		$added_contacts = $lists->add_contacts_to_list( $contacts_to_add, $list_id );
		$response       = json_decode( $added_contacts );
		if ( ! empty( $response->updated ) ) {
			$error_message = 'success';
		} elseif( sizeof( $response->discarded ) > 0) {
		  $args =  array('email' => $email, 'firstname' => $name, 'lastname' => $last_name );
		  $update_contact = $contacts->update_contact($contact_id, $args);
		  return 'success';
		}else{
		  return 'Something went wrong. Please try again later';
		}

		return $error_message;
	}

}
?>