<!DOCTYPE html>
<html>

    <head>
     <?php $this->load->view('themes/v2/head');?>
    </head>
    
    <body class="adminbody">
      <div id="main" class="forced enlarged">    
        <?php $this->load->view('themes/v2/header');?>
        <?php $this->load->view('themes/v2/sidebar');?>
        <?php $this->load->view('themes/v2/content');?>
        <?php $this->load->view('themes/v2/footer');?>
      </div>
        <?php $this->load->view('themes/v2/scripts');?>
    </body>

</html>