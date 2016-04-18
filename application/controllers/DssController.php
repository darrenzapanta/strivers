<?php

class DssController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
   $this->load->helper('url');
   $this->load->library('session');
   $this->load->model('dsp','',TRUE);
   $this->load->model('dss','',TRUE);
   if(!($this->session->userdata('logged_in') == true)){
      $this->load->view('errors/index');
   }
   $GLOBALS['data']['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname') ;
 }

 function addDSS()
 {
   $this->load->library('form_validation');

   $this->form_validation->set_rules('firstname', 'First Name', 'trim|required');
   $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required');
   $this->form_validation->set_rules('gender', 'Gender', 'trim|required|alpha');
   $this->form_validation->set_rules('contactno', 'Contact Number', 'trim');
   $this->form_validation->set_rules('email', 'E-mail', 'trim|valid_email');
   $this->form_validation->set_rules('birthday', 'Date of Birth', 'trim|required');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.
     $GLOBALS['data']['page'] = "adddss";
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('adddss');
     $this->load->view('templates/footer');
   }
   else
   {
     $firstname = $this->input->post('firstname');
     $lastname = $this->input->post('lastname');
     $contactno = $this->input->post('contactno');
     $email = $this->input->post('email');
     $birthday = $this->input->post('birthday');
     $gender = $this->input->post('gender');
     $f_birthday = date("Y-m-d", strtotime($birthday));
     $data = array(
              'dss_firstname' => $firstname,
              'dss_lastname' => $lastname,
              'dss_contactno' => $contactno,
              'dss_email' => $email,
              'dss_birthday' => $f_birthday,  
              'dss_gender' => $gender
              );

     $ret = $this->dss->addDSS($data);
     if($ret === false){
         $this->session->set_flashdata('message', 'Error has occured.');
     }else{
         $this->session->set_flashdata('message', 'Added Successfully.');
     }
    redirect('/landingController/addDSS');
   }
 }

 function editDSS(){
   $dss_id = $this->input->post('dss_id');
   $firstname = $this->input->post('firstname');
   $lastname = $this->input->post('lastname');
   $gender = $this->input->post('gender');
   $contactno = $this->input->post('contactno');
   $email = $this->input->post('email');
   $birthday = $this->input->post('birthday');
   $data = array( 
            'dss_firstname' => $firstname,
            'dss_lastname' => $lastname,
            'dss_gender' => $gender,
            'dss_contactno' => $contactno,
            'dss_email' => $email,
            'dss_birthday' => $birthday
            );
   $ret = $this->dss->editDSS($data,$dss_id);
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

 function deleteDSS(){
   $dss_id = $this->input->post('dss_id');
   $result = $this->dsp->getAllDSPbyDSS($dss_id);
   $data = null;
   if($result != NULL){
   foreach($result as $row){
      $data[] = array(
        'dsp_id' => $row->dsp_id,
        'dss_id' => 0
        );
     }
   }
   $ret = $this->dss->deleteDSS($dss_id, $data);
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
