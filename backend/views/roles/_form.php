<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\models\base\FeatureGroup;
use backend\models\base\Feature;
use backend\models\base\Permission;

/* @var $this yii\web\View */
/* @var $model backend\models\base\Roles */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin();?>
<div class="col-md-4 roles-form">

	

	    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'description')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'status')->dropdownList(Yii::$app->cms->status())?>

	<div class="form-group">
		<?=Html::a('Back', Url::to('/roles/'), ['class' => 'btn btn-primary']);?>		<?=Html::submitButton('Save', ['class' => 'btn btn-primary'])?>
	</div>



</div>

<div class="col-md-8 roles-form">
	<table class="table table-responsive">
		<tr>
			<th>
			</th>
			<th>
				Restrict
			</th>
			<th>
				Read-only
			</th>
			<th>
				Full access
			</th>

		</tr>
		<?php foreach (FeatureGroup::find()->where(['status' => 1])->all() as $item): ?>
		<tr>
			<td colspan="4">
				<strong><?php echo $item->name; ?></strong>
			</td>
		</tr>
		<?php
foreach (Feature::find()->where(['status' => 1, 'feature_group' => $item->id])->all() as $feature):
    $active = Permission::find()->where(['roles' => $roles, 'feature' => $feature->id])->one();
    ?>

			<tr>
				<td class="feature_list">
					<?php echo $feature->name; ?>
				</td>
				<td class="centered">
					<div class="radio radio-inline">
						<label>
							<input type="radio" name="feature[<?php echo $feature->id; ?>]" value="0" <?php echo ($active && $active->access == 0) ? 'checked="checked"' : ''; ?> class="flat-red">
						</label>
					</div>
				</td>
				<td class="centered">
					<div class="radio radio-inline">
						<label>
							<input type="radio" name="feature[<?php echo $feature->id; ?>]" value="1" <?php echo ($active && $active->access == 1) ? 'checked="checked"' : ''; ?>  class="flat-red">
						</label>
					</div>
				</td>
				<td class="centered">
					<div class="radio radio-inline">
						<label>
							<input type="radio" name="feature[<?php echo $feature->id; ?>]" value="2"  <?php echo ($active && $active->access == 2) ? 'checked="checked"' : ''; ?> class="flat-red">

						</label>
					</div>
				</td>

			</tr>
		<?php endforeach;?>

<?php endforeach;?>
</table>
</div>
<?php ActiveForm::end();?>