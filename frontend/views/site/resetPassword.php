<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Please Set Password';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- content page -->
<section class="bgwhite p-t-66 p-b-60">
    <div class="container">
        <div class="row">

            <div class="col-md-6 p-b-30">
                
                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']);?>

                <?=$form->field($model, 'password')->passwordInput(['autofocus' => true])?>

                <div class="form-group">
                    <?=Html::submitButton('Save', ['class' => 'btn btn-primary'])?>
                </div>

                <?php ActiveForm::end();?>

            </div>
        </div>
    </div>
</section>