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
        '/facebook' => 'site/facebook',
        '/register' => 'site/signup',
        // '/' => 'home/homepage',
        // 'view/<id:[0-9a-zA-Z\-]+>' => 'home/detail',
        // 'cat/<id:[0-9a-zA-Z\-]+>' => 'home/category',
        // 'subcategory/<id:[0-9a-zA-Z\-]+>' => 'home/subcategory',
        // 'add/<id:\d+>' => 'home/add',
        // '/cart' => 'home/cart',
    ],
];
