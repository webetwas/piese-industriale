<?php
class Platforma_model extends CI_Model {

  /**
   * [private $ownerid Owner]
   * @var [type]
   */ private $ownerid = 1;

  private $tbl_owner = TBL_OWNER;
  private $tbl_company = TBL_COMPANY;
  private $tbl_users = TBL_USERS;
  private $tbl_emailing = 'be_emailing';
  private $id_emailing = 1;

  private $objname;

  public function __construct()
  {
  	parent::__construct();
  	// Your own constructor code

    $this->objname = get_class($this);//Controller
  }

  /**
   * [getOwner description]
   * @return [type] [description]
   */
  public function getEmailing() {
		$query = $this->db->query("SELECT * FROM `" .$this->tbl_emailing. "` WHERE id = " .$this->id_emailing. ";");

		if($query->num_rows() > 0) return $query->row();
		else return false;
  } 
  
  /**
   * [getOwner description]
   * @return [type] [description]
   */
  public function getOwner() {
		$query = $this->db->query("SELECT * FROM `" .$this->tbl_owner. "` WHERE id = {$this->ownerid};");

		if($query->num_rows() > 0) return $query->row();
		else return false;
  }
  

  /**
   * [getCompany description]
   * @return [type] [description]
   */
  public function getCompany() {
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_company. "` WHERE idowner = {$this->ownerid};");

    if($query->num_rows() > 0) return $query->row();
    else return false;
  }

  /**
   * [getUser description]
   * @param  [type] $id [description]
   * @return [type]     [description]
   */
  public function getUser($id = null) {
    if(is_null($id)) $this->sError("getUser got no id", true);

    $this->db->where('id', $id);
    $query = $this->db->get($this->tbl_users);
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }

  /**
   * [sError description]
   * @param  [string]  $error [Error message]
   * @param  boolean $die     [description]
   * @return [string]         [Message]
   */
  private function sError($error, $die = false)
  {
    echo $this->objname. "/ ".$error;
    if($die) die();
  }
}
