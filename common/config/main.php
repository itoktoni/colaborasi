<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@frontend' => str_replace('common/config','frontend',str_replace('\\','/',__DIR__)), 
        '@backend' => str_replace('common/config','backend',str_replace('\\','/',__DIR__)),
        '@uploadpath' => str_replace('common/config','uploads',str_replace('\\','/',__DIR__)),
        '@productpath' => str_replace('common/config','product',str_replace('\\','/',__DIR__))
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
