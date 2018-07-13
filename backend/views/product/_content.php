<?php

use backend\components\CMS;?>

    <div class="card card-signup">
        <div class="panel-body">
            <div class="card-header card-header-icon pull-right" data-background-color="purple">
                <a href="#" id="add_content" class="" title="" rel="tooltip" data-original-title="Add Content">
                    <i class="material-icons">add</i>
                </a>
            </div>
            <div class="content-holder">
                <div class="form-group">
                    <label class="control-label">Content Type</label>
                    <select id="content_type" class="selectpicker" name="content_type" maxlength="" title="Select Content Type" data-style="select-with-transition"
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
                <div class="form-group" id="upload" style="display:none;">
                    <label class="control-label"></label>
                    <span class="btn btn-raised btn-round btn-primary btn-file">
                        <span class="fileinput-new">File</span>
                        <input type="file" name="file_upload">
                        <div class="ripple-container"></div>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <?php $this->registerJs("

    $('#add_content').click(function(){
        var value = '';
        if($('#content_type').val() == '1'){
            if($('#embed_type').val() == '1'){
                value = $('embed_code').val();
            }else if($('#embed_type').val() == '2'){
                value = $('embed_code').val();
            }
        }else if($('#content_type').val() == '2'){
            if($('#embed_type').val() == '1'){

            }else if($('#embed_type').val() == '2'){

            }
        }

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
});");