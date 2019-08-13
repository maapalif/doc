		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>Minutes of Meeting</title>
		<meta name="description" content="Free Bootstrap 4 Admin Theme | Pike Admin">
		<meta name="author" content="Pike Web Development - https://www.pikephp.com">

		<!-- Favicon -->
		<link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/favicon.ico">

		<!-- Switchery css -->
		<link href="<?php echo base_url() ?>assets/plugins/switchery/switchery.min.css" rel="stylesheet" />
		
		<!-- Bootstrap CSS -->
		<link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		
		<!-- Font Awesome CSS -->
		<link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
		
		<!-- Custom CSS -->
		<link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet" type="text/css" />	
		
		<!-- BEGIN CSS for this page -->
		 <?php
    	if( isset( $stylesheet ) )
    	{
        	foreach( $stylesheet as $css )
        	{
        		echo '<link href="' . $css . '" type="text/css" rel="stylesheet" media="screen,projection">' . "\n";
        	}
    	}
    	if( isset( $custom_style ) )
    	{
       		echo '<style rel="stylesheet">' . $custom_style . '</style>';
    	}
  		?>
		<!-- END CSS for this page -->
		<script src="<?php echo base_url() ?>assets/js/jquery.min.js"></script>
				