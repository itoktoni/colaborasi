<?php

use yii\helpers\Url;
?>

	<table class="table table-responsive">
		<thead>
			<th>#</th>
			<?php foreach ($header as $item): ?>
			<th>
				<?php echo $item; ?>
			</th>
			<?php endforeach;?>
		</thead>

		<?php foreach ($dataProvider as $item): ?>
		<tr>
			<td>
				<?php echo $item->id; ?>
			</td>
			<?php foreach ($field as $id => $s): ?>

			<?php if (is_array($s)): ?>
				<td>
				<?php if (isset($s['callback'])): ?>
					<?php echo call_user_func_array([$s['callback']['class'], $s['callback']['method']], [$item->{$id}]); ?>
				<?php endif;?>
				</td>
			<?php else: ?>
			<td>
				<?php echo $item->{$s}; ?>
			</td>
			<?php endif;?>
			<?php endforeach;?>
			<td>
			
				<?php if (YII::$app->cms->check_permission()): ?>
				<?php if ($action_edit): ?>
				<a href="<?php echo Url::to('/' . $action_url . '/update/?id=' . $item->id); ?>" class="btn btn-warning btn-xs btn-round"
				    title="Edit <?php echo $action; ?>" rel="tooltip">
					<i class="fa fa-edit"></i>
					<div class="ripple-container"></div>
				</a>
				<?php endif;?>

				<?php if ($action_delete): ?>
				<a href="<?php echo Url::to('/' . $action_url . '/delete/?id=' . $item->id); ?>" class="btn btn-primary btn-xs btn-round"
				    title="Delete <?php echo $action; ?>" rel="tooltip">
					<i class="fa fa-window-close"></i>
					<div class="ripple-container"></div>
				</a>
				<?php endif;?>
				<?php endif;?>
			</td>
		</tr>
		<?php endforeach;?>
	</table>