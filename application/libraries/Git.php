<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Git {

	public function __construct() {
		$this->ci =& get_instance();
	}

	/**
	 * Get the hash of the current git HEAD
	 * @param str $branch The git branch to check
	 * @return mixed Either the hash or a boolean false
	 */
		
    public function get_current_git_commit( $branch='master' ) 
    {
		if ( $hash = file_get_contents( sprintf( FCPATH.'.git/refs/heads/%s', $branch ) ) ) 
		{
		   return $hash;
		} 
		else 
		{
		   return false;
		}
	}
}