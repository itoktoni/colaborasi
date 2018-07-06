<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <meta charset="<?=Yii::$app->charset?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::csrfMetaTags()?>
    <title><?=Html::encode($this->title)?></title>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>

<div class="wrap">
    <?php
NavBar::begin([
    'brandLabel' => Yii::$app->name,
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
$menuItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
];

if (!Yii::$app->user->isGuest) {
    if (!Yii::$app->cache->exists('menu_' . Yii::$app->user->identity->roles)) {
        if ($menus = \backend\components\CMS::getMenu()) {
            foreach ($menus['group'] as $key => $item) 
            {
                $res = [];
                foreach ($menus['menu'][$key] as $keys => $child) {
                    if ($child['access'] == '0'):
                        continue;
                    endif;
                    $res[] = ['label' => $child['name'], 'url' => Url::to('/' . $child['slug'])];
                }

                $menuItems[] = ['label' => $item['name'], 'items' => $res];
            }
        }
        Yii::$app->cache->add('menu_' . Yii::$app->user->identity->roles, $menuItems, 30);
    } else {
        $menuItems = Yii::$app->cache->get('menu_' . Yii::$app->user->identity->roles);
    }
}

if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $menuItems[] = '<li>'
    . Html::beginForm(['/site/logout'], 'post')
    . Html::submitButton(
        'Logout (' . Yii::$app->user->identity->email . ')',
        ['class' => 'btn btn-link logout']
    )
    . Html::endForm()
        . '</li>';
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>

    <div class="container">
        <?=Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])?>
        <?=Alert::widget()?>
        <?=$content?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?=Html::encode(Yii::$app->name)?> <?=date('Y')?></p>

        <p class="pull-right"><?=Yii::powered()?></p>
    </div>
</footer>

<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
