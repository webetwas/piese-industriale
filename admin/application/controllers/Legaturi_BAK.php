<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Legaturi extends CI_Controller
{
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
	$this->controller_ajax = $this->controller. "/ajax";
	$this->uriseg = json_decode(json_encode($this->uri->uri_to_assoc(2)));

	if(!$this->user->id) redirect("login");

	$this->load->model("Item_model", "_Item");// model/_Item
	$this->load->model("Chain_model", "_Chain");// model/_Chain
	$this->load->model("Object_model", "_Object");// model/_Chain
  }

	/**
	 * [index description]
	 * @return [type] [description]
	 */
  public function index()
  {
		$viewdata = array("links" => null, "controller" => $this->controller, "controller_ajax" => $this->controller_ajax, "uri" => null);
		$viewdata["uri"] = $this->uriseg;
		
		$links = $this->_Chain->MapAllLinks();
		if($links) {
			//str_a
			foreach($links as $keystr_a => $str_a) {
				$links[$keystr_a]->objects = $this->_Object->getObjectsXContentByIdLink($str_a->id_link);//passObjectsToLink
				
				//str_b
				if(!is_null($str_a->strs_b)) {
					foreach($str_a->strs_b as $keystr_b => $str_b) {
						$links[$keystr_a]->strs_b[$keystr_b]->objects = $this->_Object->getObjectsXContentByIdLink($str_b->id_link);//passObjectsToLink
						
						if(!is_null($str_b->strs_c)) {
							foreach($str_b->strs_c as $keystr_c => $str_c) {
								$links[$keystr_a]->strs_b[$keystr_b]->strs_c[$keystr_c]->objects = $this->_Object->getObjectsXContentByIdLink($str_c->id_link);//passObjectsToLink
								
							}
						}
					}
				}
			}
		}
		
		if($links) $viewdata["links"] = $links;
		
		//breacrumb
		$breadcrumb = array("bb_titlu" => "Legaturi", "bb_button" => null, "breadcrumb" => array());
		$breadcrumb["bb_button"] = array("text" => '<i class="fa fa-plus-square"></i> Legatura noua', "linkhref" => "legaturi/item/i");
		
		$breadcrumb["breadcrumb"][0] = array("text" => "Administrare", "url" => '');
		$breadcrumb["breadcrumb"][1] = array("text" => "Legaturi", "url" => null);
    $view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
      1 => (object) ["viewhtml" => "legaturi/index", "viewdata" => $viewdata]
      ), 'javascript' => array(
      1 => (object) ["viewhtml" => "legaturi/js_index", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);
  }
	
	/**
	 * item
	 */
	public function item()
	{
		
		$viewdata = array("controller" => $this->controller, "item" => null, "parent" => null, "uri" => null, "id_object" => null, "data_object" => null, "form" => (object) []);
		$viewdata["uri"] = $this->uriseg;
		
    // an object is called
    if(isset($this->uriseg->id_object) && !is_null($this->uriseg->id_object)) {
      
      $viewdata["id_object"] = (int)trim($this->uriseg->id_object);
      $viewdata["data_object"] = $this->_Object->getDataObject($viewdata["id_object"]);

    }
    
		// FORM - Item
		$viewdata["form"]->item = (object) ["name" => "item", "prefix" => "it", "segments" => $this->controller. "/item/" .$this->uriseg->item];
    if(!is_null($viewdata["id_object"])) {

      $viewdata["form"]->item->segments .= '/id_object/' .$viewdata["id_object"];
    }
    
		$form_submititem = $viewdata["form"]->item->prefix. "submit";//submit<button>
		
		// FORM - Meta
		$viewdata["form"]->meta = (object) ["name" => "meta", "prefix" => "mt", "segments" => $this->controller. "/item/" .$this->uriseg->item];
		$form_submitmeta = $viewdata["form"]->meta->prefix. "submit";//submit<button>
		
		switch($this->uriseg->item)
		{
			case UPDATE: 
				$viewdata["form"]->item->segments .= "/id/" .$this->uriseg->id;//create2ndsegment
				$viewdata["form"]->meta->segments .= "/id/" .$this->uriseg->id;//create2ndsegment
				
				$item = $this->_Item->msqlGet(TBL_CHAIN_LINKS, array("id_link" => trim(intval($this->uriseg->id))));//fetchitem
				if($item) $viewdata["item"] = $item;
				
				/* form @item */
        if(isset($_REQUEST["{$form_submititem}"])) {
					!empty($this->input->post("{$viewdata["form"]->item->prefix}denumire_ro")) ? $idhttp_url = str_replace(" ", "_", trim(strtolower($this->input->post("{$viewdata["form"]->item->prefix}denumire_ro")))): $idhttp_url = false;
				
				
					$newDBPattern = (object) [ // Design Database Pattern
						"table" => TBL_CHAIN_LINKS,
						"database" => UPDATE,
						"type" => PUT,
						"design" => array(
							"denumire_ro" => true,
							"i_titlu" => true,
							"i_subtitlu" => true,
							"idhttp_url" => $idhttp_url
						)
					]; $update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern, array("c" => "id_link", "v" => trim(intval($this->uriseg->id))));// update@Item
					if($update) $this->_Session->setFB_Pozitive(array("ref" => "Legatura", "text" => "Modificarile tale au fost salvate!"));
					redirect($viewdata["form"]->item->segments);
				
				/* form @meta */
        } elseif(isset($_REQUEST["{$form_submitmeta}"])) {
					
					$newDBPattern = (object) [ // Design Database Pattern
						"table" => TBL_CHAIN_LINKS,
						"database" => UPDATE,
						"type" => PUT,
						"design" => array(
							"title_browser_ro" => true,
							"meta_description" => true,
							"keywords" => true
						)
					]; $update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->meta->prefix, $newDBPattern, array("c" => "id_link", "v" => trim(intval($this->uriseg->id))));// update@Meta
					if($update) $this->_Session->setFB_Pozitive(array("ref" => "Metadata Legatura", "text" => "Modificarile tale au fost salvate!"));
					redirect($viewdata["form"]->item->segments);
				}
			break;
			case INSERT:
        $id_parent = false;
				$parent = false;
				if(isset($this->uriseg->parent) && !is_null($this->uriseg->parent)) {
          
          $id_parent = intval(trim($this->uriseg->parent));
          
					$viewdata["form"]->item->segments .= "/parent/" .$id_parent;//create2ndsegment
					
					$parent = $this->_Chain->getParentByIdLink($id_parent);//fetchparent
					if($parent) $viewdata["parent"] = $parent;          
        }
				
				/* form @item */
				if(isset($_REQUEST["{$form_submititem}"])) {

					!empty($this->input->post("{$viewdata["form"]->item->prefix}denumire_ro")) ? $idhttp_url = str_replace(" ", "_", trim(strtolower($this->input->post("{$viewdata["form"]->item->prefix}denumire_ro")))): $idhttp_url = false;
					
          $admin_editable = false;
          $admin_deletable = false;
          $god_deletable = false;
          
          if(!is_null($viewdata["id_object"])) {
            $admin_editable = 1;
            $admin_deletable = 1;
            $god_deletable = 1;
          }
          
					$newDBPattern = (object) [ // Design Database Pattern
						"table" => TBL_CHAIN_LINKS,
						"database" => INSERT,
						"type" => PUT,
						"design" => array(
							"denumire_ro" => true,
							"id_parent" => $id_parent,
							"idhttp_url" => $idhttp_url,
							"unique_id" => md5(date("Y-m-d H:i:s").rand(1,1000)),
              "admin_editable" => $admin_editable,
              "admin_deletable" => $admin_deletable,
              "god_deletable" => $god_deletable
						)
					];
          
          // var_dump($newDBPattern);die();
					$insert = $this->_Item->INSItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern);// insert@Item
          
          $sessref = 'Legaturi';
          $sesstext = 'Ai creat legatura noua!';
          if($parent && !is_null($parent->obj_controller)) {
            
            $sessref = ucfirst(str_replace('_', ' ', $parent->obj_controller));
            $sesstext = 'Sectiunea a fost creata!';          
          }
					if($insert) $this->_Session->setFB_Pozitive(array("ref" => $sessref, "text" => $sesstext));
          
          if($parent && !is_null($parent->obj_controller)) {
            
            redirect($parent->obj_controller. '/sectiune/' .$insert);
          } else {
            redirect($this->controller. "/item/u/id/" .$insert);
          }
				}
			break;
			
			case DELETE:
				$id_link = (isset($this->uriseg->id) && !is_null($this->uriseg->id)) ? trim(intval($this->uriseg->id)) : false;
				
				$deletechilds = $this->_Chain->deleteChildrensxContentOf($id_link);
        
				$deletelink = false;
        
        // $parent = $this->_Chain->getParentOfThis($id_link);
        // var_dump($parent);die();
        
				if($deletechilds) $deletelink = $this->_Chain->deleteLinkxContentOf($id_link);
				
				if($deletelink && $deletechilds)
					$this->_Session->setFB_Pozitive(array("ref" => "Legaturi", "text" => "Succes! Ai sters o Legatura"));

				redirect($this->controller);
			break;
		}

		
		//breacrumb
		$breadcrumb = array("bb_titlu" => "Legaturi", "bb_button" => null, "breadcrumb" => array());
		
		$breadcrumb["breadcrumb"][0] = array("text" => "Legaturi", "url" => 'legaturi');
		$breadcrumb["breadcrumb"][1] = array("text" => (isset($item) ? $item->denumire_ro : (!is_null($viewdata["parent"]) ? $viewdata["parent"]->denumire_ro : "Creaza legatura")) , "url" => null);
    $view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
      1 => (object) ["viewhtml" => "legaturi/item", "viewdata" => $viewdata]
      ), 'javascript' => array(
      1 => (object) ["viewhtml" => "legaturi/js_item", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);	
	}
	
	public function ajax()
	{

		$res = array("status" => 1);
		
		if(!isset($this->uriseg->ajax) || is_null($this->uriseg->ajax)) exit("Error");
		
		switch($this->uriseg->ajax)
		{
			case AJXELEMENTMOVED:
				$id_link = (isset($this->uriseg->id_link) && !empty($this->uriseg->id_link)) ? $this->uriseg->id_link : false;
				$serialize = !empty($this->input->post("serialize")) ? $this->input->post("serialize") : false;
				
				$orderby = 0;
				foreach($serialize as $keyser => $ser) { //@ser["id"] as $idcontent_object
					$orderby++;
					$updatecontentitem = $this->_Object->updateContentItemOrder($ser["id"], $orderby);
					
					if(!$updatecontentitem) $res["status"] = 0;
				}
			break;
		}
		
		header("Content-Type: application/json");
		echo json_encode($res);
	}
}
