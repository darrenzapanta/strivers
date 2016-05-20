<?php
Class Globalsim extends CI_Model
{
  public function __construct() {
    parent::__construct();
    $this->load->model('Operations','',TRUE);
  }

  function getCurrentBalance($global_name){
  	$this->db->select('current_balance');
  	$this->db->from('global_balance');
  	$this->db->where('global_name', $global_name);
  	$this->db->limit(1);
  	$query = $this->db->get();
	if($query -> num_rows() == 1)
	{
	  foreach($query->result() as $row)
	  	return $row->current_balance;
	}
	else
	{
	 return false;
	}

  }

  function getAllSim(){
  	$this->db->select('*');
  	$this->db->from('global_balance');
  	$query = $this->db->get();
    return $query->result();
  }

  function getSimbyName($global_name){
    $this->db->from('global_balance');
    $this->db->where('global_name', $global_name);
    $query = $this->db->get();
    if($query->num_rows() == 1){
      return $query->result();
    }else{
      return false;
    }
  }

  function getAllTransaction(){
  	$this->db->select('*');
  	$this->db->from('load_transaction');
  	$query = $this->db->get();
    return $query->result();
  }

  function updateBalance($data, $global_name, $op = null){
    $curr_bal = $this->getCurrentBalance($global_name);
    if($curr_bal != false){
      if($op == "sub"){
        $run_bal = $this->Operations->subtract($curr_bal, $data['amount']);
        $data2 = array ('current_balance' => $run_bal);
      }else if($op == "add"){
        $run_bal = $this->Operations->add($curr_bal, $data['amount']);
        $data2 = array ('current_balance' => $run_bal);
      }else{
        return false;
      }
      $this->db->trans_start();
  	  $this->db->where('global_name', $global_name);
  	  $this->db->update('global_balance', $data2);
      $this->db->trans_complete();
      if($this->db->trans_status() === FALSE){
  	   return false;
      }else{
        return true;
      }
    }else{
      return false;
    }

  }

}
