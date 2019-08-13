<div style="color:red">
    <?php echo validation_errors(); ?>
    <?php if(isset($error)){print $error;}?>
</div>

<?php echo form_open_multipart('admin/upload');?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">                     
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-file"></i> Maximum files must have maximal 1MB </h3>
                     
                    
                <div class="card-body">
                    
                    <input type="file" name="files" id="filer_example2">
                    <input type="hidden" name="id" value="<?= $id; ?>">
                    
                </div>                                                      
            </div><!-- end card-->                  
        </div>
    </div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Upload</button>
</div>

<?php echo form_close() ?>

<script>
$(document).ready(function(){

    'use-strict';

    //Example 2
    $('#filer_example2').filer({
        limit: 1,
        extensions: ['jpg', 'jpeg', 'png', 'gif', 'psd', 'docs', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'pdf', 'rar', 'zip', '7zip', 'txt', 'jpeg'],
        changeInput: true,
        showThumbs: true,
    });
});
</script>