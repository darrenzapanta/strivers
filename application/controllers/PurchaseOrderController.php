<?php

class PurchaseOrderController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('purchaseorder','',TRUE);
   $this->load->model('globalsim','',TRUE);
   $group = array(1,2,4);
   if(!($this->ion_auth->in_group($group))){
      redirect('/LandingController');
   }
   $GLOBALS['data']['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname') ;
 }

 
 function addPurchaseOrder()
 {

   //This method will have the credentials validation
   $this->load->library('form_validation');;
   $this->form_validation->set_rules('purchaseorderdate', 'Purchase Order Date', 'trim|required');
   $this->form_validation->set_rules('paymentmode', 'Mode of Payment', 'trim|required');
   $this->form_validation->set_rules('confirmno', 'Confirmation No', 'trim');
   $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
   $this->form_validation->set_rules('sim', 'Sim', 'trim|required|callback_check_sim');
   
   if($this->form_validation->run() == FALSE)
   {
     $GLOBALS['data']['sim'] = $this->globalsim->getAllSim();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addPurchaseOrder', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }
   else
   {

     $sim = $this->input->post('sim');
     $date_created = $this->input->post('purchaseorderdate');
     $paymentmode = $this->input->post('paymentmode');
     $referencenumber = $this->input->post('confirmno');
     $amount = $this->input->post('amount');
     $user_name = $this->session->userdata('firstname')." ".$this->session->userdata('lastname');
     $data = array(
                 'global_name' => $sim, 
                 'paymentmode' => $paymentmode,
                 'referencenumber' => $referencenumber,   
                 'amount' => $amount,
                 'date_created' => $date_created,
                 'user_name' => $user_name,                       
                 );
     $ret = $this->purchaseorder->addPurchaseOrder($data);
     if($ret === false){
        $this->session->set_flashdata('message', 'Database Error.');  
     }else{
        $this->session->set_flashdata('message', 'Added Successfully.');
     }
     redirect('/landingController/addPurchaseOrder');
    }
    
    
}

 function getPurchaseOrder(){
  $po = 0;
  if(isset($_POST['network'])){
    $date1 = $this->input->post('date1');
    $date2 = $this->input->post('date2');
    $network = $this->input->post('network');
    if($date1 != " " || $date2 != " "){
      $f_date1 = date("Y-m-d", strtotime($date1));
      $f_date2 = date("Y-m-d", strtotime($date2));
    }else{
      $f_date1 = date("Y-m-d");
      $f_date2 = date("Y-m-d");
    }
    $ret = $this->purchaseorder->getPurchaseOrderByDate($date1, $date2, $network);
    if($ret != FALSE){
      $rowDef = array();
      foreach($ret as $res){
        $row = array();
        $row['purchase_id'] = $res->purchase_id;
        $row['network'] = $res->global_name;
        $row['paymentmode'] = $res->paymentmode;
        $row['confirmno'] = $res->referencenumber;
        $row['amount'] = $res->amount;
        $row['date_created'] = $res->date_created;
        $rowDef[] = $row;
      }
      header('Content-type: application/json');
      echo json_encode(array('draw' => 1, 'recordsTotal' => count($rowDef), 'recordsFiltered' => count($rowDef), 'data' => $rowDef, 'status' => 'success'));
    }else{
      header('Content-type: application/json');
      $result['status'] = 'failed';
      $result['msg'] = 'Database Error';
      echo json_encode($result);
      }
    }else{
        header('Content-type: application/json');
        $result['status'] = 'failed'; 
        $result['msg'] = 'Please select a network first';   
        echo json_encode($result);
    }  
}

function check_sim($sim){
  $result = $this->globalsim->getAllSim();
  foreach($result as $row){
    if($sim == $row->global_name)
      return true;
  }
  $this->form_validation->set_message('check_sim', 'Invalid Sim.');
  return false;
  
}

 function editPurchaseOrder2()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');;
   $this->form_validation->set_rules('purchaseorderdate', 'Purchase Order Date', 'trim|required');
   $this->form_validation->set_rules('paymentmode', 'Mode of Payment', 'trim|required');
   $this->form_validation->set_rules('confirmno', 'Confirmation No', 'trim|');
   $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
   $this->form_validation->set_rules('sim', 'Sim', 'trim|required|callback_check_sim');
   
   if($this->form_validation->run() == FALSE)
   {
      header('Content-type: application/json');
      $response_array['status'] = 'failed';    
      echo json_encode($response_array);
   }
   else
   {

     $sim = $this->input->post('sim');
     $date_created = $this->input->post('purchaseorderdate');
     $paymentmode = $this->input->post('paymentmode');
     $referencenumber = $this->input->post('confirmno');
     $amount = $this->input->post('amount');
     $user_id = $this->session->userdata('userid');
     $data = array(
                 'global_name' => $sim, 
                 'paymentmode' => $paymentmode,
                 'referencenumber' => $referencenumber,   
                 'amount' => $amount,
                 'date_created' => $date_created,
                 'user_id' => $user_id,                       
                 );
     $ret = $this->purchaseorder->addPurchaseOrder($data);
     if($ret === false){
        $this->session->set_flashdata('message', 'Database Error.');  
     }else{
        $this->session->set_flashdata('message', 'Added Successfully.');
     }
     redirect('/landingController/addPurchaseOrder');
    }
    
    
}


 function editPurchaseOrder(){
   $purchase_id = $this->input->post('purchase_id');
   $sim = $this->input->post('sim');
   $amount = $this->input->post('amount');
    $paymentmode = $this->input->post('paymentmode');
   $referencenumber = $this->input->post('confirmno');
   $purchaseorderdate = $this->input->post('purchaseorderdate');
   $data = array( 
                 'global_name' => $sim,    
                 'amount' => $amount,
                 'date_created' => $purchaseorderdate,
            );
   $ret = $this->purchaseorder->editPurchaseOrder($data,$purchase_id);
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
   $group = array(1,2);
   if(!($this->ion_auth->in_group($group))){
      return false;
   }   
   $purchase_id = $this->input->post('purchase_id');
   $ret = $this->purchaseorder->deletePurchaseOrder($purchase_id);
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
