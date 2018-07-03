<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\models\base\FeatureGroup;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Feature */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-4 category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'feature_group')->dropdownList(ArrayHelper::map(FeatureGroup::find()->where(['status' => 1])->all(),'id','name')); ?> 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropdownList([1 => 'Active', 0 => 'Inactive']) ?>

    <div class="form-group">
        <?= Html::a('Back',Url::to('/feature/'), ['class' => 'btn btn-primary']);?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div>
