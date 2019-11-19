<?php
if (!defined('ABSPATH')) exit;

class ICP_CountdownUi {
    var $classCountdown='';
    var $classDigit='';
    var $classLabel='';
    var $classBoxDigit='';
    var $classBoxSeparator='';

    var $firstSeenValues=array();

    public function __construct() {
    }
    private function drawDigit(ICP_Countdown $countdown, $labels) { ?>
        <div class="<?php echo $this->classBoxDigit ?>">
            <div class="<?php echo $this->classDigit ?>" style="font-size: <?php echo $countdown->digitsFontSize?>px;">0</div>
            <div class="<?php echo $this->classLabel ?>" style="font-size: <?php echo $countdown->labelsFontSize?>px;" icp-labels="<?php echo $labels?>">LBL</div>
        </div>
    <?php }
    private function drawSeparator(ICP_Countdown $countdown) { ?>
        <div class="<?php echo $this->classBoxSeparator ?>">
            <div class="<?php echo $this->classDigit ?>" style="font-size: <?php echo $countdown->digitsFontSize?>px;">:</div>
            <div></div>
        </div>
    <?php }
    private function generateClasses() {
        if($this->classCountdown!='') {
            return;
        }

        $this->classCountdown='icp-countdown';
        $this->classDigit='icp-digit';
        $this->classLabel='icp-label';
        $this->classBoxDigit='icp-box-digit';
        $this->classBoxSeparator='icp-box-separator';

        $this->classCountdown=$this->generateMd5($this->classCountdown);
        $this->classDigit=$this->generateMd5($this->classDigit);
        $this->classLabel=$this->generateMd5($this->classLabel);
        $this->classBoxDigit=$this->generateMd5($this->classBoxDigit);
        $this->classBoxSeparator=$this->generateMd5($this->classBoxSeparator);
    }
    private function generateMd5($name) {
        $prefix='a';
        $name.='-t'.time();
        $result=$prefix.md5($name);
        return $result;
    }
    public function draw($countdown) {
        global $icp;
        if($countdown===FALSE) {
            return;
        }

        /* @var $countdown ICP_Countdown */
        $expireIn='';
        switch ($countdown->type) {
            case ICP_CountdownConstants::TYPE_DATE:
                $expireIn=$countdown->expireDateIn;
                break;
        }

        $restart=0;
        $expiration=$icp->Utils->parseDateToTime($countdown->expirationDate);
        if($countdown->evergreen) {
            $detect=$icp->Manager->getDetectStrategy($countdown->detect);
            $firstSeen=$detect->getFirstSeen($countdown);
            if($firstSeen!==FALSE) {
                $expire=$icp->Utils->parseTimer($expireIn);
                $reset=0;
                if($reset>0 && $expire>0) {
                    $now=time();
                    $target=$firstSeen+$expire+$reset;
                    if($now>$target) {
                        $restart=1;
                    }
                }
            }
            if($restart==0 && $firstSeen!==FALSE) {
                $this->firstSeenValues[$countdown->id]=$firstSeen;
            }
        }

        $this->generateClasses();
        echo '<div class="'.$this->classCountdown.'" style="display:none; color:'.$countdown->color.';" icp-expire="'.$expireIn.'" icp-type="'.$countdown->type.'" icp-redirect="'.$countdown->redirectUri.'" icp-id="'.$countdown->id.'" icp-restart="'.$restart.'"  icp-eg="'.($icp->Utils->isTrue($countdown->evergreen) ? 1 : 0).'" icp-expiration="'.$expiration.'">';
        switch ($countdown->type) {
            case ICP_CountdownConstants::TYPE_DATE:
                $this->drawDigit($countdown, $countdown->labelsDays);
                $this->drawSeparator($countdown);
                $this->drawDigit($countdown, $countdown->labelsHours);
                $this->drawSeparator($countdown);
                $this->drawDigit($countdown, $countdown->labelsMinutes);
                $this->drawSeparator($countdown);
                $this->drawDigit($countdown, $countdown->labelsSeconds);
                break;
        }
        echo '</div>';
    }
    public function script() {
        global $icp;
        ?>
        <script>
            var dt=0;
            <?php
            foreach($this->firstSeenValues as $id=>$time) {
                if($time===FALSE) {
                    continue;
                }
                ?>
                dt=moment.unix(<?php echo $time?>).toDate();
                ICP.setDateCookie('<?php echo $id?>_FirstSeen', dt);
            <?php } ?>

            var ICP_FIRST_SEEN={};
            var ecTimer=null;
            function enCountdownSetLabel($text, $labels, index, value, label) {
                $text=jQuery($text);
                if($text.text()!=value) {
                    $text.text(value);
                }

                if($labels.length>index) {
                    var $self=jQuery($labels[index]);
                    var labels=ICP.attr($self, 'icp-labels', label);
                    labels=labels.split(',');
                    if(labels.length==1) {
                        labels.push(labels[0]);
                    }
                    value=parseInt(value);
                    label=(value===1 ? labels[1] : labels[0]);
                    if($self.text()!=label) {
                        $self.text(label);
                    }
                }
            }
            function ecCountdownsLoop() {
                jQuery('.<?php echo $this->classCountdown ?>').each(function(i,v) {
                    var $self=jQuery(this);
                    var classLabel='<?php echo $this->classLabel?>';
                    var classDigit='<?php echo $this->classDigit?>';
                    var classBoxSeparator='<?php echo $this->classBoxSeparator?>';

                    var id=ICP.attr($self, 'icp-id');
                    var redirectUri=ICP.attr($self, 'icp-redirect');
                    var type=ICP.attr($self, 'icp-type');
                    var expire=ICP.attr($self, 'icp-expire');
                    var restart=parseInt(ICP.attr($self, 'icp-restart'));

                    var eg=parseInt(ICP.attr($self, 'icp-eg'));
                    var expiration=parseInt(ICP.attr($self, 'icp-expiration'));
                    expiration=moment.unix(expiration).toDate();

                    var now=new Date();
                    var time=0;
                    var firstSeen=0;

                    if(eg==0) {
                        time=parseInt((expiration.getTime()-now.getTime())/1000);
                    } else {
                        firstSeen=ICP_FIRST_SEEN[id];
                        if(firstSeen==null || firstSeen===undefined) {
                            firstSeen=ICP.getDateCookie(id+'_FirstSeen');
                            //console.log('firstSeen=%s', firstSeen);
                            if(firstSeen==null || restart!=0) {
                                firstSeen=new Date();
                                ICP.setDateCookie(id+'_FirstSeen', firstSeen);
                            }
                        }
                        ICP_FIRST_SEEN[id]=firstSeen;

                        time=ICP.parseTimer(expire);
                        time-=parseInt((now.getTime()-firstSeen.getTime())/1000);
                    }

                    if(time<=0) {
                        time=0;
                        if(ecTimer) {
                            clearTimeout(ecTimer);
                        }
                        if(redirectUri!='') {
                            //console.log('REDIRECTING %s..', redirectUri);
                            location.href=redirectUri;
                        }
                    }

                    var $digits=$self.find('.'+classDigit);
                    var $labels=$self.find('.'+classLabel);
                    var $separators=$self.find('.'+classBoxSeparator);

                    var dt1=0;
                    var dt2=0;
                    switch (type) {
                        case 'DATE':
                            time=ICP.formatTimer(time);
                            time=time.split(':');
                            var days=time[0];
                            var hours=time[1];
                            var minutes=time[2];
                            var seconds=time[3];
                            if(parseInt(days)<=0) {
                                jQuery($digits[0]).hide();
                                jQuery($labels[0]).hide();
                                jQuery($separators[0]).hide();
                            }
                            enCountdownSetLabel($digits[0], $labels, 0, days, 'Days');
                            enCountdownSetLabel($digits[2], $labels, 1, hours, 'Hours');
                            enCountdownSetLabel($digits[4], $labels, 2, minutes, 'Minutes');
                            enCountdownSetLabel($digits[6], $labels, 3, seconds, 'Seconds');
                            break;
                    }
                    $self.show();
                });
            }

            ecTimer=setInterval(function() {
                ecCountdownsLoop();
            }, 1000);
            ecCountdownsLoop();
        </script>
    <?php }
    public function style() { ?>
        <style>
            .<?php echo $this->classCountdown?> {
                display: table;
                margin: 0px;
                padding: 0px;
                width: 50%;
                margin: auto;
            }
            .<?php echo $this->classCountdown?> .<?php echo $this->classDigit?> {
                text-align: center;
                margin: 0px;
                padding: 0px;
                line-height: normal;
            }
            .<?php echo $this->classCountdown?> .<?php echo $this->classLabel?> {
                text-align: center;
                margin: 0px;
                padding: 0px;
                line-height: normal;
            }
            .<?php echo $this->classCountdown?> .<?php echo $this->classBoxDigit?> {
                display: table-cell;
                margin: 0px;
                padding: 0px;
            }
            .<?php echo $this->classCountdown?> .<?php echo $this->classBoxSeparator?> {
                display: table-cell;
                margin: 0px;
                padding: 0px;
                padding-left: 5px;
                padding-right: 5px;
            }
        </style>
    <?php }
}