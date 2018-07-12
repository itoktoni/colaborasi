<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="">
<?php $this->beginBody() ?>

    <div class="notification-wrapper">
        <div class="notification-center">
            <div class="notification-content">
                <div class="alert alert-success">
                    <button type="button" aria-hidden="true" class="close" onclick="close_popup()">
                        <i class="material-icons">close</i>
                    </button>
                    <span>
                        <strong><?php echo Yii::$app->session->getFlash('success'); ?></strong>    
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <?= $this->render('sidebar') ?>

        <div class="main-panel">
            <?= $this->render('header') ?>
            <div class="content">
                <?= $content ?>
            </div>
        </div>

    </div>

    <?php if(Yii::$app->session->hasFlash('success')):?>
        <?php
            $script = "
                $('.notification-wrapper').fadeIn(300);
                setTimeout(function(){
                    $('.notification-wrapper').fadeOut(300);
                },3000);";
            $this->registerJs($script);
        ?>
    <?php endif; ?>

    <script>
        function close_popup()
        {
            $('.notification-wrapper').fadeOut(300);
        }
    </script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
