<?php

class GlobalController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('dsp','',TRUE);
   $this->load->model('globalSim','',TRUE);
   $group = array(1,2,4);
   if(!($this->ion_auth->in_group($group))){
      redirect('/LandingController');
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




 
}
 
?>
