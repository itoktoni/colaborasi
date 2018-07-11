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

<div class="card-content">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal']]); ?>

    <?= $form->field($model, 'feature_group')->dropdownList(ArrayHelper::map(FeatureGroup::find()->where(['status' => 1])->all(),'id','name'), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Feature Group']); ?> 

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropdownList(Yii::$app->cms->status(), ['class' => 'selectpicker', 'data-style' => 'select-with-transition', 'title' => 'Choose Status']) ?>

    <div class="form-group">
        <?= Html::a('Back',Url::to('/feature/'), ['class' => 'btn btn-fill btn-primary']);?>
        <?= Html::submitButton('Save', ['class' => 'btn btn-fill btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
