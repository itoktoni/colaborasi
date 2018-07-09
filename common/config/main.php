<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@frontend' => 'd:/xampp/htdocs/teamnew/frontend/',
        '@backend' => 'd:/xampp/htdocs/teamnew/backend/'
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        
//        'request' => [
//            'cookieValidationKey' => 'test'
//        ]
    ],
];
