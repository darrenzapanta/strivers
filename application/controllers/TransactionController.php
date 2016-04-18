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
 }

 
 function addTransaction()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');
   $this->form_validation->set_rules('dsp', 'Name', 'trim|required|callback_check_dsp');
   $this->form_validation->set_rules('dealer_no', 'Dealer No', 'trim|required');
   $this->form_validation->set_rules('date_created', 'Date', 'trim|required');
   $this->form_validation->set_rules('confirmation_no', 'Confirmation Number', 'trim|required');
   $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
   $this->form_validation->set_rules('sim', 'Sim', 'trim|required|callback_check_sim');
   
   if($this->form_validation->run() == FALSE)
   {
     $data['page'] = "addtransaction";
     $data['sim'] = $this->globalSim->getAllSim();
     $data['dsp'] = $this->dsp->getAllDSP();
     $this->load->view('templates/header', $data);
     $this->load->view('addTransaction', $data);
     $this->load->view('templates/footer');
   }
   else
   {
     $dsp = $this->input->post('dsp');
     $sim = $this->input->post('sim');
     $dealer_no = $this->input->post('dealer_no');
     $date_created = $this->input->post('date_created');
     $amount = $this->input->post('amount');
     $user_id = $this->session->userdata('userid');
     $confirmation_no = $this->input->post('confirmation_no');
     $beg_bal = $this->globalSim->getCurrentBalance($sim);
     $run_bal = $beg_bal - $amount;
     $data = array(
                 'dsp_id' => $dsp,
                 'global_name' => $sim,    
                 'amount' => $amount,
                 'confirm_no' => $confirmation_no,
                 'date_created' => $date_created,
                 'dealer_no' => $dealer_no,
                 'beg_bal' => $beg_bal,
                 'run_bal' => $run_bal,
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
  $dealer_no = $this->input->post('dealer_no');
  $result = $this->dsp->getDSPbyID($dsp);
  foreach($result as $row){
    if($dsp == $row->dsp_id || $dealer_no == $row->dealer_no)
      return true;
  }
    $this->form_validation->set_message('check_dsp', 'Invalid Name.');
    return false;
 }


 
}
 
?>
