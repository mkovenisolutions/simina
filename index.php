<?php

use Simina\App;

require_once __DIR__ .'/vendor/autoload.php';

$app = new App([
    'paths' => [
        'basePath' => __DIR__ ,
        'configPath' => 'config'
    ]
]);
