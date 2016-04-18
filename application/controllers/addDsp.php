<?php

class addDsp extends CI_Controller {
 
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
 
 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
 
   $this->form_validation->set_rules('dealer_no', 'Dealer No', 'trim|required');
   $this->form_validation->set_rules('full_name', 'Name', 'trim|required');
   $this->form_validation->set_rules('network', 'Network', 'trim|required|check_network');
   $this->form_validation->set_rules('dss', 'DSS', 'trim||check_dss', 
    array('check_dss' => 'DSS not found.'));
   $this->form_validation->set_rules('percentage', 'Percentage', 'trim|numeric');
   $this->form_validation->set_rules('balance', 'Balance', 'trim|numeric');
   
   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.
     $data['page'] = "adddsp";
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
                 'dss_id' => null,      
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
     if($ret == false){
        $this->session->set_flashdata('message', 'Database error has occured.');
     }else{
        $this->session->set_flashdata('message', 'Added successfully.');
     }

    redirect('/landingController/addDSP');
   }
 
 }

 function check_network($network){
  if($network == "sun" || $network == "smart"){
    return true;
  }

  return false;
 }

 function check_dss($dss){
  if($this->dss->getDSSbyID($dss) == false){
    return false;
  }
    return true;
 }
 
}
?>