<?php
Class dss extends CI_Model
{
  public function __construct() {
    parent::__construct();
    $this->load->model('dsp','',TRUE);
  }

  function addDSS($data){
  	$this->db->insert('dss', $data);
	if ($this->db->affected_rows() > 0) {
		return true;
	}else {
		return false;
	}

  }

  function deleteDSS($dss_id, $data){
  	$this->db->trans_start();
  	if($data != null){
  		$this->db->update_batch('dsp',$data, 'dsp_id'); 
  	}
  	$this->db->where('dss_id', $dss_id);
	$this->db->delete('dss');
	$this->db->trans_complete();
  }

  function getAllDSS(){
  	$this->db->select('*');
  	$this->db->from('dss');
  	$query = $this->db->get();
    return $query->result();
  }


  function editDSS($data, $dss_id){

	  $this->db->where('dss_id', $dss_id);
	  $this->db->update('dss', $data);
	  if ($this->db->affected_rows() >= 0) {
	    return true;
	  }else {
	    return false;
	  }
  }

 function getDSSbyName($name){
 	$this->db->select('*');
	$this->db->from('dss');
	$this->db-> where('dss_name', $name);
	$this->db->limit(1);
	$query = $this -> db -> get();
	if($query -> num_rows() == 1)
	{
	  return $query->result();
	}
	else
	{
	 return false;
	}
 }

 function getDSSbyID($id){
 	$this->db->select('*');
	$this->db->from('dss');
	$this->db-> where('dss_id', $id);
	$this->db->limit(1);
	$query = $this -> db -> get();
	if($query -> num_rows() == 1)
	{
	 return $query->result();
	}
	else
	{
	 return false;
	}
 }

}
