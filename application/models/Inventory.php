<?php
Class Inventory extends CI_Model
{
  public function __construct() {
    parent::__construct();
    $this->load->model('Operations','',TRUE);
  }

function addItem($data){
	$this->db->insert('inventory_items', $data);
	if ($this->db->affected_rows() > 0) {
		return true;
	}
	return false;
}

function getInventoryItem($itemcode){
  $this->db->from('inventory_items');
  $this->db->where('item_code', $itemcode);
  $query = $this->db->get();
  if($query->num_rows() == 1){
  	return $query->result();
  }
  return false;
}
function updateInventoryStock(){

}
function getAllItems(){
  $this->db->select('*');
  $this->db->from('inventory_items');
  $query = $this->db->get();
  if($query->num_rows() > 0){
  	return $query->result();
  }
  return false;
}
function getAllItemsArray(){
  $this->db->select('*');
  $this->db->from('inventory_items');
  $query = $this->db->get();
  if($query->num_rows() > 0){
  	return $query->result_array();
  }
  return false;
}

function getInventoryReportSales($date1, $date2){

	$this->db->from('inventory_sales');
	$this->db->where("date_sales between '".$date1."' and '".$date2."'");
	$query = $this->db->get();
	if($query->num_rows() <= 0){
		$this->db->select('item_code, item_name, item_stock');
		$this->db->from('inventory_items');
		$query = $this->db->get();
		return $query;
	}
	$sql = "call generateInventorySalesReport('".$date1."','".$date2."');";
	$query = $this->db->query($sql);
	mysqli_next_result($this->db->conn_id);
	return $query;
}


function getInventoryReportPurchase($date1, $date2){
	$this->db->from('inventory_purchase');
	$this->db->where("date_purchase between '".$date1."' and '".$date2."'");
	$query = $this->db->get();
	if($query->num_rows() <= 0){
		$this->db->select('item_code, item_name, item_stock');
		$this->db->from('inventory_items');
		$query = $this->db->get();
		return $query;
	}
	$sql = "call generateInventoryPurchaseReport('".$date1."','".$date2."');";
	$query = $this->db->query($sql);
	mysqli_next_result($this->db->conn_id);
	return $query;
}

function addInventoryPurchase($purchaseData, $data){
	$this->db->trans_start();
	$data3 = array();
	foreach($data as $d){
		$res = $this->getInventoryItem($d['item_code']);
		foreach($res as $res_item){
			$curr_stock = $res_item->item_stock;
		}
		$run_stock = $curr_stock + $d['purchase_amount'];
		if($run_stock >= 0){
			$data2 = array(
				'item_code' => $res_item->item_code,
				'item_stock' => $run_stock
				);
			$data3[] = $data2;
		}else{
			return "Cannot subtract stocks from ".$d['item_code'].".";
		}
	}
	$this->db->insert('inventory_purchase', $purchaseData);	
	$this->db->insert_batch('inventory_purchase_items', $data);
	$this->db->update_batch('inventory_items', $data3, 'item_code');
	$this->db->trans_complete();
	if ($this->db->trans_status() === FALSE)
	{
		return false;
	}else{
		return true;
	}
}
function addInventorySales($salesData, $data){
	$this->db->trans_start();
	$data3 = array();
	foreach($data as $d){
		$res = $this->getInventoryItem($d['item_code']);
		foreach($res as $res_item){
			$curr_stock = $res_item->item_stock;
		}
		$run_stock = $curr_stock - $d['sales_amount'];
		if($run_stock >= 0){
			$data2 = array(
				'item_code' => $res_item->item_code,
				'item_stock' => $run_stock
				);
			$data3[] = $data2;
		}else{
			return "Cannot subtract stocks from ".$d['item_code'].".";
		}	
	}
	$this->db->insert('inventory_sales', $salesData);	
	$this->db->insert_batch('inventory_sales_items', $data);
	$this->db->update_batch('inventory_items', $data3, 'item_code');
	$this->db->trans_complete();
	if ($this->db->trans_status() === FALSE)
	{
		return false;
	}else{
		return true;
	}
}
function addPaymentSales($data){
	$this->db->insert('inventory_sales_payment', $data);
	if ($this->db->affected_rows() > 0) {
		return true;
	}
		return false;

}

function getSalesTransactionByDate($date1, $date2){
	$date1 = $this->db->escape($date1);
	$date2 = $this->db->escape($date2);
 	$sql = "SELECT * 
			FROM  (select sales_code as s_code, sales_name, date_sales from inventory_sales where date_sales between ".$date1." and ".$date2.") i 
			left join inventory_sales_items d on i.s_code = d.sales_code left join  (select sales_code as payment_code, sales_receiptnumber, sales_mop, date_payment, payment_amount from inventory_sales_payment) d
			on i.s_code = d.payment_code
			order by date_sales, i.s_code;";
	$query = $this->db->query($sql);
	return $query->result();
}

function getPurchaseTransactionByDate($date1, $date2){
	$date1 = $this->db->escape($date1);
	$date2 = $this->db->escape($date2);
 	$sql = "SELECT * 
			FROM  (select * from inventory_purchase where date_purchase between ".$date1." and ".$date2.") i 
			left join inventory_purchase_items d on i.purchase_code = d.purchase_code 
			order by date_purchase, i.purchase_code;";
	$query = $this->db->query($sql);

	return $query->result();
}

function getSalesTransactionBySalesCode($sales_code){
	$sales_code = $this->db->escape($sales_code);
 	$sql = "SELECT * 
			FROM  (select sales_code as s_code, sales_name, date_sales from inventory_sales where sales_code = ".$sales_code.") i 
			left join inventory_sales_items d on i.s_code = d.sales_code left join  (select sales_code as payment_code, sales_receiptnumber, sales_mop, date_payment, payment_amount from inventory_sales_payment) d
			on i.s_code = d.payment_code
			order by date_sales, i.s_code;";
	$query = $this->db->query($sql);
	return $query->result();
}

function checkSalesTransactionBySalesCode($sales_code){
	$this->db->from('inventory_sales');
	$this->db->where('sales_code', $sales_code);
	$query = $this->db->get();
	if($query->num_rows() > 0){
		return true;
	}else{
		return false;
	}
}

function checkPaymentTransactionBySalesCode($sales_code){
	$this->db->from('inventory_sales_payment');
	$this->db->where('sales_code', $sales_code);
	$query = $this->db->get();
	if($query->num_rows() > 0){
		return true;
	}else{
		return false;
	}
}

function getPurchaseTransactionByPurchaseCode($purchase_code){
	$purchase_code = $this->db->escape($purchase_code);
 	$sql = "SELECT * 
			FROM  (select * from inventory_purchase where purchase_code = ".$purchase_code.") i 
			left join inventory_purchase_items d on i.purchase_code = d.purchase_code 
			order by date_purchase, i.purchase_code;";
	$query = $this->db->query($sql);
	return $query->result();
}

function editInventoryItem($data, $item_code){
	  $this->db->where('item_code', $item_code);
	  $this->db->update('inventory_items', $data);
	  if ($this->db->affected_rows() >= 0) {
	    return true;
	  }else {
	    return false;
	  }
}

function deleteInventoryItem($item_code){
	$this->db->where('item_code', $item_code);
	$this->db->delete('inventory_items');
		if ($this->db->affected_rows() >= 0) {
			return true;
		}else{
			return false;
		}
	}

function deleteSalesTransaction($sales_code){
	$this->db->trans_start();
    $result = null;
    $ret = false;
    $this->db->select('*');
    $this->db->from('inventory_sales_items');
    $this->db->where('sales_code', $sales_code);
    $query = $this->db->get();

    $data = array();
    foreach($query->result() as $res){
      	$result2 = $this->getInventoryItem($res->item_code);
      	foreach($result2 as $res2){
      		$run_stock = $res2->item_stock + $res->sales_amount;
      	}
        $data[] = array(
          'item_code' => $res->item_code,
          'item_stock' => $run_stock,
          );
      }
    if($query->num_rows() > 0){
		$this->db->update_batch('inventory_items', $data, 'item_code');
		$this->db->where('sales_code', $sales_code);
		$this->db->delete('inventory_sales');
		$this->db->trans_complete();
	}else{
		return 'Unable to find the Sales Transaction with sales code: '.$sales_code;
	}
	if($this->db->trans_status() === false){
		return false;
	}else{
		return true;
	}
}

function deleteSalesPaymentTransaction($sales_code){
	$this->db->from('inventory_sales_payment');
	$this->db->where('sales_code', $sales_code);
	$query = $this->db->get();
	if($query->num_rows() > 0){
		$this->db->where('sales_code', $sales_code);
		$this->db->delete('inventory_sales_payment');
		return true;
	}else{
		return 'Unable to find the Payment Transaction with sales code: '.$sales_code;
	}

}
function deletePurchaseTransaction($purchase_code){
	$this->db->trans_start();
    $result = null;
    $ret = false;
    $this->db->select('*');
    $this->db->from('inventory_purchase_items');
    $this->db->where('purchase_code', $purchase_code);
    $query = $this->db->get();
    
    $data = array();
    foreach($query->result() as $res){
      	$result2 = $this->getInventoryItem($res->item_code);
      	foreach($result2 as $res2){
      		$run_stock = $res2->item_stock - $res->purchase_amount;
      	}
        $data[] = array(
          'item_code' => $res->item_code,
          'item_stock' => $run_stock,
          );
      }
    if($query->num_rows() > 0){
		$this->db->update_batch('inventory_items', $data, 'item_code');
		$this->db->where('purchase_code', $purchase_code);
		$this->db->delete('inventory_purchase');
		$this->db->trans_complete();
	}else{
		return 'Unable to find the Purchase Transaction with purchase code: '.$purchase_code;
	}
	if($this->db->trans_status() === false){
		return false;
	}else{
		return true;
	}
}
}