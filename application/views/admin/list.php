<div class="container" style="margin-top: 5px; margin-right: 0px; margin-left: 0px; max-width: 70%; font-size: 14px; ">

	<div>
		<a role="button" href="<?php echo site_url('admin/addParents')?>" class="btn" style="background-color: #1e7e34; color: #FFFFFF;"><span class="btn-label"><i class="fa fa-plus"></i></span>New Parents</a>
		<a role="button" href="<?php echo site_url('admin/addChild')?>" class="btn" style="background-color: #1e7e34; color: #FFFFFF;"><span class="btn-label"><i class="fa fa-plus"></i></span>New Child</a>
		<p>	
	</div>
	
		<!-- table -->
		<div class="table-responsive" style="padding-right: 5px;">

			<table id="table" class="table table-striped table-bordered table-hover "  style="width:100%;" width="50%" cellpadding="0" cellspacing="0">
			    <thead>
			      <tr style="background-color: #1e7e34; color: #FFFFFF;">
			        <th width="1%"><center>No</center></th>
					<th><center>Folder Name</center></th>
					<th><center>Parent Folder</center></th>
					<th width="1%"><center>Act</center></th>
			      </tr>
			    </thead>
			    <tbody>
				<?php
				$i = 1;
				foreach($data as $h) {							
				?>
					<tr>
						<td align= "center"><?php echo $i++ ?></td>
						<td align= "center"><?php echo $h->Name ;?></td>
				        <td align= "center"><?php 

				        if($h->ParentID == NULL){
				        	echo "Parents";
				        }
				        else{
				        	$ParentName = $this->Tree_model->getParentName($h->ParentID,$auth_department);
				        	
				        	echo $ParentName;
				        		
				        } 

				        ?></td>		
				        <td align= "center">
				        	<?php if($h->ParentID == NULL) { ?>
							<a href="<?php echo site_url('admin/editParent')?>/<?= $h->ID ?>" title="Edit"><i class="fa fa-fw fa-pencil-square" style="color: #000000;"></i></a>
							<?php }else{?>
							<a href="<?php echo site_url('admin/editChild')?>/<?= $h->ID ?>" title="Edit"><i class="fa fa-fw fa-pencil-square" style="color: #000000;"></i></a>
							<?php }?>
							<a href="<?php echo site_url('admin/delete')?>/<?= $h->ID ?>" title="Delete" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-fw fa-window-close" style="color: #000000;"></i></a>
						</td>  
				    </tr>
				<?php } ?>
			    </tbody>
			 </table>
		</div>

</div>