<?php
class Comenzi_model extends CI_Model {	
	
	private $tbl_produse = null;
  private $tbl_clienti = null;
  private $tbl_comenzi = null;
	private $tbl_cerereoferte = null;


  /**
   * [__construct description]
   */
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    $this->objname = get_class($this);//Controller
		
		$this->tbl_produse = null;
		$this->tbl_clienti = TBL_CLIENTI;
		$this->tbl_comenzi = TBL_COMENZI;
		$this->tbl_cerereoferte = null;
  }

  public function getTotalByClient($id) {
    $query = $this->db->query("SELECT {$this->tbl_clienti}.id, SUM({$this->tbl_comenzi}.totalcomanda) AS total FROM `{$this->tbl_clienti}`
															LEFT JOIN `{$this->tbl_comenzi}` ON {$this->tbl_comenzi}.id_client = {$this->tbl_clienti}.id where {$this->tbl_clienti}.id = {$id};");
															
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }
	
	public function getUtilizatori()
	{
		$query = $this->db->query("SELECT * FROM `shop_utilizatori`");
		
		if($query->num_rows() > 0) return $query->result();
		else return false;
	}
	
	public function GetClienti()
	{
		$clienti = $this->fetchItems($this->tbl_clienti);
		
		$clienti_unique = $this->getUniqueClients();
		if($clienti && $clienti_unique) {
			$totalbythis = array();
			foreach($clienti as $client) {
			
				$total = $this->getTotalByClient($client->id);
				if($total) {
					if(isset($clienti_unique[$client->email])) {
						$clienti_unique[$client->email]->total = number_format($clienti_unique[$client->email]->total + round($total->total), 2, '.', '');
					}
				}
			}
		} else return false;
		
		// return $clienti;
		return $clienti_unique;
	}
	
	private function getUniqueClients()
	{
		$clienti = array();
    $query = $this->db->query("SELECT MAX(id_utilizator) AS id_utilizator, id, uniqueid, nume, prenume, email, telefon FROM `{$this->tbl_clienti}` GROUP BY email;");
															
    if($query->num_rows() > 0) {
			foreach($query->result() as $client) {
				$client->total = 0;
				$clienti[$client->email] = $client;
			}
			
			return $clienti;
		}
    else return false;	
	}
	
	public function GetComenzi($uniqueid = null) {
		
		if(!is_null($uniqueid)) $comenzi = $this->fetchItems($this->tbl_comenzi, (object) ["c" => "uniqueid", "v" => "\"{$uniqueid}\""]);
		else $comenzi = $this->fetchItems($this->tbl_comenzi);
		
		if($comenzi) {
			foreach($comenzi as $keycmd => $comanda) {
				$comenzi[$keycmd]->client_numeprenume = null;
				
				$client = $this->fetchClient($comanda->id_client);
				if($client) $comenzi[$keycmd]->client_numeprenume = $client->nume. " " .$client->prenume;
			}
			return $comenzi;
		}
		
		return false;
	}
	
	public function GetCerereOferte()
	{
		$cerere_oferte = $this->fetchItems($this->tbl_cerereoferte);
		if($cerere_oferte) return $cerere_oferte;
		
		return false;
	}
	
  public function fetchClient($id) {

    $query = $this->db->query("SELECT * FROM `" .$this->tbl_clienti. "` WHERE id = {$id};");
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }
	
  public function fetchClientByUniqueId($uniqueid) {

    $query = $this->db->query("SELECT * FROM `" .$this->tbl_clienti. "` WHERE uniqueid = '{$uniqueid}';");
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }	
	
  public function fetchComanda($id) {

    $query = $this->db->query("SELECT * FROM `" .$this->tbl_comenzi. "` WHERE id = {$id};");
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }
	
	public function fetchCerere($id) {
		
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_cerereoferte. "` WHERE id = {$id};");
    if($query->num_rows() > 0) return $query->row();
    else return false;		
	}
	
	public function fetchProdus($id) {
		
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_produse. "` WHERE id = {$id};");
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
}
