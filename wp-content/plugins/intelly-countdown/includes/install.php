<?php
register_activation_hook(ICP_PLUGIN_FILE, 'icp_install');
function icp_install($networkwide=NULL) {
	global $wpdb, $icp;

    $time=$icp->Options->getPluginInstallDate();
    if($time==0) {
        $icp->Options->setPluginInstallDate(time());
        $icp->Options->setTrackingEnable(TRUE);
        $icp->Tracking->sendTracking(TRUE);
    } elseif($icp->Options->isTrackingEnable()) {
        $icp->Tracking->sendTracking(TRUE);
    }
    //icp_database_update();
    $icp->Options->setPluginUpdateDate(time());
    $icp->Options->setPluginFirstInstall(TRUE);
    $icp->Options->setTrackingLastSend(0);
}

/*function icp_database_update($force=FALSE) {
    global $ec;

    //remove OLD CAE issue
    $crons=_get_cron_array();
    foreach($crons as $time=>$jobs) {
        foreach($jobs as $k=>$v) {
            switch (strtolower($k)) {
                case 'icp_scheduler_daily':
                case 'icp_scheduler_weekly':
                    unset($jobs[$k]);
                    break;
            }
            if(count($jobs)==0) {
                unset($crons[$time]);
            }
        }
    }
    _set_cron_array($crons);

    $md5=$ec->Options->getDatabaseVersion();
    $compare=$ec->Dao->Utils->getDatabaseVersion();
    if($force || $md5!=$compare) {
        if($ec->Dao->Utils->databaseUpdate()) {
            $ec->Options->setDatabaseVersion($compare);
            $ec->Options->setDatabaseUpdateDate(time());
        }
    }
}*/

add_action('admin_init', 'icp_first_redirect');
function icp_first_redirect() {
    global $icp;
    if ($icp->Options->isPluginFirstInstall()) {
        $icp->Options->setPluginFirstInstall(FALSE);
        $icp->Options->setShowActivationNotice(TRUE);

        $icp->Options->setShowWhatsNew(FALSE); //TRUE
        $icp->Utils->redirect(ICP_TAB_SETTINGS_URI);
    }
}



