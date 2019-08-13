<div class="col-md-12">
	<?php echo form_open('',['autocomplete'=>'off']) ?>

	<div class="row">
	 <div class="col-lg-6" id="pic1">  
	  <div class="form-group">
	    <label>New User</label>
	     <?=form_error('user', '<span class="badge badge-danger">','</span>'); ?>
		   <select id="pic1" name="user" class="form-control" multiple="multiple" placeholder="Input User..">
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
	<a href="<?php echo site_url('admin/listFolder')?>" class="btn btn-md btn-info">BACK</a>
	<?php echo form_close() ?>
</div>