<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
	$safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form card-content">

	<div class="col-md-4">

		<?= "<?php " ?>$form = ActiveForm::begin(); ?>
	
		<?php foreach ($generator->getColumnNames() as $attribute) {
			if (in_array($attribute, $safeAttributes)) {
				echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
			}
		} ?>

	    <div class="form-group">
			<?= "<?= Html::a('Back',Url::to('/".Inflector::camel2id(StringHelper::basename($generator->modelClass))."/'), ['class' => 'btn btn-fill btn-primary']);?>";?>
			<?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Save') ?>, ['class' => 'btn btn-fill btn-success']) ?>
		</div>

		<?= "<?php " ?>ActiveForm::end(); ?>

	</div>

</div>

