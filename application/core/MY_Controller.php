<?php

class My_Controller extends CI_Controller
{
	var $user = FALSE;
	// layout functionality
	protected $layout_view = 'application';
	protected $content_view = '';
	protected $view_data = array();

	function __construct()
	{
		parent::__construct();
		$this->user = $this->session->userdata('user_id') ? User::find_by_id($this->session->userdata('user_id')) : FALSE;
		$this->setting = Setting::find(1);
		$this->register = $this->session->userdata('register') ? $this->session->userdata('register') : FALSE;
		date_default_timezone_set($this->setting->timezone);
		$this->session->set_userdata('lang', $this->setting->language);
		$lang = $this->session->userdata("lang") == null ? "english":$this->session->userdata("lang");
		$this->lang->load($lang, $lang);
	}

	public function tz_list() {
	  $zones_array = array();
	  $timestamp = time();
	  foreach(timezone_identifiers_list() as $key => $zone) {
	    $zones_array[$key]['zone'] = $zone;
	    $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
	  }
	  return $zones_array;
	}

	public function _output($output)
	{
		// set the default content view
		if($this->content_view !== FALSE && empty($this->content_view)) $this->content_view = $this->router->class . '/' . $this->router->method;
		//render the content view
		$yield = file_exists(APPPATH . 'views/' . $this->content_view . EXT) ? $this->load->view($this->content_view, $this->view_data, TRUE) : FALSE;

		//render the layout
		if($this->layout_view){
			$this->view_data['yield'] = $yield;
			echo $this->load->view('layouts/' . $this->layout_view, $this->view_data, TRUE);
		}else
			echo $yield;

		echo $output;

	}

}
