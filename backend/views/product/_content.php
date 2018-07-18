<?php

use backend\components\CMS;
use yii\helpers\Html;
use yii\helpers\Url;?>

    <div class="card card-signup">
        <div class="panel-body" id="targetku">
            <div class="card-header card-header-icon pull-right" data-background-color="purple">
                <a href="#" id="add_content" class="" title="" rel="tooltip" data-original-title="Add Content">
                    <i class="material-icons">add</i>
                </a>
            </div>
            <div class="content-holder">
                <div class="form-group">
                    <label class="control-label">Content Type</label>
                    <select id="content_type" class="selectpicker" name="content_type[]" maxlength="" title="Select Content Type" data-style="select-with-transition"
                        data-size="7" aria-required="true" tabindex="-98">
                        <?php foreach (CMS::contentType() as $key => $item): ?>
                        <option value="<?php echo $key; ?>">
                            <?php echo $item; ?>
                        </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label">Type</label>
                    <select id="embed_type" class="selectpicker" name="embed" maxlength="" data-style="select-with-transition" data-size="7"
                        aria-required="true" tabindex="-98" title="Select Type">
                        <?php foreach (CMS::embedType() as $key => $item): ?>
                        <option value="<?php echo $key; ?>">
                            <?php echo $item; ?>
                        </option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="form-group" id="embed" style="display:none;">
                    <label class="control-label">Embed Code</label>
                    <textarea id="embed_code" name="embed_code" class="form-control" rows="6"> </textarea>
                </div>
            </div>
            <div id="embed_clone" class="col-md-12">
            </div>
        </div>
    </div>
    <div class="media-container card card-signup" id="expandable_media">

    <?php if (isset($data) && $data): ?>
        <?php foreach ($data as $item): ?>
        <div style='position:relative;' class='panel-body'>
        <?php echo urldecode($item->content);?>
        <a href="<?php echo Url::to('/product/content-delete/'.$item->id);?>" class='btn btn-warning delete-content' style='position:absolute; top: 5px; right: 5px;width:25px; height: 25px;padding: 0;margin: 0;border: none;z-index:999;'><i class='material-icons' style='top: 3px;'>delete</i></a>
        </div>
        <?php endforeach;?>
    <?php endif;?>
    </div>

    <?php $this->registerJs("
    var inputVideo = $('<input type=\'hidden\' name=\'Product[video][]\' />');
    var inputImage = $('<input type=\'hidden\' name=\'Product[content_image][]\' />');
    var inputMusic = $('<input type=\'hidden\' name=\'Product[music][]\' />');
    var inputFile = $('<div class=\'form-group\'><label class=\'control-label\'></label><span class=\'btn btn-raised btn-round btn-primary btn-file\'><span class=\'fileinput-new\'>File</span><input type=\'file\' name=\'content_file[]\'><div class=\'ripple-container\'></div></span></div>');
    var content = '';

    function __add_embed_object(type){
        var target = $($('#embed_code').val());
        if($('#embed_code').val().length < 1){
            alert('Please fill the empty field');
            return false;
        }

        if($('#embed_code').val() == 'iframe'){
            alert('Please use proper iframe tag');
            return false;
        }

        if (!target.is('iframe') ) {
            alert('Its not an embed code');
            return false;
        }
        content += $('#embed_code').val();
        content += '<input type=\'hidden\' name=\'Product['+type+'][]\' value=\''+htmlentities.encode($('#embed_code').val())+'\'/>';
        $('#embed_code').val('');
        return true;
    }

    function __add_input_object(type, text){
        var target = inputFile.clone();
        $(target).find('span.fileinput-new').html(text);
        $(target).find('input').attr('name','Product['+type+'][]');
        content += target.prop('outerHTML');
        return true;
    }


    function __branch_type(callback_embed, callback_input, callback_text){
        if($('#embed_type').val() == '1'){
            if(!__add_embed_object(callback_embed)){
                return false;
            }
        }else if($('#embed_type').val() == '2'){
            if(!__add_input_object(callback_input,callback_text)){
                return false;
            }
        }else{
            return false;
        }

        return true;
    }

    $('#add_content').click(function(){
        content = '<div style=\'position:relative;\' class=\'panel-body\'><button class=\'delete-content\' style=\'position:absolute; top: 5px; right: 5px;width:25px; height: 25px;padding: 0;margin: 0;border: none;z-index:999;\'><i class=\'material-icons\'>delete</i></button>';
        if($('#content_type').val() == '1'){
            if(!__branch_type('embed_video','video','Video File')){
                return;
            }
        }else if($('#content_type').val() == '2'){
            if(!__branch_type('embed_music','music','Music File')){
                return;
            }
        }else if($('#content_type').val() == '3'){
            if(!__branch_type('embed_image','content_image','Image File')){
                return;
            }
        }else{
            return;
        }
        content += '</div>'
        $('#expandable_media').prepend(content);
    });

    $('#embed_type').on('changed.bs.select', function (e) {
    if($(this).val() == '1'){
        $('#embed').show();
        $('#upload').hide();
    }else if($(this).val() == '2'){
        $('#embed').hide();
        $('#upload').show();
    }else{
        $('#embed').hide();
        $('#upload').hide();
    }

    $('#expandable_media').on('click','button', function(e){
        $(this).parent('div').remove();
    });

    (function(window){
        window.htmlentities = {
            /**
             * Converts a string to its html characters completely.
             *
             * @param {String} str String with unescaped HTML characters
             **/
            encode : function(str) {
                return encodeURI(str);
                // var buf = [];

                // for (var i=str.length-1;i>=0;i--) {
                //     buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
                // }

                // return buf.join('');
            },
            /**
             * Converts an html characterSet into its original character.
             *
             * @param {String} str htmlSet entities
             **/
            decode : function(str) {
                return str.replace(/&#(\d+);/g, function(match, dec) {
                    return String.fromCharCode(dec);
                });
            }
        };
    })(window);

});");