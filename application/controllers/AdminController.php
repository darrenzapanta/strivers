<?php

class AdminController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('Globalsim','',TRUE);
   $this->load->model('User','',TRUE);
   if(!($this->ion_auth->in_group('superadmin'))){
      redirect('/LandingController');
   }
   $GLOBALS['data']['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname') ;
 }

 function addSimCard(){
   $this->load->library('form_validation');

   $this->form_validation->set_rules('global_name', 'Sim Card Name', 'trim|required|callback_checkglobalname|max_length[15]');
   $this->form_validation->set_rules('network', 'Network','trim|required|max_length[10]');
   $this->form_validation->set_rules('currentbalance', 'Current Balance', 'trim|numeric|required');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addsimcard');
     $this->load->view('templates/footer');
   }
   else
   {
     $global_name = $this->input->post('global_name');
     $network = $this->input->post('network');
     $currentbalance = $this->input->post('currentbalance');
     $data = array(
              'global_name' => $global_name,
              'network' => $network,
              'current_balance' => $currentbalance,
              );

     $ret = $this->Globalsim->addSimCard($data);
     if($ret === false){
         $this->session->set_flashdata('message', 'Error has occured.');
     }else{
         $this->session->set_flashdata('message', 'Added Successfully.');
     }
    redirect('/landingController/addsimcard');
   }
 }

 function editSim(){
   $this->load->library('form_validation');

   $this->form_validation->set_rules('global_name', 'Sim Card Name', 'trim|required|callback_checkglobalnameifexist|max_length[15]');
   $this->form_validation->set_rules('network', 'Network','trim|required|max_length[10]');
   $this->form_validation->set_rules('balance', 'Current Balance', 'trim|numeric|required');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.
      header('Content-type: application/json');
      $response_array['status'] = 'failed';    
      $response_array['message'] = validation_errors();
      echo json_encode($response_array);
   }
   else
   {
     $global_name = $this->input->post('global_name');
     $network = $this->input->post('network');
     $currentbalance = $this->input->post('balance');
     $data = array(
              'network' => $network,
              'current_balance' => $currentbalance,
              );

     $ret = $this->Globalsim->editSimCard($data, $global_name);
     if($ret === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        $response_array['message'] = 'Error has occurred.'; 
        echo json_encode($response_array);
     }else{
        header('Content-type: application/json');
        $response_array['status'] = 'success';    
        $response_array['message'] = 'Edited Successfully.';  
        echo json_encode($response_array);
     }
    }
 }

  function deleteSim(){
   $global_name = $this->input->post('global_name');
   $ret = $this->Globalsim->deleteSimCard($global_name);
     if($ret === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        echo json_encode($response_array);
     }else{
        header('Content-type: application/json');
        $response_array['status'] = 'success';    
        echo json_encode($response_array);
     }
 }

  function addUser()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_check_user');
   $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
   $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]'); 
   $this->form_validation->set_rules('type', 'Type', 'trim|required|callback_check_type');   
   $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'trim|required|matches[password]'); 

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addUser');
     $this->load->view('templates/footer');
   }
   else
   {
     $username = $this->input->post('username');
     $firstname = $this->input->post('firstname');
     $lastname = $this->input->post('lastname');
     $password = $this->input->post('password');
     $type[] = $this->input->post('type');
     $data = array(
        'last_name' => $lastname,
        'first_name' => $firstname,
      );
     $ret = $this->ion_auth->register($username, $password, 'test@yahoo.com', $data, $type);
     if($ret == true){
      $this->session->set_flashdata('message', 'Registered Successfully.');
     }else{
      $this->session->set_flashdata('message', 'Error has occurred. Try again.'); 
     }
     redirect('/landingController/addUser');
   }
 
 }
 
  function check_user($username){
 
   //query the database
   $result = $this->User->getUser($username);
   if($result == false){
    return true;
   }else{
    $this->form_validation->set_message('check_user', 'Username already exist.');
    return false;
   }
 }

 function getBalance()
 {
   $global_name = $this->input->post('global_name');
   $currentBalance = $this->globalSim->getCurrentBalance($global_name);
   if($currentBalance === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        echo json_encode($response_array);
     }else{
        header('Content-type: application/json');
        $response_array['status'] = $currentBalance;
        echo json_encode($response_array);
     }
 }

 function checkglobalname($global_name){
  if($this->Globalsim->getSimByName($global_name) == false){
    return true;
  }else{
    $this->form_validation->set_message('checkglobalname', 'Duplicate Sim Card Name.');
    return false;
  }
 }

  function checkglobalnameifexist($global_name){
  if($this->Globalsim->getSimByName($global_name) == false){
    $this->form_validation->set_message('checkglobalnameifexist', 'Sim Card does not exist');
    return false;
  }else{
    
    return true;
  }
 }

 function check_type($type){
  if($type > 1 && $type < 6){
    return true;
  }else{
    $this->form_validation->set_message('check_type', 'Invalid Type.');
  }
 }







 
}
 
?>
