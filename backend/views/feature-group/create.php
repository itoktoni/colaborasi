<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\base\FeatureGroup */

$this->title = 'Create Feature Group';
$this->params['breadcrumbs'][] = ['label' => 'Feature Groups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feature-group-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
