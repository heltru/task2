<?php


function ex($arr, $die = true) {
    /* if (! YII_ENV_DEV ){
         return '';
     }*/
    /* if ( $_SERVER['HTTP_HOST'] != 'seokeys.it-06.aim' ){
         return ;
     }*/
    echo "<pre>";
    var_dump($arr);
    echo "</pre>";
    $t = debug_backtrace();
    echo "<br>".$t[0]['file']." Line:".$t[0]['line']."<br>";
    if($die !== false) {
        die('die by parameter');
    }
}


// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
