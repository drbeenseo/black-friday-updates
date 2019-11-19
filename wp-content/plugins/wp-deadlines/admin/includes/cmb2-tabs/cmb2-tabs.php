<?php


if ( is_admin() ) {

    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'cmb2-tabs/inc/assets.class.php';
    require_once plugin_dir_path( dirname( __FILE__ ) ) . 'cmb2-tabs/inc/cmb2-tabs.class.php';


    // Connection css and js
	new CMB2_Tab_Assets();

	// Run global class
	new CMB2_Tabs();
}
