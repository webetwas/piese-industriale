<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

class Catalog_produse extends CI_Controller {

	private $controller;
	private $Air;
	
	public function __construct() {
		parent::__construct();
		// Your own constructor code
		
		$this->controller = $this->router->fetch_class();
		
		$this->load->model('Pagini_model', '_Pagini');
		$this->load->model("Item_model", "_Item");
		$this->load->model("Object_model", "_Object");
		$this->load->model("Airdrop_model", "_Airdrop");
		$this->load->model("Sendemail_model", "_Sendemail");
		
		$this->Air = $this->_Airdrop->get_air_data_by_air_controller(strtolower($this->controller));
		
		if(!$this->Air) exit("Couldn't find The Air..");		
		
		$this->load->helper('matrix');
		
        // load Pagination library
        $this->load->library('pagination');
         
        // load URL helper
        $this->load->helper('url');
		$this->load->helper('application');
	}

	public function index()
	{
		$viewdata = array(
			"categories" => buildMatrix($this->_Airdrop->get_all_nodes_by_node(1), 'parent_id', 'node_id', 1),
			"page" => null,
			"pathimgpage" => PATH_IMG_PAGINA,
			"categories_cp" => null,
			"pagination" => null,
			"products" => null,
			"filter_state" => false,
			"produse_noi" => $this->_Airdrop->get_products_by_state_rand_and_limit('atom_newproduct', 5),
			"breadcrumb" => array()
		);
		
		$viewdata["breadcrumb"][] = array('text' => 'Acasa', 'href' => '/');
		$viewdata["breadcrumb"][] = array('text' => 'Catalog produse', 'href' => '/catalog_produse');

		if($get_categories = $this->_Airdrop->get_all_nodes_and_images_by_node((int)$this->Air->targeted_node_id))
		{
			$viewdata["categories_cp"] = buildMatrix($get_categories, 'parent_id', 'node_id', (int)$this->Air->targeted_node_id);
		}
		
		// var_dump($viewdata["categories_cp"]);
		// die();
		
		$page = $this->_Pagini->GetPage("catalog_produse");//getpage
		if($page) $viewdata["page"] = $page;

		
		$view = (object) [ 'html' => array
			(
				0 => (object) ["viewhtml" => "blocuri_html/bloc_banner_page", "viewdata" => $viewdata],
				1 => (object) ["viewhtml" => "catalog_produse/start", "viewdata" => null],
				2 => (object) ["viewhtml" => "catalog_produse/left-panel", "viewdata" => null],
				3 => (object) ["viewhtml" => "pagini/" .$page->s->filehtml, "viewdata" => null],
				4 => (object) ["viewhtml" => "catalog_produse/end", "viewdata" => null],
			), 'javascript' => null
		];
		
		$this->frontend->body_class = 'home-two shop-main sidebar';
		$this->frontend->menu_class = 'col-lg-12';
		$this->frontend->slider = false;
		$this->frontend->render($view,
			array(
				"title_browser_ro" => ($page->p->title_browser_ro),
				"meta_description" => ($page->p->meta_description),
				"keywords" => ($page->p->keywords)
			)
		);
	}
	
	public function categorie($slug)
	{
		$viewdata = array(
			"categories" => buildMatrix($this->_Airdrop->get_all_nodes_by_node(1), 'parent_id', 'node_id', 1),
			"page" => null,
			"pathimgpage" => PATH_IMG_PAGINA,
			"categories_cp" => null,
			"pagination" => null,
			"products" => null,
			"products_opt_values" => null,
			"filters" => null,
			"uriseg" => base_url(). 'catalog_produse/categorie/' . $slug,
			"filter_state" => false,
			"node" => null,
			"produse_noi" => $this->_Airdrop->get_products_by_state_rand_and_limit('atom_newproduct', 5),
			"breadcrumb" => array()
		);
		
		$products_opt_values = new stdClass();
		
		$products_opt_values->min_price = null;
		$products_opt_values->max_price = null;
		$products_opt_values->sizes = null;
		$products_opt_values->colors = null;
		
		
		$filters = new stdClass();
		
		$filters->page       = 1;
		$filters->perpage    = 8;
		
		$filters->order_by   = null;
		
		if(!empty($this->input->get('page')))
		{
			$filters->page = $this->input->get('page');
			$viewdata["filter_state"] = true;
			
		}		
		
		if(!empty($this->input->get('perpage')))
		{
			$filters->perpage = $this->input->get('perpage');
			$viewdata["filter_state"] = true;
			
		}
		
		if(!empty($this->input->get('order_by')))
		{
			$filters->order_by = '"' . $this->input->get('order_by') . '"';
			$viewdata["filter_state"] = true;			
		}


		$viewdata["filters"] = $filters;
		
		
		$slug = str_replace(' ', '', strtolower(trim($slug)));
		
		$node = $this->_Airdrop->get_node_by_slug($slug);
		
		if($node)
		{
			$viewdata["node"] = $node;
			if($get_categories = $this->_Airdrop->get_all_nodes_and_images_by_node((int)$node->node_id))
			{
				
				$viewdata["categories_cp"] = buildMatrix($get_categories, 'parent_id', 'node_id', $node->node_id);
			}
			
			$viewdata["breadcrumb"][] = array('text' => 'Acasa', 'href' => '/');
			$viewdata["breadcrumb"][] = array('text' => 'Catalog produse', 'href' => '/catalog_produse');
			$viewdata["breadcrumb"][] = array('text' => $node->denumire_ro, 'href' => '/catalog_produse/categorie/' . $node->slug);
			
			if($products = $this->_Airdrop->get_products('catalog_produse', $node->slug, $filters))
			{
				$viewdata["products"] = $products;
				$viewdata["filter_state"] = true;
				
				$total_rows = $this->_Airdrop->get_number_of_rows_found()->rowsfound;
				
				$url_string = base_url() . $this->uri->uri_string . '?';
				
				foreach($filters as $key_filter => $val_filter)
				{
					if($key_filter == "page") continue;
					else
					{
						if(!is_null($val_filter))
						{
							$repl_value = str_replace('"', '', $val_filter);
							$url_string .= '&' . $key_filter . '=' .$repl_value;
						}
					}
				}
				$url_string = str_replace("?&", '?', $url_string);
				
				$config = array();

				$config["base_url"] = $url_string;
				$config["total_rows"] = $total_rows;
				$config["per_page"] = $filters->perpage;
				$config['use_page_numbers'] = TRUE;
				$config['num_links'] = $total_rows;
				// $config[‘prefix’] = ''
				$config['page_query_string'] = true;
				$config['query_string_segment'] = 'page';
				//
				$config['first_link'] = '&laquo; First';
				$config['first_tag_open'] = '<li class="prev page">';
				$config['first_tag_close'] = '</li>' . "\n";
				$config['last_link'] = 'Last &raquo;';
				$config['last_tag_open'] = '<li class="next page">';
				$config['last_tag_close'] = '</li>' . "\n";
				$config['next_link'] = '<i class="fa fa-angle-right"></i>';
				$config['next_tag_open'] = '<li class="next page">';
				$config['next_tag_close'] = '</li>' . "\n";
				$config['prev_link'] = '<i class="fa fa-angle-left"></i>';
				$config['prev_tag_open'] = '<li class="prev page">';
				$config['prev_tag_close'] = '</li>' . "\n";
				$config['cur_tag_open'] = '<li class="active"><a href="">';
				$config['cur_tag_close'] = '</a></li>';
				$config['num_tag_open'] = '<li class="page">';
				$config['num_tag_close'] = '</li>' . "\n";

				$this->pagination->initialize($config);

				$viewdata["pagination"] = $this->pagination->create_links();
			}
		}

		
		// if($bloc_product_home = $this->_Airdrop->get_airdrops_and_images_by_air_controller_and_node_slug('catalog_produse', 'produse-prima-pagina-acasa'))
	
		$page = $this->_Pagini->GetPage("catalog_produse");//getpage
		if($page) $viewdata["page"] = $page;

		
		$view = (object) [ 'html' => array
			(
				0 => (object) ["viewhtml" => "blocuri_html/bloc_banner_page", "viewdata" => $viewdata],
				1 => (object) ["viewhtml" => "catalog_produse/start", "viewdata" => null],
				2 => (object) ["viewhtml" => "catalog_produse/left-panel", "viewdata" => null],
				3 => (object) ["viewhtml" => "pagini/" .$page->s->filehtml, "viewdata" => null],
				4 => (object) ["viewhtml" => "catalog_produse/end", "viewdata" => null],
			), 'javascript' => array
			(
				2 => (object) ["viewhtml" => "catalog_produse/left-panel_js", "viewdata" => null]
			)			
		];
		
		$this->frontend->body_class = 'home-two shop-main sidebar';
		$this->frontend->menu_class = 'col-lg-12';
		$this->frontend->slider = false;
		$this->frontend->render($view,
			array(
				"title_browser_ro" => (!is_null($node->title_browser_ro) ? $node->title_browser_ro : $page->p->title_browser_ro),
				"meta_description" => (!is_null($node->meta_description) ? $node->meta_description : $page->p->meta_description),
				"keywords" => (!is_null($node->keywords) ? $node->keywords : $page->p->keywords)
			)
		);
	}
	
	public function produs($slug)
	{
		$viewdata = array(
			"page" => null,
			"product" => null,
			"category" => null,
			"products_similar" => null,
			"breadcrumb" => array(),
			// "branduri" => null,
			"cerere_error" => null,
			"cerere_success" => null
		);
		
		$slug = str_replace(' ', '', strtolower(trim($slug)));
		
		if(!$product = $this->_Airdrop->get_product_by_slug($slug))
		{
			redirect(base_url() . 'catalog_produse');
			
		}
		else
		{
			$viewdata["product"] = $product;
			
			$viewdata["category"] = $this->_Airdrop->get_product_category($product->atom_id, $product->air_id);
			
			if($viewdata["category"]) {
				if($products_similar = $this->_Airdrop->get_products_similar($viewdata["category"]->node_id, $product->atom_id))
				{
					$viewdata["products_similar"] = $products_similar;
				}
			}

			$viewdata["breadcrumb"][] = array('text' => 'Acasa', 'href' => '/');
			$viewdata["breadcrumb"][] = array('text' => 'Catalog produse', 'href' => '/catalog_produse');
			if($viewdata["category"]) {
				$viewdata["breadcrumb"][] = array('text' => $viewdata["category"]->denumire_ro, 'href' => '/catalog_produse/categorie/' . $viewdata["category"]->slug);
			}
			$viewdata["breadcrumb"][] = array('text' => $viewdata["product"]->atom_name_ro, 'href' => '/catalog_produse/produs/' . $viewdata["product"]->slug);
			
			//brands
			if($brands = $this->_Airdrop->get_airdrops_and_images_by_air_controller_and_node_slug('branduri', 'branduri'))
			{
				$viewdata["branduri"] = $brands;
			}

		}

		$page = $this->_Pagini->GetPage("pagina_produs");//getpage
		if($page) $viewdata["page"] = $page;

		if(isset($_REQUEST["cerere-nume"])) {
			
			$cerere = array(
				'atom_id' => $this->input->post('atom_id'),
				'nume' => $this->input->post('cerere-nume'),
				'telefon' => $this->input->post('cerere-telefon'),
				'email' => $this->input->post('cerere-email'),
				'mesaj' => $this->input->post('cerere-mesaj'),
				"date" => date("Y-m-d H:i:s")
			);
			
			
			if(!empty($this->input->post("captcha"))) $captcha = $this->input->post("captcha");
			if(!empty($this->input->post("captchaHash"))) $captchahash = $this->input->post("captchaHash");
			if(!isset($captcha) || !isset($captchahash) || $captchahash != rpHash($captcha)) 
			{
				$viewdata["cerere_error"] = "Cererea ta nu a fost inregistrata, te rugam sa incerci din nou.";
			} else {
				$error = false;
				foreach($cerere as $cerere_row)
				{
					if(empty($cerere_row))
					{
						$error = true;
						$viewdata["cerere_error"] = "Cererea ta nu a fost inregistrata, te rugam sa incerci din nou.";
						break;
					}
				}
				
				if(!$error)
				{
					$this->_Item->msqlInsert('catalog_produse_cereri', $cerere);
					$viewdata["cerere_success"] = "Cererea ta a fost inregistrata!";
					
					if(!empty($this->frontend->user_name->email))
					{
					  $this->_Sendemail->trimitemesajcerereprodus($this->frontend->user_name->email);
					}
				}
				
			}
			
		}
		
		$view = (object) [ 'html' => array
			(
				0 => (object) ["viewhtml" => "blocuri_html/bloc_banner_page", "viewdata" => $viewdata],
				1 => (object) ["viewhtml" => "pagini/" .$page->s->filehtml, "viewdata" => null],
				// 2 => (object) ["viewhtml" => "blocuri_html/branduri", "viewdata" => null],
			), 'javascript' => array
			(
				1 => (object) ["viewhtml" => "pagini/" .$page->s->filejs, "viewdata" => null],
			)
		];
		
		$this->frontend->slider = false;
		$this->frontend->body_class = 'home-two shop-main sidebar';
		$this->frontend->menu_class = 'col-lg-12';
		$this->frontend->render($view,
			array(
				"title_browser_ro" => (!is_null($product->title_browser_ro) ? $product->title_browser_ro : $page->p->title_browser_ro),
				"meta_description" => (!is_null($product->meta_description) ? $product->meta_description : $page->p->meta_description),
				"keywords" => (!is_null($product->meta_keywords) ? $product->meta_keywords : $page->p->keywords)
			)
		);
	}
	
	/**
	 * [Cauta]
	 * @return [type] [description]
	 */
	public function cauta()
	{
		$key_search = (!empty($this->input->get('produse')) ? urldecode($this->input->get('produse')) : null);
		
		$viewdata = array("key_search" => null, "products" => null, "categories" => buildMatrix($this->_Airdrop->get_all_nodes_by_node(1), 'parent_id', 'node_id', 1),"categories_cp" => null, "produse_noi" => $this->_Airdrop->get_products_by_state_rand_and_limit('atom_newproduct', 5), "breadcrumb" => array());
		
		$viewdata["key_search"] = $key_search;
		
		$viewdata["breadcrumb"][] = array('text' => 'Acasa', 'href' => '/');
		$viewdata["breadcrumb"][] = array('text' => 'Catalog produse', 'href' => '/catalog_produse');
		
		if(!is_null($key_search) && strlen($key_search) > 2)
		{
			$products = $this->_Airdrop->get_products_by_search($key_search);
			if($products)
			{
				$viewdata["products"] = $products;
			}			
		}


		$page = $this->_Pagini->GetPage("cauta_produse");//getpage
		if($page) $viewdata["page"] = $page;


		$view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "blocuri_html/bloc_banner_page", "viewdata" => $viewdata],
			1 => (object) ["viewhtml" => "catalog_produse/start", "viewdata" => null],
			2 => (object) ["viewhtml" => "catalog_produse/left-panel", "viewdata" => null],
			3 => (object) ["viewhtml" => "catalog_produse/cauta_produse", "viewdata" => null],
			4 => (object) ["viewhtml" => "catalog_produse/end", "viewdata" => null],
			  ), 'javascript' => array(
			  0 => (object) ["viewhtml" => "catalog_produse/cauta_produse_js", "viewdata" => null],
			  )
			];
		
		$this->frontend->body_class = 'shop-main sidebar';
		$this->frontend->slider = false;
		$this->frontend->render($view,
			array(
				"title_browser_ro" => $page->p->title_browser_ro,
				"meta_description" => $page->p->meta_description,
				"keywords" => $page->p->keywords
			)
		);
	}	
}
