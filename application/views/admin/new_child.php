<div class="col-md-12">
	<?php echo form_open('',['autocomplete'=>'off']) ?>

	<div class="row">
	 <div class="col-lg-12">
	  <div class="form-group">
	    <label>Nama Parent</label>
	     <?=form_error('nm_parents', '<span class="badge badge-danger">','</span>'); ?>
	     	<select class="form-control select2 custom-select d-block my-3" required id="departement" name="nm_parents">
				<option value="" disabled selected>--pilih--</option>
				<?php foreach ($parents as $h) : ?>
					<option value="<?= $h->ID; ?>"><?= $h->ParentsName; ?></option>";
				<?php endforeach; ?>
			</select>
	  </div>
	 </div>
	</div>

	<div class="row">
	 <div class="col-lg-12">
	  <div class="form-group">
	    <label>Nama Child</label>
	     <?=form_error('nm_parents', '<span class="badge badge-danger">','</span>'); ?>
	     <input type="text" name="nm_child" class="form-control" placeholder="Input Parents Folder Name..">
	  </div>
	 </div>
	</div>

	<div></div>

	<button type="submit" class="btn btn-md btn-success">SAVE</button>
	<button type="reset" class="btn btn-md btn-danger">RESET</button>
	<a href="<?php echo site_url('admin/')?>" class="btn btn-md btn-info">BACK</a>
	<?php echo form_close() ?>
</div>