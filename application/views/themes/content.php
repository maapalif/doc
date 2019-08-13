<div class="content-page" style="margin-left: 0px;">
	
		<!-- Start content -->
        <div class="content">
            
			<div class="container-fluid">

					
							<div class="row">
									<div class="col-xl-12">
											<div class="breadcrumb-holder">
													<h1 class="main-title float-left"><?=$title?>
													</h1>
                    								<?=$this->breadcrumb->show();?>					
													<div class="clearfix"></div>
											</div>
									</div>
							</div>
							<!-- end row -->

							
							<div class="row">
									<div class="col-xl-12">									
									<?php $this->load->view('themes/flash_view');?>
        							<?php $this->load->view($main_view);?>
									</div>
							</div>



            </div>
			<!-- END container-fluid -->

		</div>
		<!-- END content -->

</div><!-- END content-page -->