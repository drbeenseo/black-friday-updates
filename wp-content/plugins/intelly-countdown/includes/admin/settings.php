<?php
function icp_ui_track($always=FALSE) {
    global $icp;
    $track=$icp->Utils->qs('track', '');
    if($track!='') {
        $settings=$icp->Options->getPluginSettings();
        $settings->allowUsageTracking=intval($track);
        $icp->Options->setPluginSettings($settings);
    }

    if(!$always && $icp->Options->isTrackingEnable()) {
        return;
    }

    if($icp->Options->isTrackingEnable()) {
        $arg=array('track'=>0);
        $uri=$icp->Utils->addQueryString($arg, ICP_TAB_SETTINGS_URI);
        $icp->Options->pushSuccessMessage('Tracking.Enabled', $uri);
    } else {
        $arg=array('track'=>1);
        $uri=$icp->Utils->addQueryString($arg, ICP_TAB_SETTINGS_URI);
        $icp->Options->pushWarningMessage('Tracking.Disabled', $uri);
    }
    $icp->Options->writeMessages();
}
function icp_ui_settings() {
    global $icp;

    ?>
    <h2><?php $icp->Lang->P('Title.Settings')?></h2>
    <?php

    icp_ui_track(TRUE);
    /*$settings=$icp->Options->getPluginSettings();
    $icp->Form->prefix='License';
    if($icp->Check->nonce('icp_settings')) {
        if($icp->Check->is('_action', 'Save')) {
            $newSettings=$icp->Dao->Utils->qs('ICP_PluginSettings');
            if($settings->allowUsageTracking!=$newSettings->allowUsageTracking) {
                $icp->Options->setTrackingEnable($newSettings->allowUsageTracking);
                $icp->Tracking->sendTracking(TRUE);
            }
            $icp->Options->setPluginSettings($newSettings);
        }
    }

    $settings=$icp->Options->getPluginSettings();
    $icp->Options->writeMessages();

    $icp->Form->formStarts();
    {
        $icp->Form->openPanel('PluginSection');
        {
            $fields='allowUsageTracking';
            $icp->Form->inputsForm($fields, $settings);

            $icp->Form->nonce('icp_settings');
            $buttons=array();
            $button=array(
                'submit'=>TRUE
            );
            $buttons['Save']=$button;
            $options=array('buttons'=>$buttons);
        }
        $icp->Form->closePanel($options);
    }
    $icp->Form->formEnds();
    */
}