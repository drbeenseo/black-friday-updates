<?php
//from Settings_API_Tabs_Demo_Plugin
class ICP_Tabs {
    private $tabs=array();

    function init() {
        global $icp;
        add_filter('wp_enqueue_scripts', array(&$this, 'siteEnqueueScripts'));
        if($icp->Utils->isAdminUser()) {
            add_action('admin_menu', array(&$this, 'attachMenu'));
            add_filter('plugin_action_links', array(&$this, 'pluginActions'), 10, 2);
            if($icp->Utils->isPluginPage()) {
                add_action('admin_enqueue_scripts', array(&$this, 'adminEnqueueScripts'), 9999);
            }
        }
    }

    function attachMenu() {
        global $icp;
        if($icp->Utils->isAdminUser()) {
            add_submenu_page('options-general.php'
                , ICP_PLUGIN_NAME, ICP_PLUGIN_NAME
                , 'manage_options', ICP_PLUGIN_SLUG, array(&$this, 'showTabPage'));
        }
    }
    function pluginActions($links, $file) {
        global $icp;
        if($file==ICP_PLUGIN_SLUG.'/index.php'){
            $settings=array();
            $settings[]="<a href='".ICP_TAB_MANAGER_URI."'>".$icp->Lang->L('Settings').'</a>';
            $settings[]="<a href='".ICP_TAB_PREMIUM_URI."'>".$icp->Lang->L('PREMIUM').'</a>';
            $links=array_merge($settings, $links);
        }
        return $links;
    }
    function siteEnqueueScripts() {
        global $post, $icp;
        if (!$post || !isset($post->post_content) || !$icp->Utils->contains($post->post_content, '[ec')) {
            return;
        }

        wp_enqueue_script('jquery');
        $this->wpEnqueueScript('assets/deps/moment/moment.js');
        $this->wpEnqueueScript('assets/js/icp.library.js');
    }
    function adminEnqueueScripts() {
        global $icp;
        $icp->Utils->dequeueScripts('select2|woocommerce|page-expiration-robot');
        $icp->Utils->dequeueStyles('select2|woocommerce|page-expiration-robot');

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('jquery-ui-autocomplete');
        wp_enqueue_script('suggest');

        $uri='//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css';
        wp_enqueue_style('font-awesome', $uri);

        $this->wpEnqueueStyle('assets/css/theme.css');
        $this->wpEnqueueStyle('assets/css/admin-forms.css');
        $this->wpEnqueueStyle('assets/css/all-themes.css');
        //$this->wpEnqueueStyle('assets/css/style.css');
        $this->wpEnqueueScript('assets/deps/starrr/starrr.js');
        //$this->wpEnqueueScript('assets/deps/qtip/jquery.qtip.min.js');

        $this->wpEnqueueStyle('assets/deps/select2/css/core.css');
        $this->wpEnqueueScript('assets/deps/select2/select2.min.js');

        $this->wpEnqueueScript('assets/deps/qtip/jquery.qtip.min.js');
        $this->wpEnqueueStyle('assets/deps/magnific/magnific-popup.css');
        $this->wpEnqueueScript('assets/deps/magnific/jquery.magnific-popup.js');
        //$this->wpEnqueueStyle('assets/deps/select2-3.5.2/select2.css');
        //$this->wpEnqueueScript('assets/deps/select2-3.5.2/select2.min.js');

        $this->wpEnqueueScript('assets/deps/moment/moment.js');

        $this->wpEnqueueStyle('assets/deps/datepicker/css/bootstrap-datetimepicker.css');
        $this->wpEnqueueScript('assets/deps/datepicker/js/bootstrap-datetimepicker.js');

        $this->wpEnqueueStyle('assets/deps/colorpicker/css/bootstrap-colorpicker.min.css');
        $this->wpEnqueueScript('assets/deps/colorpicker/js/bootstrap-colorpicker.min.js');

        $this->wpEnqueueScript('assets/js/utility.js');
        $this->wpEnqueueScript('assets/js/icp.library.js');
        $this->wpEnqueueScript('assets/js/icp.plugin.js');
    }
    function wpEnqueueStyle($uri, $name='') {
        if($name=='') {
            $name=explode('/', $uri);
            $name=$name[count($name)-1];
            $dot=strrpos($name, '.');
            if($dot!==FALSE) {
                $name=substr($name, 0, $dot);
            }
            $name=ICP_PLUGIN_PREFIX.'_'.$name;
        }

        $v='?v='.ICP_PLUGIN_VERSION;
        wp_enqueue_style($name, ICP_PLUGIN_URI.$uri.$v);
    }
    function wpEnqueueScript($uri, $name='', $version=FALSE) {
        if($name=='') {
            $name=explode('/', $uri);
            $name=$name[count($name)-1];
            $dot=strrpos($name, '.');
            if($dot!==FALSE) {
                $name=substr($name, 0, $dot);
            }
            $name=ICP_PLUGIN_PREFIX.'_'.$name;
        }

        $v='?v='.ICP_PLUGIN_VERSION;
        $deps=array();
        wp_enqueue_script($name, ICP_PLUGIN_URI.$uri.$v, $deps, $version, FALSE);
    }

    function showTabPage() {
        global $icp;

        $page=$icp->Utils->qs('page');
        if($icp->Utils->startsWith($page, ICP_PLUGIN_SLUG) && $page!=ICP_PLUGIN_SLUG) {
            $_POST['page']=ICP_PLUGIN_SLUG;
            $_GET['page']=ICP_PLUGIN_SLUG;
            $tab=substr($page, strlen(ICP_PLUGIN_SLUG)+1);
            $_POST['tab']=$tab;
            $_GET['tab']=$tab;
        }

        $id=$icp->Utils->iqs('id', 0);
        $defaultTab=ICP_TAB_MANAGER;
        if($icp->Options->isShowWhatsNew()) {
            $tab=ICP_TAB_WHATS_NEW;
            $defaultTab=$tab;
            $this->tabs[ICP_TAB_WHATS_NEW]=$icp->Lang->L('What\'s New');
            //$this->tabs[TCM_TAB_MANAGER]=$tcm->Lang->L('Start using the plugin!');
        } else {
            $tab=$icp->Utils->qs('tab', $defaultTab);
            $uri='';
            switch ($tab) {
                case ICP_TAB_DOCS:
                    $uri=ICP_TAB_DOCS_URI;
                    break;
                case ICP_TAB_PLUGINS:
                    $uri=ICP_TAB_PLUGINS_URI;
                    break;
                case ICP_TAB_SUPPORT:
                    $uri=ICP_TAB_SUPPORT_URI;
                    break;
            }
            if($uri!='') {
                $icp->Utils->redirect($uri);
            }

            $this->tabs[ICP_TAB_EDITOR]=$icp->Lang->L($id>0 && $tab==ICP_TAB_EDITOR ? 'Edit Countdown' : 'New Countdown');
            $this->tabs[ICP_TAB_MANAGER]=$icp->Lang->L('Manager');
            $this->tabs[ICP_TAB_SETTINGS]=$icp->Lang->L('Settings');
            //$this->tabs[ICP_TAB_DOCS]=$ec->Lang->L('Docs');
            //$this->tabs[ICP_TAB_ABOUT]=$ec->Lang->L('About');
        }

        ?>
        <div class="wrap" style="margin:5px;">
            <?php
            $this->showTabs($defaultTab);
            $header='';
            switch ($tab) {
                case ICP_TAB_EDITOR:
                    $header=($id>0 ? 'Edit' : 'Add');
                    break;
                case ICP_TAB_MANAGER:
                    $header='Manager';
                    break;
                case ICP_TAB_SETTINGS:
                    $header='Settings';
                    break;
                case ICP_TAB_WHATS_NEW:
                    $header='';
                    break;
            }?>
            <div class="mt20 content-max">
                <?php
                if($icp->Lang->H($header.'Title')) { ?>
                    <h2><?php $icp->Lang->P($header . 'Title', ICP_PLUGIN_VERSION) ?></h2>
                    <?php if ($icp->Lang->H($header . 'Subtitle')) { ?>
                        <div><?php $icp->Lang->P($header . 'Subtitle') ?></div>
                    <?php } ?>
                    <br/>
                    <div style="clear:both;"></div>
                <?php }

                if($tab!=ICP_TAB_WHATS_NEW) {
                    icp_ui_first_time();
                }

                switch ($tab) {
                    case ICP_TAB_WHATS_NEW:
                        icp_ui_whats_new();
                        break;
                    case ICP_TAB_EDITOR:
                        icp_ui_editor();
                        break;
                    case ICP_TAB_MANAGER:
                        icp_ui_manager();
                        break;
                    case ICP_TAB_SETTINGS:
                        icp_ui_settings();
                        break;
                }

                if($icp->Options->isShowWhatsNew()) {
                    $icp->Options->setShowWhatsNew(FALSE);
                } ?>
            </div>
        </div>
    <?php }

    function showTabs($defaultTab) {
        global $icp;
        $tab=$icp->Utils->qs('tab', $defaultTab);
        ?>
        <h2 class="nav-tab-wrapper" style="float:left; width:97%;">
            <?php
            foreach ($this->tabs as $k=>$v) {
                $active=($tab==$k ? 'nav-tab-active' : '');
                $uri='?page='.ICP_PLUGIN_SLUG.'&tab='.$k;
                ?>
                <a style="float:left; margin-left:10px; margin-left:10px;" class="nav-tab <?php echo $active?>" href="<?php echo $uri?>"><?php echo $v?></a>
            <?php
            }
            ?>
            <style>
                .starrr {display:inline-block}
                .starrr i{font-size:16px;padding:0 1px;cursor:pointer;color:#2ea2cc;}
            </style>
            <div style="float:right; display:none;" id="rate-box">
                <span style="font-weight:700; font-size:13px; color:#555;"><?php $icp->Lang->P('Rate us')?></span>
                <div id="icp-rate" class="starrr" data-connected-input="icp-rate-rank"></div>
                <input type="hidden" id="icp-rate-rank" name="icp-rate-rank" value="5" />
            </div>

            <script>
                jQuery(function() {
                    jQuery(".starrr").starrr();
                    jQuery('#icp-rate').on('starrr:change', function(e, value){
                        var url='https://wordpress.org/support/view/plugin-reviews/intelly-counter?rate=5#postform';
                        window.open(url);
                    });
                    jQuery('#rate-box').show();
                });
            </script>
        </h2>
        <div style="clear:both;"></div>
    <?php }
}
