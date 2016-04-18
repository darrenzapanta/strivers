<?php

class register extends CI_Controller {
 
 function __construct()
 {
   if($this->session->userdata('logged_in') == true && $this->session->userdata('type') != 'admin' ){

	}else{
	   parent::__construct();
	   $this->load->helper('url');
	   $this->load->library('session');
	}
 }
 
 function index()
 {
   $this->load->helper(array('form'));
   $this->load->view('header');
   $this->load->view('register');
   $this->load->view('footer');
}
 
}
 
?>