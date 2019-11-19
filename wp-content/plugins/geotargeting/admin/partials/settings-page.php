<?php
/**
 * Settings page template
 * @since  1.0.0
 */
 if (  isset( $_POST['geot_nonce'] ) && wp_verify_nonce( $_POST['geot_nonce'], 'geot_save_settings' ) ) {

     $settings = esc_sql( $_POST['geot_settings'] );

	 update_option( 'geot_settings' ,  $settings);

 }

 $opts = apply_filters('geot/settings_page/opts', get_option( 'geot_settings' ) );

 if( empty( $opts['debug_mode'] ) ) {
	 $opts['debug_mode'] = '0';
 }


?>
<div class="wrap geot-settings">
	<h2>GeoTargeting <?php echo $this->version;?></h2>
	<form name="geot-settings" method="post" enctype="multipart/form-data">
		<table class="form-table">
			<?php do_action( 'geot/settings_page/before' ); ?>
			<tr valign="top" class="">
				<th><h3><?php _e( 'Main settings:', $this->GeoTarget ); ?></h3></th>
			</tr>

			<tr valign="top" class="">
				<th><label for="maxm_id"><?php _e( 'Debug Mode', $this->GeoTarget ); ?></label></th>
				<td colspan="3">
					<label><input type="checkbox" id="maxm_id" name="geot_settings[debug_mode]" value="1" <?php checked($opts['debug_mode'] , '1');?> />
						<p class="help"><?php _e( 'If you want to calculate user data on every page load and print in the footer debug info with check this.', $this->GeoTarget ); ?></p>
				</td>
			</tr>
			<tr><td><input type="submit" class="button-primary" value="<?php _e( 'Save settings', $this->GeoTarget );?>"/></td>
				<?php wp_nonce_field('geot_save_settings','geot_nonce'); ?>
			</tr>
            <tr>
                <td colspan="2"><h2>Following settings are for premium version only</h2>
                <p>Check premium version on <a href="https://timersys.com/plugins/geotargeting-pro/&utm_source=plugin-settings&utm_medium=link&utm_campaign=geotargeting-pro">https://timersys.com/plugins/geotargeting-pro/</a></p></td>
            </tr>
		</table>
	</form>
		<div  style="border:4px dashed indianred;padding: 15px;">
			<table class="form-table">
				<tr valign="top" class="">
					<th><label for="ajax_mode"><?php _e( 'Ajax Mode', $this->GeoTarget ); ?></label></th>
					<td colspan="3">
						<label><input disabled="disabled" type="checkbox" id="ajax_mode" name="geot_settings[ajax_mode]" value="1"/>
							<p class="help"><?php _e( 'In Ajax mode, after page load an extra request is made to get all data and everything is updated with javascript. That makes the plugin compatible with any cache plugin. More info on: ', $this->GeoTarget ); ?><a href="https://timersys.com/geotargeting/docs/ajax-mode/">Ajax mode info</a></p>
					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="menu_integration"><?php _e( 'Disable Menu integration', $this->GeoTarget ); ?></label></th>
					<td colspan="3">
						<label><input disabled="disabled" type="checkbox" id="menu_integration" name="geot_settings[disable_menu_integration]" value="1" />
							<p class="help"><?php _e( 'Check this to remove geotargeting options from menus', $this->GeoTarget ); ?></p>
					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="widget_integration"><?php _e( 'Disable Widget Integration', $this->GeoTarget ); ?></label></th>
					<td colspan="3">
						<label><input  disabled="disabled" type="checkbox" id="widget_integration" name="geot_settings[disable_widget_integration]" value="1" />
							<p class="help"><?php _e( 'Check this to remove geotargeting options from widgets', $this->GeoTarget ); ?></p>
					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="region"><?php _e( 'Fallback Country', $this->GeoTarget ); ?></label></th>
					<td colspan="3">

						<select name="geot_settings[fallback_country]"  disabled="disabled" class="geot-chosen-select" data-placeholder="<?php _e('Type country name...', $this->GeoTarget );?>" >
							<option value=""><?php _e( 'Choose One', $this->GeoTarget );?></option>

						</select>

						<p class="help"><?php _e( 'If the user IP is not detected plugin will fallback to this country', $this->GeoTarget ); ?></p>
					</td>

				</tr>
				<tr valign="top" class="">
					<th><label for="bots"><?php _e( 'Bots Country', $this->GeoTarget ); ?></label></th>
					<td colspan="3">
						<select disabled="disabled" name="geot_settings[bots_country]"  class="geot-chosen-select" data-placeholder="<?php _e('Type country name...', $this->GeoTarget );?>" >
							<option value=""><?php _e( 'Choose One', $this->GeoTarget );?></option>

						</select>

						<p class="help"><?php _e( 'All bots / crawlers will be treated as the are from this country. More info in ', $this->GeoTarget ); ?><a href="https://timersys.com/geotargeting/docs/bots-seo/">Bots in Geotargeting</a></p>
					</td>
				</tr>

				<tr valign="top" class="">
					<th><h3><?php _e( 'Maxmind:', $this->GeoTarget ); ?></h3></th>
					<td colspan="3">
						<p><?php echo sprintf(__( 'If you have <a href="%s">Maxmind API credentials</a>, enter them below', $this->GeoTarget ), 'https://www.maxmind.com/en/geoip2-precision-city-service?rId=timersys'); ?></p>
					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="maxm_service"><?php _e( 'GeoIP2 Precision Service', $this->GeoTarget ); ?></label></th>
					<td colspan="3">
						<label><select  disabled="disabled" id="maxm_service" name="geot_settings[maxm_service]">
									<option value="city">City</option>
									<option value="country">Country</option>
									<option value="insights">Insights</option>
								</select>
						<p class="help"><?php _e( 'Choose the precision service you purchased', $this->GeoTarget ); ?></p>
					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="maxm_id"><?php _e( 'Maxmind User ID', $this->GeoTarget ); ?></label></th>
					<td colspan="3">
						<label><input  disabled="disabled" type="text" id="maxm_id" name="geot_settings[maxm_id]" value="" class="regular-text" />
						<p class="help"><?php _e( 'Enter your Maxmind user id', $this->GeoTarget ); ?></p>
					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="maxm_license"><?php _e( 'Maxmind license key', $this->GeoTarget ); ?></label></th>
					<td colspan="3">
						<label><input  disabled="disabled" type="text" id="maxm_license" name="geot_settings[maxm_license]" value="" class="regular-text" />
						<p class="help"><?php _e( 'Enter your Maxmind license key', $this->GeoTarget ); ?></p>
					</td>
				</tr>

				<tr valign="top" class="">
					<th><h3><?php _e( 'Countries:', $this->GeoTarget ); ?></h3></th>
					<td colspan="3">
					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="region"><?php _e( 'Create new region', $this->GeoTarget ); ?></label></th>
					<td colspan="3">

						<a href="#" class="add-region button">Add Region</a>
						<p class="help"><?php _e( 'Add as many countries you need for each region', $this->GeoTarget ); ?></p>
					</td>

				</tr>
				<tr valign="top" class="">
					<th><h3><?php _e( 'Cities:', $this->GeoTarget ); ?></h3></th>
					<td colspan="3">
					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="region"><?php _e( 'Create new region', $this->GeoTarget ); ?></label></th>
					<td colspan="3">

						<a href="#" class="add-city-region button">Add City Region</a>
						<p class="help"><?php _e( 'Add as many cities you need for each region', $this->GeoTarget ); ?></p>
					</td>

				</tr>

				<tr valign="top" class="">
					<th><h3><?php _e( 'Country Redirections:', $this->GeoTarget ); ?></h3></th>
					<td colspan="3"><p><?php _e( 'If you want to redirect users from certain countries / regions to other sites, use the section below:', $this->GeoTarget ); ?></p>
					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="redirection"><?php _e( 'Create new redirection', $this->GeoTarget ); ?></label></th>
					<td colspan="3">

						<a href="#" class="add-redirection button">Add Redirection</a>
						<p class="help"><?php _e( 'Add as many countries you need for each redirection', $this->GeoTarget ); ?></p>
						<p class="help"><?php echo sprintf(__( 'If you need to create internal redirects check <a href="%s">this</a>', $this->GeoTarget ),'https://timersys.com/geotargeting/docs/commons-problems/#3'); ?></p>
					</td>

				</tr>
				<tr valign="top" class="">
					<th><h3><?php _e( 'Uninstall:', $this->GeoTarget ); ?></h3></th>
					<td colspan="3">
						<p><?php _e( 'Check this if you want to <strong>delete all plugin data</strong> on uninstall' , $this->GeoTarget ); ?></p>
					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="maxm_id"><?php _e( 'Uninstall', $this->GeoTarget ); ?></label></th>
					<td colspan="3">
					        <input type="checkbox" id="" name="geot_settings[geot_uninstall]" value="1" />
							<p class="help"><?php _e( 'Will delete all database records and plugin settings when you delete the plugin', $this->GeoTarget ); ?></p>
					</td>
				</tr>

	            <tr valign="top" class="">
					<th><h3><?php _e( 'Export/import:', $this->GeoTarget ); ?></h3></th>
					<td colspan="3">
						<p><?php _e( 'Export your setting or import them with a few clicks' , $this->GeoTarget ); ?></p>
					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="maxm_id"><?php _e( 'Export settings', $this->GeoTarget ); ?></label></th>
					<td colspan="3">
	                    <div id="export_href">

	                    </div>

					</td>
				</tr>
				<tr valign="top" class="">
					<th><label for="maxm_id"><?php _e( 'Import settings', $this->GeoTarget ); ?></label></th>
					<td colspan="3">
	                        Select image to upload:
	                        <input type="file" name="geot_settings_json" id="fileToUpload" disabled="disabled"><br />
	                        <input type="submit" value="Import" name="submit" disabled="disabled">
					</td>
				</tr>
				<?php do_action( 'geot/settings_page/after' ); ?>

			</table>
		</div>
</div>
