<?php

class LandingController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('dsp','',TRUE);
   $this->load->model('dss','',TRUE);
   $this->load->model('globalSim','',TRUE);
   $this->load->model('transaction','',TRUE);
   if(!($this->session->userdata('logged_in') == true)){
      $this->load->view('errors/index');
   }
   $GLOBALS['data']['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname') ;
 }

 function index(){
   $GLOBALS['data']['page'] = "";
   $this->load->view('templates/header',$GLOBALS['data']);
   $this->load->view('index');
   $this->load->view('templates/footer');
 }
 
 function addDSP()
 {
   $this->load->helper(array('form'));
   $GLOBALS['data']['page'] = "adddsp";
   $GLOBALS['data']['dss'] = $this->dss->getAllDSS();
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
   $GLOBALS['data']['page'] = "viewdss";
   $GLOBALS['data']['dss'] = $this->dss->getAllDSS();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewdss', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

 function editDSP()
 {
   $GLOBALS['data']['page'] = "editdsp";
   $GLOBALS['data']['dsp'] = $this->dsp->getAllDSP();
   $GLOBALS['data']['dss'] = $this->dss->getAllDSS();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('editdsp', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

 function deleteDSP()
 {
   $GLOBALS['data']['page'] = "deletedsp";
   $GLOBALS['data']['dsp'] = $this->dsp->getAllDSP();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('deletedsp', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

 function addTransaction(){
   $this->load->helper(array('form'));
   $GLOBALS['data']['page'] = "addtransaction";
   $GLOBALS['data']['sim'] = $this->globalSim->getAllSim();
   $GLOBALS['data']['dsp'] = $this->dsp->getAllDSP();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('addtransaction', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

  function viewTransaction(){
   $GLOBALS['data']['page'] = "viewtransaction";
   $GLOBALS['data']['trans'] = $this->transaction->getAllTransaction();
   $GLOBALS['data']['dsp'] = $this->dsp->getAllDSP();
   $GLOBALS['data']['sim'] = $this->globalSim->getAllSim();
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('viewtransaction', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }

   function searchTransaction(){
   $GLOBALS['data']['page'] = "searchtransaction";
   $this->load->view('templates/header', $GLOBALS['data']);
   $this->load->view('searchtransaction', $GLOBALS['data']);
   $this->load->view('templates/footer');
 }



}
 
?>
