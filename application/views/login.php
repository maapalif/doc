<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="description" content="Login">
  <meta name="keywords" content="">
  <meta name="author" content="MIS-deddy">

  <link rel="shortcut icon" type="image/x-icon" href="<?=site_url('favicon.ico');?>" />

  <title><?=$title?> | <?=$this->config->item('app_name')?></title>
  <?php
    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    $this->session->set_userdata('hostname', $hostname);
  ?>

  <style>
      .login-form {
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
          var form = $(".login-form");
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
    <div class="login-form padding20 block-shadow">
        <?php
        if( ! isset( $on_hold_message ) )
        {
          if( isset( $login_error_mesg ) )
          {
            echo '
              <div style="border:1px solid red;">
                <p>
                  Login Error #' . $this->authentication->login_errors_count . '/' . config_item('max_allowed_attempts') . ': Invalid Username, Email Address, or Password.
                </p>
                <p>
                  Username, email address and password are all case sensitive.
                </p>
              </div>
            ';
          }

          if( $this->input->get('logout') )
          {
            echo '
              <div style="border:1px solid green">
                <p>
                  You have successfully logged out.
                </p>
              </div>
            ';
          }
        ?>
        <?=form_open($login_url, ['class' => 'std-form'])?>
            <h1 class="text-light">Login to service</h1>
            <hr class="thin"/>
            <br />
            <div class="input-control text full-size" data-role="input">
                <label for="login_string">User email/username/NIK:</label>
                <?=form_input('login_string','', array('id' => 'login_string', 'autocomplete' => 'off','maxlenght'=>'255', 'autofocus'=>'autofocus'))?>
                <button class="button helper-button clear"><span class="mif-cross"></span></button>
            </div>
            <br />
            <br />
            <div class="input-control password full-size" data-role="input">
                <label for="login_pass">User password:</label>
                <?=form_password('login_pass','',array('id' => 'login_pass','autocomplete' => 'off','onfocus' => 'this.removeAttribute("readonly");'))?>
                <button class="button helper-button reveal"><span class="mif-looks"></span></button>
            </div>
            <br />
            <br />
            <?php
              $link_protocol = USE_SSL ? 'https' : NULL;
            ?>
            <div class="form-actions">
                <?=form_submit('submit','Login to...',array('class' => 'button primary', 'id' => 'submit_button'))?>
                <a align="right" href="<?=site_url('home/recover', $link_protocol); ?>">
                  Can't access your account?
                </a>
            </div>
        <?=form_close()?>
        <?php
          }
          else
          {
            // EXCESSIVE LOGIN ATTEMPTS ERROR MESSAGE
            echo '
              <div style="border:1px solid red;">
                <h1 class="text-light">
                  Excessive Login Attempts
                </h1>
                <p>
                  You have exceeded the maximum number of failed login
                  attempts that this website will allow.
                <p>
                <p>
                  Your access to login and account recovery has been blocked for ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' minutes.
                </p>
                <p>
                  Please use the <a href="'.base_url().'home/recover">Account Recovery</a> after ' . ( (int) config_item('seconds_on_hold') / 60 ) . ' minutes has passed,
                  or contact us if you require assistance gaining access to your account.
                </p>
              </div>
            ';
          }
         ?>
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