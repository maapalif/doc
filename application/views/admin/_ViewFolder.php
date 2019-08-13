<script type="text/javascript">
    $(document).ready(function(){
        var id = $(".create").attr("data-id");
        $.ajax({
            type    : "POST",
            data    : {id:id},
            url     : "<?php echo site_url('tree/getUpload')?>" ,  
            success : function(msg){
                $(".upload").html(msg);
            }
        });

    });
</script>

<div class="card mb-3">
            <div class="card-header">
                <h3><i class="fa fa-folder-open-o"></i> <?php echo $title." "."Folder"?> </h3>
            </div>
                
            <div class="card-body">
                <div class="form-group">

                    <div>
                        <div class="btn btn-primary create" style="background-color: #69c330
;" role="button" href="#" data-id="<?= $id; ?>" data-toggle="modal" data-target="#customModal"><span class="btn-label"><i class="fa fa-plus"></i></span>New</div>
                        <p> 
                    </div>
                    
                    <!-- table -->
                    <div class="table-responsive divtree" style="padding-right: 5px;">
                            <table id="table" class="table table-striped table-bordered table-hover " width="100%" cellpadding="0" cellspacing="0">
                            <thead>
                              <tr style="background-color: #69c330
; color: #FFFFFF;">
                                <th width="1%"><center>No</center></th>
                                <th><center>Nama File</center></th>
                                <th><center>Type</center></th>
                                <th><center>Creator</center></th>
                                <th><center>Date Uploaded</center></th>
                                <th width="1%"><center>Aksi</center></th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            foreach($result as $h) {  
                                $date = date("Y-m-d", strtotime($h->u_CreatedAt));
                                $user = $this->Tree_model->user2($h->u_CreatedBy);                          
                            ?>
                                <tr>
                                    <td align= "center"><?php echo $i++ ?></td>
                                    <td align= "center"><a href="<?php echo base_url('assets/files/')?><?=$h->u_Name;?>" target="_blank"><?=$h->u_Raw;?></a></td>
                                    <td align= "center"><?= $h->u_Ext ;?></td>
                                    <td align= "center"><?php echo $user ;?></td>
                                    <td align= "center"><?= date_indo($date); ?></td>       
                                    <td align= "center">
                                        <a href="<?php echo site_url('admin/edit')?>/<?= $h->u_ID ?>" title="Edit"><i class="fa fa-fw fa-pencil-square" style="color: #000000;"></i></a>
                                        <a href="<?php echo site_url('admin/delete')?>/<?= $h->u_ID ?>" title="Delete" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-fw fa-window-close" style="color: #000000;"></i></a>
                                    </td>  
                                </tr>
                            <?php } ?>
                            </tbody>
                         </table>
                        
                    </div>

                </div>
            </div>
                
        </div>

<div class="modal fade custom-modal" id="customModal" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel2">Upload File</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body upload">
        
      </div>
      
    </div>
  </div>
</div>