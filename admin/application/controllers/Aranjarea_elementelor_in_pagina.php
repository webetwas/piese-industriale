<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aranjarea_elementelor_in_pagina extends CI_Controller {
  /**
	 * [private Controller]
	 * @var [type]
	 */
	private $controller;
  private $controller_ajax;
  
  private $controller_actions;

	/**
	 * [private URI - Segment]
	 * @var [type]
	 */
	private $uriseg;

  public function __construct() {
    parent::__construct();
    // Your own constructor code

    $this->controller = $this->router->fetch_class();//Controller
    
    $this->controller_actions = 'legaturi';
    
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
	  redirect("/");
		$viewdata = array("links" => null, "controller" => $this->controller, "controller_ajax" => $this->controller_ajax, "controller_actions" => $this->controller_actions, "uri" => null);
		$viewdata["uri"] = $this->uriseg;
		
		$links = $this->_Chain->MapAllLinks(array("justfuckinggod" => 0));
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
		
		// breacrumb
		// $breadcrumb = array("bb_titlu" => "In aceasta pagina, puteti ordona orice element al paginii,", "bb_button" => null, "breadcrumb" => array());
		
		// $breadcrumb["breadcrumb"][0] = array("text" => "Administrare", "url" => '');
		// $breadcrumb["breadcrumb"][1] = array("text" => "Legaturi", "url" => null);
    $view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "aranjare_in_pagina/top_help", "viewdata" => null],
      1 => (object) ["viewhtml" => "aranjare_in_pagina/index", "viewdata" => $viewdata]
      ), 'javascript' => array(
      1 => (object) ["viewhtml" => "aranjare_in_pagina/js_index", "viewdata" => null],
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
