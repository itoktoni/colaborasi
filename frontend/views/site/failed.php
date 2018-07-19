<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Failed Payment';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container" style="min-height: calc(100vh - 287px);">
	<div class="row payment">
		<h2>Payment failed</h2>
		<p>Please check your order and contact our customer service.</p>
		<div class="center">
			<a class="btn btn-default" href="<?php echo Url::to('/site/') ;?>">Go Back Home</a>
		</div>
	</div>
</div>