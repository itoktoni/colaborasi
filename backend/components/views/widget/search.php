<?php
use yii\helpers\Html;
use yii\helpers\Url;?>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <form action="<?php echo $action; ?>" method="<?php echo $method; ?>">
                    <?php
                        foreach ($field as $key => $item):
                            if (!is_array($item)):
                            ?>

                        <div class="form-group is-empty">
                            <input type="text" name="<?php echo $key; ?>" class="<?php echo $class; ?>" placeholder="Find <?=ucwords($key);?>"
                                value="<?php echo $item; ?>" id="<?=strtolower($key);?>">
                            <span class="material-input"></span>
                        </div>

                        <?php else: ?>
                        <?php if (isset($item['render_only']) && $item['render_only']): ?>

                        <?php echo $item['source']; ?>


                        <?php elseif (isset($item['is_dropdown'])): ?>

                        <select name="<?php echo (isset($item['name'])) ? $item['name'] : $key; ?>" class="<?php echo (isset($item['class'])) ? $item['class'] : 'form-control'; ?>">
                            <option value="" selected>
                                <?php echo (isset($item['placeholder'])) ? ucwords($item['placeholder']) : 'Select ' . ucwords((isset($item['name'])) ? $item['name'] : $key); ?>
                            </option>
                                <?php
                                if (!isset($item['value'])):
                                    $item['value'] = (isset($item['name'])) ? Yii::$app->request->get('name') : Yii::$app->request->get($key);
                                endif;
                                foreach ($item['item'] as $key => $e):
                                ?>
                                <option value="<?php echo $key; ?>" <?php echo ($item[ 'value']== $key) ? 'selected' : ''; ?>>
                                    <?php echo $e; ?>
                                </option>
                                <?php endforeach;?>
                        </select>


                        <?php elseif (isset($item['source'])): ?>
                        <select class="<?php echo $item['class']; ?>">
                            <?php foreach ($item['source'] as $each): ?>
                            <option value="<?php echo $each->id; ?>">
                                <?php echo $each->name; ?>
                            </option>
                            <?php endforeach;?>
                        </select>



                        <?php elseif (isset($item['is_widget']) && $item['is_widget']): ?>
                        <?php echo $item['widget_content']; ?>

                        <?php else: ?>

                        <div class="form-group is-empty">
                            <input type="text" name="<?php echo $item['name']; ?>" class="<?php echo $item['class']; ?>" placeholder="<?=$item['placeholder']?>"
                                value="<?php echo (isset($item['value'])) ? $item['value'] : Yii::$app->request->get($item['name']); ?>"
                                id="<?=strtolower($key);?>">
                            <span class="material-input"></span>
                        </div>


                        <?php endif;?>
                        <?php endif;?>

                        <?php if (isset($item['clearfix']) && $item['clearfix']): ?>
                        <div class="clearfix"></div>
                        <?php endif;?>
                        <?php endforeach;?>
                        <?php if ($status): ?>
                        <div class="col-md-2">
                            <div class="form-group is-empty">
                                <?php echo Html::dropDownList('status', Yii::$app->request->get('status', $defaultValue = null), (!$status_field) ? backend\components\CMS::status() : $status_field, ['prompt' => 'All Status', 'class' => 'form-control']); ?>
                            </div>
                        </div>
                        <?php endif;?>
                        <div class="clearfix"></div>
                        <div class="col-md-12  text-right">
                            <a href="<?php echo Url::to('/' . Yii::$app->request->pathinfo); ?>" class="btn btn-sm btn-round btn-default" rel="tooltip"
                                title="Reset Pencarian">
                                <i class="fas fa-sync-alt"></i>
                            </a>
                            <button type="submit" class="btn btn-sm btn-round btn-primary" rel="tooltip" title="Cari">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix">&nbsp;</div>