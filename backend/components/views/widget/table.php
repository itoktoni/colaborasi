<?php

use yii\helpers\Url;
?>
<table class="table">
    <thead class="text-primary">
        <tr>
            <th>#</th>
            <?php foreach ($header as $item): ?>
            <th><?php echo $item; ?></th>
			<?php endforeach;?>
			<th class="text-right">Action</th>
        </tr>
    </thead>

    <tbody>
    	<?php foreach ($dataProvider as $item): ?>
        <tr>
            <td><?php echo $item->id; ?></td>
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
            <td class="td-actions text-right">
            	<?php if (YII::$app->cms->check_permission()): ?>
            		<?php if ($action_edit): ?>
		                <a href="<?php echo Url::to('/' . $action_url . '/update/?id=' . $item->id); ?>" class="btn btn-warning" title="" rel="tooltip" data-original-title="Edit <?php echo $action; ?>">
		                    <i class="material-icons">edit</i>
		                </a>
		            <?php endif;?>
		            <?php if ($action_delete): ?>
		                <a href="<?php echo Url::to('/' . $action_url . '/delete/?id=' . $item->id); ?>" class="btn btn-danger" title="" rel="tooltip" data-original-title="Delete <?php echo $action; ?>">
		                    <i class="material-icons">close</i>
		                </a>
                	<?php endif;?>
                <?php endif;?>
            </td>
        </tr>
    	<?php endforeach;?>
    </tbody>
</table>