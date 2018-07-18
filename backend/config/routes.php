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
        '/dashboard' => 'dashboard/index',
        '/logout' => 'site/logout',
        // '/' => 'home/homepage',
        // 'view/<id:[0-9a-zA-Z\-]+>' => 'home/detail',
        // 'cat/<id:[0-9a-zA-Z\-]+>' => 'home/category',
        // 'subcategory/<id:[0-9a-zA-Z\-]+>' => 'home/subcategory',
        // 'add/<id:\d+>' => 'home/add',
        'product/subcategory/<id:\d+>' => 'product/subcategory',
        'product/content-delete/<id:\d+>' => 'product/contentdelete',
        // '/cart' => 'home/cart',
        // '/allproduct' => 'home/product',
    ],
];
