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
        '/'                                         => 'site/index',
        '/subscribe'                                => 'site/subscribe',
        '/password'                                 => 'site/password',
        '/github'                                   => 'site/github',
        '/facebook'                                 => 'site/facebook',
        '/twitter'                                  => 'site/twitter',
        '/google'                                   => 'site/google',
        '/register'                                 => 'site/signup',
        '/login'                                    => 'site/login',
        'category/<cats:(.*)>/<subcategory:(.*)>'   => 'category/index/',
        'category/<cats:(.*)>'                      => 'category/index/',
        'product/comment'                           => 'product/comment/',
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
        'checkout'                                  => 'cart/checkout',
        '/ongkir/province'                          => 'ongkir/province',
        '/ongkir/city'                              => 'ongkir/city',
        '/ongkir/sub'                               => 'ongkir/sub',
        '/ongkir/cost'                              => 'ongkir/cost',
        '/profile'                                  => 'profile/index',
        '/download'                                 => 'profile/download',
        '/purchase'                                 => 'profile/purchase',
    ],
];
