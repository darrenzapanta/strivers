<?php

class PurchaseOrderController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('PurchaseOrder','',TRUE);
   $this->load->model('globalSim','',TRUE);
   if(!($this->session->userdata('logged_in') == true)){
      $this->load->view('errors/index');
   }
   $GLOBALS['data']['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname') ;
 }

 
 function addPurchaseOrder()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');;
   $this->form_validation->set_rules('purchaseorderdate', 'Purchase Order Date', 'trim|required');
   $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
   $this->form_validation->set_rules('sim', 'Sim', 'trim|required|callback_check_sim');
   
   if($this->form_validation->run() == FALSE)
   {
     $GLOBALS['data']['sim'] = $this->globalSim->getAllSim();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addPurchaseOrder', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }
   else
   {

     $sim = $this->input->post('sim');
     $date_created = $this->input->post('purchaseorderdate');
     $amount = $this->input->post('amount');
     $user_id = $this->session->userdata('userid');
     $data = array(
                 'global_name' => $sim,    
                 'amount' => $amount,
                 'date_created' => $date_created,
                 'user_id' => $user_id,                       
                 );
     $ret = $this->PurchaseOrder->addPurchaseOrder($data);
     if($ret === false){
        $this->session->set_flashdata('message', 'Database Error.');  
     }else{
        $this->session->set_flashdata('message', 'Added Successfully.');
     }
     redirect('/landingController/addPurchaseOrder');
    }
    
    
}

function check_sim($sim){
  $result = $this->globalSim->getAllSim();
  foreach($result as $row){
    if($sim == $row->global_name)
      return true;
  }
  $this->form_validation->set_message('check_sim', 'Invalid Sim.');
  return false;
  
}



 function editPurchaseOrder(){
   $purchase_id = $this->input->post('purchase_id');
   $sim = $this->input->post('sim');
   $amount = $this->input->post('amount');
   $purchaseorderdate = $this->input->post('purchaseorderdate');
   $data = array( 
                 'global_name' => $sim,    
                 'amount' => $amount,
                 'date_created' => $purchaseorderdate,
            );
   $ret = $this->PurchaseOrder->editPurchaseOrder($data,$purchase_id);
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

 function deletePurchaseOrder(){
   $purchase_id = $this->input->post('purchase_id');
   $ret = $this->PurchaseOrder->deletePurchaseOrder($purchase_id);
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
