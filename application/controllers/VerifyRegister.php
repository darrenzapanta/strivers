<?php

class VerifyRegister extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->model('user','',TRUE);
   $this->load->helper('url');
 }
 
 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_check_database');
   $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
   $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
   $this->form_validation->set_rules('password', 'Password', 'trim|required');	
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
     $data['page'] = 'login';
     $this->load->view('templates/header2', $data);
     $this->load->view('login');
     $this->load->view('templates/footer');
   }
   else
   {
     $username = $this->input->post('username');
     $firstname = $this->input->post('firstname');
     $lastname = $this->input->post('lastname');
     $password = $this->input->post('password');
     $data = array(
     		'username' => $username,
     		'lastname' => $lastname,
     		'firstname' => $firstname,
     		'password' => MD5($password),
     		'type' => 'user'
     	);
     $ret = $this->user->register($data);
     if($ret == true){
     	$this->session->set_flashdata('message', 'Registered Successfully.');
     }else{
     	$this->session->set_flashdata('message', 'Error has occurred. Try again.');	
     }
     $this->load->view('templates/header2');
     $this->load->view('login');
     $this->load->view('templates/footer');
   }
 
 }
 
 function check_database($username)
 {
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('username');
 
   //query the database
   $result = $this->user->getUser($username);
 
   if($result != false)
   {
   	 $this->form_validation->set_message('check_database', 'Username already exist.');
     return false;

   }
   else
   {
     
     return true;
   }
 }
}
?>
