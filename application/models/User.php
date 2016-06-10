<?php
Class User extends CI_Model
{
  public function __construct() {
    parent::__construct();

    $this->load->library('session');

  }
 function login($username, $password)
 {

   if($this->ion_auth->login($username, $password, FALSE) == TRUE){
        $rows = $this->ion_auth->user()->row();
        $newdata = array(
          'user_id' => $rows->id,
          'firstname'  => $rows->first_name,
          'lastname'    => $rows->last_name,
        );
       $this->session->set_userdata($newdata);    
       return true;
   }else{
    return false;
   }
 }

 function getUserbyID($user_id){

  $this->db-> where('user_id', $user_id);
  $this->db->from('user');
  $query = $this->db->get();
   if($query -> num_rows() == 1)
   {
      return $query->result();
   }
   else
   {
     return false;
   }
 }

 function getUser($username){
  $this -> db -> from('user');
   $this -> db -> where('username', $username);
   $this -> db -> limit(1);
 
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
      return $query->result();
   }
   else
   {
     return false;
   }

 }

 function getAllUser(){
  $this->db->from('user');
  $query = $this->db->get();
  return $query->result();
 }
 function register($data){
  $this->db->insert('user', $data);
  if ($this->db->affected_rows() > 0) {
  return true;
  }else {
  return false;
  }
 }

 function editAccount($data, $user_id){
  $this->db->where('user_id', $user_id);
  $this->db->update('user', $data);
  if ($this->db->affected_rows() >= 0) {
      $this->session->set_userdata('username', $data['username']);
      return true;
  }else {
      return false;
  }
 }

 function checkduplicate($username){
   $this -> db -> select('id, username');
   $this -> db -> from('user');
   $this -> db -> where('username', $username);
   $this -> db -> limit(1);
   $query = $this -> db -> get();
 
   if($query -> num_rows() == 1)
   {
     return true;
   }
   else
   {
     return false;
   }

 }

 function checkpassword($password){
   $username = $this->session->userdata('username');
   $this -> db -> select('password');
   $this -> db -> from('user');
   $this -> db -> where('username', $username);
   $this -> db -> limit(1);
   $query = $this -> db -> get();
   foreach($query->result() as $row){
      if(MD5($password) == $row->password)
        return true;
      else
        return false;
   }
 }

 function changepassword($data){
  $username = $this->session->userdata('username');
  $this->db->where('username', $username);
  $this->db->update('user', $data);
  if ($this->db->affected_rows() > 0) {
    return true;
  }else {
    return false;
  }
 }
}
?>
