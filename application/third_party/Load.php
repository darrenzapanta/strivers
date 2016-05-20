<?php
Class Load
{
  private $amount;
  public function __construct($amount) 
  {
    $this->$amount = $amount;
  }

function add(Load $other) {
    return new Load($this->amount + $other->getAmount());
}

function getAmount(){
  return $this->amount;
}

function convertToFraction(){
  return new Load($this->amount/100);
}


}
?>