<?php

use yii\helpers\Html;
use backend\components\CMS;

/* @var $this yii\web\View */
/* @var $model backend\models\base\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
            <div class="card">
            	<div class="card-header card-header-text" data-background-color="purple">
				    <h4 class="card-title"><?= Html::encode($this->title) ?></h4>
				</div>
            	<?= $this->render('_form', [
			        'model' => $model,
			        'roles' => \backend\models\base\Roles::find()->where(['>=', 'status', CMS::STATUS_DELETED])->all(),
			    ]) ?>
            </div>
        </div>
	</div>
</div>