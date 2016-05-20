<?php

class DspController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('dsp','',TRUE);
   $this->load->model('Am','',TRUE);
   $this->load->model('Globalsim','',TRUE);
   $this->load->model('Operations','',TRUE);
   if(!($this->session->userdata('logged_in') == true)){
      $this->load->view('errors/index');
   }
   $GLOBALS['data']['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname') ;
 }

 function index(){
   $GLOBALS['data']['dss'] = $this->dss->getAllDSS();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('adddsp', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }
 
 function addDSP()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('dealerno', 'Dealer No', 'trim|required|callback_check_dealerno');
   $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
   $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
   $this->form_validation->set_rules('birthday', 'Date of Birth', 'trim|required');
   $this->form_validation->set_rules('email', 'E-mail', 'trim');
   $this->form_validation->set_rules('contactno', 'Contact Number', 'trim');
   $this->form_validation->set_rules('sim', 'Sim', 'trim|required|callback_check_sim');
   $this->form_validation->set_rules('am', 'Area Manager', 'trim|required|callback_check_am');
   $this->form_validation->set_rules('percentage', 'Percentage', 'trim|numeric|required');
   $this->form_validation->set_rules('balance', 'Balance', 'trim|numeric|required');
   
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.
     $GLOBALS['data']['page'] = "adddsp";
     $GLOBALS['data']['am'] = $this->Am->getAllAM();
     $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('adddsp');
     $this->load->view('templates/footer');
   }
   else
   {
     $firstname = $this->input->post('firstname');
     $lastname = $this->input->post('lastname');
     $sim = $this->input->post('sim');
     $email = $this->input->post('email');
     $contactno = $this->input->post('contactno');
     $birthday = $this->input->post('birthday');
     $dealerno = $this->input->post('dealerno');
     $temp_percentage = $this->input->post('percentage');
     $balance = $this->input->post('balance');
     $am = $this->input->post('am');
     $gender = $this->input->post('gender');
     $percentage = $this->Operations->convertPercentToFraction($temp_percentage);
     $data = array(
               'dsp_firstname' => $firstname,
               'dsp_lastname' => $lastname,
               'dsp_birthday' => $birthday,
               'dsp_email' => $email,
               'am_code' => $am,
               'dsp_gender' => $gender
               );
     $data2 =  array(
                    'dsp_network' => $sim,
                    'dsp_dealer_no' => $dealerno,
                    'dsp_percentage' => $percentage,
                    'dsp_balance' => $balance,
                    'dsp_contactno' => $contactno
                 );
     $ret = $this->dsp->addDSP($data, $data2);
     if($ret === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        echo json_encode($response_array);
     }else{
        header('Content-type: application/json');
        $response_array['status'] = 'success';    
        echo json_encode($response_array);
     }
    $this->session->set_flashdata('message', 'Added Successfully.');
    redirect('/landingController/addDSP');
      }
   }


function check_sim($sim){
  if($this->Globalsim->getSimbyName($sim) != false){
    return true;

  }else{ 
    $this->form_validation->set_message('check_sim', 'Invalid Sim');
    return false;
  }
 }

 function check_dealerno($dealerno){
    if(isset($_POST['dsp_id'])){
      $dsp_id =$this->input->post('dsp_id');
      $result = $this->dsp->getDSPbyDealerno($dealerno);
      if($result != false){
        foreach ($result as $res){
          if($res->dsp_id == $dsp_id){
            return true;
          }else{
            $this->form_validation->set_message('check_dealerno', 'Duplicate Dealer Number.');
            return false;       
          }
        }
      }else{
        return true;
      }
    }else{
      if($this->dsp->checkDealerNo($dealerno))
        return true;
      else{
        $this->form_validation->set_message('check_dealerno', 'Duplicate Dealer Number.');
        return false;
      }
    }
 }

 function check_dsp_id($dsp_id){
  if($this->dsp->getDSPbyID($dsp_id) != false){
    return true;
  }else{
    $this->form_validation->set_message('check_dsp_id', 'DSP not found.');
    return false;
  }
 }

 function check_am($am){
  if($am == null){
   return true;
  }
  if($this->Am->getAMbyCode($am) == false){
    $this->form_validation->set_message('check_am', 'Invalid Area Manager.');
    return false;
  }else{
    return true;
  }
 }


 function deleteDSP()
 {
   if($this->session->userdata('type') == 'admin'){
     $dsp_id = $this->input->post('dsp_id');
     $ret = $this->dsp->deleteDSP($dsp_id);
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
 }

 function editDSP2()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
   $this->form_validation->set_rules('dsp_id', 'DSP ID', 'trim|required|callback_check_dsp_id');
   $this->form_validation->set_rules('dealerno', 'Dealer No', 'trim|required|callback_check_dealerno');
   $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
   $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
   $this->form_validation->set_rules('birthday', 'Date of Birth', 'trim|required');
   $this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email');
   $this->form_validation->set_rules('contactno', 'Contact Number', 'trim');
   $this->form_validation->set_rules('sim', 'Sim', 'trim|required|callback_check_sim');
   $this->form_validation->set_rules('am', 'Area Manager', 'trim|required|callback_check_am');
   $this->form_validation->set_rules('percentage', 'Percentage', 'trim|numeric');
   $this->form_validation->set_rules('balance', 'Balance', 'trim|numeric');
   
   if($this->form_validation->run() == FALSE)
   {
      header('Content-type: application/json');
      $response_array['status'] = 'failed';    
      $response_array['message'] = validation_errors();
      echo json_encode($response_array);

   }
   else
   {
     $dsp_id =$this->input->post('dsp_id');
     $firstname = $this->input->post('firstname');
     $lastname = $this->input->post('lastname');
     $sim = $this->input->post('sim');
     $email = $this->input->post('email');
     $contactno = $this->input->post('contactno');
     $birthday = $this->input->post('birthday');
     $dealerno = $this->input->post('dealerno');
     $temp_percentage = $this->input->post('percentage');
     $balance = $this->input->post('balance');
     $am = $this->input->post('am');
     $gender = $this->input->post('gender');
     $percentage = $this->Operations->convertPercentToFraction($temp_percentage);
     $data = array(
               'dsp_firstname' => $firstname,
               'dsp_lastname' => $lastname,
               'dsp_birthday' => $birthday,
               'dsp_email' => $email,
               'am_code' => $am,
               'dsp_gender' => $gender
               );
     if($this->session->userdata('type') == 'admin'){
     $data2 =  array(
                    'dsp_network' => $sim,
                    'dsp_dealer_no' => $dealerno,
                    'dsp_percentage' => $percentage,
                    'dsp_balance' => $balance,
                    'dsp_contactno' => $contactno
                 );
      }else{
     $data2 =  array(
                    'dsp_network' => $sim,
                    'dsp_dealer_no' => $dealerno,
                    'dsp_percentage' => $percentage,
                    'dsp_contactno' => $contactno        
      }
     $ret = $this->dsp->editDSP($data, $data2, $dsp_id);
       if($ret === false){
          header('Content-type: application/json');
          $response_array['status'] = 'failed';    
          $response_array['message'] = 'Error has Occurred.';
          echo json_encode($response_array);
       }else{
          header('Content-type: application/json');
          $response_array['status'] = 'success'; 
          $response_array['message'] = 'Edited Successfully';   
          echo json_encode($response_array);
       } 
    }
   }
 }
?>
