<?php

if (!class_exists('EWD_Dash')) {
	require_once(EWD_UPTIN_PLUGIN_DIR . 'uptin.php');
}

class uptin_upviral extends EWD_Uptin
{

	public function __contruct()
	{

	}

	public function draw_upviral_form($form_fields, $service, $field_values)
	{
		$form_fields .= sprintf( '
					<div class="rad_dashboard_account_row">
						<label for="%1$s">%3$s</label>
						<input type="password" value="%5$s" id="%1$s">%7$s
					</div>
',
			esc_attr( 'api_key_' . $service ),
			esc_attr( 'client_id_' . $service ),
			__( 'API Key', 'uptin' ),
			__( 'JS snippet name', 'uptin' ),
			( '' !== $field_values && isset( $field_values['api_key'] ) ) ? esc_attr( $field_values['api_key'] ) : '',
			( '' !== $field_values && isset( $field_values['client_id'] ) ) ? esc_attr( $field_values['client_id'] ) : '',
			EWD_Uptin::generate_hint( sprintf(
				'<a href="http://www.uptin.com/docs#'.$service.'" target="_blank">%1$s</a>',
				__( 'Click here for more information', 'uptin' )
			), false )
		);
		return $form_fields;
	}

	/**
	 * Retrieves the lists via UpViral API and updates the data in DB.
	 * @return string
	 */

	function get_upviral_list( $app_id, $api_key, $name ) {
		if ( ! function_exists( 'curl_init' ) ) {
			return __( 'curl_init is not defined ', 'uptin' );
		}

		// if ( ! class_exists( 'iSDK' ) ) {
			require_once( EWD_UPTIN_PLUGIN_DIR . 'subscription/upviral/upviral.class.php' );
		// }

		$upviral = new Upviral($api_key);
		$uplists = $upviral->getCampaignLists();
		$mylist = json_decode($uplists);

		$lists = array();
		if(count($mylist) > 0){
			$all_lists = $mylist;
			if ( ! empty( $all_lists ) ) {
				foreach ( $all_lists as $list ) {
					$group_query                               = '%' . $list->id . '%';
					
					// $subscribers_count                         = $upviral_app->dsCount( 'Contact', array( 'Groups' => $group_query ) );
					$lists[ $list->id ]['name']              = sanitize_text_field( $list->name );
					// $lists[ $list->id ]['subscribers_count'] = sanitize_text_field( $subscribers_count );
					// $lists[ $list->id ]['growth_week']       = sanitize_text_field( $this->calculate_growth_rate( 'upviral_' . $list->id ) );
				}

				$this->update_account( 'upviral', sanitize_text_field( $name ), array(
					'lists'         => $lists,
					'api_key'       => sanitize_text_field( $api_key ),
					'client_id'     => sanitize_text_field( $app_id ),
					'is_authorized' => 'true',
				) );
			}

			$error_message = 'success';
		}else{
			$error_message = 'No Campaign List!';
		}

		return $error_message;
	}

	/**
	 * Subscribes to Infusionsoft list. Returns either "success" string or error message.
	 * @return string
	 */
	function subscribe_upviral( $api_key, $app_id, $list_id, $email, $name = '', $last_name = '' ) {
		if ( ! function_exists( 'curl_init' ) ) {
			return __( 'curl_init is not defined ', 'uptin' );
		}
		if( !is_email($email) ){
		  return 'Email address appears to be invalid';
		}
		// if ( ! class_exists( 'iSDK' ) ) {
		// 	require_once( EWD_UPTIN_PLUGIN_DIR . 'subscription/infusionsoft/isdk.php' );
		// }

		// try {
		// 	$infusion_app = new iSDK();
		// 	$infusion_app->cfgCon( $app_id, $api_key, 'throw' );
		// } catch ( iSDKException $e ) {
		// 	$error_message = $e->getMessage();
		// }

		require_once( EWD_UPTIN_PLUGIN_DIR . 'subscription/upviral/upviral.class.php' );

		// $contact_details = array(
		// 	'FirstName' => $name,
		// 	'LastName'  => $last_name,
		// 	'Email'     => $email,
		// );
		// $new_contact_id = $infusion_app->addWithDupCheck($contact_details, $checkType = 'Email');
		// $infusion_app->optIn($contact_details['Email']);
		// $response = $infusion_app->grpAssign( $new_contact_id, $list_id );
	 //  	if($response) {
		//   //contact added
		// 	$error_message = 'success';
		// }else{
		// 	//update contact if no $response
		//   $contact_id = $this->get_contact_id($infusion_app, $email);
		//   $updated_contact = $this->update_contact($infusion_app, $contact_details, $contact_id);
		//   if($updated_contact){
		// 	$error_message = 'success';
		//   }
		// }

		$upviral = new Upviral($api_key);
		$name = $name.' '.$last_name;

		$contact = $upviral->addContact($list_id, $name, $email);
		$result = json_decode($contact);
		// echo "<pre>";print_r($contact);
		if($result->result == 'success'){
			$error_message['success'] = 'success';
			$error_message['uId'] = $result->uid;
		}else{
			$error_message['success'] = 'error';
		}

		return json_encode($error_message);
	}

	function subscribe_upviral_ref ( $api_key, $app_id, $list_id, $email, $name = '', $last_name = '', $ref_link ) {
		if ( ! function_exists( 'curl_init' ) ) {
			return __( 'curl_init is not defined ', 'uptin' );
		}
		if( !is_email($email) ){
		  return 'Email address appears to be invalid';
		}
		// if ( ! class_exists( 'iSDK' ) ) {
		// 	require_once( EWD_UPTIN_PLUGIN_DIR . 'subscription/infusionsoft/isdk.php' );
		// }

		// try {
		// 	$infusion_app = new iSDK();
		// 	$infusion_app->cfgCon( $app_id, $api_key, 'throw' );
		// } catch ( iSDKException $e ) {
		// 	$error_message = $e->getMessage();
		// }

		require_once( EWD_UPTIN_PLUGIN_DIR . 'subscription/upviral/upviral.class.php' );

		// $contact_details = array(
		// 	'FirstName' => $name,
		// 	'LastName'  => $last_name,
		// 	'Email'     => $email,
		// );
		// $new_contact_id = $infusion_app->addWithDupCheck($contact_details, $checkType = 'Email');
		// $infusion_app->optIn($contact_details['Email']);
		// $response = $infusion_app->grpAssign( $new_contact_id, $list_id );
	 //  	if($response) {
		//   //contact added
		// 	$error_message = 'success';
		// }else{
		// 	//update contact if no $response
		//   $contact_id = $this->get_contact_id($infusion_app, $email);
		//   $updated_contact = $this->update_contact($infusion_app, $contact_details, $contact_id);
		//   if($updated_contact){
		// 	$error_message = 'success';
		//   }
		// }

		$upviral = new Upviral($api_key);
		$name = $name.' '.$last_name;

		$contact = $upviral->addContactRefs($list_id,$name,$email, $ref_link);
		// $result = json_decode($contact);
		// // echo "<pre>";print_r($contact);
		// if($result->result == 'success'){
			$error_message['success'] = 'success';
			$error_message['url'] = str_replace(';', '', str_replace('"', '', str_replace('window.location=', "", strip_tags($contact))));
		// }else{
		// 	$error_message['success'] = 'error';
		// }
		echo json_encode($error_message);
		exit();
	}

  	protected function get_contact_id($upviral_app, $email){
	  $returnFields = array('Id');
	  $data = $upviral_app->findByEmail($email, $returnFields);
	  return $data[0]['Id'];
	}

  	protected function update_contact($upviral_app, $contact_details, $contact_id){
		$result = $upviral_app->updateCon($contact_id, $contact_details);
	    return $result;
	}

}