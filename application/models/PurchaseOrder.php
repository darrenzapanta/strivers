<?php
Class Purchaseorder extends CI_Model
{
  public function __construct() {
  	
    parent::__construct();
    $this->load->model('globalSim','',TRUE);
  }

  function addPurchaseOrder($data){
   $this->db->trans_start();
   $this->db->insert('purchase_order', $data);
	 if ($this->db->affected_rows() > 0) {
		$data2 = array(
			'amount' => $data['amount']
			);
		$global_name = $data['global_name'];
		$ret = $this->globalSim->updateBalance($data2, $global_name, "add");
    if($ret == false){
      $this->db->trans_rollback();
    }
    $this->db->trans_complete();
		return true;
	}else {
		return false;
	}

  }

  function getAllPurchaseOrder(){
  	$this->db->select('*');
  	$this->db->from('purchase_order');
  	$query = $this->db->get();
    return $query->result();
  }

  function editPurchaseOrder($data, $purchase_id){
    $this->db->trans_start();
    $this->db->select('*');
  	$this->db->from('purchase_order');
	  $this->db->where('purchase_id', $purchase_id);
    $query = $this->db->get();
    foreach($query->result() as $row){
      if(floatval($row->amount) != floatval($data['amount']) || $row->global_name != $data['global_name']){
          if($data['global_name'] == $row->global_name){
            $beg_balance = $this->globalSim->getCurrentBalance($data['global_name']);
            $current_balance = (floatval($beg_balance) - floatval($row->amount)) + floatval($data['amount']);
            $data2 = array('current_balance' => $current_balance);
            $this->db->where('global_name', $data['global_name']);
            $this->db->update('global_balance', $data2);         
          }else if($data['global_name'] != $row->global_name){
            $beg_balance = $this->globalSim->getCurrentBalance($row->global_name);
            $current_balance = floatval($beg_balance) - floatval($row->amount);
            $data2 = array('current_balance' => $current_balance);
            $this->db->where('global_name', $row->global_name);
            $this->db->update('global_balance', $data2); 
            $beg_balance = $this->globalSim->getCurrentBalance($data['global_name']);
            $current_balance = floatval($beg_balance) + floatval($data['amount']);
            $data2 = array('current_balance' => $current_balance);
            $this->db->where('global_name', $data['global_name']);
            $this->db->update('global_balance', $data2);  
          }

        }
    }
    $this->db->from('purchase_order');
    $this->db->where('purchase_id', $purchase_id);    
	  $this->db->update('', $data);
    $this->db->trans_complete();


  }

  function recomputeBalance(){

  }

  function deletePurchaseOrder($purchase_id){
      $this->db->trans_start();
      $this->db->select('*');
      $this->db->from('purchase_order');
      $this->db->where('purchase_id', $purchase_id);
      $query = $this->db->get();
      foreach($query->result() as $row){
        $globalname = $row->global_name;
        $amount = $row->amount;
      }
      $this->db->select('current_balance');
      $this->db->from('global_balance');
      $this->db->where('global_name', $globalname);
      $this->db->limit(1);
      $query = $this->db->get();
    if($query -> num_rows() == 1)
    {
      foreach($query->result() as $row)
        $current_balance = $row->current_balance;
    }
    $run_bal = floatval($current_balance) - floatval($amount);
      $data = array ('current_balance' => $run_bal);
    $this->db->where('global_name', $globalname);
    $this->db->update('global_balance', $data);
      $this->db->where('purchase_id', $purchase_id);
    $this->db->delete('purchase_order');
    $this->db->trans_complete();
    if($this->db->affected_rows() >= 0){
      return true;
      
    }
    return false;
  }

}
