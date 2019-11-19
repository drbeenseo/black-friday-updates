<?php

namespace Countdown;

use DateTime;
use Intervention\Image\ImageManagerStatic as InterventionImage;

class Countdown
{
    /**
     * GIF file name.
     *
     * @var string
     */
    protected $gifFileName;

    /**
     * Countdown ending time.
     *
     * @var string
     */
    protected $time;

    /**
     * Countdown font property.
     *
     * @var array
     */
    protected $font;

    /**
     * Background image.
     *
     * @var string
     */
    protected $image;

    /**
     * Determine evergreen countdown is required or isn't required.
     *
     * @var bool
     */
    protected $evergreenCountdown;

    /**
     * Create a new instance of countdown.
     *
     * @param string $gifFileName
     * @param string $time
     * @param string $background
     * @param array $font
     * @param string $timezone
     * @param bool $evergreenCountdown
     */
    public function __construct($gifFileName, $time, $background = "333333", $font = [], $timezone = 'asia/dhaka', $evergreenCountdown = false)
    {
        $this->gifFileName = $gifFileName;

        putenv('GDFONTPATH=' .  $this->fontsPath());

        date_default_timezone_set($timezone);

        $this->time = $time;

        $this->font = array_merge([
            'size'=> 40,
            'angle'=> 0,
            'x-offset'=> 30,
            'y-offset'=> 70,
            'file'=> 'Xerox-Serif-Narrow-Bold.ttf',
        ], $font);

        $fontColor = array_merge([
            'red' => 255,
            'green' => 255,
            'blue' => 255
        ], isset($font['font-color']) ? $font['font-color'] : []);

        $this->image = $this->getBackgroundImage($background);

        $this->font = array_merge(
            $this->font,
            [
                'x-offset' => $this->font['size'] * 0.5,
                'y-offset' => $this->font['size'] * 1.5,
                'color'=> imagecolorallocate(
                    imagecreatefrompng($this->image),
                    $fontColor['red'], $fontColor['green'], $fontColor['blue']
                ),
            ]
        );

        $this->evergreenCountdown = $evergreenCountdown;
    }

    public function generate() {
        $future_date = new DateTime(
            date('r', strtotime($this->time))
        );

        $time_now = time();

        if($this->evergreenCountdown) {
            $now = $this->evergreenCountdown($time_now);
        } else {
            $now = new DateTime(date('r', $time_now));
        }

        $frames = array();
        $delays = array();

        $delay = 100; // milliseconds

        for($i = 0; $i <= 60; $i++){

            $interval = date_diff($future_date, $now);

            if($future_date < $now){

                // Open the first source image and add the text.
                $image = imagecreatefrompng($this->image);

                $text = $interval->format('00 : 00 : 00 : 00');

                $days = "\nDays";
                $hours = "\nHours";
                $minutes = "\nMinutes";
                $seconds = "\nSeconds";

                // %a is weird in that it doesn’t give you a two digit number
                // check if it starts with a single digit 0-9
                // and prepend a 0 if it does
                if(preg_match('/^[0-9]\ :/', $text)){
                    $text = '0'.$text;
                }

                imagettftext ($image , $this->font['size'] , $this->font['angle'] , $this->font['x-offset'] , $this->font['y-offset'] , $this->font['color'] , $this->font['file'], $text );
                imagettftext ($image , $this->font['size'] / 3 , $this->font['angle'] , $this->font['x-offset'] + ($this->font['size']/4) , $this->font['y-offset'] , $this->font['color'] , $this->font['file'], $days );
                imagettftext ($image , $this->font['size'] / 3 , $this->font['angle'] , $this->font['size'] * 2.9 , $this->font['y-offset'] , $this->font['color'] , $this->font['file'], $hours );
                imagettftext ($image , $this->font['size'] / 3 , $this->font['angle'] , $this->font['size'] * 4.9 , $this->font['y-offset'] , $this->font['color'] , $this->font['file'], $minutes );
                imagettftext ($image , $this->font['size'] / 3 , $this->font['angle'] , $this->font['size'] * 7.1 , $this->font['y-offset'] , $this->font['color'] , $this->font['file'], $seconds );
                imagettftext ($image , $this->font['size'] / 5 , $this->font['angle'] , $this->font['size'] * 3 , $this->font['y-offset'] * 1.8 , $this->font['color'] , $this->font['file'], 'powered by themesgrove' );

                ob_start();

                imagegif($image);

                $frames[]=ob_get_contents();

                $delays[]=$delay;

                $loops = 1;

                ob_end_clean();
                break;
            } else {

                // Open the first source image and add the text.
                $image = imagecreatefrompng($this->image);

                $text = $interval->format('%a : %H : %I : %S');

                $days = "\nDays";
                $hours = "\nHours";
                $minutes = "\nMinutes";
                $seconds = "\nSeconds";

                // %a is weird in that it doesn’t give you a two digit number
                // check if it starts with a single digit 0-9
                // and prepend a 0 if it does
                if(preg_match('/^[0-9]\ :/', $text)){
                    $text = '0'.$text;
                }

                imagettftext ($image , $this->font['size'] , $this->font['angle'] , $this->font['x-offset'] , $this->font['y-offset'] , $this->font['color'] , $this->font['file'], $text );
                imagettftext ($image , $this->font['size'] / 3 , $this->font['angle'] , $this->font['x-offset'] + ($this->font['size']/4) , $this->font['y-offset'] , $this->font['color'] , $this->font['file'], $days );
                imagettftext ($image , $this->font['size'] / 3 , $this->font['angle'] , $this->font['size'] * 2.9 , $this->font['y-offset'] , $this->font['color'] , $this->font['file'], $hours );
                imagettftext ($image , $this->font['size'] / 3 , $this->font['angle'] , $this->font['size'] * 4.9 , $this->font['y-offset'] , $this->font['color'] , $this->font['file'], $minutes );
                imagettftext ($image , $this->font['size'] / 3 , $this->font['angle'] , $this->font['size'] * 7.1 , $this->font['y-offset'] , $this->font['color'] , $this->font['file'], $seconds );
                imagettftext ($image , $this->font['size'] / 5 , $this->font['angle'] , $this->font['size'] * 3 , $this->font['y-offset'] * 1.8 , $this->font['color'] , $this->font['file'], 'powered by themesgrove' );

                ob_start();

                imagegif($image);

                $frames[]=ob_get_contents();
                $delays[]=$delay;
                $loops = 0;
                ob_end_clean();
            }

            $now->modify('+1 second');
        }

        //expire this image instantly
        header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
        header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
        header( 'Cache-Control: no-store, no-cache, must-revalidate' );
        header( 'Cache-Control: post-check=0, pre-check=0', false );
        header( 'Pragma: no-cache' );
        header( 'Memory: ' . (memory_get_usage()/1048576) . " MB ");
        return new AnimatedGif($frames,$delays,$loops);
    }

    /**
     * Output countdown GIF.
     */
    public function output()
    {
        $gif = $this->generate();

        return $gif->display($this->gifFileName);
    }

    public function getGif()
    {
        $gif = $this->generate();
        echo $gif->createGif();
    }

    /**
     * Get storage path.
     *
     * @return string
     */
    protected function storagePath()
    {
        return realpath(__DIR__ . '/../storage');
    }

    /**
     * Get fonts path.
     *
     * @return string
     */
    protected function fontsPath()
    {
        return realpath(__DIR__ . '/../storage/fonts');
    }

    /**
     * Get backgrounds path.
     *
     * @return string
     */
    protected function backgroundsPath()
    {
        return realpath(__DIR__ . '/../storage/backgrounds');
    }

    /**
     * Get background image path.
     *
     * @param string $background
     * @return string
     */
    protected function getBackgroundImage($background = "#333333")
    {
        $size = $this->font['size'] * 9;

        if (!file_exists($this->backgroundsPath() . "/{$background}-{$size}.png")) {
            file_put_contents(
                $this->backgroundsPath() . "/{$background}-{$size}.png",
                InterventionImage::canvas($size , $this->font['size'] * 3 , "{$background}")->encode('png')
            );
        }

        return $this->backgroundsPath() . "/{$background}-{$size}.png";
    }

    /**
     * Set cookie for evergreen countdown.
     *
     * @param $time_now
     * @return DateTime
     */
    protected function evergreenCountdown($time_now)
    {
        if (isset($_COOKIE["countdown"])) {

            $countdown = json_decode($_COOKIE["countdown"]);

            if (time() > $countdown->time + $countdown->interval) {
                setcookie("countdown",
                    json_encode([
                        "time" => $countdown->time + $countdown->interval,
                        "interval" => 60
                    ]),
                    time() + 99999, // 99999sec
                    "/"
                );

                $now = new DateTime(date('r', $countdown->time + $countdown->interval));
                return $now;
            } else {
                $now = new DateTime(date('r', $countdown->time));
                return $now;
            }
        } else {

            setcookie("countdown",
                json_encode([
                    "time" => $time_now,
                    "interval" => 60
                ]),
                time() + 99999, // 99999sec
                "/"
            );

            $now = new DateTime(date('r', $time_now));
            return $now;
        }
    }
}


