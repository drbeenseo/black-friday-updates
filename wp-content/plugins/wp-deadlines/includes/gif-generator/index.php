<?php

require __DIR__ . "/vendor/autoload.php";

$countdown = new \Countdown\Countdown(
    'gif file name',
    '2017-07-22 12:47:00',
    "333333",
    [
        'size' => 80,
        'font-color' => [
            'red' => 111,
            'green' => 255,
            'blue' => 167
        ],
        'file'=> 'Xerox Serif Narrow Bold.ttf' // this font stored in the storage/fonts directory
        // don't forget to store all required fonts file in the storage/fonts directory
    ],
    'asia/dhaka',
    false // if you will need evergreen countdown, changed it to true. Default value is false
);

$countdown->output();
