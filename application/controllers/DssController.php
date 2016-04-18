<?php

class DssController extends CI_Controller {
 
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

 function addDSS()
 {
   $this->load->library('form_validation');

   $this->form_validation->set_rules('full_name', 'Name', 'trim|required');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.
     $data['page'] = "adddss";
     $this->load->view('templates/header', $data);
     $this->load->view('adddss');
     $this->load->view('templates/footer');
   }
   else
   {
     $name = $this->input->post('full_name');
     $data = array(
              'dss_name' => $name,  
              );

     $ret = $this->dss->addDSS($data);
     if($ret === false){
         $this->session->set_flashdata('message', 'Error has occured.');
     }else{
         $this->session->set_flashdata('message', 'Added Successfully.');
     }
    redirect('/landingController/addDSS');
   }
 }

 function editDSS(){
   $dss_id = $this->input->post('dss_id');
   $name = $this->input->post('full_name');
   $data = array( 
            'dss_name' => $name
            );
   $ret = $this->dss->editDSS($data,$dss_id);
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

 function deleteDSS(){
   $dss_id = $this->input->post('dss_id');
   $result = $this->dsp->getAllDSPbyDSS($dss_id);
   $data = null;
   if($result != NULL){
   foreach($result as $row){
      $data[] = array(
        'dsp_id' => $row->dsp_id,
        'dss_id' => 0
        );
     }
   }
   $ret = $this->dss->deleteDSS($dss_id, $data);
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
