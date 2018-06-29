<?php

/* ================== ROUTE ========================
 * ini adalah routing yang dipisah dari configuration
 * jadi untuk menggunakannya tinggal di require one
 */

return [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => false,
    'showScriptName' => false,
    'rules' => [
        '/adminlogin' => 'site/login',
        // '/' => 'home/homepage',
        // 'view/<id:[0-9a-zA-Z\-]+>' => 'home/detail',
        // 'cat/<id:[0-9a-zA-Z\-]+>' => 'home/category',
        // 'subcategory/<id:[0-9a-zA-Z\-]+>' => 'home/subcategory',
        // 'add/<id:\d+>' => 'home/add',
        // '/cart' => 'home/cart',
        // '/allproduct' => 'home/product',
        // '/checkout' => 'home/checkout',
        // '/ongkir/province' => 'ongkir/province',
        // '/ongkir/city' => 'ongkir/city',
        // '/ongkir/sub' => 'ongkir/sub',
        // '/ongkir/cost' => 'ongkir/cost',
        // 'login' => 'global/login',
        // 'logout' => 'global/logout',
        // 'about' => 'home/about',
        // 'contact' => 'home/contact',
        // 'error' => 'global/error',
        // 'test' => 'home/test',
    ],
];
