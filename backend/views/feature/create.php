<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\activerecord\Feature */

$this->title = 'Create Feature';
$this->params['breadcrumbs'][] = ['label' => 'Features', 'url' => ['index']];
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
			    ]) ?>
            </div>
        </div>
	</div>
</div>
