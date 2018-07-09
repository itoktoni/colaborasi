<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\Productcontent */

$this->title = 'Create Productcontent';
$this->params['breadcrumbs'][] = ['label' => 'Productcontents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productcontent-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
