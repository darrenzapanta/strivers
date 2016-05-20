<?php
Class Dsp extends CI_Model
{
  public function __construct() {
    parent::__construct();
    $this->load->model('Operations','',TRUE);
  }

  function unassignDSP($dsp_id){
  	  $data = array(
  	  			'dss_id' => 0
  	  			);
	  $this->db->where('dsp_id', $dsp_id);
	  $this->db->update('dsp', $data);
  }

  function checkDealerNo($dealerno){
  	$this->db->select('*');
  	$this->db->from('dsp_details');
  	$this->db->where('dsp_dealer_no', $dealerno);
  	$query = $this->db->get();
  	if($query -> num_rows() > 0)
	{
	  return false;
	}else{
		return true;
	}  	
  }

  function getDSPbyDealerno($dealerno){
  	$this->db->select('*');
  	$this->db->from('dsp_details');
  	$this->db->where('dsp_dealer_no', $dealerno);
  	$this->db->join('dsp', 'dsp.dsp_id = dsp_details.dsp_id');
  	$query = $this->db->get();
  	if($query->num_rows() == 1){
  		return $query->result();
  	}else{
  		return false;
  	}
  }

  function addDSP($data, $data2){
	  	$this->db->trans_start();
	  	$this->db->insert('dsp', $data);
		if ($this->db->affected_rows() > 0) {
			$this->db->select('dsp_id');
			$this->db->from('dsp');
			$this->db->order_by('dsp_id', 'DESC');
			$this->db->limit(1);
			$query = $this->db->get();
			$row = $query->row();

			if(isset($row)){
				$data2['dsp_id'] = $row->dsp_id;
				$this->db->insert('dsp_details', $data2);
			  	if($this->db->affected_rows() > 0) {
			  		$this->db->trans_complete();
			  		return true;
			  	}			
			}
			return false;
		}else {
			return false;
		}
  }

  function deleteDSP($dsp_id){
  	$this->db->where('dsp_id', $dsp_id);
	$this->db->delete('dsp');
	if($this->db->affected_rows() > 0){
		return true;
	}
	return false;
  }

  function editDSP($data, $data2, $dsp_id){
  	  $this->db->trans_start();
	  $this->db->where('dsp_id', $dsp_id);
	  $this->db->update('dsp', $data);
	  $this->db->where('dsp_dealer_no', $data2['dsp_dealer_no']);
  	  $this->db->update('dsp_details', $data2);
  	  $this->db->trans_complete();
  	  return true;
  }

  function getAllDSP(){
  	$this->db->select('*');
  	$this->db->from('dsp');
  	$this->db->join('dsp_details', 'dsp.dsp_id = dsp_details.dsp_id');
  	$this->db->join('am', 'am.am_code = dsp.am_code');
  	$query = $this->db->get();
    return $query->result();
  }

 function getDSPbyName($name){
 	$this->db->select('*');
	$this->db->from('dsp');
	$this->db->join('dsp_details', 'dsp.dsp_id = dsp_details.dsp_id');
	$this ->db-> where('dsp_name', $name);
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

 function getDSPbyID($dsp_id){
 	$this->db->select('*');
	$this->db->from('dsp');
	$this ->db-> where('dsp.dsp_id', $dsp_id);
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

 function addBalance($dsp_dealer_no, $amount){
 	$this->db->select('*');
	$this->db->from('dsp_details');
	$this->db->where('dsp_dealer_no', $dsp_dealer_no);
	$query = $this->db->get();
	if($query->num_row() == 1){
		foreach($query->result() as $res){
			$cur_bal = $res->dsp_balance;
			$percent = $res->dsp_percentage;
		}
		$netamount = $this->Operations->getNetAmount($amount, $percent);
		$run_bal = $this->Operations->add($cur_bal, $netamount);
		$data = array('dsp_balance' => $run_bal);
		$this->db->trans_start();
	  	$this->db->where('dsp_dealer_no', $dsp_dealer_no);
	  	$this->db->update('dsp_details', $data);		
	  	$this->load->trans_complete();
	  	if($this->db->trans_status() === FALSE){
	  		return false;
	  	}else{
	  		return true;
	  	}
	}else{
		return false;
	}


 }

 function getAllDSPbyAM($am_code){
 	$this->db->select('*');
  	$this->db->from('dsp');
  	$this->db->where('am_code', $am_code);
  	$query = $this->db->get();
  	if($query -> num_rows() > 0)
	{
	  return $query->result();
	}
	else
	{
	 return false;
	} 

 }

 function getDSPbyNetwork($network){
 	$this->db->select('*');
	$this->db->from('dsp');
	$this->db->join('dsp_details', 'dsp.dsp_id = dsp_details.dsp_id');

	$this ->db-> where('network', $network);
	$query = $this->db-> get();
	if($query -> num_rows() == 1)
	{
	  return $query->result();
	}
	else
	{
	 return false;
	}
 }

 function getDSPbyDSS($dss_name){
 	$sql = "Select * from dsp_details inner join (Select dsp_id from dsp inner join (Select * from dss where dss_name = ".$this->db->escape($dss_name).") dss on (dsp.dsp_id = dss.dss_id)) dsp on (dsp_details.dsp_id = dsp.dsp_id";
 }

}
