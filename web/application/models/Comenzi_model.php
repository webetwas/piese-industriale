<?php
class Comenzi_model extends CI_Model {	
	
  private $tbl_clienti = null;
  private $tbl_comenzi = null;


  /**
   * [__construct description]
   */
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    $this->objname = get_class($this);//Controller		
		
    $this->tbl_clienti = TBL_CLIENTI;
    $this->tbl_comenzi = TBL_COMENZI;
  }

  public function getTotalByClient($id) {
    $query = $this->db->query("SELECT {$this->tbl_clienti}.id, SUM({$this->tbl_comenzi}.totalcomanda) AS total FROM `{$this->tbl_clienti}`
															LEFT JOIN `{$this->tbl_comenzi}` ON {$this->tbl_comenzi}.id_client = {$this->tbl_clienti}.id where {$this->tbl_clienti}.id = {$id};");
															
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }
	
  public function fetchClient($id) {

    $query = $this->db->query("SELECT * FROM `" .$this->tbl_clienti. "` WHERE id = {$id};");
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }
	
  public function fetchComanda($idcomanda, $id_client) {

    $query = $this->db->query("SELECT * FROM `" .$this->tbl_comenzi. "` WHERE id = {$idcomanda} AND id_client = {$id_client};");
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }
	
	public function fetchComandaByLastFive($idcomanda, $id_client, $uniqueid)
	{
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_comenzi. "` WHERE id = {$idcomanda} AND id_client = {$id_client} AND uniqueid = '{$uniqueid}' AND `insert_date` >= DATE_SUB(NOW(), interval 20 minute);");
    if($query->num_rows() > 0) return $query->row();
    else return false;		
	}
	
	/**
	 * getUniqueIdByEmail
	 */
	public function getUniqueIdByEmail($email)
	{
    $query = $this->db->query("SELECT uniqueid FROM `" .$this->tbl_clienti. "` WHERE email = '{$email}' AND uniqueid IS NOT NULL;");
    if($query->num_rows() > 0) return $query->row();
    else return false;		
	}
	
  /**
   * [fetchItems description]
   * @param  [String] $table    [description]
   * @param  [Object] $anyWHERE [description]
   * @return [type]           [description]
   */
  public function fetchItems($table = null, $anyWHERE = null) {
    if(empty($table)) $this->sError("Specify a table", 1);

    $query = $this->db->query("SELECT * FROM `" .trim($table). "` " .(!empty($anyWHERE) ? "WHERE {$anyWHERE->c} = {$anyWHERE->v}" : ""). ";");
    if($query->num_rows() > 0) return $query->result();
    else return false;
  }
	
	public function getComenziById_Utilizator($id)
	{
		
    $query = $this->db->query("SELECT {$this->tbl_clienti}.id_utilizator, {$this->tbl_comenzi}.id AS idcomanda, {$this->tbl_comenzi}.id_client, {$this->tbl_comenzi}.totalcomanda, {$this->tbl_comenzi}.insert_date FROM `{$this->tbl_comenzi}`
			LEFT JOIN {$this->tbl_clienti} ON {$this->tbl_clienti}.id = {$this->tbl_comenzi}.id_client WHERE {$this->tbl_clienti}.id_utilizator = {$id}");
			
    if($query->num_rows() > 0) return $query->result();
    else return false;
	}
	
	public function getLastClientById_Utilizator($id)
	{
		$query = $this->db->query("SELECT * FROM `{$this->tbl_clienti}` WHERE date_update = (SELECT MAX(date_update) FROM `{$this->tbl_clienti}` WHERE id_utilizator = {$id});");
		
    if($query->num_rows() > 0) return $query->row();
    else return false;
	}
	
	public function getLastClientByEmail($email)
	{
		$email = trim(str_replace(" ", "", $email));
		$query = $this->db->query("SELECT * FROM `{$this->tbl_clienti}` WHERE date_update = (SELECT MAX(date_update) FROM `{$this->tbl_clienti}` WHERE email = '{$email}');");
		
    if($query->num_rows() > 0) return $query->row();
    else return false;
	}
	
	public function getClientById_UserAndBy_Comanda($id, $by_comanda = 0)
	{
		$query = $this->db->query("SELECT * FROM `{$this->tbl_clienti}` WHERE id_utilizator = {$id} AND `by_comanda` = {$by_comanda};");
		
    if($query->num_rows() > 0) return $query->row();
    else return false;
	}	
	
	public function getJudete()
	{
		$query = $this->db->query("SELECT * FROM `localizare_judete`;");
		
    if($query->num_rows() > 0) return $query->result();
    else return false;		
	}
	
	public function getLocalitatiByIdJudet($nume)
	{
		$query = $this->db->query("SELECT localizare_localitati.nume as localitate, localizare_localitati.parinte, localizare_judete.nume FROM `localizare_localitati`
			LEFT JOIN localizare_judete ON localizare_judete.id = localizare_localitati.parinte
			WHERE localizare_judete.nume = '{$nume}';");
		
    if($query->num_rows() > 0) return $query->result();
    else return false;		
	}
}