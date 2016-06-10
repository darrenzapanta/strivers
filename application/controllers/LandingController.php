<?php

class LandingController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('Dsp','',TRUE);
   $this->load->model('Am','',TRUE);
   $this->load->model('Globalsim','',TRUE);
   $this->load->model('Transaction','',TRUE);
   $this->load->model('Purchaseorder','',TRUE);
   $this->load->model('Operations','',TRUE);
   if(!($this->ion_auth->logged_in() == true)){
      redirect('/login');
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
   if($this->ion_auth->in_group(array(1,2,4))){
     $this->load->view('templates/header',$GLOBALS['data']);
     $this->load->view('index');
     $this->load->view('templates/footer');
   }else if($this->ion_auth->in_group(array(5))){
    redirect('/LandingController/viewInventoryItems');
   }else if($this->ion_auth->in_group(array(3))){
    redirect('/LandingController/viewTransaction');
   }

 }
 
 function addDSP()
 {
   $group = array(1,2,4);
   if($this->ion_auth->in_group($group) == TRUE){
     $this->load->helper(array('form'));
     $GLOBALS['data']['am'] = $this->Am->getAllAM();
     $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('adddsp', $GLOBALS['data']);
     $this->load->view('templates/footer');
  }else{
    redirect('/LandingController');
  }
 }
 function addAM(){
   $group = array(1,2,4);
   if($this->ion_auth->in_group($group) == TRUE){
     $this->load->helper(array('form'));
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addam', $GLOBALS['data']);
     $this->load->view('templates/footer');
  }else{
    redirect('/LandingController');
  }
 }

  function viewAM(){
   $group = array(1,2,4);
   if($this->ion_auth->in_group($group) == TRUE){
     $GLOBALS['data']['am'] = $this->Am->getAllAM();
     $this->load->helper(array('form'));
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('viewam', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }else{
    redirect('/LandingController');
   }
 }

 function editDSP()
 {
   $group = array(1,2,4);
   if($this->ion_auth->in_group($group) == TRUE){
     $GLOBALS['data']['dsp'] = $this->Dsp->getAllDSP();
     $GLOBALS['data']['am'] = $this->Am->getAllAM();
     $this->load->helper(array('form'));
     $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('editdsp', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }else{
    redirect('/LandingController');
   }
 }



 function addTransaction(){
   $group = array(1,2,4);
   if($this->ion_auth->in_group($group) == TRUE){
     $this->load->helper(array('form'));
     $GLOBALS['data']['page'] = "addtransaction";
     $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
     $GLOBALS['data']['dsp'] = $this->Dsp->getAllDSP();

     $code = $this->Operations->generateCode("load_transaction");
     $this->session->set_userdata('transaction_code', $code);
     $GLOBALS['data']['code'] = $code;
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addtransaction', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }else{
     redirect('/LandingController');
   }
 }

  function viewTransaction(){
     $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('detailedtransaction', $GLOBALS['data']);
     $this->load->view('templates/footer');

 }

   function viewTransactionUN(){
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewtransactionun', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

    function viewTransactionAM(){
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewtransactionam', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }


   function addPaymentAM(){
   $group = array(1,2,4);
   if($this->ion_auth->in_group($group) == TRUE){
     $this->load->helper(array('form'));
     $GLOBALS['data']['am'] = $this->Am->getAllAM();
     $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
     
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addpaymentam', $GLOBALS['data']);
     $this->load->view('templates/footer');
  }else{
    redirect('/LandingController');
  }
}

   function addPaymentUN(){
   $group = array(1,2,4);
   if($this->ion_auth->in_group($group) == TRUE){    
     $this->load->helper(array('form'));
     $GLOBALS['data']['am'] = $this->Am->getAllAM();
     $GLOBALS['data']['dsp'] = $this->Dsp->getAllDSP();
     
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addpaymentun', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }else{
    redirect('/LandingController');
   }
}


  function addPurchaseOrder(){
   $group = array(1,2,4);
   if($this->ion_auth->in_group($group) == TRUE){
     $this->load->helper(array('form'));
     $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addpurchaseorder', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }else{
    redirect('/LandingController');
   }
 }

  function viewPurchaseOrder(){
   $group = array(1,2,4);
   if($this->ion_auth->in_group($group) == TRUE){
     $GLOBALS['data']['po'] = $this->Purchaseorder->getAllPurchaseOrder();
     $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('viewpurchaseorder', $GLOBALS['data']);
     $this->load->view('templates/footer');
  }else{
    redirect('/LandingController');
  }
 }

 function addInventoryItem(){
   $group = array(1,2,5);
   if($this->ion_auth->in_group($group) == TRUE){
     $this->load->helper(array('form'));
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addinventoryitem', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }else{
    redirect('/LandingController');
   }
 }

  function addInventoryPurchase(){
   $group = array(1,2,5);
   if($this->ion_auth->in_group($group) == TRUE){
     $this->load->model('Inventory','',TRUE);
     $this->load->helper(array('form'));

     $GLOBALS['data']['item'] = $this->Inventory->getAllItems();
     $code = $this->Operations->generateCode("inventory_purchase");
     $this->session->set_userdata('purchase_code', $code);
      $GLOBALS['data']['code'] = $code;
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addinventorypurchase', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }else{
    redirect('/LandingController');
   }
 }

  function addInventorySales(){
   $group = array(1,2,5);
   if($this->ion_auth->in_group($group) == TRUE){   
     $this->load->model('Inventory','',TRUE);
     $this->load->helper(array('form'));
     $code = $this->Operations->generateCode("inventory_sales");
     $this->session->set_userdata('sales_code', $code);
     $GLOBALS['data']['code'] = $code;
     $GLOBALS['data']['item'] = $this->Inventory->getAllItems();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addinventorysales', $GLOBALS['data']);
     $this->load->view('templates/footer');
   }else{
    redirect('/LandingController');
   }
 }

 function addSalesPayment(){
   $group = array(1,2,5);
   if($this->ion_auth->in_group($group) == TRUE){   
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addsalespayment');
     $this->load->view('templates/footer');  
   }else{
    redirect('/LandingController');
   }
 }

 function viewInventoryItems(){
   $group = array(1,2,5);
   if($this->ion_auth->in_group($group) == TRUE){   
     $this->load->model('Inventory','',TRUE);
     $GLOBALS['data']['item'] = $this->Inventory->getAllItems();
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('viewinventoryitems', $GLOBALS['data']);
     $this->load->view('templates/footer');  
   }else{
    redirect('/LandingController');
   }
 }

 function viewInventoryReport(){
   $group = array(1,2,5);
   if($this->ion_auth->in_group($group) == TRUE){  
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('viewinventoryreport', $GLOBALS['data']);
     $this->load->view('templates/footer'); 
   }else{
    redirect('/LandingController');
   }
 }

 function viewSalesTransactions(){
   $group = array(1,2,5);
   if($this->ion_auth->in_group($group) == TRUE){  
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewsalestransactions', $GLOBALS['data']);
   $this->load->view('templates/footer');    
  }else{
    redirect('/LandingController');
  }
 }

 function viewPurchaseTransactions(){
   $group = array(1,2,5);
   if($this->ion_auth->in_group($group) == TRUE){  
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('viewpurchasetransactions', $GLOBALS['data']);
     $this->load->view('templates/footer');    
   }else{
    redirect('/LandingController');
   }
 }

 function addSimCard(){
    if(($this->ion_auth->in_group('superadmin') == TRUE)){
      $this->load->helper(array('form'));
       $this->load->view('templates/header', $GLOBALS['data']);
      $this->load->view('addsimcard');
      $this->load->view('templates/footer');     
    }
 }

  function viewSimCard(){
    if(($this->ion_auth->in_group('superadmin') == TRUE)){
      $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
      $this->load->helper(array('form'));
      $this->load->view('templates/header', $GLOBALS['data']);
      $this->load->view('viewsimcard', $GLOBALS['data']);
      $this->load->view('templates/footer');     
    }
 }

 function addUser(){
    if(($this->ion_auth->in_group('superadmin') == TRUE)){
      $this->load->helper(array('form'));
       $this->load->view('templates/header', $GLOBALS['data']);
      $this->load->view('adduser');
      $this->load->view('templates/footer');     
    }
 }

function deleteUser(){
    if(($this->ion_auth->in_group('superadmin') == TRUE)){
      $this->load->helper(array('form'));
       $this->load->view('templates/header', $GLOBALS['data']);
      $this->load->view('deleteuser');
      $this->load->view('templates/footer');     
    }
 }

  function editAccount(){
    $this->load->helper(array('form'));
    $this->load->view('templates/header', $GLOBALS['data']);
    $this->load->view('editaccount');
    $this->load->view('templates/footer');     
 }



}
 
?>
