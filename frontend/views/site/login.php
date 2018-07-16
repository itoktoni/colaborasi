<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- content page -->
<section class="bgwhite p-t-66 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6 p-b-30">
                <?php $form = ActiveForm::begin(['id' => 'login-form', 'options' => ['class' => 'login-form']]); ?>

                    <h4 class="m-text26 p-b-36 p-t-15">
                        Login
                    </h4>

                    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <div class="form-group" style="display: none;">
                        <input type="checkbox" id="loginform-rememberme" name="LoginForm[rememberMe]" value="1" checked="">
                    </div>

                    <div class="form-group">
                        <p class="text-forgot">If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.</p>
                    </div>

                    <div class="w-size25">
                        <?= Html::submitButton('Login', ['class' => 'flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4', 'name' => 'login-button']) ?>
                    </div>

                    <hr>

                    <div class="form-group pull-right">
                        <a class="btn btn-primary" href="/facebook">Sign With Facebook</a> 
                        <a class="btn btn-info" href="/twitter">Sign With Twitter</a> 
                        <a class="btn btn-danger" href="/google">Sign With Google</a> 
                        <a class="btn btn-warning" href="/github">Sign With Github</a> 
                    </div>

                <?php ActiveForm::end(); ?>
    
            </div>

            <div class="col-md-6 p-b-30">
                <?php $form = ActiveForm::begin(['id' => 'form-signup', 'action' => Url::to('/site/signup'), 'options' => ['class' => 'login-form']]); ?>

                    <h4 class="m-text26 p-b-36 p-t-15">
                        Sign Up
                    </h4>

                    <?= $form->field($modelsignup, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($modelsignup, 'password')->passwordInput() ?>

                    <?= $form->field($modelsignup, 'email') ?>

                    <div class="w-size25">
                        <?= Html::submitButton('Signup', ['class' => 'flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4', 'name' => 'signup-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>