<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Success Payment';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container" style="min-height: calc(100vh - 287px);">
	<div class="row payment">
		<h2>Payment successfull</h2>
		<p>We will email you a receipt confirming your payment shortly.</p>
		<div class="center">
			<a class="btn btn-default" href="<?php echo Url::to('/site/') ;?>">Go Back Home</a>
		</div>
	</div>
</div>
