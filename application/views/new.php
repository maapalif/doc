<div class="col-md-12">
	<?php echo form_open('',['autocomplete'=>'off']) ?>

	<div class="row">
	 <div class="col-lg-12">
	  <div class="form-group">
	    <label>Nama Meeting</label>
	     <?=form_error('nm_act', '<span class="badge badge-danger">','</span>'); ?>
	     <input type="text" name="nm_meeting" class="form-control" placeholder="Input Meeting Name..">
	  </div>
	 </div>
	</div>

	<div class="row">
		<div class="col-sm-6">
		  <div class="form-group">
			<label> Hide This Meeting</label>
			  <select id="hidden" type="checkbox" name="hidden" value="1" class="form-control">
			  	<option value="1">YES</option>
			  	<option value="">NO</option>
			  </select>
			  <small id="passwordHelpInline" class="text-muted">
				*Choose "NO" if you want this meeting gonna show
			  </small>
			</label>
		  </div>
		</div>

		 <div class="col-lg-6" id="pic1">  
		  <div class="form-group">
		    <label>PIC</label>
		     <?=form_error('pic1[]', '<span class="badge badge-danger">','</span>'); ?>
			   <select id="pic1" name="pic1[]" class="form-control js-example-basic-multiple" multiple="multiple" placeholder="Input PIC..">
                <?php foreach($user as $h) { ?>
               <option value="<?php echo $h->username ?>">
                <?php echo $h->firstname." ".$h->middlename." ".$h->lastname ?></option>
                  <?php } ?>
              </select>
		  </div>
		 </div>
	</div>

	<div></div>

	<button type="submit" class="btn btn-md btn-success">SAVE</button>
	<button type="reset" class="btn btn-md btn-danger">RESET</button>
	<a href="<?php echo site_url('mom/')?>" class="btn btn-md btn-info">BACK</a>
	<?php echo form_close() ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#hidden').on("change", function(){
			if ($('#hidden').val() === '') {
				$('#pic1').attr("hidden", true);
			}
			else{
				$('#pic1').attr("hidden", false);
			}
		});
	});
</script>