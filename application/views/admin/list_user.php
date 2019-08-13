<div class="container" style="margin-top: 5px; margin-right: 0px; margin-left: 0px; max-width: 500%; font-size: 14px; ">

	<div>
		<a role="button" href="<?php echo site_url('admin/addPermission')?>" class="btn" style="background-color: #1e7e34; color: #FFFFFF;"><span class="btn-label"><i class="fa fa-plus"></i></span>New</a>
		<p>	
	</div>
	
		<!-- table -->
		<div class="table-responsive" style="padding-right: 5px;">

			<table id="table" class="table table-striped table-bordered table-hover " style="width:50%;" width="50%" cellpadding="0" cellspacing="0">
			    <thead>
			      <tr style="background-color: #1e7e34; color: #FFFFFF;">
			        <th width="1%"><center>No</center></th>
					<th><center>Name</center></th>
					<th width="1%"><center>Act</center></th>
			      </tr>
			    </thead>
			    <tbody>
				<?php
				$i = 1;
				foreach($data as $h) {		
				$user = $this->Tree_model->user2($h->User);  					
				?>
					<tr>
						<td align= "center"><?php echo $i++ ?></td>
						<td align= "center"><?php echo $user ;?></td>	
				        <td align= "center">
							<a href="<?php echo site_url('admin/deleteUser')?>/<?= $h->ID ?>" title="Delete" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-fw fa-window-close" style="color: #000000;"></i></a>
						</td>  
				    </tr>
				<?php } ?>
			    </tbody>
			 </table>
		</div>

</div>