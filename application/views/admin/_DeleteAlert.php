<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">                     
            <div class="card mb-3">
                <div class="card-header">
                    <h3><i class="fa fa-file"></i> Are you sure want delete this folder??</h3>
                     
                    
                <div class="card-body">
                    
                    <h3>There is :</h3>
                    <h3><?php echo $folders ?> Folders and</h3>
                    <h3><?php echo $files ?> Files</h3>
                </div>                                                      
            </div><!-- end card-->                  
        </div>
    </div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn" style="background-color: red
; color: #FFFFFF;"><a href="<?php echo site_url('admin/delete')?>/<?= $id ?>">DELETE</a></button>
</div>