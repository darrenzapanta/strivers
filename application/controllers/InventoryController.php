<?php

class InventoryController extends CI_Controller {
 
 function __construct()
 {
   parent::__construct();
    $this->load->helper('url');
   $this->load->library('session');  
   $this->load->model('Inventory','',TRUE);
   $GLOBALS['data']['name'] = $this->session->userdata('firstname')." ".$this->session->userdata('lastname') ;
 }
private $stock_data;
private $temp_quantity;

function addInventoryItem(){
   $this->load->library('form_validation');
	 $this->form_validation->set_rules('item_code', 'Item Code', 'trim|required|max_length[10]|callback_check_itemcode');
   $this->form_validation->set_rules('item_name', 'Item Name', 'trim|required|max_length[50]');
   $this->form_validation->set_rules('item_category', 'Category', 'trim|max_length[30]');
   $this->form_validation->set_rules('item_cost', 'Cost', 'trim|numeric');
   $this->form_validation->set_rules('item_stock', 'Stock', 'trim|numeric|integer');
   if($this->form_validation->run() == FALSE){
     $this->load->view('templates/header', $GLOBALS['data']);
     $this->load->view('addInventoryitem');
     $this->load->view('templates/footer');
   }else{
   	 $item_name = $this->input->post('item_name');
   	 $item_category = $this->input->post('item_category');
   	 $item_code = $this->input->post('item_code');
   	 $item_cost = $this->input->post('item_cost');
   	 $item_stock = $this->input->post('item_stock');
   	 $data = array(
   	 	'item_name' => $item_name,
   	 	'item_category' => $item_category,
   	 	'item_code' => $item_code,
   	 	'item_cost' => $item_cost,
   	 	'item_stock' => $item_stock
   	 	);
   	 $ret = $this->Inventory->addItem($data);
     if($ret === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        echo json_encode($response_array);
     }else{
        header('Content-type: application/json');
        $response_array['status'] = 'success';    
        echo json_encode($response_array);
        $this->session->set_flashdata('message', 'Added Successfully.');
    	redirect('/landingController/addInventoryItem');
     }

   }
}

function addInventoryPurchase(){
   $this->load->library('form_validation');
   $this->form_validation->set_rules('purchase_receipt', 'Receipt Number', 'trim|max_length[30]');
   $this->form_validation->set_rules('purchasedate', 'Date of Purchase', 'trim|required');
   $this->form_validation->set_rules('purchase_code', 'Purchase Code', 'trim|callback_check_purchasecode');
   $all_items = $this->input->post('all_items');
   if(!empty($all_items)){
     $temp = array();
	   foreach($all_items as $id => $d){
	   	$this->form_validation->set_rules('all_items['.$id.'][item_code]' , 'Item Code', 'trim|max_length[10]|required|callback_check_codeifexist');
	   	$this->form_validation->set_rules('all_items['.$id.'][item_cost]' , 'Cost per Item', 'trim|numeric|required');
	   	$this->form_validation->set_rules('all_items['.$id.'][item_quantity]' , 'Quantity', 'trim|Integer|required');
      $temp_code = $all_items[$id]['item_code'];
      if(!in_array($temp_code, $temp)){
        $temp[] = $temp_code;
      }else{
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        $response_array['message'] = "Error ".$temp_code." has a duplicate.";
        echo json_encode($response_array);
        return false;        
      }
	   
     }
	}else{
	      header('Content-type: application/json');
	      $response_array['status'] = 'failed';    
	      $response_array['message'] = "Items can't be empty.";
	      echo json_encode($response_array);
		return false;
	}
   if($this->form_validation->run() == FALSE){
      header('Content-type: application/json');
      $response_array['status'] = 'failed';    
      $response_array['message'] = validation_errors();
      echo json_encode($response_array);
   }else{
   	 $data = array();
   	  $purchasedate = $this->input->post('purchasedate');
   	 $purchase_receipt = $this->input->post('purchase_receipt');
   	 $items = $this->input->post('all_items');
     $purchase_code = $this->input->post('purchase_code');
     $purchaseData = array(
      'purchase_code' => $purchase_code,
      'purchase_receiptnumber' => $purchase_receipt,
      'date_purchase' => $purchasedate,
      );
   	 foreach($items as $id => $d){
   	 	$totalcost = round($items[$id]['item_cost'] * $items[$id]['item_quantity'],2);
   	 	$data2 = array(
   	 		'item_code' => $items[$id]['item_code'],
   	 		'purchase_itemcost' => $items[$id]['item_cost'],
   	 		'purchase_amount' => $items[$id]['item_quantity'],
   	 		'purchase_totalcost' => $totalcost,
        'purchase_code' => $purchase_code,
   	 		);
   	 	$data[] = $data2;
   	 }

   	 $ret = $this->Inventory->addInventoryPurchase($purchaseData, $data);
     if($ret === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        echo json_encode($response_array);
     }else{
        header('Content-type: application/json');
        $response_array['status'] = 'success';
        $response_array['message'] = "Added Successfully";    
        echo json_encode($response_array);
        $this->session->set_flashdata('message', "Added Successfully. Purchase code is ". $purchase_code);
     }

   }
}

function addInventorySales(){
   $this->load->library('form_validation');
   $this->form_validation->set_rules('sales_receipt', 'Receipt Number', 'trim|max_length[30]');
   $this->form_validation->set_rules('salesdate', 'Date of Sales', 'trim|required');
   $this->form_validation->set_rules('paymentdate', 'Date of Payment', 'trim');
   $this->form_validation->set_rules('sales_mop', 'Mode of Payment', 'trim|max_length[15]');
   $this->form_validation->set_rules('sales_name', 'Name', 'trim|max_length[50]|required');
   $this->form_validation->set_rules('sales_code', 'Sales Code', 'trim|callback_check_salescode');
   $all_items = $this->input->post('all_items');
   if(!empty($all_items)){
     $temp = array();
     foreach($all_items as $id => $d){
      $this->form_validation->set_rules('all_items['.$id.'][item_code]' , 'Item Code', 'trim|max_length[10]|required|callback_check_codeifexist');
      $this->form_validation->set_rules('all_items['.$id.'][item_cost]' , 'Cost per Item', 'trim|numeric|required');
      $this->form_validation->set_rules('all_items['.$id.'][item_margin]' , 'Margin', 'trim|numeric|required');
      $this->form_validation->set_rules('all_items['.$id.'][item_quantity]' , 'Quantity', 'trim|is_natural|required');
      $this->form_validation->set_rules('all_items['.$id.'][item_remarks]', 'Remarks', 'trim');
      $temp_code = $all_items[$id]['item_code'];
      if(!in_array($temp_code, $temp)){
        $temp[] = $temp_code;
      }else{
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        $response_array['message'] = "Error ".$temp_code." has a duplicate.";
        echo json_encode($response_array);
        return false;        
      }
     }
  }else{
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        $response_array['message'] = "Items can't be empty.";
        echo json_encode($response_array);
        return false;
  }
   if($this->form_validation->run() == FALSE){
      header('Content-type: application/json');
      $response_array['status'] = 'failed';    
      $response_array['message'] = validation_errors();
      echo json_encode($response_array);
   }else{
     $data = array();
      $salesdate = $this->input->post('salesdate');
     $sales_name = $this->input->post('sales_name');
     $items = $this->input->post('all_items');
     $sales_code = $this->session->userdata('sales_code');
     $grandtotal = 0;
     $salesData = array(
      'sales_code' => $sales_code,
      'date_sales' => $salesdate,
      'sales_name' => $sales_name
      );
     foreach($items as $id => $d){
      $sales_margincost = round($items[$id]['item_cost'] + $items[$id]['item_margin'], 2);
      $totalcost = round($sales_margincost * $items[$id]['item_quantity'], 2);
      $grandtotal += $totalcost;
      $data2 = array(
        'sales_code' => $sales_code,
        'item_code' => $items[$id]['item_code'],
        'sales_originalcost' => $items[$id]['item_cost'],
        'sales_amount' => $items[$id]['item_quantity'],
        'sales_margin' => $items[$id]['item_margin'],
        'sales_margincost' => $sales_margincost,
        'sales_totalcost' => $totalcost,
        'sales_remark' => $items[$id]['item_remarks'],
        );
      $data[] = $data2;
     }
     $bool = false;
     if(isset($_POST['paymentdate']) && !empty($_POST['paymentdate']) ){
      $bool = true;
      $paymentdate = $this->input->post('paymentdate');
      $sales_receipt = $this->input->post('sales_receipt');
      $sales_mop = $this->input->post('sales_mop');
      $data3 = array(
        'sales_code' => $sales_code,
        'date_payment' => $paymentdate,
        'sales_receiptnumber' => $sales_receipt,
        'sales_mop' => $sales_mop,
        'payment_amount' => $grandtotal
        );
     }
     $ret = $this->Inventory->addInventorySales($salesData, $data);
     $ret2 = null;
     if($ret === true && $bool){
      $ret2 = $this->Inventory->addPaymentSales($data3);
     }
     if($ret === false || $ret2 === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed'; 
        if($ret2 === false){
          $response_array['message'] = "Sales was added successfully but  we are unable to add Payment. \n Try manually adding the payment. \n Sales code is $sales_code.";
        }       
        echo json_encode($response_array);
     }elseif (gettype($ret) == "string") {
        header('Content-type: application/json');
        $response_array['status'] = 'failed';
        $response_array['message'] = $ret ;   
        echo json_encode($response_array);       
     }else{
        header('Content-type: application/json');
        $response_array['status'] = 'success'; 
        echo json_encode($response_array);
        $this->session->set_flashdata('message', "Added Successfully. Sales code is ". $sales_code);
     }

   }
}

function generateInventoryReport(){
  $date1 = $this->input->post('date1');
  $date2 = $this->input->post('date2');
  $type = $this->input->post('type');
  $curstocks = $this->input->post('curstocks');
  if($date1 != " " || $date2 != " "){
    $f_date1 = new DateTime($date1);
    $f_date2 = new DateTime($date2);
  }else{
    $f_date1 = new DateTime();
    $f_date2 = new DateTime();
  }
  $interval = $f_date2->diff($f_date1);
  $interval = $interval->days;
  //$interval = $interval->format('%d');
  $t_date1 = $f_date1->format('Y-m-d');
  $t_date2 = $f_date2->format('Y-m-d');
  $original_interval = $interval;
  $sales = null;
  $purchase = null;
  $p_row = null;
  $s_row = null;
  if($type == 1){
    $interval = ($interval + 1) * 2;

    $purchase = $this->Inventory->getInventoryReportPurchase($t_date1, $t_date2);
    $sales = $this->Inventory->getInventoryReportSales($t_date1, $t_date2);
    if($purchase != null){
      $p_row = $purchase->first_row('array');
      $rowcount = $purchase->num_rows();
    }
    if($sales != null){
      $s_row = $sales->first_row('array');
      $rowcount = $sales->num_rows();
    }
  }elseif($type == 2){
    $interval += 1;
    $purchase = $this->Inventory->getInventoryReportPurchase($t_date1, $t_date2);
    if($purchase != null){
      $p_row = $purchase->first_row('array');
      $rowcount = $purchase->num_rows();
    }
  }elseif($type == 3){
    $interval += 1;
    $sales = $this->Inventory->getInventoryReportSales($t_date1, $t_date2);
    if($sales != null){
      $s_row = $sales->first_row('array');
      $rowcount = $sales->num_rows();
    }
  }

  $columnDef = array();
  $rowDef = array();
  $columnData = array(
    'targets' => 0,
    'title' => 'Item Code',
    'data' => 0,
    );
  $columnDef[] = $columnData;
  $columnData = array(
    'targets' => 1,
    'title' => 'Item Description',
    'data' => 1,
    );
  $columnDef[] = $columnData;
  $k = $original_interval;
  for($i = 0; $i < $interval;){
    $temp_date = date('d-M-y', strtotime('-'.$k.' day', strtotime($t_date2)));
    if($type == 1 || $type == 2){
     $columnData = array(
      'targets'=> $i+2,
      'title'=> $temp_date.' (IN)',
      'data'=> $i+2,
      );
      $columnDef[] = $columnData;
      $i++;          
    }  
    if($type == 1 || $type == 3){
      $columnData = array(
          'targets'=> $i+2,
          'title'=> $temp_date.' (OUT)',
          'data'=> $i+2,
          );
      $columnDef[] = $columnData;
      $i++;
    }      
    $k--;
  }
  $temp_interval = $interval + 2;
  if($type == 3){
    $columnData = array(
      'targets' => $temp_interval,
      'title' => 'Total Out',
      'data' => $temp_interval,
      );
    $columnDef[] = $columnData;
    $temp_interval++;
  }elseif($type == 2){
    $columnData = array(
      'targets' => $temp_interval,
      'title' => 'Total IN',
      'data' => $temp_interval,
      );
    $columnDef[] = $columnData;  
    $temp_interval++;  
  }
  if($curstocks == 1){
    $columnData = array(
      'targets' => $temp_interval,
      'title' => 'Actual Stocks',
      'data' => $temp_interval,
      );
    $columnDef[] = $columnData;
  }
  for($j = 0; $j < $rowcount ; $j++){
    $k = $original_interval;
    $totalstock = 0;
    $rowData = array();
    if($p_row != NULL){
      $rowData[0] = $p_row['item_code'];
    }elseif($s_row != NULL){
      $rowData[0] = $s_row['item_code'];
    }
    if($p_row != NULL){
      $rowData[1] = $p_row['item_name'];
    }elseif($s_row != NULL){
      $rowData[1] = $s_row['item_name'];
    }
    for($i = 0; $i < $interval;){
    $d_temp_date = date('Y-m-d', strtotime('-'.$k.' day', strtotime($t_date2)));
      if($type == 1 || $type == 2){
         if ($p_row != NULL && array_key_exists($d_temp_date, $p_row)){
            //$rowData[] = array ( $i+1 => $p_row[$d_temp_date]); 
            $totalstock += $p_row[$d_temp_date];
            $rowData[$i+2] = $p_row[$d_temp_date];
        }else{
            //$rowData[] = array ( $i+1 => 0);
            $rowData[$i+2] = 0;
        }
         
        $i++; 
      }
      if($type == 1 || $type == 3){
         if ($s_row != NULL && array_key_exists($d_temp_date, $s_row)){
            //$rowData[] = array ( $i+1 => $s_row[$d_temp_date]); 
            $totalstock += $s_row[$d_temp_date];
            $rowData[$i+2] = $s_row[$d_temp_date];
        }else{
            //$rowData[] = array ( $i+1 => 0);
            $rowData[$i+2] = 0;
        } 
        
       
        $i++;            
      }
      $k--;
      $rowData[$i+2] = $totalstock;
      if($curstocks == 1 && ($type == 1 || $type == 2)){
        $rowData[$i+3] = $p_row['item_stock']; 
      }else if($curstocks == 1 && ($type == 1 || $type == 3)){
         $rowData[$i+3] = $s_row['item_stock']; 
      }
    }
    if(($type == 1 || $type == 2) && $p_row != NULL){
      $p_row = $purchase->next_row('array');
    }
    if(($type == 1 || $type == 3) && $s_row != NULL){
      $s_row = $sales->next_row('array');  
    }
    
    
    $rowDef[] = $rowData;
  }
  header('Content-type: application/json');
  $response_array['status'] = 'success'; 
  $response_array['columnDef'] = $columnDef; 
  $response_array['rowDef'] = $rowDef; 
  echo json_encode($response_array);
}

function editInventoryItem(){
   $this->load->library('form_validation');
   $this->form_validation->set_rules('item_name', 'Item Name', 'trim|required|max_length[50]');
   $this->form_validation->set_rules('item_category', 'Category', 'trim|max_length[30]');
   $this->form_validation->set_rules('item_cost', 'Cost', 'trim|numeric');
   $this->form_validation->set_rules('item_stock', 'Stock', 'trim|numeric|integer');
   if($this->form_validation->run() == FALSE){
      header('Content-type: application/json');
      $response_array['status'] = 'failed';    
      $response_array['message'] = validation_errors();
      echo json_encode($response_array);
   }else{
     $item_name = $this->input->post('item_name');
     $item_category = $this->input->post('item_category');
     $item_code = $this->input->post('item_code');
     $item_cost = $this->input->post('item_cost');
     $item_stock = $this->input->post('item_stock');
     $data['item_name'] = $item_name;
     $data['item_category'] = $item_category;
     $data['item_cost'] = $item_cost;
     if($this->session->userdata('type') == 'admin'){
      $data['item_stock'] = $item_stock;
     }
     $ret = $this->Inventory->editInventoryItem($data, $item_code);
     if($ret === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        echo json_encode($response_array);
     }else{
        header('Content-type: application/json');
        $response_array['status'] = 'success';    
        echo json_encode($response_array);
        $this->session->set_flashdata('message', 'Edited Successfully.');
     }

   }  
}

 function deleteInventoryItem(){
  if($this->session->userdata('type') == 'admin'){
   $item_code = $this->input->post('item_code');
   $ret = $this->Inventory->deleteInventoryItem($item_code);
     if($ret === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        echo json_encode($response_array);
     }else{
        header('Content-type: application/json');
        $response_array['status'] = 'success';    
        echo json_encode($response_array);
     }
   }else{
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        $response_array['message'] = 'Unable to delete.'; 
        echo json_encode($response_array);    
   }
 }

 function viewSalesTransaction(){
  $date1 = $this->input->post('date1');
  $date2 = $this->input->post('date2');
  $sales_code = $this->input->post('sales_code');
  $type = $this->input->post('type');
  $result = null;
  $rowData = array();
  if($type == 1){
    $result = $this->Inventory->getSalesTransactionByDate($date1, $date2);
  }elseif($type == 2){
    $result = $this->Inventory->getSalesTransactionBySalesCode($sales_code);
  }
  $total_cost = 0;
  $flag = true;
  $sales_code = null;
  foreach($result as $res){
    $row = array();
    if($sales_code == $res->sales_code || $flag == true){
      $total_cost += $res->sales_totalcost;

      $row['name'] = $res->sales_name;
      $row['date_sales'] = $res->date_sales;
      $row['sales_receiptnumber'] = $res->sales_receiptnumber;
      $row['sales_amount'] = $res->sales_amount;
      $row['item_code'] = $res->item_code;
      $row['sales_originalcost'] = $res->sales_originalcost;
      $row['sales_margin'] = $res->sales_margin;
      $row['margin_income'] = $res->sales_margin * $res->sales_amount;
      $row['sales_margincost'] = $res->sales_margincost;
      $row['sales_totalcost'] = $res->sales_totalcost;
      $row['date_payment'] = "";
      $row['sales_mop'] = "";
      $row['sales_remark'] = $res->sales_remark;
      $row['sales_code'] = $res->sales_code;
    }else{
      $row['name'] = "";
      $row['date_sales'] = "";
      $row['sales_receiptnumber'] = "";
      $row['sales_amount'] = "";
      $row['item_code'] = "";
      $row['sales_originalcost'] = "";
      $row['sales_margin'] = "";
      $row['margin_income'] = "";
      $row['sales_margincost'] = "";
      $row['sales_totalcost'] = $total_cost;
      $row['date_payment'] = $date_payment;
      $row['sales_mop'] = $sales_mop;
      $row['sales_remark'] = "";
      $row['sales_code'] = $sales_code;
      $total_cost = 0;
      $rowData[] = $row;
      $total_cost += $res->sales_totalcost;
      $row['name'] = $res->sales_name;
      $row['date_sales'] = $res->date_sales;
      $row['sales_receiptnumber'] = $res->sales_receiptnumber;
      $row['sales_amount'] = $res->sales_amount;
      $row['item_code'] = $res->item_code;
      $row['sales_originalcost'] = $res->sales_originalcost;
      $row['sales_margin'] = $res->sales_margin;
      $row['margin_income'] = $res->sales_margin * $res->sales_amount;
      $row['sales_margincost'] = $res->sales_margincost;
      $row['sales_totalcost'] = $res->sales_totalcost;
      $row['date_payment'] = "";
      $row['sales_mop'] = "";
      $row['sales_remark'] = $res->sales_remark;
      $row['sales_code'] = $res->sales_code;
    }
    $date_payment = $res->date_payment;
    $sales_mop = $res->sales_mop;
    $sales_code = $res->sales_code;
    $flag = false;
    $rowData[] = $row;
  }
  if($result != NULL){
    $row['name'] = "";
    $row['date_sales'] = "";
    $row['sales_receiptnumber'] = "";
    $row['sales_amount'] = "";
    $row['item_code'] = "";
    $row['sales_originalcost'] = "";
    $row['sales_margin'] = "";
    $row['margin_income'] = "";
    $row['sales_margincost'] = "";
    $row['sales_totalcost'] = $total_cost;
    $row['date_payment'] = $date_payment;
    $row['sales_mop'] = $sales_mop;
    $row['sales_remark'] = "";
    $row['sales_code'] = $sales_code;
    $rowData[] = $row;
  }
    header('Content-type: application/json');
    echo json_encode(array('draw' => 1, 'recordsTotal' => count($result), 'recordsFiltered' => count($result), 'data' => $rowData, 'status' => 'success'));
 }

  function viewPurchaseTransaction(){
  $date1 = $this->input->post('date1');
  $date2 = $this->input->post('date2');
  $purchase_code = $this->input->post('purchase_code');
  $type = $this->input->post('type');
  $result = null;
  $rowData = array();
  if($type == 1){
    $result = $this->Inventory->getPurchaseTransactionByDate($date1, $date2);
  }elseif($type == 2){
    $result = $this->Inventory->getPurchaseTransactionByPurchaseCode($purchase_code);
  }
  $total_cost = 0;
  $flag = true;
  $purchase_code = null;
  foreach($result as $res){
    $row = array();
    if($purchase_code == $res->purchase_code || $flag == true){
      $total_cost += $res->purchase_totalcost;
      $row['date_purchase'] = $res->date_purchase;
      $row['purchase_receiptnumber'] = $res->purchase_receiptnumber;
      $row['purchase_amount'] = $res->purchase_amount;
      $row['item_code'] = $res->item_code;
      $row['purchase_itemcost'] = $res->purchase_itemcost;
      $row['purchase_totalcost'] = $res->purchase_totalcost;
      $row['purchase_code'] = $res->purchase_code;
    }else{
      $row['date_purchase'] = "";
      $row['purchase_receiptnumber'] = "";
      $row['purchase_amount'] = "";
      $row['item_code'] = "";
      $row['purchase_itemcost'] = "";
      $row['purchase_totalcost'] = $total_cost;
      $row['purchase_code'] = "Grand Total:";
      $total_cost = 0;
      $rowData[] = $row;
      $total_cost += $res->purchase_totalcost;
      $row['date_purchase'] = $res->date_purchase;
      $row['purchase_receiptnumber'] = $res->purchase_receiptnumber;
      $row['purchase_amount'] = $res->purchase_amount;
      $row['item_code'] = $res->item_code;
      $row['purchase_itemcost'] = $res->purchase_itemcost;
      $row['purchase_totalcost'] = $res->purchase_totalcost;
      $row['purchase_code'] = $res->purchase_code;
    }
    $purchase_code = $res->purchase_code;
    $flag = false;
    $rowData[] = $row;
  }
  if($result != NULL){
      $row['date_purchase'] = "";
      $row['purchase_receiptnumber'] = "";
      $row['purchase_amount'] = "";
      $row['item_code'] = "";
      $row['purchase_itemcost'] = "";
      $row['purchase_totalcost'] = $total_cost;
      $row['purchase_code'] = "Grand Total:";
    $rowData[] = $row;
  }
    header('Content-type: application/json');
    echo json_encode(array('draw' => 1, 'recordsTotal' => count($result), 'recordsFiltered' => count($result), 'data' => $rowData, 'status' => 'success'));
 }

function deleteSalesTransaction(){
  if($this->session->userdata('type') == 'admin' && $_POST['sales_code'] != ''){
    $sales_code = $this->input->post('sales_code');
    $ret = $this->Inventory->deleteSalesTransaction($sales_code);
  
     if($ret === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';    
        echo json_encode($response_array);
     }else{
        header('Content-type: application/json');
        $response_array['status'] = 'success';    
        echo json_encode($response_array);
        $this->session->set_flashdata('message', 'Deleted Successfully. (Sales Code: '.$sales_code.')');
     }
  }else{
      header('Content-type: application/json');
      $response_array['status'] = 'failed';    
      $response_array['message'] = 'Unable to delete.'; 
      echo json_encode($response_array);   

  }
}

function deletePurchaseTransaction(){
  if($this->session->userdata('type') == 'admin' && $_POST['purchase_code'] != ''){
    $purchase_code = $this->input->post('purchase_code');
    $ret = $this->Inventory->deletePurchaseTransaction($purchase_code);
  
     if($ret === false){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';  
        $response_array['message'] = "Error has occured. Unable to delete.";    
        echo json_encode($response_array);
     }elseif(gettype($ret) == "string"){
        header('Content-type: application/json');
        $response_array['status'] = 'failed';  
         $response_array['message'] = $ret;  
        echo json_encode($response_array);
     }else{
        header('Content-type: application/json');
        $response_array['status'] = 'success';    
        $response_array['message'] = 'Deleted Successfully. (Purchase Code: '.$purchase_code.')';
        echo json_encode($response_array);
     }
  }else{
      header('Content-type: application/json');
      $response_array['status'] = 'failed';    
      $response_array['message'] = 'Unable to delete.'; 
      echo json_encode($response_array);   

  }
}

function getSalesTransactionBySalesCode(){
  $sales_code = $this->input->post('sales_code');
  $result = $this->Inventory->getSalesTransactionBySalesCode($sales_code);
  $name = "";
  $grandtotal = 0;
  $itemno = 0;
  foreach($result as $res){
    $name = $res->sales_name;
    $grandtotal += $res->sales_totalcost;
    $sales_date = $res->date_sales;
    $itemno++;
  }
  if($result == FALSE){
    header('Content-type: application/json');
    $response_array['status'] = 'failed';    
    echo json_encode($response_array);    
  }else{
    header('Content-type: application/json');
    $response_array['status'] = 'success';
    $response_array['name'] = $name;     
    $response_array['grandtotal'] = $grandtotal;
    $response_array['itemno'] = $itemno; 
    $response_array['sales_date'] = $sales_date;   
    echo json_encode($response_array);        
  }
}

function addSalesPayment(){
   $this->load->library('form_validation');
   $this->form_validation->set_rules('sales_code', 'Sales Code', 'trim|required|callback_checksalespayment');
   $this->form_validation->set_rules('sales_mop', 'Mode of Payment', 'trim|required|max_length[15]');
   $this->form_validation->set_rules('sales_receipt', 'Receipt Number', 'trim|required|max_length[30]');
   $this->form_validation->set_rules('paymentdate', 'Date of Payment', 'trim|required');
   if($this->form_validation->run() == FALSE){
      header('Content-type: application/json');
      $response_array['status'] = 'failed';    
      $response_array['message'] = validation_errors();
      echo json_encode($response_array);
   }else{
      $paymentdate = $this->input->post('paymentdate');
      $sales_receipt = $this->input->post('sales_receipt');
      $sales_mop = $this->input->post('sales_mop');
      $sales_code = $this->input->post('sales_code');
      $result = $this->Inventory->getSalesTransactionBySalesCode($sales_code);
      $grandtotal = 0;
      foreach($result as $res){
        $grandtotal += $res->sales_totalcost;
      }
      $data = array(
        'sales_code' => $sales_code,
        'date_payment' => $paymentdate,
        'sales_receiptnumber' => $sales_receipt,
        'sales_mop' => $sales_mop,
        'payment_amount' => $grandtotal
        );
       $ret2 = $this->Inventory->addPaymentSales($data);
       if($ret2 === false){
          header('Content-type: application/json');
          $response_array['status'] = 'failed';    
          echo json_encode($response_array);
       }else{
          header('Content-type: application/json');
          $response_array['status'] = 'success';    
          echo json_encode($response_array);
          $this->session->set_flashdata('message', 'Payment was added successfully to Sales Code: '.$sales_code);
       }
     }


   } 


function check_itemcode($itemcode){
  if($this->Inventory->getInventoryItem($itemcode) != false){
  	$this->form_validation->set_message('check_itemcode', 'Duplicate Item Code.');
  	return false;
  }
  return true;
}

function check_codeifexist($itemcode){  
  $ret = $this->Inventory->getInventoryItem($itemcode);
  if($ret == false){
  	$this->form_validation->set_message('check_codeifexist', 'Invalid Item Code. Add the item first.');
  	return false;
  }
  return true;
  
}

function check_salescode($salescode){
  if($salescode == $this->session->userdata('sales_code')){
    return true;
  }else{
  $this->form_validation->set_message('check_salescode', 'Invalid Sales Code. Try refreshing the page.');
  return false;    
  }

}
function check_purchasecode($purchasecode){
  if($purchasecode == $this->session->userdata('purchase_code')){
    return true;
  }else{
  $this->form_validation->set_message('check_purchasecode', 'Invalid Sales Code. Try refreshing the page.');
  return false;    
  }

}
function checksalespayment($sales_code){
  if($this->Inventory->checkPaymentTransactionBySalesCode($sales_code) == TRUE || $this->Inventory->checkSalesTransactionBySalesCode($sales_code) != TRUE){
    $this->form_validation->set_message('checksalespayment', 'Invalid Sales Code or Sales transaction has a payment already.');
    return false;
  }
  return true;
}
}
 
?>
