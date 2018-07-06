<?php

use yii\helpers\Html;
use backend\components\CMS;

/* @var $this yii\web\View */
/* @var $model backend\models\base\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roles' => \backend\models\base\Roles::find()->where(['>=', 'status', CMS::STATUS_DELETED])->all(),
    ]) ?>

</div>
