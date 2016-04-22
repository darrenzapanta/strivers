<?php
Class Transaction extends CI_Model
{
  public function __construct() {
  	
    parent::__construct();
    $this->load->model('globalsim','',TRUE);
  }

  function addTransaction($data){
    $this->db->trans_start();
  	$this->db->insert('load_transaction', $data);
	if ($this->db->affected_rows() > 0) {
		$data2 = array(
			'amount' => $data['amount']
			);
		$global_name = $data['global_name'];
		$ret = $this->globalsim->updateBalance($data2, $global_name, "sub");
    if($ret == false){
      $this->db->trans_rollback();
    }
    $this->db->trans_complete();
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

  function getTransactionForGraph($date1, $date2, $global_name){
    $this->db->select('count(transaction_id) as count, cast(date_created as date) as date_created');
    $this->db->from('load_transaction');
    $this->db->where('global_name', $global_name);
    if($date1 != $date2){
      $this->db->where("CAST(date_created AS DATE) between '".$date1."' and '".$date2."'");
    }else{
      $this->db->where("CAST(date_created AS DATE) = '".$date1."'");
    }
    $this->db->group_by('cast(date_created as date)');
    $this->db->order_by('date_created', 'DESC');
    $query = $this->db->get();
    return $query->result();
  }

  function getTopDSP($date1, $date2, $global_name){
    $this->db->select('sum(amount) as amount, dsp_firstname, dsp_lastname');
    $this->db->from('load_transaction');
    $this->db->join('dsp', 'dsp.dsp_id = load_transaction.dsp_id');
    $this->db->where('global_name', $global_name);
    if($date1 != $date2){
      $this->db->where("CAST(date_created AS DATE) between '".$date1."' and '".$date2."'");
    }else{
      $this->db->where("CAST(date_created AS DATE) = '".$date1."'");
    }
    $this->db->group_by('load_transaction.dsp_id');
    $this->db->order_by('amount', 'DESC');
    $this->db->limit(5);
    $query = $this->db->get();
    return $query->result();
  }

  function getTransactionByDate($date1, $date2, $global_name){
    $this->db->select('*');
    $this->db->from('load_transaction');
    $this->db->join('dsp', 'dsp.dsp_id = load_transaction.dsp_id');
    $this->db->where('global_name', $global_name);
    if($date1 != $date2){
      $this->db->where("CAST(date_created AS DATE) between '".$date1."' and '".$date2."'");
    }else{
      $this->db->where("CAST(date_created AS DATE) = '".$date1."'");
    }
    $this->db->order_by('date_created', 'DESC');
    $query = $this->db->get();
    $result = $query->result_array();
    $data2 = array();
    foreach($result as $trans){
      $data = array();
      $data['name'] = $trans['dsp_firstname']." ".$trans['dsp_lastname'];
      $data['dsp_id'] = $trans['dsp_id'];
      $data['global_name'] = $trans['global_name'];
      $data['confirm_no'] = $trans['confirm_no'];
      $data['amount'] = $trans['amount'];
      $data['date_created'] = $trans['date_created'];
      $data['dealer_no'] = $trans['dealer_no'];   
      $data['run_bal'] = " ";   
      $data['beg_bal'] = " ";
      $data['transaction_id'] = $trans['transaction_id'];
      $data2[] = $data;   
    }
    return $data2;
  }

  function getDetailedTransaction($global_name, $date1, $date2, $pochk){
    $this->db->select('*');
    $this->db->from('load_transaction');
    $this->db->join('dsp', 'dsp.dsp_id = load_transaction.dsp_id');
    $this->db->where('global_name', $global_name);
    $this->db->where("CAST(date_created AS DATE) >= '".$date1."'");
    $this->db->order_by('date_created', 'DESC');
    $query = $this->db->get();
    $this->db->select('*');
    $this->db->from('purchase_order');
    $this->db->where('global_name', $global_name);
    $this->db->where("CAST(date_created AS DATE) >= '".$date1."'");
    $this->db->order_by('date_created', 'DESC');
    $query2 = $this->db->get();
    $j = $query->num_rows();
    $k = $query2->num_rows();
    $count = $j+$k;
    $current_balance = $this->globalsim->getCurrentBalance($global_name);
    $trans = $query->first_row('array');
    $po = $query2->first_row('array');
    $result = array();
    $f_date1 = new DateTime($date1);
    $f_date2 = new DateTime($date2);
    $date1 = $f_date1->format('Y-m-d');
    $date2 = $f_date2->format('Y-m-d');
    for($i = 0; $i < $count; $i++){
      $trans_d = new DateTime($trans['date_created']);
      $po_d = new DateTime($po['date_created']);
      $f_date3 = $trans_d->format('Y-m-d');
      $f_date4 = $po_d->format('Y-m-d');
      if(($trans_d > $po_d || $k <= 0) && $j > 0){

        if($f_date3 <= $date2){
          $data = array();
          $data['run_bal'] = $current_balance;
          $current_balance += $trans['amount'];
          $data['dsp_id'] = $trans['dsp_id'];
          $data['beg_bal'] = $current_balance;
          $data['transaction_id'] = $trans['transaction_id'];
          $data['name'] = $trans['dsp_firstname']." ".$trans['dsp_lastname'];
          $data['global_name'] = $global_name;
          $data['amount'] = $trans['amount'];
          $data['confirm_no'] = $trans['confirm_no'];
          $data['date_created'] = $trans['date_created'];
          $data['dealer_no'] = $trans['dealer_no'];
          array_push($result, $data);
        }else{
          $current_balance += $trans['amount'];
        }
          $trans = $query->next_row('array');
          $j--;        
      }elseif (($po_d >= $trans_d || $j <= 0 ) && $k > 0) {
          if($pochk == 1 && $f_date4 <= $date2){
            $data = array();
            $data['name'] =  "Purchase Order";
            $data['dsp_id'] = "none";
            $data['global_name'] = $global_name;
            $data['run_bal'] = $current_balance;
            $current_balance -= $po['amount'];
            $data['amount'] = $po['amount'];
            $data['beg_bal'] = $current_balance;
            $data['transaction_id'] = "none";
            $data['dealer_no'] = " ";
            $data['date_created'] = $po['date_created'];
            $data['confirm_no'] = " ";
            array_push($result, $data);
          }else{
            $current_balance -= $po['amount'];
          }
          $po = $query2->next_row('array');
          $k--;
      }
    }
    return $result;
  }

  function editTransaction($data, $trans_id){
    $this->db->trans_start();
    $this->db->select('*');
    $this->db->from('load_transaction');
    $this->db->where('transaction_id', $trans_id);
    $query = $this->db->get();
    foreach($query->result() as $row){
      if(floatval($row->amount) != floatval($data['amount']) || $row->global_name != $data['global_name']){
          if($data['global_name'] == $row->global_name){
            $beg_balance = $this->globalsim->getCurrentBalance($data['global_name']);
            $current_balance = (floatval($beg_balance) + floatval($row->amount)) - floatval($data['amount']);
            $data2 = array('current_balance' => $current_balance);
            $this->db->where('global_name', $data['global_name']);
            $this->db->update('global_balance', $data2);         
          }else if($data['global_name'] != $row->global_name){
            $beg_balance = $this->globalsim->getCurrentBalance($row->global_name);
            $current_balance = floatval($beg_balance) + floatval($row->amount);
            $data2 = array('current_balance' => $current_balance);
            $this->db->where('global_name', $row->global_name);
            $this->db->update('global_balance', $data2); 
            $beg_balance = $this->globalsim->getCurrentBalance($data['global_name']);
            $current_balance = floatval($beg_balance) - floatval($data['amount']);
            $data2 = array('current_balance' => $current_balance);
            $this->db->where('global_name', $data['global_name']);
            $this->db->update('global_balance', $data2);  
          }
        }
    }
  	$this->db->from('load_transaction');
	  $this->db->where('transaction_id', $trans_id);
	  $this->db->update('', $data);
    $this->db->trans_complete();
  }
  function getTransactionCount(){
    return $this->db->count_all('load_transaction');
  }
  function deleteTransaction($trans_id){
  	$this->db->trans_start();
  	$this->db->select('*');
  	$this->db->from('load_transaction');
  	$this->db->where('transaction_id', $trans_id);
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
    $data = array ('current_balance' => $current_balance + $amount);
	$this->db->where('global_name', $globalname);
	$this->db->update('global_balance', $data);
  	$this->db->where('transaction_id', $trans_id);
	$this->db->delete('load_transaction');
	$this->db->trans_complete();
	if($this->db->affected_rows() >= 0){
		return true;
		
	}
	return false;
  }

}
