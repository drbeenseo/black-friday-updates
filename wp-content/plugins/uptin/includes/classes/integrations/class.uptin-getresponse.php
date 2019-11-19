<?php
if (!class_exists('EWD_Dash')) {
	require_once(EWD_UPTIN_PLUGIN_DIR . 'uptin.php');
}

class uptin_getresponse extends EWD_Uptin
{

	public function __contruct()
	{

	}

	public function draw_getresponse_form($form_fields, $service, $field_values)
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
	 * Retrieves the lists via GetResponse API and updates the data in DB.
	 * @return string
	 */
	function get_getresponse_lists($api_key, $name)
	{
		$lists = array();

		if (!function_exists('curl_init')) {
			return __('curl_init is not defined ', 'uptin');
		}

		if (!class_exists('GetResponse')) {
			require_once(EWD_UPTIN_PLUGIN_DIR . 'subscription/getresponse/getresponseapi.class.php');
		}

		$api = new GetResponse($api_key);

		$campaigns = (array)$api->getCampaigns();

		if (!empty($campaigns)) {
			$error_message = 'success';

			foreach ($campaigns as $id => $details) {
				$lists[$id]['name'] = $details->name;
				$contacts = (array)$api->getContacts(array($id));

				$total_contacts = count($contacts);
				$lists[$id]['subscribers_count'] = $total_contacts;

				$lists[$id]['growth_week'] = $this->calculate_growth_rate('getresponse_' . $id);
			}

			$this->update_account('getresponse', $name, array(
				'api_key' => esc_html($api_key),
				'lists' => $lists,
				'is_authorized' => esc_html('true'),
			));
		} else {
			$error_message = __('Invalid API key or something went wrong during Authorization request', 'uptin');
		}

		return $error_message;
	}

	/**
	 * Subscribes to GetResponse list. Returns either "success" string or error message.
	 * @return string
	 */
	function subscribe_get_response($list, $email, $api_key, $name = '-')
	{
		if (!function_exists('curl_init')) {
			return;
		}
		if( !is_email($email) ){
		  return 'Email appears to be invalid';
		}
		require_once(EWD_UPTIN_PLUGIN_DIR . 'subscription/getresponse/jsonrpcclient.php');
		$api_url = 'http://api2.getresponse.com';

		$name = '' == $name ? '-' : $name;

		$client = new jsonRPCClient($api_url);
		$result = $client->add_contact(
			$api_key,
			array(
				'campaign' => $list,
				'name' => $name,
				'email' => $email,
				'cycle_day' => 0,
			)
		);
		if (isset($result['result']['queued']) && 1 == $result['result']['queued']) {
			$result = 'success';
		} else {
			if (isset($result['error']['message'])) {
			  if($result['error']['message'] == 'Contact already added to target campaign'){
				$result = 'success';
			  }else {
				$result = $result['error']['message'];
			  }
			} else {
				$result = 'unknown error';
			}
		}

		return $result;
	}
}