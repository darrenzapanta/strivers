<?php

class LogoutController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->library('session');
   $this->load->helper('url');
   $this->load->library('session');
 }
 
 function index()
 {
 	$this->session->sess_destroy();	
 	$data['page'] = "login";
	$this->load->helper(array('form'));
	$this->load->view('templates/header2',$data);
	$this->load->view('login', $data);
	$this->load->view('templates/footer');
 }

}
 
?>
