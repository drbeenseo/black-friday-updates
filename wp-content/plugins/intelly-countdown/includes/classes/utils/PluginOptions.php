<?php

class ICP_PluginOptions extends ICP_Options {
    public function __construct() {
    }

    public function getIpAddressFirstSeen($countdownId, $ipAddress) {
        if(intval($countdownId)<=0 || $ipAddress=='') {
            return FALSE;
        }

        $bytes=explode('.', $ipAddress);
        $key='IpAddressFirstSeen_'.$countdownId.'_'.$bytes[0];
        $addresses=$this->getOption($key, array());
        $result=(isset($addresses[$ipAddress]) ? $addresses[$ipAddress] : FALSE);
        return $result;
    }
    public function setIpAddressFirstSeen($countdownId, $ipAddress, $time) {
        if(intval($countdownId)<=0 || $ipAddress=='') {
            return;
        }

        $bytes=explode('.', $ipAddress);
        $key='IpAddressFirstSeen_'.$countdownId.'_'.$bytes[0];
        $addresses=$this->getOption($key, array());
        $addresses[$ipAddress]=$time;
        $this->setOption($key, $addresses);
    }
    public function removeIpAddressFirstSeen($countdownId) {
        if(intval($countdownId)<=0) {
            return;
        }

        for($i=0; $i<=256; $i++) {
            $key='IpAddressFirstSeen_'.$countdownId.'_'.$i;
            $this->removeOption($key);
        }
        return TRUE;
    }

    //ArrayCountdowns
    public function getArrayCountdowns() {
        $result=$this->getOption('ArrayCountdowns', array());
        if(!is_array($result)) {
            $result=array();
        }
        foreach($result as $k=>$v) {
            if($v===FALSE || !($v instanceof ICP_Countdown)) {
                unset($result[$k]);
            }
        }
        return $result;
    }
    public function setArrayCountdowns($array) {
        $this->setOption('ArrayCountdowns', $array);
    }

    //PluginSettings
    public function getPluginSettings() {
        /* @var $result ICP_PluginSettings */
        $result=$this->getClassOption('ICP_PluginSettings', 'PluginSettings');
        if($result->allowUsageTracking===null) {
            $result->allowUsageTracking=1;
        }
        return $result;
    }
    public function setPluginSettings(ICP_PluginSettings $value, $overwrite=FALSE) {
        global $icp;
        $current=$this->getPluginSettings();
        if($current->allowUsageTracking!=$value->allowUsageTracking) {
            $this->setTrackingEnable($value->allowUsageTracking);
            $icp->Tracking->sendTracking(TRUE);
        }
        $this->setClassOption('PluginSettings', $value, $overwrite);
    }
}