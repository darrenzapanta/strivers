<?php
Class globalsim extends CI_Model
{
  public function __construct() {
    parent::__construct();
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

  function getAllTransaction(){
  	$this->db->select('*');
  	$this->db->from('load_transaction');
  	$query = $this->db->get();
    return $query->result();
  }

  function updateBalance($data, $global_name, $op = null){
    $curr_bal = $this->getCurrentBalance($global_name);
    if($op == "sub"){
      $data2 = array ('current_balance' => $curr_bal - $data['amount']);
    }else if($op == "add"){
      $data2 = array ('current_balance' => $curr_bal + $data['amount']);
    }else{
      return false;
    }
	  $this->db->where('global_name', $global_name);
	  $this->db->update('global_balance', $data2);
	  return true;

  }

}
