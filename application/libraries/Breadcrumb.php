<?php
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');

	/**
	* Breadcrumb Class
	*
	* @package		Breadcrumb
	* @version		1.0
	* @author 		Matej Gleza <matejgleza@gmail.com>
	* @copyright 	Copyright (c) 2016, Matej Gleza
	* @link			https://github.com/Arthom/CodeIgniter-Breadcrumb
	*/

	class Breadcrumb {

		/**
		 * Breadcrumbs stack
		 *
		*/

		private $breadcrumbs = array();

		/**
		 * Constructor
		 *
		 * @access	public
		 *
		*/	

		public function __construct() {
			$this->ci =& get_instance();
			$this->ci->load->config('breadcrumb', true);

			$this->start = $this->ci->config->item('breadcrumb_open', 'breadcrumb');
			$this->end = $this->ci->config->item('breadcrumb_close', 'breadcrumb');

			$this->item_open = $this->ci->config->item('item_open', 'breadcrumb');
			$this->item_close = $this->ci->config->item('item_close', 'breadcrumb');
			$this->item_last = $this->ci->config->item('item_last', 'breadcrumb');

			$this->separator = $this->ci->config->item('separator', 'breadcrumb');
		}

		/**
		 * Append crumb to stack
		 *
		 * @access	public
		 * @param	string $page
		 * @param	string $href
		 * @return	void
		 *
		*/	

		public function add($title, $href){		
			if (!$title OR !$href)
				return;

			$this->breadcrumbs[] = array('title' => $title, 'href' => $href);
		}

		/**
		 * Generate breadcrumb
		 *
		 * @access  public
		 * @return  string
		*/

		public function show() {
			$out = '';
			if ($this->breadcrumbs) {
				$out = $this->start;

				foreach ($this->breadcrumbs as $key => $value) {
					if ($key)
						$out .= $this->separator;
					
					if ((count($this->breadcrumbs) - 1) == $key)
						$out .= $this->item_last.$value['title'];
					else
						$out .= $this->item_open.'<a href="'.$value['href'].'">'.$value['title'].'</a>';

					$out .= $this->item_close;
				}

				$out .= $this->end.PHP_EOL; 
			}
			return $out;
		}
	}
?>