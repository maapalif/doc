<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js"></script>

<script src="<?php echo base_url() ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>

<script src="<?php echo base_url() ?>assets/js/detect.js"></script>
<script src="<?php echo base_url() ?>assets/js/fastclick.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url() ?>assets/plugins/switchery/switchery.min.js"></script>

<!-- App js -->
<script src="<?php echo base_url() ?>assets/js/pikeadmin.js"></script>

<!-- BEGIN Java Script for this page -->
<?php
        if( isset( $javascripts ) )
        {
            foreach( $javascripts as $js )
            {
            echo '<script src="' . $js . '"></script>' . "\n";
            }
        }
        if( isset( $final_script ) )
        {
            echo '<script type="text/javascript">' . $final_script. '</script>';
        }
?>
<!-- END Java Script for this page -->