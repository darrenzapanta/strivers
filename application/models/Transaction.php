<?php
Class transaction extends CI_Model
{
  public function __construct() {
  	
    parent::__construct();
    $this->load->model('globalSim','',TRUE);
  }

  function addTransaction($data){
  	$this->db->insert('load_transaction', $data);
	if ($this->db->affected_rows() > 0) {
		$data2 = array(
			'current_balance' => $data['run_bal']
			);
		$global_name = $data['global_name'];
		$ret = $this->globalSim->updateBalance($data2, $global_name);
		return true;
		
	}else {
		return false;
	}

  }

  function getAllTransaction(){
  	$this->db->select('*');
  	$this->db->from('load_transaction');
  	$this->db->join('dsp', 'dsp.dsp_id = load_transaction.dsp_id');
  	$query = $this->db->get();
    return $query->result();
  }


  function editTransaction($data){
	  $this->db->where('name', $username);
	  $this->db->update('dss', $data);
	  if ($this->db->affected_rows() > 0) {
	    return true;
	  }else {
	    return false;
	  }
  }


}
