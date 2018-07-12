<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'vendors/bootstrap/css/bootstrap.min.css',
        'fonts/font-awesome-4.7.0/css/font-awesome.min.css',
        'fonts/themify/themify-icons.css',
        'fonts/Linearicons-Free-v1.0.0/icon-font.min.css',
        'fonts/elegant-font/html-css/style.css',
        'vendors/animate/animate.css',
        'vendors/css-hamburgers/hamburgers.min.css',
        'vendors/animsition/css/animsition.min.css',
        'vendors/select2/select2.min.css',
        'vendors/daterangepicker/daterangepicker.css',
        'vendors/slick/slick.css',
        'vendors/lightbox2/css/lightbox.min.css',
        'css/util.css',
        'css/main.css',
    ];
    public $js = [
        'vendors/animsition/js/animsition.min.js',
        'vendors/bootstrap/js/popper.js',
        'vendors/bootstrap/js/bootstrap.min.js',
        'vendors/select2/select2.min.js',
        'vendors/slick/slick.min.js',
        'js/slick-custom.js',
        'vendors/countdowntime/countdowntime.js',
        'vendors/lightbox2/js/lightbox.min.js',
        'vendors/sweetalert/sweetalert.min.js',
        'vendors/parallax100/parallax100.js',
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyC9gsbJtv4rbhXA0-Zy_cxsWiOeaFku9r4',
        'js/map-custom.js',
        'js/main.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
