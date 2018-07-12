<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\base\Product */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
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
					'content' => $content,
					'subcategory_list' => false,
					'selected_subcategory' => false
			    ]) ?>
            </div>
        </div>
	</div>
</div>