<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wizard-container">
    <div class="card wizard-card" data-color="rose" id="wizardProfile">
        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <div class="wizard-header">
            <h3 class="wizard-title">
                Login
            </h3>
            <h5>Please fill out the following fields to login.</h5>
        </div>

        <div class="tab-content">
            <div class="row">
                <div class="col-sm-10" style="float: none;margin: 0 auto;">
                    <?= $form->field($model, 'email')->textInput() ?>
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-10" style="float: none;margin: 0 auto;">
                    <div class="form-group">
                        <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

