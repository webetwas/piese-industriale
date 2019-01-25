<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Magazin extends CI_Controller {
  /**
	 * [private Controller]
	 * @var [type]
	 */
	private $controller;
  private $controller_ajax;

	/**
	 * [private URI - Segment]
	 * @var [type]
	 */
	private $uriseg;

  public function __construct()
  {
    parent::__construct();
		// Your own constructor code

		$this->controller = $this->router->fetch_class();//Controller
		$this->controller_ajax = $this->controller;
		$this->uriseg = json_decode(json_encode($this->uri->uri_to_assoc(2)));

		if(!$this->user->id) redirect("login");

		$this->load->model("Comenzi_model", "_Comenzi");// model/_Item
		$this->load->model("Item_model", "_Item");// model/_Item
  }

	/**
	 * [index description]
	 * @return [type] [description]
	 */
  public function index()
  {
		//
  }
	
	/**
	 * Item - Comenzi
	 */
	public function item()
	{
		$redir = base_url().$this->controller. "/comenzi";
    /**
     * [$viewdata description]
     * @var array
     */ $viewdata = array("controller" => $this->controller, "controller_ajax" => $this->controller_ajax, "uri" => null, "client" => null, "comanda" => null, "form" => (object) [], $products = null);
		$viewdata["uri"] = $this->uriseg;
		
		// FORM - NEW
		$viewdata["form"]->item = (object) [];
		$viewdata["form"]->item->name = "item";
		$viewdata["form"]->item->id = "item_comanda";
		$viewdata["form"]->item->prefix = "it";
		$viewdata["form"]->item->segments = $this->controller. "/item/" .$this->uriseg->item. "/id/" .$this->uriseg->id;

		$form_submit = $viewdata["form"]->item->prefix. "submit";//submit<button>
		//FORM - ACT
		if(isset($_REQUEST["{$form_submit}"])) {
			/**
			 * [$newDBPattern description]
			 * @var array
			 */ $newDBPattern = (object) [ "table" => TBL_COMENZI, "database" => UPDATE, "type" => PUT, "design" => array() ];
			$newDBPattern->design["starecomanda"] = true;
			$newDBPattern->design["update_date"] = date("Y-m-d H:i:s");

			$update = $this->_Item->UPitem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern, trim(intval($this->uriseg->id)));//create categorie
			if($update) redirect($redir);
		}
		
		if($this->uriseg->item == "d")
		{
			if(isset($this->uriseg->id) && !is_null($this->uriseg->id)){
				$delete_atom = $this->_Item->msqlDelete('shop_comenzi', array("id" => $this->uriseg->id));
				redirect(base_url().$this->controller. "/comenzi");				
			} else {
				redirect(base_url().$this->controller. "/comenzi");
			}

		}
		
		$comanda = $this->_Comenzi->fetchComanda($this->uriseg->id);
		if($comanda) {
			$viewdata["comanda"] = $comanda;
			foreach(json_decode($comanda->cosjson)->articole as $articol)
			{
				// echo '<pre>';
				// var_dump($articol);
				// echo '</pre>';
				// die();
			}
			
			$client = $this->_Comenzi->fetchClient($comanda->id_client);
			if($client) $viewdata["client"] = $client;
		}
		
    $view = (object) [ 'html' => array(
      0 => (object) ["viewhtml" => "magazin/comanda", "viewdata" => $viewdata],
      ), 'javascript' => array(
      0 => (object) ["viewhtml" => "magazin/js_comanda", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);
	}
	
	/**
	 * Item - Cerere
	 */
	public function cerere()
	{
		$redir = base_url().$this->controller. "/cerere_oferte";
    /**
     * [$viewdata description]
     * @var array
     */ $viewdata = array("controller" => $this->controller, "controller_ajax" => $this->controller_ajax, "uri" => null, "cerere" => null, "produs" => null, "form" => (object) []);
    $viewdata["uri"] = $this->uriseg;
		
		// FORM - NEW
		$viewdata["form"]->item = (object) [];
		$viewdata["form"]->item->name = "item";
		$viewdata["form"]->item->id = "item_cerere";
		$viewdata["form"]->item->prefix = "it";
		$viewdata["form"]->item->segments = $this->controller. "/cerere/" .$this->uriseg->cerere. "/id/" .$this->uriseg->id;

		$form_submit = $viewdata["form"]->item->prefix. "submit";//submit<button>
		//FORM - ACT
		if(isset($_REQUEST["{$form_submit}"])) {
			/**
			 * [$newDBPattern description]
			 * @var array
			 */ $newDBPattern = (object) [ "table" => TBL_CERERE_OFERTA, "database" => UPDATE, "type" => PUT, "design" => array() ];
			$newDBPattern->design["starecerere"] = true;
			$newDBPattern->design["update_date"] = date("Y-m-d H:i:s");

			$update = $this->_Item->UPitem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern, trim(intval($this->uriseg->id)));//create categorie
			if($update) redirect($redir);
		}
		
		$cerere = $this->_Comenzi->fetchCerere(trim(intval($this->uriseg->id)));
		if($cerere) {
			$viewdata["cerere"] = $cerere;
			
			$produs = $this->_Comenzi->fetchProdus($cerere->idprodus);
			if($produs) $viewdata["produs"] = $produs;
		}
		
    $view = (object) [ 'html' => array(
      0 => (object) ["viewhtml" => "magazin/cerere", "viewdata" => $viewdata],
      ), 'javascript' => array(
      0 => (object) ["viewhtml" => "magazin/js_cerere", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);
	}
	
	public function clienti()
	{
    /**
     * [$viewdata description]
     * @var array
     */ $viewdata = array("controller" => $this->controller, "controller_ajax" => $this->controller_ajax, "uri" => null, "clienti" => null);
    $viewdata["uri"] = $this->uriseg;
		
		$clienti = $this->_Comenzi->GetClienti();
		if($clienti) $viewdata["clienti"] = $clienti;
		
    $view = (object) [ 'html' => array(
      0 => (object) ["viewhtml" => "magazin/clienti", "viewdata" => $viewdata],
      ), 'javascript' => array(
      0 => (object) ["viewhtml" => "magazin/js_clienti", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);
	}
	
	public function utilizatori()
	{
    /**
     * [$viewdata description]
     * @var array
     */ $viewdata = array("controller" => $this->controller, "controller_ajax" => $this->controller_ajax, "uri" => null, "utilizatori" => null);
    $viewdata["uri"] = $this->uriseg;
		
		$utilizatori = $this->_Comenzi->getUtilizatori();
		if($utilizatori) $viewdata["utilizatori"] = $utilizatori;
		
    $view = (object) [ 'html' => array(
      0 => (object) ["viewhtml" => "magazin/utilizatori", "viewdata" => $viewdata],
      ), 'javascript' => array(
      0 => (object) ["viewhtml" => "magazin/js_utilizatori", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);
	}
	
	public function sterge_client($id_client)
	{
		if(!is_null($id_client)){
			$delete_atom = $this->_Item->msqlDelete('shop_clienti', array("id" => $id_client));
			redirect(base_url().$this->controller. "/clienti");
		} else {
			redirect(base_url().$this->controller. "/clienti");
		}
	}
	
	public function sterge_utilizator($id_utilizator)
	{
		if(!is_null($id_utilizator)){
			$delete_atom = $this->_Item->msqlDelete('shop_utilizatori', array("id" => $id_utilizator));
			redirect(base_url().$this->controller. "/utilizatori");
		} else {
			redirect(base_url().$this->controller. "/utilizatori");
		}
	}
	
	public function comenzi($uniqueid = null)
	{
		$parent = null;
    /**
     * [$viewdata description]
     * @var array
     */ $viewdata = array("controller" => $this->controller, "controller_ajax" => $this->controller_ajax, "uri" => null, "comenzi" => null, "client" => null);
    $viewdata["uri"] = $this->uriseg;
		
		if(!is_null($uniqueid)) {
			$parent = (object) ["c" => "uniqueid", "v" => trim(intval($uniqueid))];
			
			$client = $this->_Comenzi->fetchClientByUniqueId(trim($uniqueid));
			if($client) $viewdata["client"] = $client;
		}
		
		$comenzi = $this->_Comenzi->GetComenzi($uniqueid);
		if($comenzi) $viewdata["comenzi"] = $comenzi;
		
    $view = (object) [ 'html' => array(
      0 => (object) ["viewhtml" => "magazin/comenzi", "viewdata" => $viewdata],
      ), 'javascript' => array(
      0 => (object) ["viewhtml" => "magazin/js_comenzi", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);		
	}
	
	public function cerere_oferte()
	{
    /**
     * [$viewdata description]
     * @var array
     */ $viewdata = array("controller" => $this->controller, "controller_ajax" => $this->controller_ajax, "uri" => null, "cerere_oferte" => null);
    $viewdata["uri"] = $this->uriseg;
		
		$cerere_oferte = $this->_Comenzi->GetCerereOferte();
		if($cerere_oferte) $viewdata["cerere_oferte"] = $cerere_oferte;
		
    $view = (object) [ 'html' => array(
      0 => (object) ["viewhtml" => "magazin/cerere_oferte", "viewdata" => $viewdata],
      ), 'javascript' => array(
      0 => (object) ["viewhtml" => "magazin/js_cerere_oferte", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);				
	}
}
