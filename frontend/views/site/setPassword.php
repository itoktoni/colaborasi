<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>

<section class="bgwhite p-t-66 p-b-60">
    <div class="container">
        <div class="row">

            <div class="col-md-6 p-b-30">
                
                <?php $form = ActiveForm::begin(['action' => ['site/password'], 'id' => 'reset-password-form']);?>

                <?=$form->field($model, 'password')->passwordInput(['autofocus' => true])?>
                <input type="hidden" name="id" value="<?php echo $model->email; ?>">
                <div class="form-group">
                    <?=Html::submitButton('Save', ['class' => 'btn btn-primary flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4'])?>
                </div>

                <?php ActiveForm::end();?>

            </div>
        </div>
    </div>
</section>


