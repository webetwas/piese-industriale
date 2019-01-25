<?php
class Owner_model extends CI_Model {
	private $tbl;
  private $tbl_company;

	public $owner;
	public $companie;

  public function __construct()
  {
  	parent::__construct();
  	// Your own constructor code

  	$this->tbl = 'be_owner';
    $this->tbl_company = 'be_ocompany';
  }

  public function get() {
		$query = $this->db->query("SELECT * FROM `" .$this->tbl. "`;");
		
		if($query->num_rows() > 0) {
      $this->owner = $query->row();
      return $this->owner;
    }
		else return false;  	
  }

  public function getCompany() {
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_company. "` WHERE idowner = " .$this->owner->id. ";");
    
    if($query->num_rows() > 0) {
      $this->owner = $query->row();
      return $this->owner;
    }
    else return false;
  }

  public function updateOwner($data) {
    foreach($data as $keyd => $d) {
      $this->db->set($keyd, $d);
    }
    
    $this->db->where('id', $this->owner->id);
    $this->db->update($this->tbl);
    if($this->db->affected_rows() > 0) {
      return true;
    }
    else return false;
  }

  public function updateCompany($data) {
    foreach($data as $keyd => $d) {
      $this->db->set($keyd, $d);
    }
    
    $this->db->where('idowner', $this->owner->id);
    $this->db->update($this->tbl_company);
    if($this->db->affected_rows() > 0)
      return true;
    else return false;
  }
}