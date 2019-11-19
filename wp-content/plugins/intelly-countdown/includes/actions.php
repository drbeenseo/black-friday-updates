<?php
if (!defined('ABSPATH')) exit;

//add_action('init', 'icp_do_action');
add_action('wp_ajax_do_action', 'icp_do_action');
function icp_do_action() {
    global $icp;

	if ($icp->Utils->qs('icp_action')) {
        $args=array_merge($_GET, $_POST, $_COOKIE, $_SERVER);
        $name='icp_'.$icp->Utils->qs('icp_action');
        if(has_action($name)) {
            $icp->Log->debug('EXECUTING ACTION=%s', $name);
            do_action($name, $args);
        } elseif(function_exists($name)) {
            $icp->Log->debug('EXECUTING FUNCTION=%s DATA=%s', $name, $args);
            call_user_func($name, $args);
        } elseif(strpos($icp->Utils->qs('icp_action'), '_')!==FALSE) {
            $pos=strpos($icp->Utils->qs('icp_action'), '_');
            $what=substr($icp->Utils->qs('icp_action'), 0, $pos);
            $function=substr($icp->Utils->qs('icp_action'), $pos+1);

            $class=NULL;
            switch (strtolower($what)) {
                case 'cron':
                    $class=$icp->Cron;
                    break;
                case 'tracking':
                    $class=$icp->Tracking;
                    break;
                case 'properties':
                    $class=$icp->Options;
                    break;
            }

            if(!$class) {
                $icp->Log->fatal('NO CLASS FOR=%s IN ACTION=%s', $what, $icp->Utils->qs('icp_action'));
            } elseif(!method_exists ($class, $function)) {
                $icp->Log->fatal('NO METHOD FOR=%s IN CLASS=%s IN ACTION=%s', $function, $what, $icp->Utils->qs('icp_action'));
            } else {
                $icp->Log->debug('METHOD=%s OF CLASS=%s', $function, $what);
                call_user_func(array($class, $function), $args);
            }
        } else {
            $icp->Log->fatal('NO FUNCTION FOR==%s', $icp->Utils->qs('icp_action'));
        }
	}
}
add_action('wp_ajax_icp_ajax_ll', 'icp_ajax_ll');
function icp_ajax_ll() {
    global $icp;
    $action=$icp->Utils->qs('icp_action');
    $icp->Lazy->executeJson($action);
    wp_die();
}