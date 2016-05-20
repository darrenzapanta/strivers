<?php

class TransactionController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('dsp','',TRUE);
   $this->load->model('transaction','',TRUE);
   $this->load->model('globalsim','',TRUE);
   $this->load->model('Am','',TRUE);
   $this->load->model('Operations','',TRUE);
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
   $this->form_validation->set_rules('confirmationno', 'Confirmation Number', 'trim|required|callback_check_confirmno');
   $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
   $this->form_validation->set_rules('sim', 'Sim', 'trim|required|callback_check_sim');
   $this->form_validation->set_rules('transaction_code', 'Transaction Code', 'trim|required|callback_checktransactioncode');
   
   if($this->form_validation->run() == FALSE)
   {
     $GLOBALS['data']['sim'] = $this->globalsim->getAllSim();
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
     $transaction_code = $this->session->userdata('transaction_code');
     $amount = $this->input->post('amount');
     $user_name = $this->session->userdata('firstname')." ".$this->session->userdata('lastname');
     $confirmation_no = $this->input->post('confirmationno');
     $result = $this->dsp->getDSPbyID($dsp);
     foreach($result as $res){
      $dsp_name = $res->dsp_firstname." ".$res->dsp_lastname;
     }
     $curr_bal = $this->globalsim->getCurrentBalance($sim);
     $run_bal = $this->Operations->subtract($curr_bal, $amount);
     $simbalance = array('current_balance' => $run_bal);
     $result = $this->dsp->getDSPbyDealerno($dealer_no);
     foreach($result as $res){
      $am_code = $res->am_code;
      $percentage = $res->dsp_percentage;
      if($am_code == 'Unassigned'){
        $dsp_curr_bal = $res->dsp_balance;
      }
     }
     if($am_code == 'Unassigned'){
      $netamount = $this->Operations->getNetAmount($amount, $percentage);
      $dsp_run_bal = $this->Operations->add($dsp_curr_bal, $netamount);
      $totalbalance = array('dsp_balance' => $dsp_run_bal);
     }else{
      $result2 = $this->Am->getAMbyCode($am_code);
      foreach($result2 as $res){
        $am_curr_bal = $res->am_totalbalance;
      }
      $netamount = $this->Operations->getNetAmount($amount, $percentage);
      $am_run_bal = $this->Operations->add($am_curr_bal, $netamount);      
      $totalbalance = array('am_totalbalance' => $am_run_bal);
     }
     $data = array(
                 'transaction_code' => $transaction_code,
                 'dsp_id' => $dsp,
                 'global_name' => $sim,    
                 'amount' => $amount,
                 'confirm_no' => $confirmation_no,
                 'date_created' => $date_created,
                 'dealer_no' => $dealer_no,
                 'user_name' => $user_name,
                 'dsp_name' => $dsp_name,
                 'am_code' => $am_code,
                 'net_amount' => $netamount,
                 'load_percentage' => $percentage                  
                 );
     $ret = $this->transaction->addTransaction($data, $simbalance, $totalbalance, $am_code);
     if($ret === false){
        $this->session->set_flashdata('message', 'Database Error.');  
     }else{
        $this->session->set_flashdata('message', 'Added Successfully.');
     }
     redirect('/landingController/addTransaction');
    }
    
    
}

function getTotalRevenue($date1, $date2){
  $result = $this->transaction->getTotalRevenue($date1, $date2);
  $totalRevenue = 0;
  foreach($result as $res){
    $revenue = $this->Operations->getRevenue($res->amount, $res->load_percentage);
    $totalRevenue += $revenue;
  }
  return $totalRevenue;
}

  function graphSales(){
   $date1 = $this->input->post('date1');
   $date2 =  $this->input->post('date2');
  $f_date1 = date("Y-m-d", strtotime($date1));
  $f_date2 = date("Y-m-d", strtotime($date2));
   $result = $this->Am->getAllAM();
    $tick = array();
    $count = 0;
    $temp = array();
   foreach($result as $row){
    $tData = array();
    $temp[$row->am_code] = $count;
    $tData[] = $count;
    $tData[] = $row->am_code;
    $tick[] = $tData;
    $count++;
   }
   $result = $this->transaction->totalSalesByAMCode($f_date1, $f_date2);
   if($result != false){
      $data = array();
      $n = 1;
      $row = $result->first_row();
      for($i = 0; $i < $count; $i++){
        $y = array();
        if($n <= $result->num_rows()){
          if($i < $temp[$row->am_code] || $row == null){
              $y[] = $i;
              $y[] = 0;         
          }else{
             $y[] = $temp[$row->am_code];
             $y[] = $row->amount;       
             $row = $result->next_row();
             $n++;    
          }
        }else{
              $y[] = $i;
              $y[] = 0;               
          }
        $data[] = $y;
      }


      $graph = array(
         'tick' => $tick,
         'data' => $data,
         'revenue' => $this->getTotalRevenue($f_date1, $f_date2)
         );
      header('Content-type: application/json');
      echo json_encode($graph);
   }
 }



function check_confirmno($confirmno){
  if($this->transaction->getTransactionByConfirmno($confirmno) != false){
    $this->form_validation->set_message('check_confirmno', 'Duplicate Confirmation Number.');
    return false;
  }else {
    return true;
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


 function check_dsp($dsp){
  $dealer_no = $this->input->post('dealerno');
  $sim = $this->input->post('sim');
  $result = $this->dsp->getDSPbyDealerno($dealer_no);
  if($result != false){
  foreach($result as $row){
    if($dsp == $row->dsp_id && $dealer_no == $row->dsp_dealer_no && $sim == $row->dsp_network)
      return true;
  }
    $this->form_validation->set_message('check_dsp', 'Invalid Name.');
    return false;
  }
    $this->form_validation->set_message('check_dsp', 'Invalid Name.');
    return false;
 }

 function editTransaction(){
    if($this->session->userdata('type') != 'admin'){
      return false;
    }
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
  function editTransaction2()
 {
   //This method will have the credentials validation
  if($this->session->userdata('type') != 'admin'){
    return false;
  }
   $this->load->library('form_validation');
   $this->form_validation->set_rules('dsp_id', 'Name', 'trim|required|callback_check_dsp');
   $this->form_validation->set_rules('dealerno', 'Dealer No', 'trim|required');
   $this->form_validation->set_rules('transactiondate', 'Date', 'trim|required');
   $this->form_validation->set_rules('confirmationno', 'Confirmation Number', 'trim|required');
   $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
   $this->form_validation->set_rules('sim', 'Sim', 'trim|required|callback_check_sim');
   
   if($this->form_validation->run() == FALSE)
   {
      header('Content-type: application/json');
      $response_array['status'] = 'failed';    
      $response_array['message'] = validation_errors();
      echo json_encode($response_array);
   }
   else
   {
     $trans_id = $this->input->post('trans_id');
     $dsp = $this->input->post('dsp_id');
     $sim = $this->input->post('sim');
     $dealer_no = $this->input->post('dealerno');
     $date_created = $this->input->post('transactiondate');
     $amount = $this->input->post('amount');
     $user_name = $this->session->userdata('firstname')." ".$this->session->userdata('lastname');
     $confirmation_no = $this->input->post('confirmationno');
     $result = $this->dsp->getDSPbyID($dsp);
     foreach($result as $res){
      $dsp_name = $res->dsp_firstname." ".$res->dsp_lastname;
     }

     $data = array(
                 'dsp_id' => $dsp,
                 'global_name' => $sim,    
                 'amount' => $amount,
                 'confirm_no' => $confirmation_no,
                 'date_created' => $date_created,
                 'dealer_no' => $dealer_no,
                 'user_name' => $user_name,
                 'dsp_name' => $dsp_name,                       
                 );
     $ret = $this->transaction->editTransaction($data,$trans_id);
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

 function deleteTransaction(){
  if($this->session->userdata('type') == 'admin'){
     $transaction_code= $this->input->post('transaction_code');
     $ret = $this->transaction->deleteTransaction($transaction_code);
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

  function getTransactionUN(){
    $date1 = $this->input->post('date1');
    $date2 = $this->input->post('date2');
    if($date1 != " " || $date2 != " "){
      $f_date1 = date("Y-m-d", strtotime($date1));
      $f_date2 = date("Y-m-d", strtotime($date2));
    }else{
      $f_date1 = date("Y-m-d");
      $f_date2 = date("Y-m-d");
    }
      $ret = $this->transaction->getTransactionUNByDate($f_date1, $f_date2);
      if($ret != False){
        $rowDef = array();
      foreach($ret as $res){
        $row = array();
        $row['payment_id'] = $res->load_payment_id;
        $row['name'] = $res->dsp_name;
        $row['transaction_code'] = $res->payment_transaction_code;
        $row['dealer_no'] = $res->dealer_no;
        $row['global_name'] = $res->global_name;
        $row['amount'] = $res->amount;
        $row['date_created'] = $res->date_created;
        $row['paymentmode'] =  $res->paymentmode;
        $row['confirm_no'] = $res->confirm_no;
        $rowDef[] = $row;
      }
      header('Content-type: application/json');
      echo json_encode(array('draw' => 1, 'recordsTotal' => count($rowDef), 'recordsFiltered' => count($rowDef), 'data' => $rowDef, 'status' => 'success'));
      }else{
        header('Content-type: application/json');
        $result['status'] = 'failed';    
        echo json_encode($result);
      }


 }

   function getTransactionAM(){
    $date1 = $this->input->post('date1');
    $date2 = $this->input->post('date2');
    if($date1 != " " || $date2 != " "){
      $f_date1 = date("Y-m-d", strtotime($date1));
      $f_date2 = date("Y-m-d", strtotime($date2));
    }else{
      $f_date1 = date("Y-m-d");
      $f_date2 = date("Y-m-d");
    }
      $ret = $this->transaction->getTransactionAMByDate($f_date1, $f_date2);
      if($ret != False){
        $rowDef = array();
      foreach($ret as $res){
        $row = array();
        $row['payment_id'] = $res->load_payment_id;
        $row['am_code'] = $res->am_code;
        $row['amount'] = $res->amount;
        $row['date_created'] = $res->date_created;
        $row['paymentmode'] =  $res->paymentmode;
        $row['confirm_no'] = $res->confirm_no;
        $rowDef[] = $row;
      }
      header('Content-type: application/json');
      echo json_encode(array('draw' => 1, 'recordsTotal' => count($rowDef), 'recordsFiltered' => count($rowDef), 'data' => $rowDef, 'status' => 'success'));
      }else{
        header('Content-type: application/json');
        $result['status'] = 'failed';    
        echo json_encode($result);
      }


 }

 function addPaymentAM(){
   //This method will have the credentials validation
   $this->load->library('form_validation');
   $this->form_validation->set_rules('amcode', 'Area Manager Code', 'trim|required|callback_check_amid');
   $this->form_validation->set_rules('paymentmode', 'Mode of Payment', 'trim|required');
   $this->form_validation->set_rules('paymentdate', 'Date of Payment', 'trim|required');
   $this->form_validation->set_rules('confirmno', 'Confirmation Number', 'trim|callback_check_confirmno');
   $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
   
   if($this->form_validation->run() == FALSE)
   {
     $GLOBALS['data']['am'] = $this->Am->getAllAM();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addpaymentam', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }
   else
   {
     $am_code = $this->input->post('amcode');
     $date_created = $this->input->post('paymentdate');
     $amount = $this->input->post('amount');
     $paymentmode = $this->input->post('paymentmode');
     $confirmation_no = $this->input->post('confirmno');
     $user_name = $this->session->userdata('firstname')." ".$this->session->userdata('lastname');
     $data = array(
                 'am_code' => $am_code,
                 'amount' => $amount,
                 'confirm_no' => $confirmation_no,
                 'date_created' => $date_created,
                 'paymentmode' => $paymentmode,
                 'user_name' => $user_name,                      
                 );
     $curr_bal = $this->Am->getTotalBalance($am_code);
     $run_bal = $this->Operations->subtract($curr_bal, $amount);
     $totalbalance = array('am_totalbalance' => $run_bal);
     $ret = $this->transaction->addPaymentAM($data, $totalbalance, $am_code);
     if($ret === false){
        $this->session->set_flashdata('message', 'Database Error.');  
     }else{
        $this->session->set_flashdata('message', 'Added Successfully.');
     }
     redirect('/landingController/addPaymentAM');
    }
    
    
 }

  function addPaymentUN(){
   //This method will have the credentials validation
   $this->load->library('form_validation');
   $this->form_validation->set_rules('transaction_code', 'Transaction Code', 'trim|callback_checktransactionifexist');
   $this->form_validation->set_rules('dsp_id', 'DSP name', 'trim|required|callback_checkdspifUN');
   $this->form_validation->set_rules('sim', 'Sim', 'trim|required');
   $this->form_validation->set_rules('dealer_no', 'Dealer No.', 'trim|required');
   $this->form_validation->set_rules('paymentmode', 'Mode of Payment', 'trim|required');
   $this->form_validation->set_rules('paymentdate', 'Date of Payment', 'trim|required');
   $this->form_validation->set_rules('confirmno', 'Confirmation Number', 'trim');
   $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required|callback_checkamountifmatch');
   
   if($this->form_validation->run() == FALSE)
   {
     $GLOBALS['data']['dsp'] = $this->dsp->getAllDSP();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addpaymentun', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }
   else
   {
     $transaction_code = null;
     $dsp_id = $this->input->post('dsp_id');
     $dealer_no = $this->input->post('dealer_no');
     $sim = $this->input->post('sim');
     $date_created = $this->input->post('paymentdate');
     $amount = $this->input->post('amount');
     $paymentmode = $this->input->post('paymentmode');
     $confirmation_no = $this->input->post('confirmno');
     $user_name = $this->session->userdata('firstname')." ".$this->session->userdata('lastname');
     $result = $this->dsp->getDSPbyID($dsp_id);
     foreach($result as $res){
      $dsp_name = $res->dsp_firstname." ".$res->dsp_lastname;
     }
     if(isset($_POST['transaction_code']) && $_POST['transaction_code'] != ""){
      $transaction_code = $this->input->post('transaction_code');
       $data = array(
                   'payment_transaction_code' => $transaction_code,
                   'dsp_id' => $dsp_id,
                   'dsp_name' => $dsp_name,
                   'dealer_no' => $dealer_no,
                   'global_name' => $sim,    
                   'amount' => $amount,
                   'confirm_no' => $confirmation_no,
                   'date_created' => $date_created,
                   'paymentmode' => $paymentmode,
                   'user_name' => $user_name,                      
                   );
     }else{
       $data = array(
                   'dsp_id' => $dsp_id,
                   'dsp_name' => $dsp_name,
                   'dealer_no' => $dealer_no,
                   'global_name' => $sim,    
                   'amount' => $amount,
                   'confirm_no' => $confirmation_no,
                   'date_created' => $date_created,
                   'paymentmode' => $paymentmode,
                   'user_name' => $user_name,                      
                   );
      }
     $result = $this->dsp->getDSPbyDealerno($dealer_no);
     foreach($result as $res){
      $curr_bal = $res->dsp_balance;
     }
     $run_bal = $this->Operations->subtract($curr_bal, $amount);
     $totalbalance = array('dsp_balance' => $run_bal);
     $ret = $this->transaction->addPaymentUN($data, $totalbalance, $dealer_no);
     if($ret === false){
        $this->session->set_flashdata('message', 'Database Error.');  
     }else{
        $this->session->set_flashdata('message', 'Added Successfully.');
     }
     redirect('/landingController/addPaymentUN');
    }
    
    
 }


 function getTransactionByTransactionCode(){
  $transaction_code = $this->input->post('transaction_code');
  $ret = $this->transaction->getTransactionByTransactionCode($transaction_code);
   if($ret === false){
      header('Content-type: application/json');
      $response_array['status'] = 'failed';    
      $response_array['message'] = 'Error has Occurred.';
      echo json_encode($response_array);
   }else{
      foreach($ret as $res){
        $data['name'] = $res->dsp_name;
        $data['date'] = $res->date_created;
        $data['net'] = $res->net_amount;
        $data['percentage'] = $res->load_percentage;
        $data['gross'] = $res->amount;
      }
      header('Content-type: application/json');
      $response_array['status'] = 'success'; 
      $response_array['message'] = 'Edited Successfully';   
      $response_array['data'] = $data;  
      echo json_encode($response_array);
   } 
 }

 function deleteTransactionUN(){
    if($this->session->userdata('type') == 'admin'){
     $payment_id= $this->input->post('payment_id');
     $ret = $this->transaction->deleteTransactionUN($payment_id);
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

  function deleteTransactionAM(){
    if($this->session->userdata('type') == 'admin'){
     $payment_id= $this->input->post('payment_id');
     $ret = $this->transaction->deleteTransactionAM($payment_id);
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


 function check_amid($am_code){
  $result = $this->Am->getAMbyCode($am_code);
  if($result != false){
    return true;
  }else{
    $this->form_validation->set_message('check_amid', 'Invalid Am Code.');
    return false;
  }

 }


  function checkdspifUN($dsp){
  $dealer_no = $this->input->post('dealer_no');
  $sim = $this->input->post('sim');
  $result = $this->dsp->getDSPbyDealerno($dealer_no);
  if($result != false){
  foreach($result as $row){
    
    if($row->am_code != 'Unassigned'){
      $this->form_validation->set_message('checkdspifUN', 'DSP is not UNASSIGNED. Please use the add payment for area manager.');
      return false;
    }
    if($dsp == $row->dsp_id && $dealer_no == $row->dsp_dealer_no && $sim == $row->dsp_network)
      return true;
  }
    $this->form_validation->set_message('checkdspifUN', 'Invalid Name.');
    return false;
  }
    $this->form_validation->set_message('checkdspifUN', 'Invalid Name.');
    return false;
 }

 function checktransactionifexist($transaction_code){
  if($this->transaction->getPaymentByTransactionCode($transaction_code) != FALSE){
    $this->form_validation->set_message('checktransactionifexist', 'The Transaction code has a payment already.');
    return false;
  }
  if($this->transaction->getTransactionByTransactionCode($transaction_code) == FALSE && $_POST['transaction_code'] != ""){
    $this->form_validation->set_message('checktransactionifexist', 'Invalid Transaction Code. Transaction not found.');
    return false;
  }else{
    return true;
  }
 }

  function checkamountifmatch($amount){
  $this->form_validation->set_message('checkamountifmatch', 'The amount is not equal to the net amount of the transaction.');
  if(isset($_POST['transaction_code']) && $_POST['transaction_code'] != ""){
    $transaction_code = $this->input->post('transaction_code');
    $ret = $this->transaction->getTransactionByTransactionCode($transaction_code);
    if($ret == false){
      return true;
    }else{
      foreach($ret as $res){
        $net_amount = $res->net_amount;
      }
      if($amount > $net_amount || $amount < $net_amount){
        
        return false;
      }elseif($amount == $net_amount){
        return true;
      }
    }
  }else{
    return true;
  }
 }

 function checktransactioncode($transaction_code){
  if($transaction_code == $this->session->userdata('transaction_code') && $this->transaction->getTransactionByTransactionCode($transaction_code) == FALSE){
    return true;
  }else{
  $this->form_validation->set_message('checktransactioncode', 'Invalid Transaction Code. Try refreshing the page.');
  return false;    
  }

}
 
}
 
?>
