<?php

class UserController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('User','',TRUE);
   if(!($this->ion_auth->logged_in() == true)){
      redirect('/login');
   }
    $GLOBALS['data']['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname') ;
 }

 function editAccount(){
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_check_user');
   $this->form_validation->set_rules('oldpassword', 'Old Password', 'trim|callback_check_password'); 
   $this->form_validation->set_rules('password', 'Password', 'trim|min_length[5]');  
   $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|matches[password]'); 

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('editAccount');
     $this->load->view('templates/footer');
   }
   else
   {
     $user = $this->ion_auth->user()->row();
     $id = $user->id;
     $username = $this->input->post('username');
     $password = $this->input->post('password');

     if(isset($_POST['password']) && $_POST['password'] != "" ){
     $data = array(
        'username' => $username,
        'password' => $password,
      );
     }else{
	     $data = array(
	        'username' => $username,
	      );     	
     }

     $ret = $this->ion_auth->update($id, $data);
     if($ret == true){
      $this->session->set_flashdata('message', 'Edited Successfully.');
      $this->session->set_userdata('username', $username);
     }else{
      $this->session->set_flashdata('message', 'Error has occurred. Try again.'); 
     }
     redirect('/landingController/editAccount');
   }
 }


  function check_user($username){
   $user = $this->ion_auth->user()->row();
   if($this->ion_auth->identity_check($username) == FALSE || $user->username == $username){
    return true;
   }else{
      $this->form_validation->set_message('check_user', 'Username already exist.');
      return false;
   }
 }

 function check_password($password){
     $user = $this->ion_auth->user()->row();
     $id = $user->id;
  if($password != ""){

    if($this->ion_auth->hash_password_db($id, $password)){
      return true;
   	}else{
      $this->form_validation->set_message('check_password', 'Old Password doesn\'t match');
      return false;
    }
  }
}

 

 
}
 
?>