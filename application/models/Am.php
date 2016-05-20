<?php
Class Am extends CI_Model
{
  public function __construct() {
    parent::__construct();
    $this->load->model('dsp','',TRUE);
    $this->load->model('Operations','',TRUE);
  }

  function addAM($data){
  	$this->db->insert('am', $data);
	if ($this->db->affected_rows() > 0) {
		return true;
	}else {
		return false;
	}

  }

  function checkAMCodeAndSim($amcode, $sim){
  	$this->db->from('am');
  	$this->db->where('am_code', $amcode);
  	$this->db->where('am_global_name', $sim);
  	$query = $this->db->get();
  	if($query -> num_rows() >= 1){
  		return false;
  	}
  	return true;
  }

  function getAMCount(){
  	return $this->db->count_all('am');
  }

 function addBalance($am_id, $amount, $percentage){
	$result = $this->getAMbyID($am_id);
	if($result != false){
	foreach($result as $res){
		$cur_bal = $res->am_totalbalance;
	}
	$netamount = $this->Operations->getNetAmount($amount, $percent);
	$run_bal = $this->Operations->add($cur_bal, $netamount);
	$data = array('am_totalbalance' => $run_bal);
  	$this->db->where('am_code', $am_code);
  	$this->db->update('am', $data);		
  	if($this->db->trans_status() === FALSE){
	  		return false;
	  	}else{
	  		return true;
	  	}
  	}else{
  		return false;
  	}


 }

 function getTotalBalance($am_code){
 	$this->db->select('am_totalbalance');
 	$this->db->from('am');
 	$this->db->where('am_code', $am_code);
 	$query = $this->db->get();
 	if($query->num_rows() == 1){
 		foreach($query->result() as $res){
 			return $res->am_totalbalance;
 		}
 	}else{
 		return false;
 	}
 }


  function deleteAM($am_code, $data){
  	$this->db->trans_start();
  	if($data != null){
  		$this->db->update_batch('dsp',$data, 'dsp_id'); 
  	}
  	$this->db->where('am_code', $am_code);
	$this->db->delete('am');
	$this->db->trans_complete();
	if($this->db->trans_status() === FALSE){
		return false;
	}else{
		return true;
	}
  }

  function getAllAM(){
  	$this->db->select('*');
  	$this->db->from('am');
  	$query = $this->db->get();
    return $query->result();
  }


  function editAM($data, $am_code){

	  $this->db->where('am_code', $am_code);
	  $this->db->update('am', $data);
	  if ($this->db->affected_rows() >= 0) {
	    return true;
	  }else {
	    return false;
	  }
  }

 function getAMbyLocation($name){
 	$this->db->select('*');
	$this->db->from('am');
	$this->db-> where('am_location', $location);
	$this->db->limit(1);
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

 function getAMbyCode($code){
 	$this->db->select('*');
	$this->db->from('am');
	$this->db-> where('am_code', $code);
	$this->db->limit(1);
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

}
