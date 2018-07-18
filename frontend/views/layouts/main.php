<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
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
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="animsition">

    <?php $this->beginBody() ?>

        <?= $this->render('header') ?>
        <?= $content ?>
        <?= $this->render('footer') ?>

    <?php $this->endBody() ?>

</body>

<?php if (Yii::$app->session->hasFlash('success')): ?>
<script>
    swal({ title: "Success !",
        text: "<?=Yii::$app->session->getFlash('success')?>",
        timer: 3000,
        showConfirmButton: false,
        icon: "success",
    });
</script>
<?php endif;?>
<?php if (Yii::$app->session->hasFlash('error')): ?>
<script>
    swal({ title: "Error !",
        text: "<?=Yii::$app->session->getFlash('error')?>",
        timer: 3000,
        showConfirmButton: false,
        icon: "error",
    });
</script>
<?php endif;?>

<script src="https://js.pusher.com/4.0/pusher.min.js"></script>
<script>

// Enable pusher logging - don't include this in production
Pusher.logToConsole = false;

var pusher = new Pusher('b07270a223c7b4f48843', {
    cluster: 'ap1',
    encrypted: true
});

var channel = pusher.subscribe('my-channel');
channel.bind('my-event', function(data) {
    
    swal({ title: "Information Notification !",
        text: data.message,
        timer: 3000,
        showConfirmButton: true,
        icon: "info",
    });

});
</script>

<script>
    <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5b178de98859f57bdc7be288/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</script>

<?php $this->endPage() ?>
