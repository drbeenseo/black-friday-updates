<?php

if ( ! class_exists( 'EWD_Dash' ) ) {
  require_once( EWD_UPTIN_PLUGIN_DIR . 'uptin.php' );
}

class uptin_mailchimp extends EWD_Uptin{

  public function __contruct(){

  }

  public function draw_mailchimp_form($form_fields, $service, $field_values)
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
   * Retrieves the lists via MailChimp API and updates the data in DB.
   * @return string
   */

  public function get_mailchimp_lists( $api_key, $name=''){

	$lists = array();
	$error_message = '';
	$args = array(
	  'start' => 0,
	  'limit' => 100
	);

	if ( ! function_exists( 'curl_init' ) ) {
	  return __( 'curl_init is not defined ', 'uptin' );
	}

	if ( ! class_exists( 'MailChimp_Uptin' ) ) {
	  require_once( EWD_UPTIN_PLUGIN_DIR . 'subscription/mailchimp/mailchimp.php' );
	}

	if ( false === strpos( $api_key, '-' ) ) {
	  $error_message = __( 'invalid API key', 'uptin' );
	  return $error_message;
	}
	$mailchimp = new MailChimp_Uptin($api_key);

	$retval = $mailchimp->call('lists/list', $args);
	$error_message = $this->mailchimp_error_check($retval);
	if(strlen($error_message) > 0) {
	  return $error_message;
	}
	$number_list_returned = $retval['total'];

	if($number_list_returned <= 100){
	  $lists = $this->all_mailchimp_lists($retval);
	}else{
	  $error_message = 'success';
	  //set original call into list array
	  $list_itterator = $retval['total'];
	  while($list_itterator > 0) {
		$retval = $mailchimp->call('lists/list', $args);
		$new_lists = $this->all_mailchimp_lists($retval);
		$lists = array_merge($lists, $new_lists);
		if ($list_itterator >= 100) {
		  $args['start'] = $args['start'] + 1;
		}
		else {
		  $args['start'] = $args['start'] + $list_itterator;
		}
		$list_itterator = $list_itterator - 100;
	  }
	}

	$this->update_account( 'mailchimp', sanitize_text_field( $name ), array(
	  'lists'         => $lists,
	  'api_key'       => sanitize_text_field( $api_key ),
	  'is_authorized' => 'true',
	) );

	$error_message = 'success';
	return $error_message;
  }


  private function all_mailchimp_lists($returnedLists){
	$current_lists = array();
	foreach ( $returnedLists['data'] as $list ) {
	  $current_lists[ $list['id'] ]['name']              = sanitize_text_field( $list['name'] );
	  $current_lists[ $list['id'] ]['subscribers_count'] = sanitize_text_field( $list['stats']['member_count'] );
	  $current_lists[ $list['id'] ]['growth_week']       = sanitize_text_field( $this->calculate_growth_rate( 'mailchimp_' . $list['id'] ) );
	}

	return $current_lists;
  }


  private function mailchimp_error_check($retval){
	$error_message = '';
	if ( ! empty( $retval['errors'] ) ) {
	  $errors = '';
	  foreach ( $retval['errors'] as $error ) {
		$errors .= $error . ' ';
	  }
	  $error_message = $errors;
	}

	if ( '' !== $error_message ) {
	  $error_message = sprintf( '%1$s: %2$s',
		esc_html__( 'Additional Information: ' ),
		$error_message
	  );
	}

	return $error_message;
  }

  /**
   * Subscribes to Mailchimp list. Returns either "success" string or error message.
   * @return string
   */

  public function subscribe_mailchimp( $api_key, $list_id, $email, $name = '', $last_name = '', $disable_dbl ){
	if ( ! function_exists( 'curl_init' ) ) {
	  return;
	}

	if ( ! class_exists( 'MailChimp_Uptin' ) ) {
	  require_once( EWD_UPTIN_PLUGIN_DIR . 'subscription/mailchimp/mailchimp.php' );
	}

	$validApiStruct = strpos($api_key, '-');
	if($validApiStruct == false){
	  return 'Please check structure of api key. Must contain -';
	}
	$mailchimp = new MailChimp_Uptin( $api_key );
	$email = array( 'email' => $email );
	$double_optin = '' === $disable_dbl ? 'true' : 'false';

	$merge_vars = array(
	  'FNAME' => $name,
	  'LNAME' => $last_name,
	);

	$retval = $mailchimp->call( 'lists/subscribe', array(
	  'id'         		=> $list_id,
	  'email'      		=> $email,
	  'double_optin' 	=> $double_optin,
	  'merge_vars' 		=> $merge_vars,
	  'update_existing' => 'true',
	) );

	if ( isset( $retval['error'] ) ) {
	  if ( '214' == $retval['code'] ) {
		$error_message = str_replace( 'Click here to update your profile.', '', $retval['error'] );
	  } else {
		$error_message = $retval['error'];
	  }
	} else {
	  $error_message = 'success';
	}

	return $error_message;
  }

}