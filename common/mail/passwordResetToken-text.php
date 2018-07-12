<?php

use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Url::to(['site/reset-password', 'token' => $user->password_reset_token], true);
?>
Hello <?= $user->email ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
