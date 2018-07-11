<?php
use backend\components\CMS;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\tinymce\TinyMce;
?>

    <?php $form = ActiveForm::begin();?>


    <div class="form-group pull-right">
        <?=Html::a('Back', Url::to('/product/'), ['class' => 'btn btn-primary']);?>
            <?=Html::submitButton('Save', ['class' => 'btn btn-primary'])?>
    </div>
    <div class="clearfix"></div>

    <?php if (!$page): ?>
    <?php $field = [$field];?>
    <?php endif;?>

    <?php foreach ($field as $item): ?>
    <div class="col-md-4 product-form">
        <?php foreach ($item as $key => $item): ?>
        <div class="form-group">
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
                    <input type="file" name="<?php echo $key; ?>" />
                </span>
                <?php
$object = false;
            break;
        case "uploadimage": ?>
        <label class="control-label"><?php echo isset($item['label']) ? $item['label'] : ucwords($key); ?></label>
        <div class="clearfix"></div>

                    <span class="btn btn-raised btn-round btn-primary btn-file">
                        <span class="fileinput-new">Select image</span>
                        <span class="fileinput-exists">Change</span>
                        <input type="file" name="<?php echo $key; ?>" />
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
            if (isset($item['id']) && isset($item['name'])) {
                $item['option']['class'] = 'selectpicker';
                $item['option']['data-style'] = 'select-with-transition';
                $item['option']['data-size'] = '7';
                $object->dropDownList(ArrayHelper::map($item['item'], $item['id'], $item['name']), $item['option']);
            }
            break;
        case "checkboxList":
            $object->checkboxList($item['item'], $item['option']);
            break;
        case "checkbox":
            $item['option']['class'] = 'form-check-input';
            $object->checkbox($item['option']);
            break;
        case "text":
            $object->textInput($item['option']);
            break;
        case "tags":
            $item['option']['data-role'] = "tagsinput";
            $item['option']['data-color'] = "primary";
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
                        "insertdatetime media table contextmenu paste"
                    ],
                    'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                ]
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
</div>
                        <?php endforeach;?>
        </div>
    </div>

    <?php
endforeach;?>
    <div class="clearfix"></div>
    <div class="form-group pull-right">
        <?=Html::a('Back', Url::to('/product/'), ['class' => 'btn btn-primary']);?>
            <?=Html::submitButton('Save', ['class' => 'btn btn-primary'])?>
    </div>


    <?php ActiveForm::end();?>