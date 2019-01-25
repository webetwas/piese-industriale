<?php
class Secure_model extends CI_Model {	
	
  private $tbl_utilizatori = null;
  private $tbl_clienti = null;


  /**
   * [__construct description]
   */
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    $this->objname = get_class($this);//Controller		
		
		$this->tbl_utilizatori = TBL_UTILIZATORI;
    $this->tbl_clienti = TBL_CLIENTI;
  }

	public function checkIntegrityUserAsClient($idclient, $uniqueid)
	{
		$query = $this->db->query("SELECT {$this->tbl_clienti}.id, {$this->tbl_clienti}.id_utilizator, {$this->tbl_utilizatori}.uniqueid FROM `{$this->tbl_clienti}`
			LEFT JOIN `{$this->tbl_utilizatori}` ON {$this->tbl_utilizatori}.id = {$this->tbl_clienti}.id_utilizator
			WHERE {$this->tbl_clienti}.id = {$idclient} AND {$this->tbl_utilizatori}.uniqueid = '{$uniqueid}';");	
			
    if($query->num_rows() > 0) return true;
    else return false;
	}
}