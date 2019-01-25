<?php
class Utilizator_model extends CI_Model {	
	
  private $tbl_utilizatori = null;


  /**
   * [__construct description]
   */
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    $this->objname = get_class($this);//Controller		
		
    $this->tbl_utilizatori = TBL_UTILIZATORI;
  }
	
  public function fetchUtilizator($id) {

    $query = $this->db->query("SELECT * FROM `" .$this->tbl_utilizatori. "` WHERE id = {$id};");
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }
	
  public function fetchEmail($email) {

    $query = $this->db->query("SELECT id FROM `" .$this->tbl_utilizatori. "` WHERE email = '{$email}';");
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }
	
	public function fetchIdByTokenPassword($tokenpassword) {
    $query = $this->db->query("SELECT id FROM `" .$this->tbl_utilizatori. "` WHERE tokenpassword = '{$tokenpassword}';");
    if($query->num_rows() > 0) return $query->row();
    else return false;		
	}
}