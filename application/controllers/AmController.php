<?php

class AmController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('dsp','',TRUE);
   $this->load->model('Am','',TRUE);
   $this->load->model('Globalsim','',TRUE);
   if(!($this->session->userdata('logged_in') == true)){
      $this->load->view('errors/index');
   }
   $GLOBALS['data']['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname') ;
 }

 function addAM()
 {
   $this->load->library('form_validation');

   $this->form_validation->set_rules('amcode', 'Area Manager Code', 'trim|required|callback_checkamcode');
   $this->form_validation->set_rules('amlocation', 'Location','trim|required');
   $this->form_validation->set_rules('totalbalance', 'Total Balance', 'trim|numeric');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.
     $GLOBALS['data']['am'] = $this->Am->getAllAM();
     $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addam');
     $this->load->view('templates/footer');
   }
   else
   {
     $amcode = $this->input->post('amcode');
     $am_location = $this->input->post('amlocation');
     if(isset($_POST['totalbalance'])){
      $am_totalbalance = $this->input->post('totalbalance');
     }else{
      $am_totalbalance = 0;
     }
     $data = array(
              'am_code' => $amcode,
              'am_location' => $am_location,
              'am_totalbalance' => $am_totalbalance,
              );

     $ret = $this->Am->addAM($data);
     if($ret === false){
         $this->session->set_flashdata('message', 'Error has occured.');
     }else{
         $this->session->set_flashdata('message', 'Added Successfully.');
     }
    redirect('/landingController/addAM');
   }
 }

 function checkamcode($amcode){
    if($this->Am->getAMByCode($amcode) != false){
      $this->form_validation->set_message('checkamcode', 'Duplicate Entry for AM Code.');
      return false;
    }else{
      return true;
    }
 }


 function editAM(){
   $am_location = $this->input->post('location');
   $am_code = $this->input->post('am_code');
   $ret = false;
   $data = array( 
            'am_location' => $am_location,
            );
   $ret = $this->Am->editAM($data,$am_code);
     if($ret === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        $response_array['message'] = 'Duplicate Entry for AM Code and Sim.';
        echo json_encode($response_array);
     }else{
        header('Content-type: application/json');
        $response_array['status'] = 'success'; 
        $response_array['message'] = 'Edited Successfully';   
        echo json_encode($response_array);
     }  

 }

 function deleteAM(){
   $am_code = $this->input->post('am_code');
   $result = $this->dsp->getAllDSPbyAM($am_code);
   $data = null;
   if($result != NULL){
   foreach($result as $row){
      $data[] = array(
        'dsp_id' => $row->dsp_id,
        'am_code' => 'Unassigned'
        );
     }
   }
   $ret = $this->Am->deleteAM($am_code, $data);
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
 
?>
