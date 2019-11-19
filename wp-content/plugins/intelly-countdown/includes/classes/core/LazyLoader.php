<?php

class ICP_LazyLoader {
    //Facebook
    public function Facebook_getAdAccounts($accountId=0) {
        global $icp;
        $result=$this->Facebook_getName();
        if($result!==FALSE) {
            return $result;
        }

        if($accountId===0 || (is_array($accountId) && count($accountId)==0)) {
            $accountId=$icp->Utils->qs('parentId', '');
        }

        $result=array();
        $profile=$icp->Options->getFacebookProfiles($accountId);
        if($profile!==FALSE && isset($profile['adAccounts'])) {
            $accounts=$profile['adAccounts'];
            foreach($accounts as $k=>$v) {
                if(!is_array($v) || !isset($v['name'])) {
                    $v=$k;
                } else {
                    $v=$v['name'].' ('.$k.')';
                }
                $result[]=array('id'=>$k, 'text'=>$v);
            }
        }
        return $result;
    }

    public function execute($action) {
        global $icp;
        $result=array();
        $function=array($this, $action);
        if($icp->Utils->functionExists($function)) {
            $result=$icp->Utils->functionCall($function);
        } else {
            $result['error']='NO FUNCTION '.$action.' DEFINED';
        }
        return $result;
    }
    public function executeJson($action) {
        $json=$this->execute($action);
        echo json_encode($json);
        return (count($json)>0 && !isset($json['error']));
    }

    private function getArgs($parents, $size) {
        global $icp;
        if($parents===0 || $parents=='' || (is_array($parents) && count($parents)==0)) {
            $parents=$icp->Utils->qs('parentId', 0);
        }

        $result=FALSE;
        $parents=$icp->Utils->toArray($parents);
        if(count($parents)==$size) {
            $result=$parents;
        }
        return $result;
    }
}