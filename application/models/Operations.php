<?php
Class Operations extends CI_Model
{
  public function __construct() {
    parent::__construct();
  }

  function convertPercentToFraction($number){
    return $number/100;
  }

  function subtract($num1, $num2){
  	return $num1 - $num2;
  }

  function add($num1, $num2){
  	return $num1 + $num2;
  }

  function getRevenue($amount, $percentage){
    $total_percent = 0.04;
    $rev_percent = $total_percent - $percentage;
    $temp = $amount * $rev_percent;
    $revenue = round($temp, 2, PHP_ROUND_HALF_UP); 
    return $revenue;
  }

  function getNetAmount($amount, $percentage){
  	$temp = $amount * $percentage;
  	return $amount - $temp;
  }
  function uniqueCode(){
    $random_id_length = 5; 

    //generate a random id encrypt it and store it in $rnd_id 
    $rnd_id = md5(uniqid(rand(),true)); 

    //to remove any slashes that might have come 
    $rnd_id = strip_tags(stripslashes($rnd_id)); 

    //Removing any . or / and reversing the string 
    $rnd_id = str_replace(".","",$rnd_id); 
    $rnd_id = strrev(str_replace("/","",$rnd_id)); 

    //finally I take the first 10 characters from the $rnd_id 
    $rnd_id = substr($rnd_id,0,$random_id_length); 
    return $rnd_id;
  }
  function generateCode($type){
    $code = $this->uniqueCode();
    if($type == "load_transaction"){
      $code = "l_".$code;
    }else if($type == "inventory_purchase"){
      $code = "p_".$code;
    }else if($type == "inventory_sales"){
      $code = "s_".$code;
    }
      return $code;
  }

}
