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
   $topDSP = array();

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
   $GLOBALS['data']['am'] = $this->Am->getAllAM();
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('adddsp', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }
 function addAM(){
   $this->load->helper(array('form'));
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('addam', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

  function viewAM(){

   $GLOBALS['data']['am'] = $this->Am->getAllAM();
   $this->load->helper(array('form'));
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewam', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

 function editDSP()
 {

   $GLOBALS['data']['dsp'] = $this->Dsp->getAllDSP();
   $GLOBALS['data']['am'] = $this->Am->getAllAM();
   $this->load->helper(array('form'));
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('editdsp', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }



 function addTransaction(){
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
   function detailedTransaction(){
   $GLOBALS['data']['trans'] = array();
   $this->load->helper(array('form'));
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('detailedtransaction', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

   function addPaymentAM(){
   $this->load->helper(array('form'));
   $GLOBALS['data']['am'] = $this->Am->getAllAM();
   $GLOBALS['data']['sim'] = $this->Globalsim->getAllSim();
   
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('addpaymentam', $GLOBALS['data']);
   $this->load->view('templates/footer');
}

   function addPaymentUN(){
   $this->load->helper(array('form'));
   $GLOBALS['data']['am'] = $this->Am->getAllAM();
   $GLOBALS['data']['dsp'] = $this->Dsp->getAllDSP();
   
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('addpaymentun', $GLOBALS['data']);
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

 function addInventoryItem(){

   $this->load->helper(array('form'));
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('addinventoryitem', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

  function addInventoryPurchase(){
   $this->load->model('Inventory','',TRUE);
   $this->load->helper(array('form'));

   $GLOBALS['data']['item'] = $this->Inventory->getAllItems();
   $code = $this->Operations->generateCode("inventory_purchase");
   $this->session->set_userdata('purchase_code', $code);
    $GLOBALS['data']['code'] = $code;
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('addinventorypurchase', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

  function addInventorySales(){
   
   $this->load->model('Inventory','',TRUE);
   $this->load->helper(array('form'));
   $code = $this->Operations->generateCode("inventory_sales");
   $this->session->set_userdata('sales_code', $code);
   $GLOBALS['data']['code'] = $code;
   $GLOBALS['data']['item'] = $this->Inventory->getAllItems();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('addinventorysales', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

 function addSalesPayment(){
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('addsalespayment');
   $this->load->view('templates/footer');  
 }

 function viewInventoryItems(){
   $this->load->model('Inventory','',TRUE);
   $GLOBALS['data']['item'] = $this->Inventory->getAllItems();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewinventoryitems', $GLOBALS['data']);
   $this->load->view('templates/footer');  
 }

 function viewInventoryReport(){
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewinventoryreport', $GLOBALS['data']);
   $this->load->view('templates/footer'); 
 }

 function viewSalesTransactions(){
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewsalestransactions', $GLOBALS['data']);
   $this->load->view('templates/footer');    
 }

 function viewPurchaseTransactions(){
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewpurchasetransactions', $GLOBALS['data']);
   $this->load->view('templates/footer');    
 }


}
 
?>
