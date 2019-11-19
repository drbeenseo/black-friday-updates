<?php
abstract class ICP_AbstractDetect {
    public function getFirstSeen(ICP_Countdown $v) {
        return FALSE;
    }
    public function getCookieFirstSeen(ICP_Countdown $v) {
        global $icp;
        $result=FALSE;
        if(isset($_COOKIE['ICP_'.$v->id.'_FirstSeen'])) {
            $dt=$_COOKIE['ICP_'.$v->id.'_FirstSeen'];
            $result=DateTime::createFromFormat(DateTime::ISO8601, $dt);
            if($result===FALSE) {
                if($icp->Utils->contains($dt, ' ') && !$icp->Utils->contains($dt, '+')) {
                    $dt=str_replace(' ', '+', $dt);
                }
                $result=DateTime::createFromFormat(DateTime::ISO8601, $dt);
            }
            if($result!==FALSE) {
                $result=$result->getTimestamp();
            }
            /*
            $offset=$_COOKIE['ICP_GTM'];
            $dt->getTimestamp();
            $now=new DateTime($dt, new DateTimeZone('GMT'));
            $now->add(DateInterval::createFromDateString($offset.' minutes'));*/
        }
        return $result;
    }
    public function getIpAddressFirstSeen(ICP_Countdown $v) {
        global $icp;
        $ipAddress=$icp->Utils->getVisitorIpAddress();
        if($ipAddress=='') {
            $ipAddress=$icp->Utils->getClientIpAddress();
        }
        if($ipAddress=='') {
            return FALSE;
        }

        $result=$icp->Options->getIpAddressFirstSeen($v->id, $ipAddress);
        if($result===FALSE) {
            $result=time();
            $icp->Options->setIpAddressFirstSeen($v->id, $ipAddress, $result);
        }
        return $result;
    }
}