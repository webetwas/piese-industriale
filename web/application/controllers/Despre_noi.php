<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Despre_noi extends CI_Controller {

	private $ControllerObject;
	
	public function __construct() {
		parent::__construct();
		// Your own constructor code

		$this->load->model('Pagini_model', '_Pagini');
		$this->load->model("Item_model", "_Item");
		$this->load->model("Object_model", "_Object");

	}

	/**
	 * [Index]
	 * @return [type] [description]
	 */
	public function index()
	{
		
		$viewdata = array(
			"page" => null,
			"pathimgpage" => BASE_URL.PATH_IMG_PAGINA,
			"pathimgechipa" => BASE_URL.PATH_IMG_ECHIPA,
			"breadcrumb" => array(),
			"echipa" => null,
			"texte_diverse_informativ" => null
		);		
		
		$page = $this->_Pagini->GetPage("despre_noi");//getpage
		if($page) $viewdata["page"] = $page;

		$viewdata["breadcrumb"][] = array('text' => 'Acasa', 'href' => '/');
		$viewdata["breadcrumb"][] = array('text' => $page->p->title_ro, 'href' => '/' . $page->p->slug);		

		if($echipa = $this->_Airdrop->get_airdrops_and_images_by_air_controller_and_node_slug('echipa', 'echipa'))
		{
			$viewdata["echipa"] = $echipa;
		}		
		
		if($texte_diverse_informativ = $this->_Airdrop->get_airdrops_by_air_controller_and_node_slug('texte_diverse', 'texte-diverse-informativ'))
		{
			$viewdata["texte_diverse_informativ"] = $texte_diverse_informativ;
		}
		
		$view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "blocuri_html/bloc_banner_page", "viewdata" => $viewdata],
			1 => (object) ["viewhtml" => "pagini/" .$page->s->filehtml, "viewdata" => $viewdata],
			2 => (object) ["viewhtml" => "blocuri_html/echipa", "viewdata" => null],
			3 => (object) ["viewhtml" => "blocuri_html/texte_diverse_informativ", "viewdata" => null],
			4 => (object) ["viewhtml" => "blocuri_html/end_div", "viewdata" => null],
		  ), 'javascript' => null
		];
		
		$this->frontend->slider = false;
		$this->frontend->body_class = 'home-two shop-main sidebar';
		$this->frontend->menu_class = 'col-lg-12';
		$this->frontend->render($view,
			array(
				"title_browser_ro" => $page->p->title_browser_ro,
				"meta_description" => $page->p->meta_description,
				"keywords" => $page->p->keywords
			)
		);
	}
}
