<!DOCTYPE html>
<html>

    <head>
     <?php $this->load->view('themes/head');?>
    </head>
    
    <body class="adminbody">
      <div id="main" class="forced">    
        <?php $this->load->view('themes/header');?>
        <?php $this->load->view('themes/content');?>
        <?php $this->load->view('themes/footer');?>
      </div>
        <?php $this->load->view('themes/scripts');?>
    </body>

</html>