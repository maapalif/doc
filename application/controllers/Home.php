<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Author: MIS7102
 * @Date:   2018-11-21 09:02:02
 * @Last Modified by:   dpratama
 * @Last Modified time: 2019-01-15 10:54:31
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->is_logged_in();
	}

	public function login()
	{
		if(isset($this->auth_user_id)) redirect('home');
		// Method should not be directly accessible
		if( $this->uri->uri_string() == 'home/login')
			show_404();

		if( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' )
			$this->require_min_level(1);

		$this->setup_login_form();

		$data = array (
			'title' => 'Login',
		);

		$data['stylesheet'] = array(
			base_url('node_modules/metro-ui/build/css/metro.min.css'),
			base_url('node_modules/metro-ui/build/css/metro-schemes.min.css'),
			base_url('node_modules/metro-ui/build/css/metro-icons.min.css'),
			base_url('node_modules/metro-ui/build/css/metro-responsive.min.css')
		);

		$data['javascripts'] = array(
			base_url('node_modules/jquery/dist/jquery.min.js'),
			base_url('node_modules/metro-ui/build/js/metro.min.js')
		);

		$html = $this->load->view('login', $data, TRUE);
		echo $html;
	}

	public function logout()
	{
		$this->authentication->logout();

		// Set redirect protocol
		$redirect_protocol = USE_SSL ? 'https' : NULL;
		$this->session->sess_destroy();

		//redirect( site_url( LOGIN_PAGE . '?logout=1', $redirect_protocol ) );
		redirect( site_url( 'home', $redirect_protocol ) );
	}

	public function recover()
	{
		$view_data['stylesheet'] = array(
			base_url('node_modules/metro-ui/build/css/metro.min.css'),
			base_url('node_modules/metro-ui/build/css/metro-schemes.min.css'),
			base_url('node_modules/metro-ui/build/css/metro-icons.min.css'),
			base_url('node_modules/metro-ui/build/css/metro-responsive.min.css')
		);

		$view_data['javascripts'] = array(
			base_url('node_modules/jquery/dist/jquery.min.js'),
			base_url('node_modules/metro-ui/build/js/metro.min.js')
		);

		$view_data['title'] = 'Account Recovery';
		// Load resources
		$this->load->model('examples/examples_model');

		/// If IP or posted email is on hold, display message
		if( $on_hold = $this->authentication->current_hold_status( TRUE ) )
		{
			$view_data['disabled'] = 1;
		}
		else
		{
			// If the form post looks good
			if( $this->tokens->match && $this->input->post('email') )
			{
				if( $user_data = $this->examples_model->get_recovery_data( $this->input->post('email') ) )
				{
					// Check if user is banned
					if( $user_data->banned == '1' )
					{
						// Log an error if banned
						$this->authentication->log_error( $this->input->post('email', TRUE ) );

						// Show special message for banned user
						$view_data['banned'] = 1;
					}
					else
					{
						/*
						| Use the authentication libraries salt generator for a random string
						| that will be hashed and stored as the password recovery key.
						| Method is called 4 times for a 88 character string, and then
						| trimmed to 72 characters
						*/
						$recovery_code = substr( $this->authentication->random_salt()
								. $this->authentication->random_salt()
								. $this->authentication->random_salt()
								. $this->authentication->random_salt(), 0, 72 );

						// Update user record with recovery code and time
						$this->examples_model->update_user_raw_data(
							$user_data->user_id,
							[
								'passwd_recovery_code' => $this->authentication->hash_passwd($recovery_code),
								'passwd_recovery_date' => date('Y-m-d H:i:s')
							]
						);

						// Set the link protocol
						$link_protocol = USE_SSL ? 'https' : NULL;
						// Set URI of link
						$link_uri = 'home/recovery_verification/' . $user_data->user_id . '/' . $recovery_code;
						// send special_link
						$config = parse_ini_file(APPPATH . 'config/var/secure.ini', true);

						$mail = new PHPMailer(true);
						try {
						    //Server settings
						    //$mail->SMTPDebug = 2;                               // Enable verbose debug output
						    $mail->isSMTP();                                      // Set mailer to use SMTP
						    $mail->Host = $config['mail_host'];  				  // Specify main and backup SMTP servers
						    $mail->SMTPAuth = true;                               // Enable SMTP authentication
						    $mail->Username = $config['mail_uname'];              // SMTP username
						    $mail->Password = $config['mail_pwd'];                // SMTP password
						    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
						    $mail->Port = $config['mail_port'];                   // TCP port to connect to
						    $mail->Priority = null; 							  // 1=high 3=normal
							$mail->ContentType = 'text/html';
							$mail->SMTPOptions = array(
							    'ssl' => array(
							        'verify_peer' => false,
							        'verify_peer_name' => false,
							        'allow_self_signed' => true
							    )
							);

						    //Recipients
						    $user_email = explode("@", $user_data->email);

						    $mail->setFrom($config['mail_uname'], 'LPI');
							$mail->addAddress( $user_data->email );

						    //Content
						    $data = array(
						    	'main_view'		=>	'email/recovery',
						    	'user_name'		=>	$user_email[0],
						    	'special_link'	=>	site_url( $link_uri, $link_protocol ),
						    );
						    $message = $this->load->view('email/template',$data,true);

						    $mail->isHTML(true);                                  	// Set email format to HTML
						    $mail->Subject = 'Account Recovery';
						    $mail->Body =  $message;
						    $mail->CharSet = "utf-8";

						    $mail->send();
						    //echo 'Message has been sent';
						} catch (Exception $e) {
						    //echo 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
						}

						$view_data['confirmation'] = 1;
					}
				}
				// There was no match, log an error, and display a message
				else
				{
					// Log the error
					$this->authentication->log_error( $this->input->post('email', TRUE ) );

					$view_data['no_match'] = 1;
				}
			}
		}

		echo $this->load->view('recover_form', ( isset( $view_data ) ) ? $view_data : '', TRUE );
	}

	// --------------------------------------------------------------
	/**
	 * Verification of a user by email for recovery
	 *
	 * @param  int     the user ID
	 * @param  string  the passwd recovery code
	 */
	public function recovery_verification( $user_id = '', $recovery_code = '' )
	{
		$view_data['stylesheet'] = array(
			base_url('node_modules/metro-ui/build/css/metro.min.css'),
			base_url('node_modules/metro-ui/build/css/metro-schemes.min.css'),
			base_url('node_modules/metro-ui/build/css/metro-icons.min.css'),
			base_url('node_modules/metro-ui/build/css/metro-responsive.min.css')
		);

		$view_data['javascripts'] = array(
			base_url('node_modules/jquery/dist/jquery.min.js'),
			base_url('node_modules/metro-ui/build/js/metro.min.js')
		);

		$view_data['title'] = 'Account Recovery - Stage 2';

		/// If IP is on hold, display message
		if( $on_hold = $this->authentication->current_hold_status( TRUE ) )
		{
			$view_data['disabled'] = 1;
		}
		else
		{
			// Load resources
			$this->load->model('examples/examples_model');

			if(
				/**
				* Make sure that $user_id is a number and less
				* than or equal to 10 characters long
				*/
				is_numeric( $user_id ) && strlen( $user_id ) <= 10 &&

				/**
				* Make sure that $recovery code is exactly 72 characters long
				*/
				strlen( $recovery_code ) == 72 &&

				/**
				* Try to get a hashed password recovery
				* code and user salt for the user.
				*/
				$recovery_data = $this->examples_model->get_recovery_verification_data( $user_id ) )
			{
				/**
				* Check that the recovery code from the
				* email matches the hashed recovery code.
				*/
				if( $recovery_data->passwd_recovery_code == $this->authentication->check_passwd( $recovery_data->passwd_recovery_code, $recovery_code ) )
				{
					$view_data['user_id']       = $user_id;
					$view_data['username']      = $recovery_data->username;
					$view_data['recovery_code'] = $recovery_data->passwd_recovery_code;
				}

				// Link is bad so show message
				else
				{
					$view_data['recovery_error'] = 1;
					// Log an error
					$this->authentication->log_error('');
				}
			}

			// Link is bad so show message
			else
			{
				$view_data['recovery_error'] = 1;
				// Log an error
				$this->authentication->log_error('');
			}

			/**
			* If form submission is attempting to change password
			*/
			if( $this->tokens->match )
			{
				$this->examples_model->recovery_password_change();
			}
		}
		echo $this->load->view( 'choose_password_form', $view_data, TRUE );
	}
}