<?php
if ( ! class_exists( 'EWD_Dash' ) ) {
require_once( EWD_UPTIN_PLUGIN_DIR . 'uptin.php' );
}

class uptin_constant_contact extends EWD_Uptin
{

	public function __contruct()
	{

	}

	public function draw_contstant_contact_form($form_fields, $service, $field_values){
		$form_fields .=
			sprintf(
				'
						<div class="rad_dashboard_account_row">
							<label for="%1$s">%3$s</label>
							<input type="password" value="%5$s" id="%1$s">%7$s
						</div>
						<div class="rad_dashboard_account_row">
						<label for="%2$s">%4$s</label>
						<input type="password" value="%6$s" id="%2$s">%7$s
						</div>
						',
				esc_attr( 'api_key_' . $service ),
				esc_attr( 'token_' . $service ),
				__( 'API key', 'uptin' ),
				__( 'Token', 'uptin' ),
				( '' !== $field_values && isset( $field_values['api_key'] ) ) ? esc_html( $field_values['api_key'] ) : '',
				( '' !== $field_values && isset( $field_values['token'] ) ) ? esc_attr( $field_values['token'] ) : '',
				EWD_Uptin::generate_hint( sprintf(
					'<a href="http://www.uptin.com/docs#'.$service.'" target="_blank">%1$s</a>',
					__( 'Click here for more information', 'uptin' )
				), false )
			);
		return $form_fields;
	}

	/**
	 * Retrieves the lists via Constant Contact API and updates the data in DB.
	 * @return string
	 */
	function get_constant_contact_lists( $api_key, $token, $name ) {

		$lists         = array();
		$error_message = '';

		$request_url = esc_url_raw( 'https://api.constantcontact.com/v2/lists?api_key=' . $api_key );

		$theme_request = wp_remote_get( $request_url, array(
			'timeout' => 30,
			'headers' => array( 'Authorization' => 'Bearer ' . $token ),
		) );

		$response_code = wp_remote_retrieve_response_code( $theme_request );

		if ( ! is_wp_error( $theme_request ) && $response_code == 200 ) {
			$theme_response = wp_remote_retrieve_body( $theme_request );
			if ( ! empty( $theme_response ) ) {
				$error_message = 'success';

				$response = json_decode( $theme_response, true );

				foreach ( $response as $key => $value ) {
					if ( isset( $value['id'] ) ) {
						$lists[ $value['id'] ]['name']              = sanitize_text_field( $value['name'] );
						$lists[ $value['id'] ]['subscribers_count'] = sanitize_text_field( $value['contact_count'] );
						$lists[ $value['id'] ]['growth_week']       = sanitize_text_field( $this->calculate_growth_rate( 'constant_contact_' . $value['id'] ) );
					}
				}

				$this->update_account( 'constant_contact', sanitize_text_field( $name ), array(
					'lists'         => $lists,
					'api_key'       => sanitize_text_field( $api_key ),
					'token'         => sanitize_text_field( $token ),
					'is_authorized' => 'true',
				) );
			} else {
				$error_message .= __( 'empty response', 'uptin' );
			}
		} else {
			$error_map     = array(
				"401" => 'Invalid Token',
				"403" => 'Invalid API key'
			);
			$error_message = $this->get_error_message( $theme_request, $response_code, $error_map );
		}

		return $error_message;
	}

	/**
	 * Subscribes to Constant Contact list. Returns either "success" string or error message.
	 * @return string
	 */
	function subscribe_constant_contact( $email, $api_key, $token, $list_id, $name = '', $last_name = '' ) {
	  if(!is_email( $email )){
		return "Email address appears to be incorrect";
	  }
		$request_url   = esc_url_raw( 'https://api.constantcontact.com/v2/contacts?email=' . $email . '&api_key=' . $api_key );
		$error_message = '';

		$theme_request = wp_remote_get( $request_url, array(
			'timeout' => 30,
			'headers' => array( 'Authorization' => 'Bearer ' . $token ),
		) );
		$response_code = wp_remote_retrieve_response_code( $theme_request );

		if ( ! is_wp_error( $theme_request ) && $response_code == 200 ) {
			$theme_response = wp_remote_retrieve_body( $theme_request );
			$response       = json_decode( $theme_response, true );

			if ( empty( $response['results'] ) ) {
				$request_url   = esc_url_raw( 'https://api.constantcontact.com/v2/contacts?api_key=' . $api_key );
				$body_request  = '{"email_addresses":[{"email_address": "' . $email . '" }], "lists":[{"id": "' . $list_id . '"}], "first_name": "' . $name . '", "last_name" : "' . $last_name . '" }';
				$theme_request = wp_remote_post( $request_url, array(
					'timeout' => 30,
					'headers' => array(
						'Authorization' => 'Bearer ' . $token,
						'content-type'  => 'application/json',
					),
					'body'    => $body_request,
				) );
				$response_code = wp_remote_retrieve_response_code( $theme_request );
				if ( ! is_wp_error( $theme_request ) && $response_code == 201 ) {
					$error_message = 'success';
				} else {
					$error_map     = array(
						"409" => 'Already subscribed'
					);
					$error_message = $this->get_error_message( $theme_request, $response_code, $error_map );
				}
			} else {
			  if($response['results'][0]['id'] > 0) {
				$error_message = __('success', 'uptin');//show a success if they are already subscribed
			  }else{
				$error_message = __('General Error', 'uptin');//show a success if they are already subscribed
			  }
			}
		} else {
			$error_map     = array(
				"401" => 'Invalid Token',
				"403" => 'Invalid API key'
			);
			$error_message = $this->get_error_message( $theme_request, $response_code, $error_map );
		}

		return $error_message;
	}
}