<?php
  defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="MIS-deddy">
  <link rel="shortcut icon" type="image/x-icon" href="<?=site_url('favicon.ico');?>" />
  <title><?=$title?> | <?=$this->config->item('app_name')?></title>
  <?php
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $this->session->set_userdata('hostname', $hostname);
  ?>

  <style>
      .recovery-form {
          width: 25rem;
          /*height: 18.75rem;*/
          position: fixed;
          top: 50%;
          margin-top: -9.375rem;
          left: 50%;
          margin-left: -12.5rem;
          background-color: #ffffff;
          opacity: 0;
          -webkit-transform: scale(.8);
          transform: scale(.8);
      }
  </style>
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
  <?php
    if( isset( $javascripts ) )
    {
      foreach( $javascripts as $js )
      {
        echo '<script src="' . $js . '"></script>' . "\n";
      }
    }
    if( isset( $final_head ) )
    {
      echo $final_head;
    }
  ?>
  <script>
      $( document ).ready(function() {
          var form = $(".recovery-form");
          form.css({
              opacity: 1,
              "-webkit-transform": "scale(1)",
              "transform": "scale(1)",
              "-webkit-transition": ".5s",
              "transition": ".5s"
          });
      });
  </script>
</head>
<body class="bg-darkTeal">
    <div class="recovery-form padding20 block-shadow">
      <?php
      $showform = 1;
      if( isset( $validation_errors ) )
      {
        echo '
          <div style="border:1px solid red">
            <p>
              ' . $validation_errors . '
            </p>
          </div>
        ';
      }
      else
      {
        $display_instructions = 1;
      }

      if( isset( $validation_passed ) )
      {
        echo '
          <div style="border:1px solid green;">
            <p>
              You have successfully changed your password.
            </p>
            <p>
              You can now <a href="'.base_url() . LOGIN_PAGE . '">login</a>
            </p>
          </div>
        ';

        $showform = 0;
      }
      if( isset( $recovery_error ) )
      {
        echo '
          <div style="border:1px solid red;">
            <h1 class="text-light">
              No usable data for account recovery.
            </h1>
            <p>
              Account recovery links expire after
              ' . ( (int) config_item('recovery_code_expiration') / ( 60 * 60 ) ) . '
              hours.<br />You will need to use the
              <a href="/examples/recover">Account Recovery</a> form
              to send yourself a new link.
            </p>
          </div>
        ';

        $showform = 0;
      }
      if( isset( $disabled ) )
      {
        echo '
          <div style="border:1px solid red;">
            <h1 class="text-light">
              Account recovery is disabled.
            </h1>
            <p>
              You have exceeded the maximum login attempts or exceeded the
              allowed number of password recovery attempts.
              Please wait ' . ( (int) config_item('seconds_on_hold') / 60 ) . '
              minutes, or contact us if you require assistance gaining access to your account.
            </p>
          </div>
        ';

        $showform = 0;
      }
      if( $showform == 1 )
      {
        if( isset( $recovery_code, $user_id ) )
        {
          if( isset( $display_instructions ) )
          {
            if( isset( $username ) )
            {
              echo '<p>
                Your login user name is <i>' . $username . '</i><br />
                Please write this down, and change your password now:
              </p>';
            }
            else
            {
              echo '<p>Please change your password now:</p>';
            }
          }

        ?>
        <?=form_open()?>
            <h1 class="text-light">Step 2 - Choose your new password</h1>
            <hr class="thin"/>
            <br />
            <div class="input-control text full-size" data-role="input">
                <?=form_label('Password','passwd', ['class'=>'form_label']); ?>
                <?php $input_data = [
                          'name'         => 'passwd',
                          'id'           => 'passwd',
                          'class'        => 'form_input password',
                          'max_length'   => config_item('max_chars_for_password'),
                          'required'      => 'required'
                        ];
                ?>
                <?=form_password($input_data)?>
                <button class="button helper-button clear"><span class="mif-cross"></span></button>
            </div>
            <br />
            <br />
            <div class="input-control password full-size" data-role="input">
              <?=form_label('Confirm Password','passwd_confirm', ['class'=>'form_label']);?>
              <?php $input_data = [
                        'name'       => 'passwd_confirm',
                        'id'         => 'passwd_confirm',
                        'class'      => 'form_input password',
                        'max_length' => config_item('max_chars_for_password'),
                        'required'    => 'required'
                      ];
                ?>
                <?=form_password($input_data);?>
                <button class="button helper-button reveal"><span class="mif-looks"></span></button>
            </div>
            <div class="form-actions">
                <?=form_hidden('recovery_code',$recovery_code)?>
                <?=form_hidden('user_identification',$user_id)?>
                <?=form_submit('submit','Submit',array('class' => 'button primary', 'id' => 'submit_button'))?>
            </div>
        <?=form_close()?>
        <?php
      }
    }?>
    </div>
</body>
<script>
  if (window.location.hostname !== 'localhost') {
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
              m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-90641615-1', 'auto');
      ga('send', 'pageview');
  }
</script>
</html>