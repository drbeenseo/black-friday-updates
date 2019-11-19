<?php
if (!defined('ABSPATH')) exit;

class ICP_Ui {
    var $Countdown;

    public function __construct() {
        $this->Countdown=new ICP_CountdownUi();
    }
    function getFieldOptions($class, $name, &$options) {
        global $icp;
        $readonly=FALSE;
        $required=FALSE;

        $i=0;
        $chars=str_split($name);
        foreach($chars as $c) {
            $exit=TRUE;
            switch ($c) {
                case '@':
                    $options['check']=TRUE;
                    $exit=FALSE;
                    break;
                case '!':
                    $options['hidden']=TRUE;
                    $exit=FALSE;
                    break;
                case '*':
                    $required=TRUE;
                    $exit=FALSE;
                    break;
                case '^':
                    $readonly=TRUE;
                    $exit=FALSE;
                    break;
                case '#':
                    $options['ui-link']=ICP_TAB_EDITOR_URI.'&id=';
                    $exit=FALSE;
                    break;
                case '_':
                    $options['ui-target']='_blank';
                    $exit=FALSE;
                    break;
                case '?':
                    $options['row-hidden']=TRUE;
                    $exit=FALSE;
                    break;
            }

            if($exit) {
                break;
            }
            ++$i;
        }
        if($i>0) {
            $name=substr($name, $i);
        }

        if($icp->Form->readonly) {
            $readonly=TRUE;
        }

        $column=array();
        if(is_object($class)) {
            $column=$icp->Dao->Utils->getColumn($class, $name);
        }
        if(!$readonly) {
            $readonly=$icp->Utils->get($column, 'ui-readonly', FALSE);
            $readonly=$icp->Utils->isTrue($readonly);
        }
        if(!$required) {
            $required=$icp->Utils->get($column, 'ui-required', FALSE);
            $required=$icp->Utils->isTrue($required);
        }
        $visible=$icp->Utils->get($column, 'ui-visible', '');
        if($visible!='') {
            $options['ui-visible']=$visible;
        }

        if($readonly) {
            $options['readonly']='readonly';
        }
        if($required) {
            $options['ui-required']='required';
        }
        //$column=$ec->Dao->Utils->getColumn($class, $name);
        if(isset($column['alias'])) {
            $name=$column['alias'];
        }
        return $name;
    }

    function validateDomain($instance, $fields, $all=FALSE) {
        global $icp;
        $fields=$icp->Utils->toArray($fields);
        if(is_null($fields) || $fields===FALSE) {
            return TRUE;
        }

        $result=TRUE;
        foreach($fields as $f) {
            if(trim($f)=='') {
                continue;
            }

            $options=array();
            $k=$icp->Ui->getFieldOptions($instance, $f, $options);
            if(isset($options['readonly']) && $options['readonly']) {
                continue;
            }

            $p1='';
            $p2='';
            $p3='';

            $v=$icp->Utils->get($instance, $k);
            $column=$icp->Dao->Utils->getColumn($instance, $k);
            if(!$icp->Dao->Utils->isColumnVisible($instance, $k)) {
                continue;
            }

            if(!isset($options['lb-required']) && !$all) {
                //in ogni caso i campi vengono validati il che significa che p.e. i campi
                //che non trasferiscono il valore vengono cmq modificati (altrimenti succede
                //p.e. che si ha una combo che non viene selezionata e quindi non verrebbe
                //più aggiornata mantenendo sempre il veccho valore
                if(is_null($v)) {
                    if($icp->Dao->Utils->isColumnNumeric($instance, $k)) {
                        if($column['ui-type']=='toggle' || $column['ui-type']=='tick') {
                            $v=0;
                        }
                    } elseif($icp->Dao->Utils->isColumnDate($instance, $k)) {
                        $v=0;
                    } elseif($icp->Dao->Utils->isColumnArray($instance, $k)) {
                        $v=array();
                    }
                }
                $icp->Utils->set($instance, $k, $v);
            } elseif(isset($options['lb-required']) || $all) {
                $message='Error.Store['.get_class($instance).'].'.$k;
                $message=str_replace(ICP_PLUGIN_PREFIX, '', $message);
                $e=FALSE;
                if($v!==0 && is_null($v)) {
                    $e=TRUE;
                } else {
                    if($icp->Dao->Utils->isColumnDate($instance, $k)) {
                        if($v==0) {
                            $e=TRUE;
                        }
                    } elseif($icp->Dao->Utils->isColumnNumeric($instance, $k)) {
                        if(is_null($v) && $column['ui-type']=='toggle') {
                            $v=0;
                        }

                        if($v==='' || $v===FALSE) {
                            //if is a foreign key must be >0
                            $e=TRUE;
                        } else {
                            $min=$icp->Utils->get($column, 'ui-min', FALSE);
                            $max=$icp->Utils->get($column, 'ui-max', FALSE);

                            if(!$e && $min!='') {
                                $min=doubleval($min);
                                if($v<$min) {
                                    $message.='.Min';
                                    $e=TRUE;
                                }
                            }
                            if(!$e && $max!='') {
                                $max=doubleval($max);
                                if($v>$max) {
                                    $message.='.Max';
                                    $e=TRUE;
                                }
                            }
                        }
                    } elseif($icp->Dao->Utils->isColumnArray($instance, $k)) {
                        //nocheck
                        if(is_array($v) && count($v)==0) {
                            $e=TRUE;
                        }
                    } else {
                        if(is_array($v) && count($v)==0) {
                            $e=TRUE;
                        } elseif(trim($v)==='') {
                            $e=TRUE;
                        } else {
                            $len=strlen(trim($v));
                            if(isset($column['ui-len']) && intval($column['ui-len'])>0) {
                                $compare=intval($column['ui-len']);
                                if($len!=$compare) {
                                    $message.='.Len';
                                    $p1=$compare;
                                    $p2=$len;
                                    $e=TRUE;
                                }
                            }

                            if(!$e) {
                                $min=$icp->Utils->iget($column, 'ui-min', -1);
                                $max=$icp->Utils->iget($column, 'ui-max', -1);

                                if($min>-1 && $len<$min) {
                                    $message.='.Min';
                                    $p1=$min;
                                    $p2=$len;
                                    $e=TRUE;
                                } elseif($max>-1 && $len>$max) {
                                    $message.='.Max';
                                    $p1=$max;
                                    $p2=$len;
                                    $e=TRUE;
                                }
                            }
                        }
                    }
                }

                if($e) {
                    $icp->Options->pushErrorMessage($message, $p1, $p2, $p3);
                    $result=FALSE;
                }
            }
        }
        return $result;
    }

    public function getText($text, $args, $options=array()) {
        global $icp;

        $defaults=array('striptags'=>FALSE);
        $options=$icp->Utils->parseArgs($options, $defaults);
        if($args!==FALSE && count($args)>0) {
            $patterns = array();
            $starts = strpos($text, "{");
            while ($starts !== FALSE) {
                $ends = strpos($text, "}", $starts + 1);
                if ($ends !== FALSE) {
                    $patterns[] = $icp->Utils->substr($text, $starts + 1, $ends);
                }
                $starts = strpos($text, "{", $ends + 1);
            }
            foreach ($patterns as $k) {
                $v = '#' . $k . '??#';
                if (strpos($k, '.') !== FALSE) {
                    $k = explode('.', $k);
                    $instance = FALSE;
                    if (isset($args[$k[0]])) {
                        $instance = $args[$k[0]];
                    } elseif (isset($args[$k[0] . '.'])) {
                        $instance = $args[$k[0] . '.'];
                    }
                    if (is_object($instance)) {
                        $property = $k[1];
                        $v = $this->FF->inputGet($instance, $property, FALSE, FALSE);
                    }
                    $k = implode('.', $k);
                } elseif (isset($args[$k])) {
                    $v = $args[$k];
                }
                $text = str_replace("{" . $k . "}", $v, $text);
            }
        }
        if($options['striptags']) {
            $text=strip_tags($text);
        }
        return $text;
    }

    //some alerts
    public function alertSuccessError($success, $message, $v1=NULL, $v2=NULL, $v3=NULL, $v4=NULL, $v5=NULL) {
        global $icp;
        if($icp->Utils->isTrue($success)) {
            $this->alertSuccess($message, $v1, $v2, $v3, $v4, $v5);
        } else {
            $this->alertError($message, $v1, $v2, $v3, $v4, $v5);
        }
    }
    public function alertSuccess($message, $v1=NULL, $v2=NULL, $v3=NULL, $v4=NULL, $v5=NULL) {
        $this->alert('success', $message, $v1, $v2, $v3, $v4, $v5);
    }
    public function alertInfo($message, $v1=NULL, $v2=NULL, $v3=NULL, $v4=NULL, $v5=NULL) {
        $this->alert('info', $message, $v1, $v2, $v3, $v4, $v5);
    }
    public function alertWarning($message, $v1=NULL, $v2=NULL, $v3=NULL, $v4=NULL, $v5=NULL) {
        $this->alert('warning', $message, $v1, $v2, $v3, $v4, $v5);
    }
    public function alertError($message, $v1=NULL, $v2=NULL, $v3=NULL, $v4=NULL, $v5=NULL) {
        $this->alert('error', $message, $v1, $v2, $v3, $v4, $v5);
    }
    public function alert($type, $message, $v1=NULL, $v2=NULL, $v3=NULL, $v4=NULL, $v5=NULL) {
        global $icp;
        $color='';
        $icon='';
        if($icp->Lang->H($message)) {
            $message=$icp->Lang->L($message, $v1, $v2, $v3, $v4, $v5);
        }
        switch (strtolower($type)) {
            case 'success':
                $color='success';
                $icon='check';
                break;
            case 'info':
                $color='primary';
                $icon='info';
                break;
            case 'warning';
                $color='warning';
                $icon='warning';
                break;
            case 'error':
                $color='danger';
                $icon='remove';
                break;
        }
        ?>
        <div class="bs-component mw1000 left-block mb10">
            <div class="alert alert-<?php echo $color?> alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="fa fa-<?php echo $icon?> pr10"></i>
                <?php echo $message?>
                <div style="clear:both"></div>
            </div>
        </div>
    <?php }
    public function redirectEdit($id=FALSE) {
        global $icp;
        $uri=ICP_TAB_EDITOR_URI;
        if($id!==FALSE) {
            $uri.='&id='.$id;
        }
        $icp->Utils->redirect($uri);
    }
    public function redirectManager($id=FALSE) {
        global $icp;
        $uri=ICP_TAB_MANAGER_URI;
        if($id!==FALSE) {
            $uri.='&id='.$id;
        }
        $icp->Utils->redirect($uri);
    }
}