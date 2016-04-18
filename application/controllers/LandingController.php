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
 }

 function index(){
   $data['page'] = "";
   $this->load->view('templates/header',$data);
   $this->load->view('index');
   $this->load->view('templates/footer');
 }
 
 function addDSP()
 {
   $this->load->helper(array('form'));
   $data['page'] = "adddsp";
   $data['dss'] = $this->dss->getAllDSS();
   $this->load->view('templates/header', $data);
   $this->load->view('adddsp', $data);
   $this->load->view('templates/footer');
 }
 function addDSS(){
   $this->load->helper(array('form'));
   $data['page'] = "adddss";
   $this->load->view('templates/header', $data);
   $this->load->view('adddss', $data);
   $this->load->view('templates/footer');
 }

  function viewDSS(){
   $data['page'] = "viewdss";
   $data['dss'] = $this->dss->getAllDSS();
   $this->load->view('templates/header', $data);
   $this->load->view('viewdss', $data);
   $this->load->view('templates/footer');
 }

 function editDSP()
 {
   $data['page'] = "editdsp";
   $data['dsp'] = $this->dsp->getAllDSP();
   $data['dss'] = $this->dss->getAllDSS();
   $this->load->view('templates/header', $data);
   $this->load->view('editdsp', $data);
   $this->load->view('templates/footer');
 }

 function deleteDSP()
 {
   $data['page'] = "deletedsp";
   $data['dsp'] = $this->dsp->getAllDSP();
   $this->load->view('templates/header', $data);
   $this->load->view('deletedsp', $data);
   $this->load->view('templates/footer');
 }

 function addTransaction(){
   $this->load->helper(array('form'));
   $data['page'] = "addtransaction";
   $data['sim'] = $this->globalSim->getAllSim();
   $data['dsp'] = $this->dsp->getAllDSP();
   $this->load->view('templates/header', $data);
   $this->load->view('addtransaction', $data);
   $this->load->view('templates/footer');
 }

  function viewTransaction(){
   $data['page'] = "viewtransaction";
   $data['trans'] = $this->transaction->getAllTransaction();
   $data['dsp'] = $this->dsp->getAllDSP();
   $data['sim'] = $this->globalSim->getAllSim();
   $this->load->view('templates/header', $data);
   $this->load->view('viewtransaction', $data);
   $this->load->view('templates/footer');
 }

   function searchTransaction(){
   $data['page'] = "searchtransaction";
   $this->load->view('templates/header', $data);
   $this->load->view('searchtransaction', $data);
   $this->load->view('templates/footer');
 }



}
 
?>
