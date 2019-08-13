<div class="col-md-12">
	<?php echo form_open('',['autocomplete'=>'off']) ?>

	<div class="row">
	 <div class="col-lg-12">
	  <div class="form-group">
	    <label>Nama Parent</label>
	     <?=form_error('nm_parents', '<span class="badge badge-danger">','</span>'); ?>
	     <input type="text" name="nm_parents" class="form-control" value="<?= $data->Name ?>">
	  </div>
	 </div>
	</div>

	<div class="row">
	 <div class="col-lg-12">
	  <div class="form-group">
	    <label>Deskripsi</label>
	     <?=form_error('desc', '<span class="badge badge-danger">','</span>'); ?>
	     <input type="text" name="desc" class="form-control" value="<?= $data->Desc ?>">
	  </div>
	 </div>
	</div>

	<div></div>

	<button type="submit" class="btn btn-md btn-success">SAVE</button>
	<button type="reset" class="btn btn-md btn-danger">RESET</button>
	<a href="<?php echo site_url('admin/listFolder')?>" class="btn btn-md btn-info">BACK</a>
	<?php echo form_close() ?>
</div>