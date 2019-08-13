<div class="container" style="margin-top: 5px; margin-right: 0px; margin-left: 0px; max-width: 100%; font-size: 11.5px; ">

<div>
<a role="button" href="<?php echo site_url('mom/newMeeting')?>" class="btn btn-primary"><span class="btn-label"><i class="fa fa-plus"></i></span>New Meeting</a>
<p><br/></p>
</div>

	<div class="row">
		<?php 
		foreach ($meeting->result() as $h) :
		?>
			<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card-box noradius noborder bg-default">
							<a href="<?php echo site_url('mom/listIndex')?>/<?= $h->MeetingID?>"><i class="fa fa-file-text-o float-right text-white"></i></a>
							<h6 class="text-white text-uppercase m-b-20"><?= $h->MeetingName?></h6>
							<h1 class="m-b-20 text-white counter"><?php echo $this->Topic_model->count($h->MeetingID);?></h1>
							<h6 class="text-white">TOPICS</h6>
							<h8><a href="<?php echo site_url('mom/deleteIndex')?>/<?= $h->MeetingID?>" title="Delete Meeting" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-sm fa-window-close text-white" style="font-size: 20px;"></i></a></h8>
					</div>
			</div>

		<?php endforeach; ?>

		<?php 
		$query1 = $this->Topic_model->getMeeting1($auth_username);
		foreach ($query1->result() as $y) :
		?>
			<div class="col-xs-12 col-md-6 col-lg-6 col-xl-3">
					<div class="card-box noradius noborder bg-default">
							<a href="<?php echo site_url('mom/listIndex')?>/<?= $h->MeetingID?>"><i class="fa fa-file-text-o float-right text-white"></i></a>
							<h6 class="text-white text-uppercase m-b-20"><?= $y->MeetingName?></h6>
							<h1 class="m-b-20 text-white counter"><?php echo $this->Topic_model->count($y->MeetingID);?></h1>
							<h6 class="text-white">TOPICS</h6>
							<h8><a href="<?php echo site_url('mom/deleteIndex')?>/<?= $y->MeetingID?>" title="Delete Meeting" onclick="return confirm('Are you sure you want to delete?')"><i class="fa fa-sm fa-window-close text-white" style="font-size: 20px;"></i></a></h8>
							<h8><a role="button" href="#" title="Info user yang menerima hak akses" onclick="return confirm ('List users can access : <?php echo $y->PIC; ?>')"><i class="fa fa-sm fa-vcard text-white" style="font-size: 20px;"></i></a></h8>
					</div>
			</div>

		<?php endforeach; ?>

	</div>

<!-- Small modal -->
	

	
	<!-- end row -->

<div>