<?php

class TransactionController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('dsp','',TRUE);
   $this->load->model('dss','',TRUE);
   $this->load->model('transaction','',TRUE);
   $this->load->model('globalSim','',TRUE);
   if(!($this->session->userdata('logged_in') == true)){
      $this->load->view('errors/index');
   }
   $GLOBALS['data']['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname') ;
 }

 
 function addTransaction()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
   $this->form_validation->set_rules('dsp_id', 'Name', 'trim|required|callback_check_dsp');
   $this->form_validation->set_rules('dealerno', 'Dealer No', 'trim|required');
   $this->form_validation->set_rules('transactiondate', 'Date', 'trim|required');
   $this->form_validation->set_rules('confirmationno', 'Confirmation Number', 'trim|required');
   $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
   $this->form_validation->set_rules('sim', 'Sim', 'trim|required|callback_check_sim');
   
   if($this->form_validation->run() == FALSE)
   {
     $GLOBALS['data']['page'] = "addtransaction";
     $GLOBALS['data']['sim'] = $this->globalSim->getAllSim();
     $GLOBALS['data']['dsp'] = $this->dsp->getAllDSP();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addTransaction', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }
   else
   {
     $dsp = $this->input->post('dsp_id');
     $sim = $this->input->post('sim');
     $dealer_no = $this->input->post('dealerno');
     $date_created = $this->input->post('transactiondate');
     $amount = $this->input->post('amount');
     $user_id = $this->session->userdata('userid');
     $confirmation_no = $this->input->post('confirmationno');
     $data = array(
                 'dsp_id' => $dsp,
                 'global_name' => $sim,    
                 'amount' => $amount,
                 'confirm_no' => $confirmation_no,
                 'date_created' => $date_created,
                 'dealer_no' => $dealer_no,
                 'user_id' => $user_id,                       
                 );
     $ret = $this->transaction->addTransaction($data);
     if($ret === false){
        $this->session->set_flashdata('message', 'Database Error.');  
     }else{
        $this->session->set_flashdata('message', 'Added Successfully.');
     }
     redirect('/landingController/addTransaction');
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


 function check_dsp($dsp){
  $dealer_no = $this->input->post('dealerno');
  $sim = $this->input->post('sim');
  $result = $this->dsp->getDSPbyID($dsp);
  foreach($result as $row){
    if($dsp == $row->dsp_id && $dealer_no == $row->dsp_dealer_no && $sim == strtoupper($row->dsp_network))
      return true;
  }
    $this->form_validation->set_message('check_dsp', 'Invalid Name.');
    return false;
 }

 function editTransaction(){
   $dsp_id = $this->input->post('dsp_id');
   $trans_id = $this->input->post('trans_id');
   $dealerno = $this->input->post('dealerno');
   $sim = $this->input->post('sim');
   $amount = $this->input->post('amount');
   $confirmationno = $this->input->post('confirmationno');
   $transactiondate = $this->input->post('transactiondate');
   $user_id = $this->session->userdata('userid');
   $result = $this->dsp->getDSPbyID($dsp_id);
    foreach($result as $row){
      if($dsp_id == $row->dsp_id && $dealerno == $row->dsp_dealer_no && $sim == strtoupper($row->dsp_network)){
         $data = array( 
                       'dsp_id' => $dsp_id,
                       'global_name' => $sim,    
                       'amount' => $amount,
                       'confirm_no' => $confirmationno,
                       'date_created' => $transactiondate,
                       'dealer_no' => $dealerno,
                       'user_id' => $user_id
                  );

         $ret = $this->transaction->editTransaction($data,$trans_id);
        }else{
         $ret = false;
        }
    }
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

 function deleteTransaction(){
   $trans_id = $this->input->post('trans_id');
   $ret = $this->transaction->deleteTransaction($trans_id);
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

 function getTransaction(){
  $po = 0;
  if(isset($_POST['network'])){
    $date1 = $this->input->post('date1');
    $date2 = $this->input->post('date2');
    $network = $this->input->post('network');
    $po = $this->input->post('po');
    $balchk = $this->input->post('balchk');
    if($date1 != " " || $date2 != " "){
      $f_date1 = date("Y-m-d", strtotime($date1));
      $f_date2 = date("Y-m-d", strtotime($date2));
    }else{
      $f_date1 = date("Y-m-d");
      $f_date2 = date("Y-m-d");
    }
    if($balchk == 1){
      $ret = $this->transaction->getDetailedTransaction($network, $f_date1, $f_date2, $po);
    }else{
      $ret = $this->transaction->getTransactionByDate($f_date1, $f_date2, $network);
    }
      header('Content-type: application/json');
      $result['status'] = 'success';
      $result['data'] = $ret;
      echo json_encode(array('draw' => 1, 'recordsTotal' => count($ret), 'recordsFiltered' => count($ret), 'data' => $ret, 'status' => 'success'));

      //echo json_encode($result);
    }else{
        header('Content-type: application/json');
        $result['status'] = 'failed';    
        echo json_encode($result);
    }

 }
 
}
 
?>
