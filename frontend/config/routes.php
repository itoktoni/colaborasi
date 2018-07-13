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
        '/password'                                 => 'site/password',
        '/github'                                   => 'site/github',
        '/facebook'                                 => 'site/facebook',
        '/twitter'                                  => 'site/twitter',
        '/google'                                   => 'site/google',
        '/register'                                 => 'site/signup',
        'category/<cats:(.*)>/<subcategory:(.*)>'   => 'category/index/',
        'category/<cats:(.*)>'                      => 'category/index/',
        'product/<slug:(.*)>'                       => 'product/index/',
        'cart/voucher'                              => 'cart/voucher',
        'cart/destroy'                              => 'cart/destroy',
        'cart/delete/<item:(.*)>'                   => 'cart/delete',
        'cart/update/<item:(.*)>/<qty:(.*)>'        => 'cart/update',
        'cart/add/<item:(.*)>/<qty:(.*)>'           => 'cart/add',
        'cart/add/<item:(.*)>'                      => 'cart/add',
        'cart/add/'                                 => 'cart/add',
        'cart/'                                     => 'cart/index',
        'cart'                                      => 'cart/index',
    ],
];
