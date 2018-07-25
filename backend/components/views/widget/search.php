<?php
use yii\helpers\Html;
use yii\helpers\Url;?>

    <div class="row">
    
        <div class="col-md-12">
        <div class="card" style="padding: 30px 15px;">
                <form action="<?php echo $action; ?>" method="<?php echo $method; ?>" id="<?php echo $id;?>">
                    <?php foreach ($field as $key => $item): ?>

                        <?php if (isset($item['columnCss'])): ?>
                        <div class="<?php echo $item['columnCss']; ?>">
                        <?php else: ?>
                        <div class="col-md-3">
                        <?php endif;?>
                            <?php if (!is_array($item)): ?>

                            <div class="form-group is-empty">
                                <input type="text" name="<?php echo $key; ?>" class="<?php echo $class; ?>" placeholder="Find <?=ucwords($key);?>" value="<?php echo $item; ?>"
                                    id="<?=strtolower($key);?>">
                                <span class="material-input"></span>
                            </div>

                            <?php else: ?>
                            <?php if (isset($item['render_only']) && $item['render_only']): ?>

                            <?php echo $item['source']; ?>


                            <?php elseif (isset($item['is_dropdown'])): ?>

                                <div class="form-group is-empty" style="margin-top: 11px;">
                               <select class="selectpicker" data-size="7" data-style="select-with-transition" name="<?php echo (isset($item['name'])) ? $item['name'] : $key; ?>" class="<?php echo (isset($item['class'])) ? $item['class'] : 'form-control'; ?>">
                                <option value="" selected>
                                    <?php echo (isset($item['placeholder'])) ? ucwords($item['placeholder']) : 'Select ' . ucwords((isset($item['placeholder'])) ? $item['name'] : $key); ?>
                                </option>
                                <?php
if (!isset($item['value'])):
    $item['value'] = (isset($item['name'])) ? Yii::$app->request->get($item['name']) : Yii::$app->request->get($key);
endif;
foreach ($item['item'] as $key => $e):
?>
                                    <option value="<?php echo $key; ?>" <?php echo ($item['value'] == $key && $item['value'] != '') ? 'selected' : ''; ?>>
                                        <?php echo $e; ?>
                                    </option>
                                    <?php endforeach;?>
                            </select>
                            </div>

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
                        </div>
                        <?php if (isset($item['clearfix']) && $item['clearfix']): ?>
                            <div class="clearfix">&nbsp;</div>
                            <?php endif;?>
                        <?php endforeach;?>

                        <?php if ($status): ?>
                        <div class="col-md-2">
                            <div class="form-group is-empty" style="margin-top:11px;">
                                <?php echo Html::dropDownList('sort_order', Yii::$app->request->get('sort_order', $defaultValue = null), (!$sort_field) ? backend\components\CMS::sort() : $status_field, ['prompt' => 'No Sort', 'class' => 'selectpicker', 'data-size' => '7', 'data-style' => 'select-with-transition']); ?>
                            </div>
                        </div>
                        <?php endif;?>


                        <?php if ($status): ?>
                        <div class="col-md-2">
                            <div class="form-group is-empty" style="margin-top:11px;">
                                <?php echo Html::dropDownList('status', Yii::$app->request->get('status', $defaultValue = null), (!$status_field) ? backend\components\CMS::status() : $status_field, ['prompt' => 'All Status', 'class' => 'selectpicker', 'data-size' => '7', 'data-style' => 'select-with-transition']); ?>
                            </div>
                        </div>
                        <?php endif;?>
                        <div class="clearfix"></div>
                        <div class="col-md-12  text-right">
                            <a href="<?php echo Url::to('/' . Yii::$app->request->pathinfo); ?>" class="btn btn-sm btn-default" rel="tooltip" title="" data-original-title="Reset Search"><i class="material-icons">sync</i></a>
                            <button type="submit" class="btn btn-sm btn-primary" rel="tooltip" title="" data-original-title="Search"><i class="material-icons">search</i></button>
                        </div>
                </form>
        </div>
    </div>
    </div>
    <div class="clearfix">&nbsp;</div>