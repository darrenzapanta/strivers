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
 }

 function index(){
   $data['dss'] = $this->dss->getAllDSS();
   $this->load->view('templates/header');
   $this->load->view('DSPPanel', $data);
   $this->load->view('templates/footer');
 }
 
 function addDSP()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('dealer_no', 'Dealer No', 'trim|required');
   $this->form_validation->set_rules('full_name', 'Name', 'trim|required');
   $this->form_validation->set_rules('network', 'Network', 'trim|required|callback_check_network');
   $this->form_validation->set_rules('dss', 'DSS', 'trim|callback_check_dss');
   $this->form_validation->set_rules('percentage', 'Percentage', 'trim|numeric');
   $this->form_validation->set_rules('balance', 'Balance', 'trim|numeric');
   
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.
     $data['page'] = "adddsp";
     $data['dss'] = $this->dss->getAllDSS();
     $this->load->view('templates/header', $data);
     $this->load->view('adddsp');
     $this->load->view('templates/footer');
   }
   else
   {
     $name = $this->input->post('full_name');
     $network = $this->input->post('network');
     $dealer_no = $this->input->post('dealer_no');
     $percentage = $this->input->post('percentage');
     $balance = $this->input->post('balance');
     $dss = $this->input->post('dss');
     if($dss == 0){
        $data = array(
                 'dsp_name' => $name,
                 'dss_id' => 0,      
                 );
     }else{
        $data = array(
                 'dsp_name' => $name,
                 'dss_id' => $dss,
                 );
     }
     $data2 =  array(
                    'network' => $network,
                    'dealer_no' => $dealer_no,
                    'percentage' => $percentage,
                    'balance' => $balance
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
     $dsp_id = $this->input->post('dsp_id');
     $name = $this->input->post('full_name');
     $network = $this->input->post('network');
     $dealer_no = $this->input->post('dealer_no');
     $percentage = $this->input->post('percentage');
     $balance = $this->input->post('balance');
     $dss = $this->input->post('dss');
     if($dss == 0){
        $data = array(
                 'dsp_name' => $name,
                 'dss_id' => 0,      
                 );
     }else{
        $data = array(
                 'dsp_name' => $name,
                 'dss_id' => $dss,
                 );
     }
     $data2 =  array(
                    'network' => $network,
                    'dealer_no' => $dealer_no,
                    'percentage' => $percentage,
                    'balance' => $balance
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
