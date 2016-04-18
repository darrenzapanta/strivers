<?php

class DspController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('dsp','',TRUE);
   $this->load->model('dss','',TRUE);
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
   $this->form_validation->set_rules('network', 'Network', 'trim|required|callback_check_network');
   $this->form_validation->set_rules('dss', 'DSS', 'trim|callback_check_dss');
   $this->form_validation->set_rules('percentage', 'Percentage', 'trim|numeric');
   $this->form_validation->set_rules('balance', 'Balance', 'trim|numeric');
   
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.
     $GLOBALS['data']['page'] = "adddsp";
     $GLOBALS['data']['dss'] = $this->dss->getAllDSS();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('adddsp');
     $this->load->view('templates/footer');
   }
   else
   {
     $firstname = $this->input->post('firstname');
     $lastname = $this->input->post('lastname');
     $network = $this->input->post('network');
     $email = $this->input->post('email');
     $contactno = $this->input->post('contactno');
     $birthday = $this->input->post('birthday');
     $dealerno = $this->input->post('dealerno');
     $percentage = $this->input->post('percentage');
     $balance = $this->input->post('balance');
     $dss = $this->input->post('dss');
     $gender = $this->input->post('gender');
      $data = array(
               'dsp_firstname' => $firstname,
               'dsp_lastname' => $lastname,
               'dsp_birthday' => $birthday,
               'dsp_email' => $email,
               'dss_id' => $dss,
               'dsp_gender' => $gender
               );
     $data2 =  array(
                    'dsp_network' => $network,
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

function check_network($network){
  if($network == "sun" || $network == "smart"){
    return true;
  }else{
   $this->form_validation->set_message('check_network', 'Invalid Network.');
   return false;
  }
 }

 function check_dealerno($dealerno){
    if($this->dsp->checkDealerNo($dealerno))
      return true;
    else{
      $this->form_validation->set_message('check_dealerno', 'Duplicate Dealer Number.');
      return false;
    }
 }

 function check_dss($dss){
  if($dss == null){
   return true;
  }
  if($this->dss->getDSSbyID($dss) == false){
    $this->form_validation->set_message('check_dss', 'Invalid DSS.');
    return false;
  }else{
    return true;
  }
 }

 function editDSP()
 {
     $firstname = $this->input->post('firstname');
     $lastname = $this->input->post('lastname');
     $network = $this->input->post('network');
     $email = $this->input->post('email');
     $contactno = $this->input->post('contactno');
     $birthday = $this->input->post('birthday');
     $dealerno = $this->input->post('dealerno');
     $percentage = $this->input->post('percentage');
     $balance = $this->input->post('balance');
     $dss = $this->input->post('dss');
     $dsp_id =$this->input->post('dsp_id');
     $gender = $this->input->post('gender');
      $data = array(
               'dsp_firstname' => $firstname,
               'dsp_lastname' => $lastname,
               'dsp_birthday' => $birthday,
               'dsp_email' => $email,
               'dss_id' => $dss,
               'dsp_gender' => $gender,
               );
     $data2 =  array(
                    'dsp_network' => $network,
                    'dsp_dealer_no' => $dealerno,
                    'dsp_percentage' => $percentage,
                    'dsp_balance' => $balance,
                    'dsp_contactno' => $contactno
                 );
     $ret = $this->dsp->editDSP($data, $data2, $dsp_id);
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

 function deleteDSP()
 {
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

 function assignDSStoDSP()
 {

 }


 
}
 
?>
