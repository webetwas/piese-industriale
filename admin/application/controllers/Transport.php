<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transport extends CI_Controller {

	private $ControllerObject;

  /**
	 * [private Controller]
	 * @var [type]
	 */
	private $controller;
	private $controller_fake;
  private $controller_ajax;

	/**
	 * [private URI - Segment]
	 * @var [type]
	 */
	private $uriseg;

  public function __construct() {
    parent::__construct();
    // Your own constructor code

    $this->controller = $this->router->fetch_class();//Controller
		
		$this->controller_fake = $this->controller;
    $this->controller_ajax = $this->controller;
		$this->uriseg = json_decode(json_encode($this->uri->uri_to_assoc(2)));

    if(!$this->user->id) redirect("login");
		
    $this->load->model("Item_model", "_Item");// model/_Item
		$this->load->model("Chain_model", "_Chain");// model/_Chain
		$this->load->model("Object_model", "_Object");// model/_Categories
		$this->load->model('Pagini_model', '_Pagini');// model/_Pagini
		$this->load->model("Upload_model", "_Upload");// model/_Upload
		$this->load->model('Nodes_model', "_Nodes");
		
		$this->ControllerObject = $this->_Nodes->get_air_data_by_air_controller(strtolower($this->controller));
		
		if(!$this->ControllerObject) exit("Couldn't find Controller's Object");
		
		// var_dump($this->ControllerObject);die();
  }
	
	/**
	 * [proiecte description]
	 * @return [type] [description]
	 */
  public function index()
  {
		
    redirect($this->controller_fake .'/item/u/id/1');
  }	
	
	/**
	 * Item
	 */
	public function item()
	{
		
		$viewdata = array("controller" => $this->controller, "controller_fake" => $this->controller_fake, "controller_ajax" => $this->controller_fake. "/ajax/", "item" => null, "item_links" => null, "links" => null, "uri" => null, "form" => (object) [], "imgpathitem" => null);
		$viewdata["uri"] = $this->uriseg;
		// $viewdata["imgpathitem"] = SITE_URL.PATH_IMG_ECHIPA."m/";
		// var_dump($this->uriseg);
	
		// FORM - Item
		$viewdata["form"]->item = (object) ["name" => "item", "prefix" => "it", "segments" => $this->controller_fake. "/item/" .$this->uriseg->item. ($this->uriseg->item == "u" && isset($this->uriseg->id) && !is_null($this->uriseg->id) ? "/id/" .trim(intval($this->uriseg->id)) : "")];
		$form_submititem = $viewdata["form"]->item->prefix. "submit";//submit<button>	
		
		switch($this->uriseg->item)
    {
      case UPDATE:
				if(isset($this->uriseg->id) && !is_null($this->uriseg->id)):		
				
					$item = $this->_Item->msqlGet($this->ControllerObject->air_table, array("id_item" => trim(intval($this->uriseg->id))));
					if($item) {
						$viewdata["item"] = $item;
					}
					
					/* form @item */
					if(isset($_REQUEST["{$form_submititem}"])) {
					
						$newDBPattern = (object) [ // Design Database Pattern
							"table" => $this->ControllerObject->air_table,
							"database" => UPDATE,
							"type" => GET,
							"design" => array(
							)
						]; 
						$update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern, array("c" => "id_item", "v" => trim(intval($this->uriseg->id))));// update@Item
						if($update) $this->_Session->setFB_Pozitive(array("ref" => "Transport", "text" => "Modificarile tale au fost salvate!"));
						redirect($viewdata["form"]->item->segments);

					}
				endif;
      break;
   }	
	
		
		//breacrumb
		$breadcrumb = array("bb_titlu" => "Programul nostru", "bb_button" => null, "breadcrumb" => array());
		
		$breadcrumb["breadcrumb"][0] = array("text" => "Administrare", "url" => "/");
		$breadcrumb["breadcrumb"][1] = array("text" => "Programul nostru", "url" => null);
    $view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
      1 => (object) ["viewhtml" => "transport/item", "viewdata" => $viewdata]
      ), 'javascript' => array(
      1 => (object) ["viewhtml" => "transport/js_item", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);	
	}
}