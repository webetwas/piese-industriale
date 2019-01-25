<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proiecte extends CI_Controller {

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
		
		$this->controller_fake = "portofoliu/" .$this->controller;
    $this->controller_ajax = $this->controller;
		$this->uriseg = json_decode(json_encode($this->uri->uri_to_assoc(3)));

    if(!$this->user->id) redirect("login");
		
    $this->load->model("Item_model", "_Item");// model/_Item
		$this->load->model("Chain_model", "_Chain");// model/_Chain
		$this->load->model("Object_model", "_Object");// model/_Categories
		
		$this->ControllerObject = $this->_Object->getObjectStructure($this->controller);
		
		if(!$this->ControllerObject) exit("Couldn't find Controller's Object");
  }
	
	/**
	 * [proiecte description]
	 * @return [type] [description]
	 */
  public function index()
  {
		
		$viewdata = array("proiecte" => null, "controller_fake" => $this->controller_fake, "uri" => null);
		$viewdata["uri"] = $this->uriseg;
		
		$proiecte = $this->_Item->msqlGetAll(TBL_PORTOFOLIU_PROIECTE);
		if($proiecte) $viewdata["proiecte"] = $proiecte;
		
		//breacrumb
		$breadcrumb = array("bb_titlu" => "Portofoliu", "bb_button" => null, "breadcrumb" => array());
		$breadcrumb["bb_button"] = array("text" => '<i class="fa fa-plus-square"></i> Adauga proiect', "linkhref" => $this->controller_fake ."/item/i");
		
		$breadcrumb["breadcrumb"][0] = array("text" => "Portofoliu", "url" => 'portofoliu');
		$breadcrumb["breadcrumb"][1] = array("text" => "Proiecte", "url" => null);
    $view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
      1 => (object) ["viewhtml" => "portofoliu/proiecte/index", "viewdata" => $viewdata]
      ), 'javascript' => array(
      1 => (object) ["viewhtml" => "portofoliu/proiecte/js_index", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);
  }	
	
	/**
	 * Item
	 */
	public function item()
	{
		
		$viewdata = array("controller" => $this->controller, "controller_fake" => $this->controller_fake, "controller_ajax" => $this->controller_fake. "/ajax/", "item" => null, "item_links" => null, "links" => null, "uri" => null, "form" => (object) []);
		$viewdata["uri"] = $this->uriseg;
		// var_dump($this->uriseg);
	
		// FORM - NEW Item - Page
		$viewdata["form"]->item = (object) ["name" => "item", "prefix" => "it", "segments" => $this->controller_fake. "/item/" .$this->uriseg->item. ($this->uriseg->item == "u" && isset($this->uriseg->id) && !is_null($this->uriseg->id) ? "/id/" .trim(intval($this->uriseg->id)) : "")];
		$form_submititem = $viewdata["form"]->item->prefix. "submit";//submit<button>	
    switch($this->uriseg->item)
    {
      case UPDATE:
				if(isset($this->uriseg->id) && !is_null($this->uriseg->id)):
					$links = $this->_Chain->getAllLinks();
					$links ? $viewdata["links"] = $links : $viewdata["links"] = null;				
				
					$item = $this->_Item->msqlGet(TBL_PORTOFOLIU_PROIECTE, array("id_project" => trim(intval($this->uriseg->id))));
					$item ? $viewdata["item"] = $item : $viewdata["item"] = null;
					
					$item_links = $this->_Chain->getIIDS_LinksByAnObjectItem($this->ControllerObject->id_object, trim(intval($this->uriseg->id)));
					if($item_links) $viewdata["item_links"] = $item_links;
					
					/* form @item */
					if(isset($_REQUEST["{$form_submititem}"])) {

						$newDBPattern = (object) [ // Design Database Pattern
							"table" => "portofoliu_proiecte",
							"database" => UPDATE,
							"type" => GET,
							"design" => array()
						]; 
						$update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern, array("c" => "id_project", "v" => trim(intval($this->uriseg->id))));// update@Item
						if($update) $this->_Session->setFB_Pozitive(array("ref" => $item->project_name, "text" => "Modificarile tale au fost salvate!"));
						redirect($viewdata["form"]->item->segments);
					}
				endif;
      break;

      case INSERT:
				/* form @item */
        if(isset($_REQUEST["{$form_submititem}"])) {

					$newDBPattern = (object) [ // Design Database Pattern
						"table" => TBL_PORTOFOLIU_PROIECTE,
						"database" => INSERT,
						"type" => GET,
						"design" => array()
					]; 
					$insert = $this->_Item->INSItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern);// insert@Item
					if($insert) $this->_Session->setFB_Pozitive(array("ref" => "Proiecte", "text" => "Ai adaugat un Proiect nou!"));
					redirect($this->controller_fake);
        }
      break;
   }	
	
		
		//breacrumb
		$breadcrumb = array("bb_titlu" => "Proiecte", "bb_button" => null, "breadcrumb" => array());
		
		$breadcrumb["breadcrumb"][0] = array("text" => "Proiecte", "url" => $this->controller_fake);
		$breadcrumb["breadcrumb"][1] = array("text" => "Proiect dd", "url" => null);
    $view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
      1 => (object) ["viewhtml" => "portofoliu/proiecte/item", "viewdata" => $viewdata]
      ), 'javascript' => array(
      1 => (object) ["viewhtml" => "portofoliu/proiecte/js_item", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);	
	}
	
	/**
	 * [Ajax description]
	 */
  public function Ajax()
	{
		
		if(!empty($this->uriseg->ajax) && isset($this->uriseg->id) && !is_null($this->uriseg->id))
	    switch($this->uriseg->ajax)
			{
				case LINKREQUEST:
					$res = array("status" => 0);
					
					$params = !empty($this->input->post("params")) ? $this->input->post("params") : null;
					foreach($params as $paramaction => $param) {
						$paction = $paramaction;
						$pparam = $param;
					}
					
					if($paction == "selected")
						$actdb = $this->_Object->InsertContent($this->ControllerObject->id_object, $this->uriseg->id, $pparam);
					elseif($paction == "deselected")
						$actdb = $this->_Object->DeleteContent($this->ControllerObject->id_object, $this->uriseg->id, $pparam);

					if($actdb) $res["status"] = 1;
					
					header("Content-Type: application/json");
					echo json_encode($res);
				break;
			}
		else show_404();
  }
}
