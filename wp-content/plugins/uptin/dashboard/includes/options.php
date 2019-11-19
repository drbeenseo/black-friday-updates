<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//Array of all sections. All sections will be added into sidebar navigation except for the 'header' section.
$rad_all_sections = array(
	'optin'  => array(
		'title'    => __( 'Opt-In Configuration', 'uptin' ),
		'contents' => array(
			'setup'   => __( 'Setup', 'uptin' ),
			'premade' => __( 'Premade Layouts', 'uptin' ),
			'design'  => __( 'Design', 'uptin' ),
			'display' => __( 'Display Settings', 'uptin' ),
		),
	),
	'header' => array(
		'contents' => array(
			'stats'        => __( 'Opt-In Stats', 'uptin' ),
			'accounts'     => __( 'Accounts settings', 'uptin' ),
			'importexport' => __( 'Import & Export', 'uptin' ),
			'home'         => __( 'Home', 'uptin' ),
			'edit_account' => __( 'Edit Account', 'uptin' ),
			'support' => __( 'Help and Support', 'uptin' ),
		),
	),
);

/**
 * Array of all options
 * General format for options:
 * '<option_name>' => array(
 *							'type' => ...,
 *							'name' => ...,
 *							'default' => ...,
 *							'validation_type' => ...,
 *							etc
 *						)
 * <option_name> - just an identifier to add the option into $rad_assigned_options array
 * Array of parameters may contain diffrent attributes depending on option type.
 * 'type' is the required attribute for all options. All other attributes depends on the option type.
 * 'validation_type' and 'name' are required attribute for the option which should be saved into DataBase.
 *
 */

require('options_config.php');

$more_info_hint_text = sprintf(
	'<a href="%2$s" target="_blank">%1$s</a>',
	__( 'Click here for more information', 'uptin' ),
	esc_url( 'http://www.uptin.com' )
);

$rad_dashboard_options_all = array(
	'optin_name' => array(
		'section_start' => array(
			'type'  => 'section_start',
			'title' => __( 'Opt-In Form Name', 'uptin' ),
			'hint_text'       => __( 'This name is used to identify your form in the ACTIVE OPT-INS dashboard screen. It won’t appear on the form itself.', 'uptin' ),
		),

		'option' => array(
			'type'            => 'text',
			'rows'            => '1',
			'name'            => 'optin_name',
			'placeholder'     => __( 'Enter Opt-In Form Name', 'uptin' ),
			// 'default'         => __( 'Enter Opt-In Form Name', 'uptin' ),
			'validation_type' => 'simple_text',
		),
	),

	'form_integration' => array(
		'section_start' => array(
			'type'  => 'section_start',
			'title' => __( 'Connect Your Email Service Provider', 'uptin' ),
			'class' => 'rad_dashboard_child_hidden rad_dashboard_provider_setup_dropdown',
		),
		'enable_redirect_form' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Message and Link Only', 'uptin' ),
			'name'            => 'enable_redirect_form',
			'default'         => false,
			'validation_type' => 'boolean',
			'hint_text'       => __( 'Select this if you do not want your banner to include an email opt-in.', 'uptin' ),
			'class'			  =>  'rad_dashboard_enable_redirect_form',
			'conditional'	  =>  'redirect_list_id#email_text#redirect_url#submit_remove,#enable_success_redirect#enable_consent#redirect_bar',
		),
		'email_provider' => array(
			'type'            => 'select',
			'title'           => __( 'Select Email Provider', 'uptin' ),
			'name'            => 'email_provider',
			'value'           => $email_providers_new_optin,
			'default'         => 'empty',
			'conditional'     => 'mailchimp_account#aweber_account#constant_contact_account#custom_html#activecampaign#display_name#name_fields#disable_dbl_optin',
			'validation_type' => 'simple_text',
			'class'           => 'rad_dashboard_select_provider',
		),
		'select_account' => array(
			'type'            => 'select',
			'title'           => __( 'Select Account', 'uptin' ),
			'name'            => 'account_name',
			'value'           => array(
				'empty'       => __( 'Select One...', 'uptin' ),
				'add_account' => __( 'Add Account', 'uptin' ) ),
			'default'         => 'empty',
			'validation_type' => 'simple_text',
			'class'           => 'rad_dashboard_select_account',
		),
		'email_list' => array(
			'type'            => 'select',
			'title'           => __( 'Select Email List', 'uptin' ),
			'name'            => 'email_list',
			'value'           => array(
				'empty' => __( 'Select One...', 'uptin' )
			),
			'default'         => 'empty',
			'validation_type' => 'simple_text',
			'class'           => 'rad_dashboard_select_list',
		),
		'custom_html' => array(
			'type'            => 'text',
			'rows'            => '4',
			'name'            => 'custom_html',
			'placeholder'     => __( 'Insert HTML', 'uptin' ),
			'default'         => '',
			'validation_type' => 'html',
			'display_if'      => 'custom_html'
		),
		'disable_dbl_optin' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Disable Double Optin', 'uptin' ),
			'name'            => 'disable_dbl_optin',
			'default'         => false,
			'display_if'      => 'mailchimp',
			'validation_type' => 'boolean',
			'hint_text'       => __( 'Abusing this feature may cause your Mailchimp account to be suspended.', 'uptin' ),
		),
	),

	'optin_title' => array(
		'section_start' => array(
			'type'     	=> 'section_start',
			'title'    	=> __( 'Opt-In title', 'uptin' ),
			'subtitle' 	=> __( 'No title will appear if left blank', 'uptin' ),
			'class'		=> 'rad_uptin_hide_for_rapidbar',
		),

		'option' => array(
			'type'            => 'text',
			'rows'            => '1',
			'name'            => 'optin_title',
			'class'           => 'rad_dashboard_optin_title rad_dashboard_mce',
			'placeholder'     => __( 'Insert Text', 'uptin' ),
			'default'         => __( 'Subscribe To Our Newsletter', 'uptin' ),
			'validation_type' => 'html',
			'is_wpml_string'  => true,
		),
	),

	'optin_message' => array(
		'section_start' => array(
			'type'     => 'section_start',
			'title'    => __( 'Opt-In message', 'uptin' ),
			'subtitle' => __( 'No message will appear if left blank', 'uptin' ),
		),

		'option' => array(
			'type'            => 'text',
			'rows'            => '3',
			'name'            => 'optin_message',
			'class'           => 'rad_dashboard_optin_message rad_dashboard_mce',
			'placeholder'     => __( 'Insert Text', 'uptin' ),
			'default'         => __( 'Join our mailing list to receive the latest news and updates from our team.', 'uptin' ),
			'validation_type' => 'html',
			'is_wpml_string'  => true,
		),
	),

	'image_settings' => array(
		'section_start' => array(
			'type'  => 'section_start',
			'title' => __( 'Image Settings', 'uptin' ),
			'class' => 'rad_dashboard_10_bottom rad_uptin_hide_for_rapidbar',
		),
		'image_orientation' => array(
			'type'            => 'select',
			'title'           => __( 'Image Orientation', 'uptin' ),
			'name'            => 'image_orientation',
			'value'           => array(
				'no_image' => __( 'No Image', 'uptin' ),
				'above'    => __( 'Image Above Text', 'uptin' ),
				'below'    => __( 'Image Below Text', 'uptin' ),
				'right'    => __( 'Image Right of Text', 'uptin' ),
				'left'     => __( 'Image Left of Text', 'uptin' ),
			),
			'default'         => 'no_image',
			'conditional'     => 'image_upload',
			'validation_type' => 'simple_text',
			'class'           => 'rad_uptin_hide_for_widget rad_dashboard_image_orientation',
		),
		'image_orientation_widget' => array(
			'type'            => 'select',
			'title'           => __( 'Image Orientation', 'uptin' ),
			'name'            => 'image_orientation_widget',
			'value'           => array(
				'no_image' => __( 'No Image', 'uptin' ),
				'above'    => __( 'Image Above Text', 'uptin' ),
				'below'    => __( 'Image Below Text', 'uptin' ),
			),
			'default'         => 'no_image',
			'conditional'     => 'image_upload',
			'validation_type' => 'simple_text',
			'class'           => 'rad_uptin_widget_only_option rad_dashboard_image_orientation_widget',
		),
	),

	'image_upload' => array(
		'section_start' => array(
			'type'       => 'section_start',
			'name'       => 'image_upload',
			'class'      => 'e_no_top_space rad_uptin_hide_for_rapidbar',
			'display_if' => 'above#below#right#left',
		),
		'image_url' => array(
			'type'            => 'image_upload',
			'title'           => __( 'Image URL', 'uptin' ),
			'name'            => 'image_url',
			'class'           => 'rad_dashboard_upload_image',
			'button_text'     => __( 'Upload an Image', 'uptin' ),
			'wp_media_title'  => __( 'Choose an Opt-In Image', 'uptin' ),
			'wp_media_button' => __( 'Set as Opt-In Image', 'uptin' ),
			'validation_type' => 'simple_array',
		),
		'image_animation' => array(
			'type'            => 'select',
			'title'           => __( 'Image Load-In Animation', 'uptin' ),
			'name'            => 'image_animation',
			'value'           => array(
				'no_animation' => __( 'No Animation', 'uptin' ),
				'fadein'       => __( 'Fade In', 'uptin' ),
				'slideright'   => __( 'Slide Right', 'uptin' ),
				'slidedown'    => __( 'Slide Down', 'uptin' ),
				'slideup'      => __( 'Slide Up', 'uptin' ),
				'lightspeedin' => __( 'Light Speed', 'uptin' ),
				'zoomin'       => __( 'Zoom In', 'uptin' ),
				'flipinx'      => __( 'Flip', 'uptin' ),
				'bounce'       => __( 'Bounce', 'uptin' ),
				'swing'        => __( 'Swing', 'uptin' ),
				'tada'         => __( 'Tada!', 'uptin' ),
			),
			'hint_text'       => __( 'Define the animation that is used to load the image', 'uptin' ),
			'default'         => 'slideup',
			'validation_type' => 'simple_text',
		),
		'hide_mobile' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Hide image on mobile', 'uptin' ),
			'name'            => 'hide_mobile',
			'default'         => false,
			'validation_type' => 'boolean',
		),
	),
	'form_setup' => array(
		'section_start' => array(
			'type'  => 'section_start',
			'title' => __( 'Form setup', 'uptin' ),
		),
		'display_as_link' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Display button as link', 'uptin' ),
			'name'            => 'display_as_link',
			'class'           => 'rad_dashboard_display_as_link_checkbox',
			'default'         => false,
			'validation_type' => 'boolean',
		),
		'form_orientation' => array(
			'type'            => 'select',
			'title'           => __( 'Form Orientation', 'uptin' ),
			'name'            => 'form_orientation',
			'value'           => array(
				'right'  => __( 'Form On Right', 'uptin' ),
				'left'   => __( 'Form On Left', 'uptin' ),
				'bottom' => __( 'Form On Bottom', 'uptin' ),
			),
			'default'         => 'right',
			'validation_type' => 'simple_text',
			'class'           => 'rad_uptin_hide_for_widget rad_uptin_hide_for_rapidbar rad_dashboard_form_orientation',
		),
		'display_name' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Display Name Field', 'uptin' ),
			'name'            => 'display_name',
			'class'           => 'rad_dashboard_name_checkbox',
			'default'         => false,
			'conditional'     => 'single_name_text',
			'validation_type' => 'boolean',
			'display_if'      => 'getresponse#aweber',
		),
		'redirect_url' => array(
			'type'            => 'input_field',
			'subtype'         => 'text',
			'name'            => 'redirect_url',
			'class'           => 'rad_dashboard_redirect_url',
			'title'           => __( 'Redirect Url', 'uptin' ),
			'placeholder'     => __( 'http://example.com', 'uptin' ),
			'default'         => '',
			'display_if'      => 'enable_redirect_form#true',
			'validation_type' => 'simple_text',
			'is_wpml_string'  => true,
		),
		'redirect_bar' => array(
		  'type'            	=> 'select',
		  'title'           	=> __( 'Redirect Type', 'uptin' ),
		  'name'            	=> 'redirect_bar',
		  'value'           	=> array(
			'current_window' 	=> __( 'Current Window', 'uptin' ),
			'new_tab'       	=> __( 'New Tab', 'uptin' ),
			'new_window'   		=> __( 'New Window', 'uptin' ),
		  ),
		  'class'           => 'rad_uptin_redirect_bar',
		  'default'         => 'new_window',
		  'validation_type' => 'simple_text',
		  'display_if'      => 'enable_redirect_form#true',
		),
		'rapidbar_popup' => array(
			'type'            => 'select',
			'title'           => __( 'Select opt-in to open', 'uptin' ),
			'name'            => 'rapidbar_popup',
			'value'           => $valid_optins,
			'default'         => 'empty',
			'validation_type' => 'simple_text',
			'class'           => 'rad_dashboard_select_optin rad_uptin_for_rapidbar',
			'hint_text'		  => __('If selected, redirect will not happen. Will only display popup or flyin forms that are selected to show on everything.', 'uptin'),
		),
		'name_fields' => array(
			'type'            => 'select',
			'title'           => __( 'Name Field(s)', 'uptin' ),
			'name'            => 'name_fields',
			'class'           => 'rad_dashboard_name_fields rad_uptin_hide_for_rapidbar',
			'value'           => array(
				'no_name'         => __( 'No Name Field', 'uptin' ),
				'single_name'     => __( 'Single Name Field', 'uptin' ),
				'first_last_name' => __( 'First + Last Name Fields', 'uptin' ),
			),
			'default'         => 'no_name',
			'conditional'     => 'name_text#last_name#single_name_text',
			'validation_type' => 'simple_text',
			'display_if'      => implode( '#', $show_name_fields ).'#button_redirect#false',
		),
		'name_text' => array(
			'type'            => 'input_field',
			'subtype'         => 'text',
			'name'            => 'name_text',
			'class'           => 'rad_dashboard_name_text',
			'title'           => __( 'Name Text', 'uptin' ),
			'placeholder'     => __( 'First Name', 'uptin' ),
			'default'         => '',
			'display_if'      => 'first_last_name',
			'validation_type' => 'simple_text',
			'is_wpml_string'  => true,
		),
		'single_name_text' => array(
			'type'            => 'input_field',
			'subtype'         => 'text',
			'name'            => 'single_name_text',
			'class'           => 'rad_dashboard_name_text_single',
			'title'           => __( 'Name Text', 'uptin' ),
			'placeholder'     => __( 'Name', 'uptin' ),
			'default'         => '',
			'display_if'      => 'single_name#true',
			'validation_type' => 'simple_text',
			'is_wpml_string'  => true,
		),
		'last_name' => array(
			'type'            => 'input_field',
			'subtype'         => 'text',
			'name'            => 'last_name',
			'class'           => 'rad_dashboard_last_name_text',
			'title'           => __( 'Last Name Text', 'uptin' ),
			'placeholder'     => __( 'Last Name', 'uptin' ),
			'default'         => '',
			'display_if'      => 'first_last_name',
			'validation_type' => 'simple_text',
			'is_wpml_string'  => true,
		),
		'email_text' => array(
			'type'            => 'input_field',
			'subtype'         => 'text',
			'name'            => 'email_text',
			'class'           => 'rad_dashboard_email_text',
			'title'           => __( 'Email Text', 'uptin' ),
			'placeholder'     => __( 'Email', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
			'is_wpml_string'  => true,
			'display_if'	  => 'enable_redirect_form#false'
		),
		'enable_consent' => array(
		  'type'            => 'checkbox',
		  'title'           => __( 'Optin Consent', 'uptin' ),
		  'name'            => 'enable_consent',
		  'default'         => false,
		  'class' 		  => 'rad_uptin_enable_consent',
		  'validation_type' => 'boolean',
		  'display_if'      => 'enable_redirect_form#false',
		  'conditional'     => 'consent_text#consent_color#consent_error',
		),
		'consent_text' => array(
		  'type'            => 'text',
		  'subtype'         => 'text',
		  'name'            => 'consent_text',
		  'class'           => 'rad_dashboard_consent_text',
		  'title'           => __( 'Consent Text', 'uptin' ),
		  'placeholder'     => __( 'Yes, I consent to receiving direct marketing from this website.', 'uptin' ),
		  'default'         => __( 'Yes, I consent to receiving direct marketing from this website.', 'uptin' ),
		  'validation_type' => 'simple_text',
		  'is_wpml_string'  => true,
		  'display_if'	  => 'enable_consent#true'
		),
		'consent_color' => array(
		  'type'            => 'color_picker',
		  'title'           =>  __( 'Consent Text Color', 'uptin' ),
		  'name'            => 'consent_color',
		  'class'           => 'rad_dashboard_consent_color',
		  'placeholder'     => __( 'Hex Value', 'uptin' ),
		  'default'         => '',
		  'validation_type' => 'simple_text',
		  'display_if'	  	=> 'enable_consent#true'
		),
		'consent_error' => array(
		  'type'            => 'input_field',
		  'subtype'         => 'text',
		  'name'            => 'consent_error',
		  'class'           => 'rad_dashboard_consent_error',
		  'title'           => __( 'Consent Error Text', 'uptin' ),
		  'placeholder'     => __( 'Please provide consent.', 'uptin' ),
		  'default'         => __( 'Please provide consent.', 'uptin' ),
		  'validation_type' => 'simple_text',
		  'is_wpml_string'  => true,
		  'display_if'	  => 'enable_consent#true'
		),
		'button_text' => array(
			'type'            => 'input_field',
			'subtype'         => 'text',
			'name'            => 'button_text',
			'class'           => 'rad_dashboard_button_text',
			'title'           => __( 'Button Text', 'uptin' ),
			'placeholder'     => __( 'SUBSCRIBE!', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
			'is_wpml_string'  => true,
		),
		'button_text_color' => array(
			'type'            => 'select',
			'title'           => __( 'Button Text Color', 'uptin' ),
			'name'            => 'button_text_color',
			'class'           => 'rad_dashboard_field_button_text_color',
			'value'           => array(
				'light' => __( 'Light', 'uptin' ),
				'dark'  => __( 'Dark', 'uptin' ),
			),
			'default'         => 'light',
			'validation_type' => 'simple_text',
		),
		'rapidbar_position' => array(
			'type'            => 'select',
			'title'           => __( 'Select banner position', 'uptin' ),
			'name'            => 'rapidbar_position',
			'value'           => $rapidbar_position,
			'default'         => 'stickytop',
			'validation_type' => 'simple_text',
			'class'           => 'rad_dashboard_select_rapidbar_position',
		),
	),

	'optin_styling' => array(
		'section_start' => array(
			'type'  => 'section_start',
			'title' => __( 'Opt-In Styling', 'uptin' ),
		),
		'header_bg_color' => array(
			'type'            => 'color_picker',
			'title'           =>  __( 'Background Color', 'uptin' ),
			'name'            => 'header_bg_color',
			'class'           => 'rad_dashboard_optin_bg rad_uptin_hide_for_rapidbar',
			'placeholder'     => __( 'Hex Value', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
		),
		'header_font' => array(
			'type'            => 'font_select',
			'title'           => __( 'Header Font', 'uptin' ),
			'name'            => 'header_font',
			'class'           => 'rad_dashboard_header_font rad_uptin_hide_for_rapidbar',
			'validation_type' => 'simple_text',
		),
		'body_font' => array(
			'type'            => 'font_select',
			'title'           => __( 'Body Font', 'uptin' ),
			'name'            => 'body_font',
			'class'           => 'rad_dashboard_body_font rad_dashboard_for_rapidbar',
			'validation_type' => 'simple_text',
		),
		'header_text_color' => array(
			'type'            => 'select',
			'title'           => __( 'Text Color', 'uptin' ),
			'name'            => 'header_text_color',
			'class'           => 'rad_dashboard_text_color',
			'value'           => array(
				'light' => __( 'Light Text', 'uptin' ),
				'dark'  => __( 'Dark Text', 'uptin' ),
			),
			'default'         => 'dark',
			'validation_type' => 'simple_text',
		),
		'corner_style' => array(
			'type'            => 'select',
			'title'           => __( 'Corner Style', 'uptin' ),
			'name'            => 'corner_style',
			'class'           => 'rad_dashboard_corner_style rad_uptin_hide_for_rapidbar',
			'value'           => array(
				'squared' => __( 'Squared Corners', 'uptin' ),
				'rounded' => __( 'Rounded Corners', 'uptin' ),
			),
			'default'         => 'squared',
			'validation_type' => 'simple_text',
		),
		'border_orientation' => array(
			'type'            => 'select',
			'title'           => __( 'Border Orientation', 'uptin' ),
			'name'            => 'border_orientation',
			'class'           => 'rad_dashboard_border_orientation rad_dashboard_for_rapidbar',
			'value'           => array(
				'no_border'  => __( 'No Border', 'uptin' ),
				'full'       => __( 'Full Border', 'uptin' ),
				'top'        => __( 'Top Border', 'uptin' ),
				'right'      => __( 'Right Border', 'uptin' ),
				'bottom'     => __( 'Bottom Border', 'uptin' ),
				'left'       => __( 'Left Border', 'uptin' ),
				'top_bottom' => __( 'Top + Bottom Border', 'uptin' ),
				'left_right' => __( 'Left + Right Border', 'uptin' ),
			),
			'default'         => 'no_border',
			'conditional'     => 'border_color#border_style',
			'validation_type' => 'simple_text',
		),
		'border_color' => array(
			'type'            => 'color_picker',
			'title'           =>  __( 'Border Color', 'uptin' ),
			'name'            => 'border_color',
			'class'           => 'rad_dashboard_border_color rad_dashboard_for_rapidbar',
			'placeholder'     => __( 'Hex Value', 'uptin' ),
			'default'         => '',
			'display_if'      => 'full#top#left#right#bottom#top_bottom#left_right',
			'validation_type' => 'simple_text',
		),
	),

	'form_styling' => array(
		'section_start' => array(
			'type'  => 'section_start',
			'title' => __( 'Form Styling', 'uptin' ),
		),
		'field_orientation' => array(
			'type'            => 'select',
			'title'           => __( 'Form Field Orientation', 'uptin' ),
			'name'            => 'field_orientation',
			'value'           => array(
				'stacked' => __( 'Stacked Form Fields', 'uptin' ),
				'inline'  => __( 'Inline Form Fields', 'uptin' ),
			),
			'default'         => 'inline',
			'validation_type' => 'simple_text',
			'class'           => 'rad_uptin_hide_for_widget rad_dashboard_field_orientation rad_uptin_hide_for_rapidbar',
		),
		'field_corner' => array(
			'type'            => 'select',
			'title'           => __( 'Form Field Corner Style', 'uptin' ),
			'name'            => 'field_corner',
			'class'           => 'rad_dashboard_field_corners',
			'value'           => array(
				'squared' => __( 'Squared Corners', 'uptin' ),
				'rounded' => __( 'Rounded Corners', 'uptin' ),
			),
			'default'         => 'rounded',
			'validation_type' => 'simple_text',
		),
		'text_color' => array(
			'type'            => 'select',
			'title'           => __( 'Form Text Color', 'uptin' ),
			'name'            => 'text_color',
			'class'           => 'rad_dashboard_form_text_color rad_uptin_hide_for_rapidbar',
			'value'           => array(
				'light' => __( 'Light Text', 'uptin' ),
				'dark'  => __( 'Dark Text', 'uptin' ),
			),
			'default'         => 'dark',
			'validation_type' => 'simple_text',
		),
		'form_bg_color' => array(
			'type'            => 'color_picker',
			'title'           =>  __( 'Form Background Color', 'uptin' ),
			'name'            => 'form_bg_color',
			'class'           => 'rad_dashboard_form_bg_color rad_dashboard_for_rapidbar',
			'placeholder'     => __( 'Hex Value', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
		),
		'form_button_color' => array(
			'type'            => 'color_picker',
			'title'           =>  __( 'Button Color', 'uptin' ),
			'name'            => 'form_button_color',
			'class'           => 'rad_dashboard_form_button_color rad_dashboard_for_rapidbar',
			'placeholder'     => __( 'Hex Value', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
		),
	),

	'edge_style' => array(
		'type'            => 'select_shape',
		'title'           => __( 'Choose form edge style', 'uptin' ),
		'name'            => 'edge_style',
		'value'           => array(
			'basic_edge',
			'carrot_edge',
			'wedge_edge',
			'curve_edge',
			'zigzag_edge',
			'breakout_edge',
		),
		'default'         => 'basic_edge',
		'class'           => 'rad_dashboard_optin_edge rad_uptin_hide_for_rapidbar',
		'validation_type' => 'simple_text',
	),

	'border_style' => array(
		'type'            => 'select_shape',
		'title'           => __( 'Choose border style', 'uptin' ),
		'name'            => 'border_style',
		'class'           => 'rad_dashboard_border_style rad_dashboard_for_rapidbar',
		'value'           => array(
			'solid',
			'dashed',
			'double',
			'inset',
			'letter',
		),
		'default'         => 'solid',
		'display_if'      => 'full#top#left#right#bottom#top_bottom#left_right',
		'validation_type' => 'simple_text',
	),

	'footer_text' => array(
		'section_start' => array(
			'type'  => 'section_start',
			'title' =>__( 'Form Footer Text', 'uptin' ),
			'class'	=> 'rad_uptin_hide_for_rapidbar',
		),
		'option' => array(
			'type'            => 'text',
			'rows'            => '3',
			'name'            => 'footer_text',
			'class'           => 'rad_dashboard_footer_text',
			'placeholder'     => __( 'Insert Your Footer Text', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
			'is_wpml_string'  => true,
		),
	),

	'success_message' => array(
		'section_start' => array(
			'type'  => 'section_start',
			'title' =>__( 'Success Message Text', 'uptin' ),
		),
		'option' => array(
			'type'            => 'text',
			'rows'            => '1',
			'name'            => 'success_message',
			'class'           => 'success_message',
			'placeholder'     => __( 'You Have Successfully Subscribed!', 'uptin' ),
			'default'         => '',
			'validation_type' => 'html',
			'is_wpml_string'  => true,
		),
		'enable_success_redirect' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Redirect to URL after opt-in', 'uptin' ),
			'name'            => 'enable_success_redirect',
			'default'         => false,
			'conditional'     => 'success_redirect_section',
			'class' 		  => 'rad_uptin_success_redirect_enable',
			'validation_type' => 'boolean',
			'display_if'      => 'enable_redirect_form#false',
		),
	),
	'success_redirect' => array(
		'section_start' => array(
			'type'  	=> 'section_start',
			'name'		=> 'success_redirect_section',
			'title' 	=> __( 'Success Follow-Up', 'uptin' ),
			'class' 	=> 'rad_uptin_success_redirect_section',
			'display_if'=> 'enable_success_redirect#true',
		),
		'success_url' => array(
			'type'            => 'input_field',
			'subtype'         => 'text',
			'name'            => 'success_url',
			'class'           => 'rad_dashboard_success_url',
			'title'           => __( 'Success follow-Up url', 'uptin' ),
			'placeholder'     => __( 'http://example.com', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
			'is_wpml_string'  => true,
		),
		'success_load_delay' => array(
			'type'            => 'input_field',
			'subtype'         => 'number',
			'title'           => __( 'Delay (in seconds) till redirect', 'uptin' ),
			'name'            => 'success_load_delay',
			'hint_text'       => __( 'Define how many seconds you want to wait before the redirect window opens.', 'uptin' ),
			'default'         => '5',
			'validation_type' => 'number',
		),
		'redirect_standard' => array(
		  'type'            	=> 'select',
		  'title'           	=> __( 'Redirect Type', 'uptin' ),
		  'name'            	=> 'redirect_standard',
		  'value'           	=> array(
			'current_window' 	=> __( 'Current Window', 'uptin' ),
			'new_tab'       	=> __( 'New Tab', 'uptin' ),
			'new_window'   		=> __( 'New Window', 'uptin' ),
		  ),
		  'class'           => 'rad_uptin_standard_bar',
		  'default'         => 'new_window',
		  'validation_type' => 'simple_text',
		),
	),
	'custom_css' => array(
		'section_start' => array(
			'type'  => 'section_start',
			'title' =>__( 'Custom CSS', 'uptin' ),
			'class'		=> 'rad_uptin_hide_for_rapidbar',
		),
		'option' => array(
			'type'            => 'text',
			'rows'            => '7',
			'name'            => 'custom_css',
			'placeholder'     => __( 'Insert Your Custom CSS Code', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
		),
	),

	'load_in' => array(
		'section_start' => array(
			'type'  => 'section_start',
			'title' => __( 'Display and Timing Settings', 'uptin' ),
			'class' => 'rad_dashboard_for_popup rad_dashboard_for_rapidbar',
		),
		'load_animation' => array(
			'type'            => 'select',
			'title'           => __( 'Intro Animation', 'uptin' ),
			'name'            => 'load_animation',
			'value'           => array(
				'no_animation' => __( 'No Animation', 'uptin' ),
				'fadein'       => __( 'Fade In', 'uptin' ),
				'slideright'   => __( 'Slide Right', 'uptin' ),
				'slideup'      => __( 'Slide Up', 'uptin' ),
				'slidedown'    => __( 'Slide Down', 'uptin' ),
				'lightspeedin' => __( 'Light Speed', 'uptin' ),
				'zoomin'       => __( 'Zoom In', 'uptin' ),
				'flipinx'      => __( 'Flip', 'uptin' ),
				'bounce'       => __( 'Bounce', 'uptin' ),
				'swing'        => __( 'Swing', 'uptin' ),
				'tada'         => __( 'Tada!', 'uptin' ),
			),
			'hint_text'       => __( 'Define the animation that is used, when you load the page.', 'uptin' ),
			'class'           => 'rad_uptin_load_in_animation rad_uptin_hide_for_rapidbar',
			'default'         => 'fadein',
			'validation_type' => 'simple_text',
		),
		'trigger_auto' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Trigger After Time Delay', 'uptin' ),
			'name'            => 'trigger_auto',
			'default'         => '1',
			'conditional'     => 'load_delay',
			'validation_type' => 'boolean',
		),
		'load_delay' => array(
			'type'            => 'input_field',
			'subtype'         => 'number',
			'title'           => __( 'Delay (in seconds)', 'uptin' ),
			'name'            => 'load_delay',
			'hint_text'       => __( 'Define how many seconds you want to wait before the pop up appears on the screen.', 'uptin' ),
			'default'         => '20',
			'display_if'      => 'true',
			'validation_type' => 'number',
		),
		'trigger_idle' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Trigger After Inactivity', 'uptin' ),
			'name'            => 'trigger_idle',
			'default'         => false,
			'conditional'     => 'idle_timeout',
			'validation_type' => 'boolean',
			'class'			  => 'rad_uptin_hide_for_rapidbar'
		),
		'idle_timeout' => array(
			'type'            => 'input_field',
			'subtype'         => 'number',
			'title'           => __( 'Idle Timeout ( in seconds )', 'uptin' ),
			'name'            => 'idle_timeout',
			'hint_text'       => __( 'Define how many seconds user should be inactive before the pop up appears on screen.', 'uptin' ),
			'default'         => '15',
			'display_if'      => 'true',
			'validation_type' => 'number',
			'class'			  => 'rad_uptin_hide_for_rapidbar'
		),
		'post_bottom' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Trigger At The Bottom of Post', 'uptin' ),
			'name'            => 'post_bottom',
			'default'         => '1',
			'validation_type' => 'boolean',
			'class'			  => 'rad_uptin_hide_for_rapidbar'
		),
		'comment_trigger' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Trigger After Commenting', 'uptin' ),
			'name'            => 'comment_trigger',
			'default'         => false,
			'validation_type' => 'boolean',
			'class'			  => 'rad_uptin_hide_for_rapidbar'
		),
        'exit_trigger' => array(
            'type'            => 'checkbox',
            'title'           => __( 'Trigger Before Leaving Page', 'uptin' ),
            'name'            => 'exit_trigger',
            'default'         => false,
            'validation_type' => 'boolean',
			'class'			  => 'rad_uptin_hide_for_rapidbar'
        ),
		'trigger_scroll' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Trigger After Scrolling', 'uptin' ),
			'name'            => 'trigger_scroll',
			'default'         => false,
			'conditional'     => 'scroll_pos',
			'validation_type' => 'boolean',
			'class'			  => 'rad_uptin_hide_for_rapidbar'
		),
		'scroll_pos' => array(
			'type'            => 'input_field',
			'subtype'         => 'number',
			'title'           => __( 'Percentage Down The Page', 'uptin' ),
			'name'            => 'scroll_pos',
			'hint_text'       => __( 'Define the % of the page to be scrolled before the pop up appears on the screen.', 'uptin' ),
			'default'         => '50',
			'display_if'      => 'true',
			'validation_type' => 'number',
			'class'			  => 'rad_uptin_hide_for_rapidbar'
		),
		'purchase_trigger' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Trigger After Purchasing', 'uptin' ),
			'name'            => 'purchase_trigger',
			'default'         => false,
			'hint_text'       => __( 'Display on "Thank you" page of WooCommerce after purchase', 'uptin' ),
			'validation_type' => 'boolean',
			'class'			  => 'rad_uptin_hide_for_rapidbar'
		),
		'session' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Display once per session', 'uptin' ),
			'name'            => 'session',
			'default'         => false,
			'validation_type' => 'boolean',
			'conditional'     => 'session_duration',
			'class'			  => 'rad_uptin_hide_for_rapidbar'
		),
		'session_duration' => array(
			'type'            => 'input_field',
			'subtype'         => 'number',
			'title'           => __( 'Session Duration (in days)', 'uptin' ),
			'name'            => 'session_duration',
			'hint_text'       => __( 'Define the length of time (in days) that a session lasts for. For example, if you input 2 a user will only see a popup on your site every two days.', 'uptin' ),
			'default'         => '1',
			'validation_type' => 'number',
			'display_if'      => 'true',
			'class'			  => 'rad_uptin_hide_for_rapidbar'
		),
		'hide_mobile' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Hide on Mobile', 'uptin' ),
			'name'            => 'hide_mobile_optin',
			'default'         => false,
			'validation_type' => 'boolean',
		),
		'click_trigger' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Trigger When Element is Clicked', 'uptin' ),
			'name'            => 'click_trigger',
			'hint_text'       => __( 'Adds new onclick shortcode option to Uptin editor when editing a page / post', 'uptin' ),
			'default'         => false,
			'validation_type' => 'boolean',
			'class'			  => 'rad_uptin_click_trigger',
			'class'			  => 'rad_uptin_hide_for_rapidbar',
		),
		'allow_dismiss' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Allow user to dismiss', 'uptin' ),
			'hint_text'		  => __('Allows user to close banner by clicking X'),
			'name'            => 'allow_dismiss',
			'class'			  => 'rad_uptin_allow_dismiss',
			'default'         => true,
			'validation_type' => 'boolean',
		),
		'submit_remove' => array(
			'type'            => 'checkbox',
			'title'           => __( 'Remove on redirect', 'uptin' ),
			'hint_text'		  => __('Close the banner on link click'),
			'name'            => 'submit_remove',
			'class'			  => 'rad_uptin_submit_removes',
			'default'         => true,
			'validation_type' => 'boolean',
			'display_if'      => 'enable_redirect_form#true'
		),
	),

	'flyin_orientation' => array(
		'section_start' => array(
			'type'  => 'section_start',
			'title' => __( 'Fly-In Orientation', 'uptin' ),
			'class' => 'rad_dashboard_for_flyin',
		),
		'flyin_orientation' => array(
			'type'            => 'select',
			'title'           => __( 'Choose Orientation', 'uptin' ),
			'name'            => 'flyin_orientation',
			'value'           => array(
				'right'  => __( 'Right', 'uptin' ),
				'left'   => __( 'Left', 'uptin' ),
				'center' => __( 'Center', 'uptin' ),
			),
			'default'         => 'right',
			'validation_type' => 'simple_text',
		),
	),

	'post_types' => array(
		array(
			'type'  => 'section_start',
			'title' => __( 'Display on', 'uptin' ),
			'class' => 'rad_dashboard_child_hidden display_on_section',
		),
		array(
			'type'            => 'checkbox_set',
			'name'            => 'display_on',
			'value'           => array(
				'everything' => __( 'Everything', 'uptin' ),
				'home'       => __( 'Homepage', 'uptin' ),
				'archive'    => __( 'Archives', 'uptin' ),
				'category'   => __( 'Categories', 'uptin' ),
				'tags'       => __( 'Tags', 'uptin' ),
			),
			'default'         => array( '' ),
			'validation_type' => 'simple_array',
			'conditional'     => array(
				'everything' => 'pages_exclude_section#posts_exclude_section#pages_include_section#posts_include_section',
				'category'   => 'categories_include_section',
			),
			'class'           => 'display_on_checkboxes',
		),
		array(
			'type'            => 'checkbox_posts',
			'subtype'         => 'post_types',
			'name'            => 'post_types',
			'default'         => array( 'post' ),
			'validation_type' => 'simple_array',
			'conditional'     => array(
				'page'     => 'pages_exclude_section',
				'post'     => 'categories_include_section#posts_exclude_section',
				'any_post' => 'posts_exclude_section#categories_include_section',
			),
		),
	),

	'post_categories' => array(
		array(
			'type'       => 'section_start',
			'title'      => __( 'Display on these categories', 'uptin' ),
			'class'      => 'rad_dashboard_child_hidden categories_include_section',
			'name'       => 'categories_include_section',
			'display_if' => 'true',
		),
		array(
			'type'            => 'checkbox_posts',
			'subtype'         => 'post_cats',
			'name'            => 'post_categories',
			'include_custom'  => true,
			'default'         => array(),
			'validation_type' => 'simple_array',
		),
	),

	'pages_exclude' => array(
		array(
			'type'       => 'section_start',
			'title'      => __( 'Do not display on these pages', 'uptin' ),
			'class'      => 'rad_dashboard_child_hidden',
			'name'       => 'pages_exclude_section',
			'display_if' => 'true',
		),
		array(
			'type'            => 'live_search',
			'name'            => 'pages_exclude',
			'post_type'       => 'only_pages',
			'placeholder'     => __( 'Start Typing Page Name...', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
		),
	),

	'pages_include' => array(
		array(
			'type'       => 'section_start',
			'title'      => __( 'Display on these pages', 'uptin' ),
			'subtitle'   => __( 'Pages defined below will override all settings above', 'uptin' ),
			'class'      => 'rad_dashboard_child_hidden',
			'name'       => 'pages_include_section',
			'display_if' => 'false',
		),
		array(
			'type'            => 'live_search',
			'name'            => 'pages_include',
			'post_type'       => 'only_pages',
			'placeholder'     => __( 'Start Typing Page Name...', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
		),
	),

	'posts_exclude' => array(
		array(
			'type'       => 'section_start',
			'title'      => __( 'Do not display on these posts', 'uptin' ),
			'class'      => 'rad_dashboard_child_hidden',
			'name'       => 'posts_exclude_section',
			'display_if' => 'true',
		),
		array(
			'type'            => 'live_search',
			'name'            => 'posts_exclude',
			'post_type'       => 'only_posts',
			'placeholder'     => __( 'Start Typing Post Name...', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
		),
	),

	'posts_include' => array(
		array(
			'type'       => 'section_start',
			'title'      => __( 'Display on these posts', 'uptin' ),
			'subtitle'   => __( 'Posts defined below will override all settings above', 'uptin' ),
			'class'      => 'rad_dashboard_child_hidden',
			'name'       => 'posts_include_section',
			'display_if' => 'false',
		),
		array(
			'type'            => 'live_search',
			'name'            => 'posts_include',
			'post_type'       => 'only_posts',
			'placeholder'     => __( 'Start Typing Post Name...', 'uptin' ),
			'default'         => '',
			'validation_type' => 'simple_text',
		),
	),

	'authorization' => array(
		'authorization_title' => array(
			'type'  => 'main_title',
			'title' => __( 'Setup your accounts', 'uptin' ),
		),

		'sub_section_mailchimp' => array(
			'type'        => 'section_start',
			'sub_section' => true,
			'title'       => __( 'MailChimp', 'uptin' ),
		),

		'mailchimp_key' => array(
			'type'                 => 'input_field',
			'subtype'              => 'text',
			'name'                 => 'mailchimp_key',
			'title'                => __( 'MailChimp API Key', 'uptin' ),
			'default'              => '',
			'class'                => 'api_option api_option_key',
			'hide_contents'        => true,
			'hint_text'            => $more_info_hint_text,
			'hint_text_with_links' => 'on',
			'validation_type'      => 'simple_text',
		),
		'mailchimp_button' => array(
			'type'      => 'button',
			'title'     => __( 'Authorize', 'Monarch' ),
			'link'      => '#',
			'class'     => 'rad_dashboard_authorize',
			'action'    => 'mailchimp',
			'authorize' => true,
		),

		'sub_section_aweber' => array(
			'type'        => 'section_start',
			'sub_section' => true,
			'title'       => __( 'AWeber', 'uptin' ),
		),

		'aweber_key' => array(
			'type'                 => 'input_field',
			'subtype'              => 'text',
			'name'                 => 'aweber_key',
			'title'                => __( 'AWeber authorization code', 'uptin' ),
			'default'              => '',
			'class'                => 'api_option api_option_key',
			'hide_contents'        => true,
			'hint_text'            => $more_info_hint_text,
			'hint_text_with_links' => 'on',
			'validation_type'      => 'simple_text',
		),
		'aweber_button' => array(
			'type'      => 'button',
			'title'     => __( 'Authorize', 'Monarch' ),
			'link'      => '#',
			'class'     => 'rad_dashboard_authorize',
			'action'    => 'aweber',
			'authorize' => true,
		),
	),

	'optin_type' => array(
		'type'            => 'hidden_option',
		'subtype'         => 'string',
		'name'            => 'optin_type',
		'validation_type' => 'simple_text',
	),

	'optin_status' => array(
		'type'            => 'hidden_option',
		'subtype'         => 'string',
		'name'            => 'optin_status',
		'validation_type' => 'simple_text',
	),

	'test_status' => array(
		'type'            => 'hidden_option',
		'subtype'         => 'string',
		'name'            => 'test_status',
		'validation_type' => 'simple_text',
	),

	'next_optin' => array(
		'type'            => 'hidden_option',
		'subtype'         => 'string',
		'name'            => 'next_optin',
		'default'         => '-1',
		'validation_type' => 'simple_text',
	),

	'child_of' => array(
		'type'            => 'hidden_option',
		'subtype'         => 'string',
		'name'            => 'child_of',
		'validation_type' => 'simple_text',
	),

	'child_optins' => array(
		'type'            => 'hidden_option',
		'subtype'         => 'array',
		'name'            => 'child_optins',
		'validation_type' => 'simple_array',
	),
	'setup_title' => array(
		'type'     => 'main_title',
		'title'    => __( 'Step 1: Name and Connect Your Form', 'uptin' ),
		'subtitle' =>  __( 'Create and publish your new opt-in form in just 4 steps.', 'uptin'),
		'subtitle2' =>  __( 'Give your opt-in form a name, then connect it with your Email Service Provider for building your email list.', 'uptin' ),
	),
	'design_title' => array(
		'type'     => 'main_title',
		'title'    => __( 'Step 3: Customize Your Form Template', 'uptin' ),
		'subtitle' => __( 'This is your 3rd step in creating your new opt-in form. In this step, you’ll enter the text you want to appear on your form, make style, color and image choices, and more.', 'uptin' ),
		'subtitle2' => __( 'Customizing your form is easy, and you can see how it looks as you go by clicking the blue preview button.', 'uptin' ),
		'class'    => 'rad_dashboard_design_title',
	),

	'display_title' => array(
		'type'     => 'main_title',
		'title'    => __( 'Step 4: Select When and Where Your Form Appears', 'uptin' ),
		'subtitle' => __( 'In this final step you can choose a variety of triggers for when your opt-in form displays, and where you want it to show up.', 'uptin' ),
	),

	'import_export' => array(
		'type'  => 'import_export',
		'title' => __( 'Import/Export', 'uptin' ),
	),

	'home' => array(
		'type'  => 'home',
		'title' => __( 'Home', 'uptin' ),
	),

	'stats' => array(
		'type'  => 'stats',
		'title' => __( 'Opt-In Stats', 'uptin' ),
	),

	'accounts' => array(
		'type'  => 'account',
		'title' => __( 'Accounts', 'uptin' ),
	),
	'support' => array(
		'type'  => 'support',
		'title' => __( 'Help and Support', 'uptin' ),
	),
	'edit_account' => array(
		'type'  => 'edit_account',
		'title' => __( 'Edit Account', 'uptin' ),
	),

	'preview_optin' => array(
		'type'  => 'preview_optin',
		'title' => __( 'Preview', 'uptin' ),
	),

	'premade_templates_start' => array(
		'type'     => 'main_title',
		'title'    => __( 'Step 2: Select a Template To Customize', 'uptin' ),
		'subtitle' => __( 'Choose a template that best represents your basic style preference. Don’t worry if you can’t find the exact color or image. You’ll be able to customize these elements to your liking in the next step.', 'uptin' ),
	),

	'premade_templates_main' => array(
		'type'  => 'premade_templates',
		'title' => __( 'Choose a template', 'uptin' ),
	),

	'end_of_section' => array(
		'type' => 'section_end',
	),

	'end_of_sub_section' => array(
		'type'        => 'section_end',
		'sub_section' => 'true',
	),
);

/**
 * Array of options assigned to sections. Format of option key is following:
 * 	<section>_<sub_section>_options
 * where:
 *	<section> = $rad_ -> $key
 *	<sub_section> = $rad_ -> $value['contents'] -> $key
 *
 * Note: name of this array shouldn't be changed. $rad_assigned_options variable is being used in EWD_Dash class as options container.
 */
$rad_assigned_options = array(
	'optin_setup_options' => array(
		$rad_dashboard_options_all[ 'setup_title' ],
		$rad_dashboard_options_all[ 'optin_type' ],
		$rad_dashboard_options_all[ 'optin_status' ],
		$rad_dashboard_options_all[ 'test_status' ],
		$rad_dashboard_options_all[ 'child_of' ],
		$rad_dashboard_options_all[ 'child_optins' ],
		$rad_dashboard_options_all[ 'next_optin' ],
		$rad_dashboard_options_all[ 'optin_name' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'optin_name' ][ 'option' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'form_integration' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'form_integration' ][ 'enable_redirect_form' ],
			$rad_dashboard_options_all[ 'form_integration' ][ 'email_provider' ],
			$rad_dashboard_options_all[ 'form_integration' ][ 'select_account' ],
			$rad_dashboard_options_all[ 'form_integration' ][ 'email_list' ],
			$rad_dashboard_options_all[ 'form_integration' ][ 'custom_html' ],
			$rad_dashboard_options_all[ 'form_integration' ][ 'disable_dbl_optin' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
	),
	'optin_premade_options' => array(
		$rad_dashboard_options_all[ 'premade_templates_start' ],
		$rad_dashboard_options_all[ 'premade_templates_main' ],
	),
	'optin_design_options' => array(
		$rad_dashboard_options_all[ 'preview_optin' ],
		$rad_dashboard_options_all[ 'design_title' ],
		$rad_dashboard_options_all[ 'optin_title' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'optin_title' ][ 'option' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'optin_message' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'optin_message' ][ 'option' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'image_settings' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'image_settings' ][ 'image_orientation' ],
			$rad_dashboard_options_all[ 'image_settings' ][ 'image_orientation_widget' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'image_upload' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'image_upload' ][ 'image_url' ],
			$rad_dashboard_options_all[ 'image_upload' ][ 'image_animation' ],
			$rad_dashboard_options_all[ 'image_upload' ][ 'hide_mobile' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'optin_styling' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'form_setup' ][ 'rapidbar_position' ],
			$rad_dashboard_options_all[ 'optin_styling' ][ 'header_bg_color' ],
			$rad_dashboard_options_all[ 'optin_styling' ][ 'header_font' ],
			$rad_dashboard_options_all[ 'optin_styling' ][ 'body_font' ],
			$rad_dashboard_options_all[ 'optin_styling' ][ 'header_text_color' ],
			$rad_dashboard_options_all[ 'optin_styling' ][ 'corner_style' ],
			$rad_dashboard_options_all[ 'optin_styling' ][ 'border_orientation' ],
			$rad_dashboard_options_all[ 'optin_styling' ][ 'border_color' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'border_style' ],
		$rad_dashboard_options_all[ 'form_setup' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'form_setup' ][ 'form_orientation' ],
			$rad_dashboard_options_all[ 'form_setup' ][ 'redirect_url' ],
	  		$rad_dashboard_options_all[ 'form_setup' ][ 'redirect_bar' ],
	  $rad_dashboard_options_all[ 'form_setup' ][ 'rapidbar_popup' ],
	  		$rad_dashboard_options_all[ 'form_setup' ][ 'display_name' ],
			$rad_dashboard_options_all[ 'form_setup' ][ 'name_fields' ],
			$rad_dashboard_options_all[ 'form_setup' ][ 'name_text' ],
			$rad_dashboard_options_all[ 'form_setup' ][ 'single_name_text' ],
			$rad_dashboard_options_all[ 'form_setup' ][ 'last_name' ],
			$rad_dashboard_options_all[ 'form_setup' ][ 'email_text' ],
			$rad_dashboard_options_all[ 'form_setup' ][ 'button_text' ],
	  		$rad_dashboard_options_all[ 'form_setup' ][ 'enable_consent' ],
	  		$rad_dashboard_options_all[ 'form_setup' ][ 'consent_color' ],
	  		$rad_dashboard_options_all[ 'form_setup' ][ 'consent_text' ],
	  		$rad_dashboard_options_all[ 'form_setup' ][ 'consent_error' ],
			$rad_dashboard_options_all[ 'form_setup' ][ 'display_as_link' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'form_styling' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'form_styling' ][ 'field_orientation' ],
			$rad_dashboard_options_all[ 'form_styling' ][ 'field_corner' ],
			$rad_dashboard_options_all[ 'form_styling' ][ 'text_color' ],
			$rad_dashboard_options_all[ 'form_styling' ][ 'form_bg_color' ],
			$rad_dashboard_options_all[ 'form_styling' ][ 'form_button_color' ],
			$rad_dashboard_options_all[ 'form_setup' ][ 'button_text_color' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'edge_style' ],
		$rad_dashboard_options_all[ 'footer_text' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'footer_text' ][ 'option' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'success_message' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'success_message' ][ 'option' ],
			$rad_dashboard_options_all['success_message']['enable_success_redirect'],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all['success_redirect']['section_start'],
			$rad_dashboard_options_all[ 'success_redirect' ][ 'success_url' ],
			$rad_dashboard_options_all[ 'success_redirect' ][ 'success_load_delay' ],
	  		$rad_dashboard_options_all[ 'success_redirect' ][ 'redirect_standard' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'custom_css' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'custom_css' ][ 'option' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
	),
	'optin_display_options' => array(
		$rad_dashboard_options_all[ 'display_title' ],
		$rad_dashboard_options_all[ 'flyin_orientation' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'flyin_orientation' ][ 'flyin_orientation' ],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'load_in' ][ 'section_start' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'load_animation' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'trigger_auto' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'load_delay' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'trigger_idle' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'idle_timeout' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'post_bottom' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'comment_trigger' ],
            $rad_dashboard_options_all[ 'load_in' ][ 'exit_trigger' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'click_trigger' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'trigger_scroll' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'scroll_pos' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'purchase_trigger' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'session' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'session_duration' ],
			$rad_dashboard_options_all[ 'load_in' ][ 'hide_mobile' ],
			$rad_dashboard_options_all['load_in']['allow_dismiss'],
			$rad_dashboard_options_all['load_in']['submit_remove'],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'post_types' ][0],
			$rad_dashboard_options_all[ 'post_types' ][1],
			$rad_dashboard_options_all[ 'post_types' ][2],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'post_categories' ][0],
			$rad_dashboard_options_all[ 'post_categories' ][1],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'pages_include' ][0],
			$rad_dashboard_options_all[ 'pages_include' ][1],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'pages_exclude' ][0],
			$rad_dashboard_options_all[ 'pages_exclude' ][1],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'posts_exclude' ][0],
			$rad_dashboard_options_all[ 'posts_exclude' ][1],
		$rad_dashboard_options_all[ 'end_of_section' ],
		$rad_dashboard_options_all[ 'posts_include' ][0],
			$rad_dashboard_options_all[ 'posts_include' ][1],
		$rad_dashboard_options_all[ 'end_of_section' ],
	),
	'header_importexport_options' => array(
		$rad_dashboard_options_all[ 'import_export' ],
	),
	'header_home_options' => array(
		$rad_dashboard_options_all[ 'home' ],
	),
	'header_accounts_options' => array(
		$rad_dashboard_options_all[ 'accounts' ],
	),
	'header_edit_account_options' => array(
		$rad_dashboard_options_all[ 'edit_account' ],
	),
	'header_stats_options' => array(
		$rad_dashboard_options_all[ 'stats' ],
	),
	'header_support_options' => array(
		$rad_dashboard_options_all[ 'support' ],
	),
);