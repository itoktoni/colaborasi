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
        '/password' => 'site/password',
        '/github' => 'site/github',
        '/facebook' => 'site/facebook',
        '/twitter' => 'site/twitter',
        '/google' => 'site/google',
        '/register' => 'site/signup',
        'category/<cats:(.*)>/<subcategory:(.*)>'   => 'category/index/',
        'category/<cats:(.*)>'                      => 'category/index/',
        'product/<slug:(.*)>'                       => 'product/index/',
        // '/' => 'home/homepage',
        // 'view/<id:[0-9a-zA-Z\-]+>' => 'home/detail',
        // 'cat/<id:[0-9a-zA-Z\-]+>' => 'home/category',
        // 'subcategory/<id:[0-9a-zA-Z\-]+>' => 'home/subcategory',
        // 'add/<id:\d+>' => 'home/add',
        // '/cart' => 'home/cart',
    ],
];
