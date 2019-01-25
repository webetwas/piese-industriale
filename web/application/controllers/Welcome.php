<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		// Your own constructor code

		$this->load->model('Pagini_model', '_Pagini');
		$this->load->model("Object_model", "_Object");
		$this->load->model("Airdrop_model", "_Airdrop");
	}

	/**
	 * [Index]
	 * @return [type] [description]
	 */
	public function index()
	{
		$viewdata = array
		(
			"p_acasa" => array(
				"p_acasa" => null,
				"produse" => array(
					'catalog_acasa' => array(
						'noutati' => null,
						'speciale' => null
					)
				),
				"texte_diverse_informativ" => null
			)
		);
		
		$page_acasa = $this->_Pagini->GetPage("acasa");
		if($page_acasa) $viewdata["p_acasa"]["p_acasa"] = $page_acasa;

		if($categorii_principale = $this->_Frontend->get_categorii_principale())
		{
			$viewdata["p_acasa"]["categorii_principale"] = $categorii_principale;
		}
		
		if($texte_diverse_informativ = $this->_Airdrop->get_airdrops_by_air_controller_and_node_slug('texte_diverse', 'texte-diverse-informativ'))
		{
			$viewdata["p_acasa"]["texte_diverse_informativ"] = $texte_diverse_informativ;
		}
		
		//products
		if($atom_newproduct = $this->_Airdrop->get_products_by_state('atom_newproduct', 12))
		{
			$viewdata["p_acasa"]["produse"]["catalog_acasa"]["noutati"] = $atom_newproduct;
		}

		if($atom_special = $this->_Airdrop->get_products_by_state('atom_special', 12))
		{
			$viewdata["p_acasa"]["produse"]["catalog_acasa"]["speciale"] = $atom_special;
		}
		
		$this->frontend->carousel_proiecte = true;
		$view = (object) [ 'html' => array
			(
				0 => (object) ["viewhtml" => "pagini/" .$page_acasa->s->filehtml, "viewdata" => $viewdata["p_acasa"]],
				1 => (object) ["viewhtml" => "blocuri_html/texte_diverse_informativ", "viewdata" => null],
				2 => (object) ["viewhtml" => "blocuri_html/catalog_acasa_noutati", "viewdata" => null],
				3 => (object) ["viewhtml" => "blocuri_html/categorii_speciale", "viewdata" => null],
				4 => (object) ["viewhtml" => "blocuri_html/catalog_acasa_speciale", "viewdata" => null],
			), 'javascript' => null
		];
		
		$this->frontend->render($view,
			array(
				"title_browser_ro" => $page_acasa->p->title_browser_ro,
				"meta_description" => $page_acasa->p->meta_description,
				"keywords" => $page_acasa->p->keywords
			),
			true //isHome
		);
	}

	/**
	 * [page description]
	 * @param  [type] $id_page [description]
	 * @return [type]          [description]
	 */
	public function page($id_page)
	{
		
		$viewdata = array("page" => null, "pathimgpage" => null);
		$viewdata["pathimgpage"] = SITE_URL.PATH_IMG_PAGINA;

		$page = $this->_Pagini->GetPage(trim($id_page));
		if($page) {
			$viewdata["page"] = $page;
		}
		
    
		$view = (object) [ 'html' => array(
      0 => (object) ["viewhtml" => "blocuri_html/bloc_bannerpage", "viewdata" => $viewdata],
      1 => (object) ["viewhtml" => 'pagini/' .$page->s->filehtml, null],
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
