<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@frontend' => 'c:/xampp/htdocs/team/frontend/',
        '@backend' => 'c:/xampp/htdocs/team/backend/'
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
