<?php

class VerifyLogin extends CI_Controller {
 
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
 
   $this->form_validation->set_rules('username', 'Username', 'trim|required');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
 
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
     //Go to private area
    redirect('/landingController');
   }
 
 }
 
 function check_database($password)
 {
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('username');
 
   //query the database
   $result = $this->user->login($username, $password);
 
   if($result === true)
   {
     return TRUE;
   }
   else
   {
     $this->form_validation->set_message('check_database', 'Invalid username or password');
     return false;
   }
 }
}
?>
