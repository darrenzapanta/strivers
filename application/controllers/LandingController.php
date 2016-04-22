<?php

class LandingController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('Dsp','',TRUE);
   $this->load->model('Dss','',TRUE);
   $this->load->model('Globalsim','',TRUE);
   $this->load->model('Transaction','',TRUE);
   $this->load->model('Purchaseorder','',TRUE);
   if(!($this->session->userdata('logged_in') == true)){
      $this->load->view('errors/index');
   }
   $GLOBALS['data']['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname') ;
 }
 function graphWeekly($data){
   $data2 = array();
   for($i = 0; $i < 8; $i++){
      $date = date('Y-m-d', strtotime('-'.$i.' days'));
      $arr = array();
      $flag = false;
      foreach($data as $data_item){
         $flag = false;
         $f_date1 = date_create_from_format('Y-m-d', $date);
         $f_date2 = date_create_from_format('Y-m-d', $data_item->date_created);
         if($f_date1 == $f_date2){

            $arr[] = $date;
            $arr[] = $data_item->count; 
            $flag = true;
            break;
         }
      }
      if($flag == false){
         $arr[] = $date;
         $arr[] = 0; 
      }
      array_push($data2, $arr);
   }
   return $data2;

 }
 function index(){
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   $GLOBALS['data']['transaction'] =$this->Transaction->getTransactionCount();
   $date1 = date('Y-m-d', strtotime('-1 week'));
   $date2 = date('Y-m-d');
   $sim = $this->Globalsim->getAllSim();
   $data2 = array();
   $topDSP = array();
   foreach($sim as $sim_item){
      $temp = array();
      $result = $this->Transaction->getTransactionForGraph($date1, $date2, $sim_item->global_name);
      $temp['global_name'] = $sim_item->global_name;
      $temp['data'] = $this->Transaction->getTopDSP($date1, $date2, $sim_item->global_name);
      $topDSP[] = $temp;
      array_push($data2, array($sim_item->global_name,$this->graphWeekly($result)));
   }
   $GLOBALS['data']['graph'] = json_encode($data2);
   $GLOBALS['data']['topDSP'] = $topDSP;
   $GLOBALS['data']['totalsales'] = "";
   $GLOBALS['data']['purchaseorder'] = "";
   $this->load->view('templates/header',$GLOBALS['data']);
   $this->load->view('index');
   $this->load->view('templates/footer');
 }
 
 function addDSP()
 {
   $this->load->helper(array('form'));
   $GLOBALS['data']['page'] = "adddsp";
   $GLOBALS['data']['dss'] = $this->Dss->getAllDSS();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('adddsp', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }
 function addDSS(){
   $this->load->helper(array('form'));
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('adddss', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

  function viewDSS(){

   $GLOBALS['data']['dss'] = $this->Dss->getAllDSS();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewdss', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

 function editDSP()
 {

   $GLOBALS['data']['dsp'] = $this->Dsp->getAllDSP();
   $GLOBALS['data']['dss'] = $this->Dss->getAllDSS();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('editdsp', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }



 function addTransaction(){
   $this->load->helper(array('form'));
   $GLOBALS['data']['page'] = "addtransaction";
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   $GLOBALS['data']['dsp'] = $this->Dsp->getAllDSP();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('addtransaction', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

  function viewTransaction(){
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   $GLOBALS['data']['dsp'] = $this->Dsp->getAllDSP();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('detailedtransaction', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }
   function detailedTransaction(){
   $GLOBALS['data']['trans'] = array();
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   $GLOBALS['data']['dsp'] = $this->Dsp->getAllDSP();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('detailedtransaction', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }




   function searchTransaction(){
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('searchtransaction', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

  function addPurchaseOrder(){
   $this->load->helper(array('form'));
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('addpurchaseorder', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

  function viewPurchaseOrder(){
   $GLOBALS['data']['po'] = $this->Purchaseorder->getAllPurchaseOrder();
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewpurchaseorder', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }



}
 
?>
