<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - Recover Form View
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2017, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */
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
  <title><?=$title;?> | <?=$this->config->item('app_name');?></title>
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
      if( isset( $disabled ) )
      {
        echo '
          <div style="border:1px solid red;">
            <h1 class="text-light">
              Account Recovery is Disabled.
            </h1>
            <p>
              If you have exceeded the maximum login attempts, or exceeded
              the allowed number of password recovery attempts, account recovery
              will be disabled for a short period of time.
              Please wait ' . ( (int) config_item('seconds_on_hold') / 60 ) . '
              minutes, or contact us if you require assistance gaining access to your account.
            </p>
          </div>
        ';
      }
      else if( isset( $banned ) )
      {
        echo '
          <div style="border:1px solid red;">
            <h1 class="text-light">
              Account Locked.
            </h1>
            <p>
              You have attempted to use the password recovery system using
              an email address that belongs to an account that has been
              purposely denied access to the authenticated areas of this website.
              If you feel this is an error, you may contact us
              to make an inquiry regarding the status of the account.
            </p>
          </div>
        ';
      }
      else if( isset( $confirmation ) )
      {
        echo '
          <div style="border:1px solid green;">
            <p>
              Congratulations, you have created an account recovery link.
            </p>
            <p>
              "We have sent you an email with instructions on how
              to recover your account."
            </p>
            <p>
              <b>Please note</b>: The account recovery link would normally be placed in an email,
              and you would not see it here on the screen.
            </p>
          </div>
        ';
      }
      else if( isset( $no_match ) )
      {
        echo '
          <div  style="border:1px solid red;">
            <p class="feedback_header">
              Supplied email did not match any record.
            </p>
          </div>
        ';

        $show_form = 1;
      }
      else
      {
        echo '
          <p>
            If you\'ve forgotten your password and/or username,
            enter the email address used for your account,
            and we will send you an e-mail
            with instructions on how to access your account.
          </p>
        ';

        $show_form = 1;
      }
      if( isset( $show_form ) )
      {
        ?>
        <?=form_open()?>
            <h1 class="text-light">Enter your email:</h1>
            <hr class="thin"/>
            <br />
            <div class="input-control text full-size" data-role="input">
                <?=form_label('Email Address','email', ['for'=>'email'] ); ?>
                <input type="email" name="email" id="email" class="" maxlength="255" required />
                <button class="button helper-button clear"><span class="mif-cross"></span></button>
            </div>
            <div class="form-actions">
                <?=form_submit('submit','Submit',array('class' => 'button primary', 'id' => 'submit_button'))?>
            </div>
        <?=form_close()?>
        <?php } ?>
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