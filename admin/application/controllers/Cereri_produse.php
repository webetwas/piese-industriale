<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cereri_produse extends CI_Controller {


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
		
		$this->controller_fake = $this->controller;//Here we don't need an Fake controller, there are no Father Controller
    $this->controller_ajax = $this->controller;
		$this->uriseg = json_decode(json_encode($this->uri->uri_to_assoc(2)));

    if(!$this->user->id) redirect("login");
		
    $this->load->model("Item_model", "_Item");// model/_Item
		

		
		// var_dump($this->ControllerObject);die();
  }
	
	/**
	 * [proiecte description]
	 * @return [type] [description]
	 */
  public function index()
  {
		
		$viewdata = array("items" => null, "controller_fake" => $this->controller_fake, "controller_ajax" => $this->controller_fake. "/ajax/", "uri" => null);
		$viewdata["uri"] = $this->uriseg;
		
		$items = $this->_Item->msqlGetAllCereri('catalog_produse_cereri');
		if($items) $viewdata["items"] = $items;
		
		//breacrumb
		$breadcrumb = array("bb_titlu" => "Cereri produse", "bb_button" => null, "breadcrumb" => array());
		
		$breadcrumb["breadcrumb"][0] = array("text" => "Administrare", "url" => '');
		$breadcrumb["breadcrumb"][1] = array("text" => "Cereri produse", "url" => null);
    $view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
      1 => (object) ["viewhtml" => "cereri_produse/index", "viewdata" => $viewdata]
      ), 'javascript' => array(
      1 => (object) ["viewhtml" => "cereri_produse/js_index", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);
  }
  
  public function sterge_participant($id_item)
  {
	if(!is_null($id_item)){
		$delete_atom = $this->_Item->msqlDelete('catalog_produse_cereri', array("cerere_id" => $id_item));
		redirect(base_url().$this->controller);
	} else {
		redirect(base_url().$this->controller);
	}	  
  }
  
  public function finalizata($id_item)
  {
	if(!is_null($id_item)){
		$delete_atom = $this->_Item->msqlUpdate('catalog_produse_cereri', array("seen" => 1), array("c" => "cerere_id", "v" => $id_item));
		redirect(base_url().$this->controller);
	} else {
		redirect(base_url().$this->controller);
	}	  
  }

}
