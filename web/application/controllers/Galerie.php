<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

class Galerie extends CI_Controller {

	private $ControllerObject;
	
	public function __construct() {
		parent::__construct();
		// Your own constructor code

		$this->load->model('Pagini_model', '_Pagini');
		$this->load->model("Item_model", "_Item");
		$this->load->model("Object_model", "_Object");
		
		$this->ControllerObject = $this->_Object->getObjectStructure("servicii");
	}
  
  public function index()
  {
    redirect(base_url()."galerie/foto");
  }
  
	/**
	 * [foto]
	 * @return [type] [description]
	 */
	public function foto()
	{
		
		$viewdata = array(
			"page" => null,
			"pathimgpage" => PATH_IMG_PAGINA,
			"pathimggaleriefoto" => BASE_URL.PATH_IMG_GALERIEFOTO,
      "items" => null
		);
		
		$page = $this->_Pagini->GetPage("galerie_foto");//getpage
		if($page) $viewdata["page"] = $page;
		
		$galerie_foto = $this->_Object->getContentItemsFullByFirstChild("galerie_foto", "d79ae6197b706cac41d808c914a162db");//getportofoliu
		if($galerie_foto) {
			$grouplinksbyitems = $this->_Object->groupLinksByItems($galerie_foto);//grouplinksbyitems
			
			$viewdata["items"] = $grouplinksbyitems;
		}
    
		$view = (object) [ 'html' => array(
      0 => (object) ["viewhtml" => "blocuri_html/bloc_bannerpage", "viewdata" => $viewdata],
      1 => (object) ["viewhtml" => "pagini/" .$page->s->filehtml, "viewdata" => null],
      ), 'javascript' => null
    ];
		
		$this->frontend->slider = false;
    $this->frontend->imagini_footer = false;
		$this->frontend->render($view,
			array(
				"title_browser_ro" => $page->p->title_browser_ro,
				"meta_description" => $page->p->meta_description,
				"keywords" => $page->p->keywords
			)
		);
	}
  
	/**
	 * [video]
	 * @return [type] [description]
	 */
	public function video()
	{
		
		$viewdata = array(
			"page" => null,
			"pathimgpage" => PATH_IMG_PAGINA,
			"pathimggalerievideo" => BASE_URL.PATH_IMG_GALERIEVIDEO,
      "items" => null
		);
		
		$page = $this->_Pagini->GetPage("galerie_video");//getpage
		if($page) $viewdata["page"] = $page;
		
		$galerie_video = $this->_Object->getContentItemsFullByFirstChild("galerie_video", "7a934b4b1b870e7a1c28551257789305");//getportofoliu
		if($galerie_video) {
			$grouplinksbyitems = $this->_Object->groupLinksByItems($galerie_video);//grouplinksbyitems
			
			$viewdata["items"] = $grouplinksbyitems;
		}
    
		$view = (object) [ 'html' => array(
      0 => (object) ["viewhtml" => "blocuri_html/bloc_bannerpage", "viewdata" => $viewdata],
      1 => (object) ["viewhtml" => "pagini/" .$page->s->filehtml, "viewdata" => null],
      ), 'javascript' => array(1 => (object) ["viewhtml" => "pagini/" .$page->s->filejs, "viewdata" => null]
      )
    ];
		
		$this->frontend->slider = false;
    $this->frontend->imagini_footer = false;
		$this->frontend->render($view,
			array(
				"title_browser_ro" => $page->p->title_browser_ro,
				"meta_description" => $page->p->meta_description,
				"keywords" => $page->p->keywords
			)
		);
	}
}
