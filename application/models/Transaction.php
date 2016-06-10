<?php
Class Transaction extends CI_Model
{
  public function __construct() {
  	
    parent::__construct();
    $this->load->model('globalsim','',TRUE);
    $this->load->model('dsp','',TRUE);
    $this->load->model('Am','',TRUE);
    $this->load->model('Operations','',TRUE);
  }
  function totalSalesByAMCode($date1, $date2){
    $this->db->select('am_code, sum(amount) as amount');
    $this->db->from('load_transaction');
    $this->db->where("CAST(date_created AS DATE) between '".$date1."' and '".$date2."'");
    $this->db->group_by('am_code');
    $query = $this->db->get();
    return $query;
  }
  function addTransaction($data, $simbalance, $totalbalance, $am_code){
    $this->db->trans_start();
  	$this->db->insert('load_transaction', $data);
    $this->db->where('global_name', $data['global_name']);
    $this->db->update('global_balance', $simbalance);
    if($am_code == 'Unassigned'){
      $this->db->where('dsp_dealer_no', $data['dealer_no']);
      $this->db->update('dsp_details', $totalbalance);  
    }else{
      $this->db->where('am_code', $am_code);
      $this->db->update('am', $totalbalance);       
    }
    $this->db->trans_complete();
    if($this->db->trans_status() === FALSE){
      return false;
    }
    return true;

  }

  function addPaymentUN($data, $totalbalance, $dealer_no, $am_code){
    $this->db->trans_start();
    $this->db->insert('load_payment_un', $data);
    if($am_code == 'Unassigned'){
      $this->db->where('dsp_dealer_no', $dealer_no);
      $this->db->update('dsp_details', $totalbalance);       
    }else{
      $this->db->where('am_code', $am_code);
      $this->db->update('am', $totalbalance);         
    }
    $this->db->trans_complete();
    if($this->db->trans_status() === FALSE){
      return false;
    }
    return true;    
  }

  function addPaymentAM($data, $totalbalance, $am_code){
    $this->db->trans_start();
    $this->db->insert('load_payment_am', $data);
    $this->db->where('am_code', $am_code);
    $this->db->update('am', $totalbalance); 
    $this->db->trans_complete();
    if($this->db->trans_status() === FALSE){
      return false;
    }
    return true;
  }

  function getTransactionByTransactionCode($transaction_code){
    $this->db->from('load_transaction');
    $this->db->where('transaction_code', $transaction_code);
    $query = $this->db->get();
    if($query->num_rows() == 1){
      return $query->result();
    }else{
      return false;
    }    
  }

  function getTransactionByConfirmno($confirm_no){
    $this->db->from('load_transaction');
    $this->db->where('confirm_no', $confirm_no);
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
  	$this->db->join('dsp', 'dsp.dsp_id = load_transaction.dsp_id');
  	$query = $this->db->get();
    return $query->result();
  }

  function getPaymentByTransactionCode($transaction_code){
    $this->db->from('load_payment_un');
    $this->db->where('payment_transaction_code', $transaction_code);
    $query = $this->db->get();
    if($query->num_rows() == 1){
      return $query->result();
    }else{
      return false;
    }    
  }

  function getTransactionForGraph($date1, $date2, $global_name){
    $this->db->select('count(transaction_code) as count, cast(date_created as date) as date_created');
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

  function getTransactionUNByDate($date1, $date2){
    $this->db->select('*');
    $this->db->from('load_payment_un');
    if($date1 != $date2){
      $this->db->where("CAST(date_created AS DATE) between '".$date1."' and '".$date2."'");
    }else{
      $this->db->where("CAST(date_created AS DATE) = '".$date1."'");
    }
    $this->db->order_by('date_created', 'DESC');
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    } 
    return false;
  }

  function getTotalRevenue($date1, $date2){
    $this->db->select('amount, load_percentage');
    $this->db->from('load_transaction');
    $this->db->where("CAST(date_created AS DATE) between '".$date1."' and '".$date2."'");
    $query = $this->db->get();
    return $query->result();
  }

  function getTransactionAMByDate($date1, $date2){
    $this->db->select('*');
    $this->db->from('load_payment_am');
    if($date1 != $date2){
      $this->db->where("CAST(date_created AS DATE) between '".$date1."' and '".$date2."'");
    }else{
      $this->db->where("CAST(date_created AS DATE) = '".$date1."'");
    }
    $this->db->order_by('date_created', 'DESC');
    $query = $this->db->get();
    if($query->num_rows() > 0){
      return $query->result();
    } 
    return false;
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
      $data['transaction_code'] = $trans['transaction_code'];
      $data['percentage'] = $trans['load_percentage'] * 100;
      $data['net_amount'] = $trans['net_amount'];
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
          $data['transaction_code'] = $trans['transaction_code'];
          $data['percentage'] = $trans['load_percentage'] * 100;
          $data['net_amount'] = $trans['net_amount'];
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
            $data['dsp_id'] = "None";
            $data['global_name'] = $global_name;
            $data['run_bal'] = $current_balance;
            $current_balance -= $po['amount'];
            $data['amount'] = $po['amount'];
            $data['beg_bal'] = $current_balance;
            $data['transaction_code'] = "None";
            $data['percentage'] = "";
            $data['dealer_no'] = "";
            $data['net_amount'] = "";
            $data['date_created'] = $po['date_created'];
            $data['confirm_no'] = "";
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

  function getDetailedAllPaymentAM($date1, $date2, $am = NULL){
    $this->db->select('am_code');
    $this->db->from('am');
    if($am != NULL){
      $this->db->where('am_code', $am);
    }
    $this->db->order_by('am_code', 'ASC');
    $amquery = $this->db->get();
    $this->db->select('*');
    $this->db->from('load_transaction');
    $this->db->where("CAST(date_created AS DATE) >= '".$date1."'");
    if($am != NULL){
      $this->db->where('am_code', $am);
    }    
    $this->db->order_by('am_code', 'ASC');
    $this->db->order_by('date_created', 'DESC');
    $query = $this->db->get();
    $e_date1 = $this->db->escape($date1);
    if($am == NULL){
      $sql = "SELECT * FROM (select * from load_payment_un where date_created >= ".$e_date1.") p 
              left join (select net_amount, transaction_code from load_transaction) s 
              on p.payment_transaction_code = s.transaction_code
              order by am_code ASC, date_created DESC;";
    }else{
      $e_am = $this->db->escape($am);
      $sql = "SELECT * FROM (select * from load_payment_un where date_created >= ".$e_date1." and am_code = ".$e_am.") p 
              left join (select net_amount, transaction_code from load_transaction) s 
              on p.payment_transaction_code = s.transaction_code
              order by am_code ASC, date_created DESC;";      
    }
    $query2 = $this->db->query($sql);
    $j = $query->num_rows();
    $k = $query2->num_rows();
    $z = $amquery->num_rows();
    $count = $j+$k+$z;
    $trans = $query->first_row('array');
    $p_un = $query2->first_row('array');
    $am = $amquery->first_row('array');
    $result = array();
    $f_date1 = new DateTime($date1);
    $f_date2 = new DateTime($date2);
    $date1 = $f_date1->format('Y-m-d');
    $date2 = $f_date2->format('Y-m-d');
    $flag = false;
    for($i = 0; $i < $count; $i++){
      $trans_d = new DateTime($trans['date_created']);
      $p_un_d = new DateTime($p_un['date_created']);
      $f_date3 = $trans_d->format('Y-m-d');
      $f_date4 = $p_un_d->format('Y-m-d');
      if($flag == false && $z >= 0){
        if($am['am_code'] == 'Unassigned'){
          $am = $amquery->next_row('array');
          $am_code = $am['am_code'];
          $z--;
        }
        if($am['am_code'] != null){
          $am_code = $am['am_code'];
          $current_balance = $this->Am->getTotalBalance($am_code);
          $am = $amquery->next_row('array');
          $data = array();
          $data['type'] = "amcode";
          $data['beg_bal'] = "Current Balance: ";
          $data['run_bal'] = $current_balance;
          $data['transaction_amount'] = "";
          $data['transaction_code'] = "";
          $data['net_amount'] = "";
          $data['name'] = $am_code;
          $data['global_name'] = "";
          $data['confirm_no'] = "";
          $data['date_created'] = "";
          $data['dealer_no'] = "";
          $data['paymentmode'] = "";
          array_push($result, $data);
          $z--;
        }
      }
      $flag = false;
      if($trans['am_code'] == $am_code && (($trans_d > $p_un_d || $p_un['am_code'] != $am_code) || $k <= 0) && $j > 0){
        if($f_date3 <= $date2){
          $data = array();
          $data['type'] = "lt";
          $data['run_bal'] = $current_balance;
          $current_balance -= $trans['net_amount'];
          $data['beg_bal'] = $current_balance;
          $data['transaction_amount'] = $trans['net_amount'];
          $data['transaction_code'] = $trans['transaction_code'];
          $data['net_amount'] = "";
          $data['name'] = $trans['dsp_name'];
          $data['global_name'] = $trans['global_name'];
          $data['confirm_no'] = "";
          $data['date_created'] = "";
          $data['dealer_no'] = $trans['dealer_no'];
          $data['paymentmode'] = "";
          array_push($result, $data);
        }else{
          $current_balance -= $trans['amount'];
        }
          $flag = true;
          $trans = $query->next_row('array');
          $j--;        
      }elseif ( $p_un['am_code'] == $am_code && (($p_un_d >= $trans_d || $trans['am_code'] != $am_code) || $j <= 0 ) && $k > 0) {
          if($f_date4 <= $date2){
            $data = array();
            $data['type'] = "pun";
            $data['run_bal'] = $current_balance;
            $current_balance += $p_un['amount'];
            $data['beg_bal'] = $current_balance;
            $data['transaction_amount'] = $p_un['net_amount'];
            $data['payment_id'] = $p_un['load_payment_id'];
            $data['transaction_code'] = $p_un['transaction_code'];
            $data['net_amount'] = $p_un['amount'];
            $data['name'] = $p_un['dsp_name'];
            $data['global_name'] = $p_un['global_name'];
            $data['confirm_no'] = $p_un['confirm_no'];
            $data['date_created'] = $p_un['date_created'];
            $data['dealer_no'] = $p_un['dealer_no'];
            $data['paymentmode'] = $p_un['paymentmode'];
            array_push($result, $data);
          }else{
            $current_balance += $p_un['amount'];
          }
          $flag = true;
          $p_un = $query2->next_row('array');
          $k--;
      }
    }
    return $result;
  }

  function getDetailedAllPaymentUN($date1, $date2, $name = NULL){
    $this->db->select('*');
    $this->db->from('load_transaction');
    $this->db->where("CAST(date_created AS DATE) >= '".$date1."'");
    if($name == NULL){
      $this->db->where('am_code', 'Unassigned');
      $this->db->order_by('dsp_id', 'ASC');
    }else{
      $this->db->where('am_code', 'Unassigned');
      $this->db->where('dsp_name', $name);
    }
    $this->db->order_by('date_created', 'DESC');
    $query = $this->db->get();
    $e_date1 = $this->db->escape($date1);
    if($name == NULL){
      $sql = "SELECT * FROM (select * from load_payment_un where date_created >= ".$e_date1." and am_code = 'Unassigned') p 
              left join (select net_amount, transaction_code from load_transaction) s 
              on p.payment_transaction_code = s.transaction_code
              order by dsp_id ASC, date_created DESC;";
    }else{
      $e_name = $this->db->escape($name);
      $sql = "SELECT * FROM (select * from load_payment_un where date_created >= ".$e_date1." and dsp_name = ".$e_name." and am_code = 'Unassigned') p 
              left join (select net_amount, transaction_code from load_transaction) s 
              on p.payment_transaction_code = s.transaction_code
              order by dsp_id ASC, date_created DESC;";      
    }
    $query2 = $this->db->query($sql);
    $j = $query->num_rows();
    $k = $query2->num_rows();
    $count = $j+$k;
    $trans = $query->first_row('array');
    $p_un = $query2->first_row('array');
    $result = array();
    $f_date1 = new DateTime($date1);
    $f_date2 = new DateTime($date2);
    $date1 = $f_date1->format('Y-m-d');
    $date2 = $f_date2->format('Y-m-d');
    $flag = false;
    for($i = 0; $i < $count; $i++){
      $trans_d = new DateTime($trans['date_created']);
      $p_un_d = new DateTime($p_un['date_created']);
      $f_date3 = $trans_d->format('Y-m-d');
      $f_date4 = $p_un_d->format('Y-m-d');
      if(($p_un['dsp_id'] <= $trans['dsp_id'] || $j <= 0) && $flag == false && $k > 0 ){
          $dsp_id = $p_un['dsp_id'];
          $name = $p_un['dsp_name'];
          $dealer_no = $p_un['dealer_no'];
          $current_balance = $this->dsp->getDSPBalance($dealer_no);
          $data = array();
          $data['type'] = "name";
          $data['beg_bal'] = "Current Balance: ";
          $data['run_bal'] = $current_balance;
          $data['transaction_amount'] = "";
          $data['transaction_code'] = "";
          $data['net_amount'] = "";
          $data['name'] = $name;
          $data['global_name'] = $p_un['global_name'];
          $data['confirm_no'] = "";
          $data['date_created'] = "";
          $data['dealer_no'] = $dealer_no;
          $data['paymentmode'] = "";
          array_push($result, $data);
      }else if(($p_un['dsp_id'] > $trans['dsp_id'] || $k <= 0) && $flag == false && $j > 0){
          $dsp_id = $trans['dsp_id'];
          $name = $trans['dsp_name'];
          $dealer_no = $trans['dealer_no'];
          $current_balance = $this->dsp->getDSPBalance($dealer_no);
          $data = array();
          $data['type'] = "name";
          $data['beg_bal'] = "Current Balance: ";
          $data['run_bal'] = $current_balance;
          $data['transaction_amount'] = "";
          $data['transaction_code'] = "";
          $data['net_amount'] = "";
          $data['name'] = $name;
          $data['global_name'] = $trans['global_name'];
          $data['confirm_no'] = "";
          $data['date_created'] = "";
          $data['dealer_no'] = $dealer_no;
          $data['paymentmode'] = "";
          array_push($result, $data);
      }
      $flag = false;
      if($trans['dsp_id'] == $dsp_id && (($trans_d > $p_un_d || $p_un['dsp_id'] != $dsp_id) || $k <= 0) && $j > 0){
        if($f_date3 <= $date2){
          $data = array();
          $data['type'] = "lt";
          $data['run_bal'] = $current_balance;
          $current_balance -= $trans['net_amount'];
          $data['beg_bal'] = $current_balance;
          $data['transaction_amount'] = $trans['net_amount'];
          $data['transaction_code'] = $trans['transaction_code'];
          $data['net_amount'] = "";
          $data['name'] = "";
          $data['global_name'] = "";
          $data['confirm_no'] = "";
          $data['date_created'] = "";
          $data['dealer_no'] = "";
          $data['paymentmode'] = "";
          array_push($result, $data);
        }else{
          $current_balance -= $trans['amount'];
        }
          $flag = true;
          $trans = $query->next_row('array');
          $j--;        
      }elseif ( $p_un['dsp_id'] == $dsp_id && (($p_un_d >= $trans_d || $trans['dsp_id'] != $dsp_id) || $j <= 0 ) && $k > 0) {
          if($f_date4 <= $date2){
            $data = array();
            $data['type'] = "pun";
            $data['run_bal'] = $current_balance;
            $current_balance += $p_un['amount'];
            $data['beg_bal'] = $current_balance;
            $data['transaction_amount'] = $p_un['net_amount'];
            $data['payment_id'] = $p_un['load_payment_id'];
            $data['transaction_code'] = $p_un['transaction_code'];
            $data['net_amount'] = $p_un['amount'];
            $data['name'] = "";
            $data['global_name'] = "";
            $data['confirm_no'] = $p_un['confirm_no'];
            $data['date_created'] = $p_un['date_created'];
            $data['dealer_no'] = "";
            $data['paymentmode'] = $p_un['paymentmode'];
            array_push($result, $data);
          }else{
            $current_balance += $p_un['amount'];
          }
          $flag = true;
          $p_un = $query2->next_row('array');
          $k--;
      }
      if($flag == false){
        $count++;
      }
    }
    return $result;
  }

  function editTransaction($data, $trans_id){
    $this->db->trans_start();
    $this->db->select('*');
    $this->db->from('load_transaction');
    $this->db->where('transaction_code', $trans_code);
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
	  $this->db->where('transaction_code', $trans_code);
	  $this->db->update('', $data);
    $this->db->trans_complete();
  }
  function getTransactionCount(){
    return $this->db->count_all('load_transaction');
  }

  function deleteTransactionUN($payment_id){
    $this->db->trans_start();
    $this->db->select('*');
    $this->db->from('load_payment_un');
    $this->db->where('load_payment_id', $payment_id);
    $query = $this->db->get();
    if($query->num_rows() < 1){
      return false;
    }
    foreach($query->result() as $res){
      $amount = $res->amount;
      $dealer_no = $res->dealer_no;
    }
    $this->db->select('dsp_balance');
    $this->db->from('dsp_details');
    $this->db->where('dsp_dealer_no', $dealer_no);
    $query = $this->db->get();
    if($query->num_rows() > 0){
      foreach($query->result() as $row){
        $current_balance = $row->dsp_balance;
      }
      $run_bal = $this->Operations->add($current_balance, $amount);
      $data = array('dsp_balance' => $run_bal);
      $this->db->where('dsp_dealer_no', $dealer_no);
      $this->db->update('dsp_details', $data);  
    }
    $this->db->where('load_payment_id', $payment_id);
    $this->db->delete('load_payment_un');
    $this->db->trans_complete();

  }

  function deleteTransactionAM($payment_id){
    $this->db->trans_start();
    $this->db->select('*');
    $this->db->from('load_payment_un');
    $this->db->where('load_payment_id', $payment_id);
    $query = $this->db->get();
    if($query->num_rows() < 1){
      return false;
    }
    foreach($query->result() as $res){
      $amount = $res->amount;
      $am_code = $res->am_code;
    }
    $this->db->select('am_totalbalance');
    $this->db->from('am');
    $this->db->where('am_code', $am_code);
    $query = $this->db->get();
    foreach($query->result() as $row){
      $current_balance = $row->am_totalbalance;
    }
    if($query->num_rows() > 0){
      $run_bal = $this->Operations->add($current_balance, $amount);
      $data = array('am_totalbalance' => $run_bal);
      $this->db->where('am_code', $am_code);
      $this->db->update('am', $data);
    }
    $this->db->where('load_payment_id', $payment_id);
    $this->db->delete('load_payment_un');
    $this->db->trans_complete();
    if($this->db->trans_status() === FALSE){
      return false;
    }else{
      return true;
    }

  }
  function deleteTransaction($trans_code){
  	$this->db->trans_start();
  	$this->db->select('*');
  	$this->db->from('load_transaction');
  	$this->db->where('transaction_code', $trans_code);
  	$query = $this->db->get();
    if($query->num_rows() < 1){
      return false;
    }
  	foreach($query->result() as $row){
	  	$globalname = $row->global_name;
	  	$amount = $row->amount;
      $net_amount = $row->net_amount;
      $am_code = $row->am_code;
      $dealer_no = $row->dealer_no;
  	}
    if($am_code != 'Unassigned'){
      $this->db->select('am_totalbalance');
      $this->db->from('am');
      $this->db->where('am_code', $am_code);
      $query = $this->db->get();
      foreach($query->result() as $row){
        $current_balance = $row->am_totalbalance;
      }
      $run_bal = $this->Operations->subtract($current_balance, $net_amount);
      $data = array('am_totalbalance' => $run_bal);
      $this->db->where('am_code', $am_code);
      $this->db->update('am', $data);
    }else{
      $this->db->select('dsp_balance');
      $this->db->from('dsp_details');
      $this->db->where('dsp_dealer_no', $dealer_no);
      $query = $this->db->get();
      foreach($query->result() as $row){
        $current_balance = $row->dsp_balance;
      }
      $run_bal = $this->Operations->subtract($current_balance, $net_amount);
      $data = array('dsp_balance' => $run_bal);
      $this->db->where('dsp_dealer_no', $dealer_no);
      $this->db->update('dsp_details', $data);      
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
  $this->db->where('transaction_code', $trans_code);
	$this->db->delete('load_transaction');
	$this->db->trans_complete();
	if($this->db->affected_rows() >= 0){
		return true;
		
	}
	return false;
  }



}
