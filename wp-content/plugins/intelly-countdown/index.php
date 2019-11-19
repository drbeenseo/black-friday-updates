<?php
/*
Plugin Name: Evergreen Countdown Timer
Plugin URI: https://intellywp.com/evergreen-countdown-timer/
Description: Evergreen Countdown is a plugin built for marketers that need a reliable solution to use scarcity on their websites and landing pages.
Author: IntellyWP
Author URI: http://intellywp.com/
Email: support@intellywp.com
Version: 1.1.0
*/
if(defined('ICP_PLUGIN_NAME')) {
    function ICP_FREE_admin_notices() {
        global $icp; ?>
        <div style="clear:both"></div>
        <div class="error iwp" style="padding:10px;">
            <?php $icp->Lang->P('PluginProAlreadyInstalled'); ?>
        </div>
        <div style="clear:both"></div>
    <?php }
    add_action('admin_notices', 'ICP_FREE_admin_notices');
    return;
}

define('ICP_PLUGIN_PREFIX', 'ICP_');
define('ICP_PLUGIN_FILE',__FILE__);
define('ICP_PLUGIN_SLUG', 'intelly-countdown');
define('ICP_PLUGIN_NAME', 'Evergreen Countdown');
define('ICP_PLUGIN_VERSION', '1.1.0');
define('ICP_PLUGIN_AUTHOR', 'IntellyWP');
define('ICP_PLUGIN_DIR', dirname(__FILE__).'/');

define('ICP_PLUGIN_URI', plugins_url('/', __FILE__));
define('ICP_PLUGIN_ASSETS_URI', ICP_PLUGIN_URI.'assets/');
define('ICP_PLUGIN_IMAGES_URI', ICP_PLUGIN_ASSETS_URI.'images/');

//define('ICP_LOGGER', FALSE);
define('ICP_AUTOSAVE_LANG', TRUE);

define('ICP_QUERY_POSTS_OF_TYPE', 1);
define('ICP_QUERY_POST_TYPES', 2);
define('ICP_QUERY_CATEGORIES', 3);
define('ICP_QUERY_TAGS', 4);

define('ICP_ENGINE_SEARCH_CATEGORIES_TAGS', 0);
define('ICP_ENGINE_SEARCH_CATEGORIES', 1);
define('ICP_ENGINE_SEARCH_TAGS', 2);

define('ICP_INTELLYWP_SITE', 'https://intellywp.com/');
define('ICP_INTELLYWP_ENDPOINT', ICP_INTELLYWP_SITE.'wp-content/plugins/intellywp-manager/data.php');
define('ICP_PAGE_FAQ', ICP_INTELLYWP_SITE.ICP_PLUGIN_SLUG);
define('ICP_PAGE_PREMIUM', ICP_INTELLYWP_SITE.ICP_PLUGIN_SLUG);
define('ICP_PAGE_HOME', admin_url().'options-general.php?page='.ICP_PLUGIN_SLUG);

define('ICP_TAB_PLUGINS', 'plugins');
define('ICP_TAB_PLUGINS_URI', 'https://intellywp.com/plugins/');
define('ICP_TAB_DOCS', 'docs');
define('ICP_TAB_DOCS_URI', 'https://intellywp.com/docs/category/'.ICP_PLUGIN_SLUG);
define('ICP_TAB_SUPPORT', 'support');
define('ICP_TAB_SUPPORT_URI', 'https://intellywp.com/contact/');
define('ICP_TAB_PREMIUM_URI', 'https://intellywp.com/evergreen-countdown-timer/');

define('ICP_TAB_SETTINGS', 'settings');
define('ICP_TAB_SETTINGS_URI', ICP_PAGE_HOME.'&tab='.ICP_TAB_SETTINGS);
define('ICP_TAB_EDITOR', 'editor');
define('ICP_TAB_EDITOR_URI', ICP_PAGE_HOME.'&tab='.ICP_TAB_EDITOR);
define('ICP_TAB_MANAGER', 'manager');
define('ICP_TAB_MANAGER_URI', ICP_PAGE_HOME.'&tab='.ICP_TAB_MANAGER);
define('ICP_TAB_WHATS_NEW', 'whatsnew');
define('ICP_TAB_WHATS_NEW_URI', ICP_PAGE_HOME.'&tab='.ICP_TAB_WHATS_NEW);

define('ICP_BLOG_URL', get_bloginfo('wpurl'));
define('ICP_BLOG_EMAIL', get_bloginfo('admin_email'));

/*if (!function_exists('hex2bin')) {
    function hex2bin($str) {
        $result="";
        $len=strlen($str);
        for ($i=0; $i<$len; $i+=2) {
            $result.=pack("H*", substr($str, $i, 2));
        }
        return $result;
    }
}*/

include_once(dirname(__FILE__).'/autoload.php');
icp_include_php(dirname(__FILE__).'/includes/');

global $icp;
$icp=new ICP_Singleton();
$icp->init();
