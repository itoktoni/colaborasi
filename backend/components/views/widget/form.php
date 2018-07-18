<?php
use backend\components\CMS;
use dosamigos\tinymce\TinyMce;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

    <?php $form = ActiveForm::begin($form_option);?>


    
    <div class="clearfix"></div>

    <?php if (!$page): ?>
    <?php $field = [$field];?>
    <?php endif;?>

    <?php foreach ($field as $mykey => $item):?>
    
        <?php if(isset($col_class)):
            if(is_array($col_class)):?>
                <div class="<?php echo $col_class[$mykey];?> product-form form-group">
            <?php else:?>
                <div class="<?php echo $col_class;?> product-form form-group">
            <?php endif;?>
        <?php else:?>
        <div class="<?php echo $col_class;?> product-form form-group">
        <?php endif;?>
        <?php foreach ($item as $key => $item): ?>
            <?php
            $object = $form->field($model, $key);

            if (isset($item['type']) && $item['type']) {
                if (!isset($item['option'])) {
                    $item['option'] = ['maxlength' => true];
                }

                switch ($item['type']) {
                    case "label":
                        $object->label($item['value'], $item['option']);
                        break;
                    case "file":
                        // $object->fileInput($item['option']);
                        ?>
                        <label class="control-label"><?php echo isset($item['option']['label']) ? $item['option']['label'] : ucwords($key); ?></label>
                        <div class="clearfix"></div>
                            <span class="btn btn-raised btn-round btn-primary btn-file">
                                <span class="fileinput-new">Select File</span>
                                <?=Html::activeFileInput($model, $key, $item['option'])?>
                            </span>
                            <?php
                        $object = false;
                        break;
                    case "uploadimage": ?>
                        <?=Html::img($model->{$key},['id' => 'image-preview']);?>
                        <label class="control-label"><?php echo isset($item['label']) ? $item['label'] : ucwords($key); ?></label>
                        <div class="clearfix"></div>
                                <span class="btn btn-raised btn-round btn-primary btn-file">
                                    <span class="fileinput-new">Select image</span>
                                    <?=Html::activeFileInput($model, $key, $item['option'])?>
                                </span>
                            <?php
                        $object = false;
                        break;
                    case "datepicker":
                        $object->fileInput($item['option']);
                        break;
                    case "dropdown":
                        $item['option']['class'] = 'selectpicker';
                        $item['option']['data-style'] = 'select-with-transition';
                        $item['option']['data-size'] = '7';
                        $object->dropDownList($item['item'], $item['option']);
                        break;
                    case "dropdown_model":

                        if (!isset($item['id'])) {
                            $item['id'] = 'id';
                        }
                        if (!isset($item['name'])) {
                            $item['name'] = 'name';
                        }
                        $item['option']['class'] = 'selectpicker';
                        $item['option']['data-style'] = 'select-with-transition';
                        $item['option']['data-size'] = '7';

                        if (!$item['item']) {
                            $item['item'] = [];
                            $object->dropDownList([], $item['option']);
                            break;
                        }

                        $object->dropDownList(ArrayHelper::map($item['item'], $item['id'], $item['name']), $item['option']);
                        break;
                    case "checkboxlist":
                        $object->checkboxList($item['item'], $item['option']);
                        break;

                    case "checkboxlist_model":
                        if (!isset($item['id'])) {
                            $item['id'] = 'id';
                        }
                        if (!isset($item['name'])) {
                            $item['name'] = 'name';
                        }
                        $object->checkboxList(ArrayHelper::map($item['item'], $item['id'], $item['name']), $item['option']);
                        break;
                    case "checkbox":
                        $item['class'] = 'form-check-input';
                        $object->checkbox($item['option']);
                        break;
                    case "text":
                        $object->textInput($item['option']);
                        break;
                    case "tags":
                        $item['option']['data-role'] = "tagsinput";
                        $item['option']['data-color'] = "#9c27b0";
                        $item['option']['class'] = "tagsinput form-control";
                        $object->textInput($item['option']);
                        break;
                    case "textarea":
                        $object->textarea($item['option']);
                        break;
                    case "tinymce":
                        $object->widget(TinyMce::className(), [
                            'options' => $item['option'],
                            'language' => 'en',
                            'clientOptions' => [
                                'resize' => false,
                                'plugins' => [
                                    "advlist autolink lists link charmap print preview anchor",
                                    "searchreplace visualblocks code fullscreen",
                                    "insertdatetime media table contextmenu paste",
                                ],
                                'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                            ],
                        ]);
                        break;

                    case "radio":
                        $object->radio($item['option']);
                        break;
                    case "radiolist":
                        $object->radioList($item['item'], $item['option']);
                        break;
                    case "password":
                        $object->passwordInput($item['option']);
                        break;
                    case "status":
                        $item['option']['class'] = 'selectpicker';
                        $item['option']['data-style'] = 'select-with-transition';
                        $item['option']['data-size'] = '7';
                        $object->dropDownList(CMS::status(), $item['option']);
                        break;
                    case "widget":
                        $object->widget($item['widget_object'], $item['option']);
                        break;
                    case "html":
                        $object = $item['content'];
                        break;
                    default:
                        $object->textInput($item['option']);
                }
            } else {
                $object->textInput(['maxlength' => true]);
            }

            if ($object) {
                echo $object;
            }

            ?>
        <?php endforeach;?>
    </div>

    <?php endforeach;?>
    <div class="clearfix"></div>
    <div class="form-group">
        <?=Html::a('Back', Url::to('/product/'), ['class' => 'btn btn-fill btn-primary']);?>
            <?=Html::submitButton('Save', ['class' => 'btn btn-fill btn-success'])?>
    </div>


    <?php ActiveForm::end();?>