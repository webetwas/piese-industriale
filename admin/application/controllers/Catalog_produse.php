<?php
defined('BASEPATH') OR exit('No direct script access allowed');


ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

class Catalog_produse extends CI_Controller
{
	private $Air;
	
	private $controller;
	private $controller_ajax;
	private $uriseg;

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code

		$this->controller = $this->router->fetch_class();
		$this->controller_ajax = $this->controller. "/ajax";
		$this->uriseg = json_decode(json_encode($this->uri->uri_to_assoc(2)));

		if(!$this->user->id) redirect("login");

		$this->load->model("Item_model", "_Item");
		$this->load->model('Pagini_model', '_Pagini');// model/_Pagini
		// $this->load->model("Upload_model", "_Upload");// model/_Upload
		$this->load->model("Slug_model", "_Slug");
		$this->load->model("Nodes_model", "_Nodes");
		$this->load->model("Imager_model", "_Imager");
		
		$this->Air = $this->_Nodes->get_air_data_by_air_controller(strtolower($this->controller));
		
		if(!$this->Air) exit("Couldn't find The Air..");		
		
		$this->load->helper('matrix');
	}
	
	public function index()
	{
		
		$viewdata = array
		(
			"air" => $this->Air,
			"nodes" => null,
			"controller" => $this->controller,
			"controller_ajax" => $this->controller_ajax,
			"uri" => $this->uriseg,
			"atoms_missing_airdrop_or_node" => null
		);
		
		// Nodes
		if($nodes = $this->_Nodes->get_all_nodes_by_node((int)$this->Air->targeted_node_id))
		{
			$build_nodes_airs_airdrops = $this->_Nodes->build_nodes_airs_airdrops($nodes);
			
			$viewdata["nodes"] = buildMatrix($build_nodes_airs_airdrops, 'parent_id', 'node_id', (int)$this->Air->targeted_node_id);
			
		}
		
		if($atoms_missing_airdrop_or_node = $this->_Nodes->fetch_atoms_miss_airdrop_or_root_node($this->Air->air_table, (int)$this->Air->air_id, (int)$this->Air->targeted_node_id))
		{
			$viewdata["atoms_missing_airdrop_or_node"] = $atoms_missing_airdrop_or_node;
		}
		
		//breacrumb
		$breadcrumb = array("bb_titlu" => $this->Air->air_name, "bb_button" => null, "breadcrumb" => array());
		
		$breadcrumb["breadcrumb"][0] = array("text" => "Administrare", "url" => '');
		$breadcrumb["breadcrumb"][1] = array("text" => $this->Air->air_identplural, "url" => null);
		$view = (object) [ 'html' => array
			(
				0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
				1 => (object) ["viewhtml" => "catalog_produse/index", "viewdata" => $viewdata]
			), 'javascript' => array
			(
				1 => (object) ["viewhtml" => "catalog_produse/js_index", "viewdata" => null],
			)
		];
		$this->frontend->render($view);		
	}
	
	public function categorii_speciale()
	{
		
		$viewdata = array
		(
			"air" => $this->Air,
			"nodes" => null,
			"controller" => $this->controller,
			"controller_ajax" => $this->controller_ajax,
			"uri" => $this->uriseg
		);
		
		// Nodes
		if($nodes = $this->_Nodes->get_all_nodes_by_node((int)$this->Air->targeted_special_node_id))
		{
			$build_nodes_airs_airdrops = $this->_Nodes->build_nodes_airs_airdrops($nodes);
			
			$viewdata["nodes"] = buildMatrix($build_nodes_airs_airdrops, 'parent_id', 'node_id', (int)$this->Air->targeted_special_node_id);
			
		}
		
		//breacrumb
		$breadcrumb = array("bb_titlu" => $this->Air->air_name . ' - Categorii speciale', "bb_button" => null, "breadcrumb" => array());
		
		$breadcrumb["breadcrumb"][0] = array("text" => "Administrare", "url" => '');
		$breadcrumb["breadcrumb"][1] = array("text" => $this->Air->air_identplural, "url" => null);
		$view = (object) [ 'html' => array
			(
				0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
				1 => (object) ["viewhtml" => "catalog_produse_categorii_speciale/index", "viewdata" => $viewdata]
			), 'javascript' => array
			(
				1 => (object) ["viewhtml" => "catalog_produse_categorii_speciale/js_index", "viewdata" => null],
			)
		];
		$this->frontend->render($view);		
	}
	
	/**
	 * Item
	 */
	public function item()
	{
		
		$viewdata = array
		(
			"air" => $this->Air,
			"controller" => $this->controller,
			"controller_ajax" => $this->Air->air_controller. "/ajax/",
			"item" => null,
			"airdrop" => null,
			"nodes" => null,
			"uri" => null,
			"form" => (object) [],
			"imgpathitem" => null,
			"imager" => null
		);
		
		$imager_return = false;
		$imager_sizes = $this->_Imager->get_images_sizes(57, $imager_return);
		if($imager_return)
		{
			$viewdata["imager"] = $imager_sizes;
		}
		
		$viewdata["uri"] = $this->uriseg;
		$viewdata["imgpathitem"] = SITE_URL.PATH_IMG_CATALOG_PRODUSE."m/";
		// var_dump($this->uriseg);
	
		// FORM - Item
		$viewdata["form"]->item = (object) [
			"name" => "item",
			"prefix" => "it",
			"segments" => $this->Air->air_controller. "/item/" .$this->uriseg->item
			. ($this->uriseg->item == "u" && isset($this->uriseg->id) && !is_null($this->uriseg->id) ? "/id/" .trim(intval($this->uriseg->id)) : "")
			.(isset($this->uriseg->air_id) && isset($this->uriseg->node_id) ? '/air_id/' .$this->uriseg->air_id . '/node_id/' . $this->uriseg->node_id : '')
		];
		$form_submititem = $viewdata["form"]->item->prefix. "submit";//submit<button>	
		
		switch($this->uriseg->item)
		{
			case UPDATE:
				if(isset($this->uriseg->id) && !is_null($this->uriseg->id))
				{
					$get_item = $this->_Item->msqlGet('catalog_produse', array('atom_id' => trim(intval($this->uriseg->id))));
					
					$temp_nodes = array();
					// Nodes
					if(!is_null($this->Air->targeted_nodes))
					{
						// fetching all Nodes by conditions - each id each node
						if($get_all_nodes_by_conditions = $this->_Nodes->get_all_nodes_by_conditions(json_decode($this->Air->targeted_nodes)))
						{
							// $temp_nodes += $get_all_nodes_by_conditions;
							$temp_nodes = array_merge($temp_nodes, $get_all_nodes_by_conditions);
						}
						
					}
					if(!is_null($this->Air->targeted_node_id))
					{
						// fetching all Nodes by the Root specified(taken all his childrens)
						if($get_all_nodes_by_node = $this->_Nodes->get_all_nodes_by_node($this->Air->targeted_node_id))
						{
							// $temp_nodes += $get_all_nodes_by_node;
							$temp_nodes = array_merge($temp_nodes, $get_all_nodes_by_node);
						}
					}
					
					if(!is_null($this->Air->targeted_special_node_id))
					{
						// fetching all Nodes by the Root specified(taken all his childrens)
						if($get_all_nodes_by_node = $this->_Nodes->get_all_nodes_by_node($this->Air->targeted_special_node_id))
						{
							// $temp_nodes += $get_all_nodes_by_node;
							$temp_nodes = array_merge($temp_nodes, $get_all_nodes_by_node);
						}
					}					
					
					if(!empty($temp_nodes))
					{
						foreach($temp_nodes as $tnk => $tn)
						{
							
							$first_node = $this->_Nodes->getFirstNode($tn["node_id"]);
							if($first_node)
								$temp_nodes[$tnk]["denumire_ro"] = $first_node->denumire_ro . ' > ' . $temp_nodes[$tnk]["denumire_ro"];
						}
						
						$viewdata["nodes"] = $temp_nodes;
					}
					
					// Atom
					if($item = $this->_Item->msqlGet($this->Air->air_table, array("atom_id" => trim(intval($this->uriseg->id)))))
					{
						$item->i = $this->_Item->msqlGetAll($this->Air->air_table_img, array("id_item" => $item->atom_id), 'order');
						$viewdata["item"] = $item;
					}


					// Airdrop
					if($airdrop = $this->_Nodes->airdrop_get_all_nodes_ids_assoc_by_atom($this->Air->air_id, $viewdata["item"]->atom_id))
					{
						$viewdata["airdrop"] = $airdrop;
					}
					// var_dump($viewdata["airdrop"]);die();
					
					/* form @item */
					if(isset($_REQUEST["{$form_submititem}"]))
					{
						
						$slug = $this->_Slug->slug_it('catalog_produse', $this->input->post("{$viewdata["form"]->item->prefix}atom_name_ro"), $item->slug);
						
						$pret = false;
						$pret_nou = true;
						
						$pret = number_format($this->input->post("{$viewdata["form"]->item->prefix}pret"), 2, '.', '');
						if(!empty($this->input->post("{$viewdata["form"]->item->prefix}pret_nou")))
						{
							$pret_nou = number_format($this->input->post("{$viewdata["form"]->item->prefix}pret_nou"), 2, '.', '');
						}						
						
						$newDBPattern = (object) [ // Design Database Pattern
							"table" => $this->Air->air_table,
							"database" => UPDATE,
							"type" => GET,
							"design" => array(
								"atom_isactive" => false,
								"atom_instock" => false,
								"atom_newproduct" => false,
								"atom_recomanded" => false,
								"atom_special" => false,
								"atom_name_ro" => ucfirst($this->input->post("{$viewdata["form"]->item->prefix}atom_name_ro")),
								"atom_name_en" => ucfirst($this->input->post("{$viewdata["form"]->item->prefix}atom_name_en")),
								"slug" => $slug,
								"pret" => $pret,
								"pret_nou" => $pret_nou,
								"meta_description" => true,
							)
						]; 
						$update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern, array("c" => "atom_id", "v" => trim(intval($this->uriseg->id))));// update@Item
						
						// input @fisa_tehnica_pdf
						if(!empty($_FILES['fisa_tehnica_pdf']['name']))
						{
							$update_pdf = true;
							$pdfname = substr(uniqid(microtime()), 2, 8) . '.pdf'; // pdf file encrypt name here which need to save
							move_uploaded_file($_FILES['fisa_tehnica_pdf']['tmp_name'], '../web/public/upload/pdf/' . $pdfname);
							
							$this->_Item->msqlUpdate('catalog_produse', array("fisa_tehnica_pdf" => $pdfname), array("c" => "atom_id", "v" => trim(intval($this->uriseg->id))));
							
							if(isset($get_item->fisa_tehnica_pdf) && !is_null($get_item->fisa_tehnica_pdf))
							{
								if(file_exists('../web/public/upload/pdf/' . $get_item->fisa_tehnica_pdf))
								{
									unlink('../web/public/upload/pdf/' . $get_item->fisa_tehnica_pdf);
								}
							}
						}
						
						if($update || isset($update_pdf)) $this->_Session->setFB_Pozitive(array("ref" => $item->atom_name, "text" => "Produsul a fost actualizat!"));
						redirect($viewdata["form"]->item->segments);

					}
				}
				break;

			case INSERT:
				/* form @item */
				$redirect = $this->Air->air_controller;
				if(isset($_REQUEST["{$form_submititem}"]))
				{
					
					$slug = $this->_Slug->slug_it('catalog_produse', $this->input->post("{$viewdata["form"]->item->prefix}atom_name"));
						
					$newDBPattern = (object) [ // Design Database Pattern
						"table" => $this->Air->air_table,
						"database" => INSERT,
						"type" => PUT,
						"design" => array(
							"atom_name_ro" => true,
							"slug" => $slug,
							"pret" => true,
							"pret_nou" => true,
							"air_id" => $this->uriseg->air_id
						)
					]; 
					$insert = $this->_Item->INSItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern);// insert@Item
					
					if($insert) {
						
						$data = new stdClass();
						$data->air_id  = (int)$this->uriseg->air_id;
						$data->atom_id = (int)$insert;
						$data->node_id = (int)$this->uriseg->node_id;
						if(!is_null($this->Air->targeted_node_id))
						{
							// set the @node_id_root for the Airdrop as @targeted_node_id Air
							$data->node_id_root = (int)$this->Air->targeted_node_id;
						}
					
						$this->_Nodes->airdrop_add_airdrop($data);
						
						$this->_Session->setFB_Pozitive(array("ref" => "Catalog produse", "text" => "Redacteaza informatiile produsului.."));
						$redirect = $this->Air->air_controller. "/item/u/id/". $insert; 
					}
					redirect($redirect);
				}
				break;
				
			case DELETE:
				if(isset($this->uriseg->id) && !is_null($this->uriseg->id))
				{
					$data = new stdClass();
					
					$data->air_id = (int)$this->Air->air_id;
					$data->atom_id = (int)trim($this->uriseg->id);
		
					$this->_Nodes->airdrop_rem_airdrops($data);
					$this->_Item->msqlDelete($this->Air->air_table, array("atom_id" => $data->atom_id));
					$this->_Session->setFB_Pozitive(array("ref" => "Catalog produse", "text" => "Ai sters un produs.."));
					redirect($this->Air->air_controller);
				}
				break;
	   }
	
		
		//breacrumb
		$breadcrumb = array("bb_titlu" => $this->Air->air_identplural, "bb_button" => null, "breadcrumb" => array());
		
		$breadcrumb["breadcrumb"][0] = array("text" => $this->Air->air_identplural, "url" => $this->Air->air_controller);
		$breadcrumb["breadcrumb"][1] = array("text" => (!is_null($viewdata["item"]) ? $viewdata["item"]->atom_name_ro : 'Adauga produs'), "url" => null);
		$view = (object) [ 'html' => array
			(
				0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
				1 => (object) ["viewhtml" => "catalog_produse/item", "viewdata" => $viewdata]
			), 'javascript' => array(
				1 => (object) ["viewhtml" => "catalog_produse/js_item", "viewdata" => null],
				2 => (object) ["viewhtml" => "catalog_produse/js_improved_item", "viewdata" => null]
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
				
				case UPLOADIMG:
					$res = array("status" => 0, "id" => null);
					$inputfile = "inpfile";
					$filetarget = trim($this->input->post("filetarget"));//@banner@poza
					$fileref = trim($this->input->post("fileref"));//@banner1@banner2
					
					$pagestruct = $this->_Pagini->getStructure("array", 57);//getpagestructure
					$locations = (object) ["table" => null, "path" => null];
					$imaginaryfolder = null;//usetrueformultiplefiles[s,m,l]
					$filesdata = null;
					$insertdata = null;
					switch($this->input->post("filetarget"))
					{
						case UPIMGPOZA:
							$locations->table = $this->Air->air_table_img;
							$locations->path = '../web/' .PATH_IMG_CATALOG_PRODUSE;
							$imaginaryfolder = array("s" => true, "m" => true, "l" => true);
							
							$filesdata = array(
								"s" => array("w" => null, "h" => null, "p" => null),
								"m" => array("w" => null, "h" => null, "p" => null),
								"l" => array("w" => null, "h" => null, "p" => null)
							);
							foreach($filesdata as $kd => $d) {
								foreach($d as $kdd => $dd) {
									$db_format = "image_" .$kd.$kdd;//databasecolumn
									$filesdata[$kd][$kdd] = !is_null($pagestruct[$db_format]) ? $pagestruct[$db_format] : json_decode(constant("IMG_SIZE_" .strtoupper($kd)), true)[$kdd];
									
									if($kdd == "p")
										$filesdata[$kd][$kdd] = $pagestruct[$db_format] == "1" ? true : json_decode(constant("IMG_SIZE_" .strtoupper($kd)), true)[$kdd];
								}
							}
						break;
					}
					if(!is_null($filesdata)) {
						$upimgs = $this->_Upload->uploadImage($locations->path, $filesdata, $imaginaryfolder);//uploadimages
						if($upimgs["img"]) {
							$res["status"] = 1;
							$res["img"] = $upimgs["img"];
							
							$insertdata = array("id_item" => trim(intval($this->uriseg->id)), "img" => $upimgs["img"], "img_ref" => $fileref);
							if(!is_null($imaginaryfolder))
								foreach($imaginaryfolder as $kifolder => $ifolder) $insertdata[$kifolder] = $ifolder;//pushimaginaryfoldertoinsertdata
							
							$insertitem = $this->_Item->msqlInsert($locations->table, $insertdata);
							if($insertitem) $res["id"] = $insertitem;
						}
					}
					echo json_encode($res);
				break;

				case DELETE:
					$res = array("status" => 0);

					$fileid = trim($this->input->post("fileid"));
					$fileref = trim($this->input->post("fileref"));// reference could be "banner1" for "banner"
					
					$locations = (object) ["table" => null, "path" => null];
					$imaginaryfolder = null;//usetrueformultiplefiles[s,m,l]
					
					//remove Poza
					if(strstr($fileref, "poza")) {
						$locations->path = '../web/' .PATH_IMG_CATALOG_PRODUSE;
						$locations->table = $this->Air->air_table_img;
						$imaginaryfolder = array("s" => true, "m" => true, "l" => true);
					}
					
					$deleteitem = $this->_Item->RetrieveAndRemove($locations->table, array("id" => intval(trim($fileid)), "id_item" => intval(trim($this->uriseg->id))));
					if($deleteitem) {
						deletefile('../web/' .$locations->path, $deleteitem->img, $imaginaryfolder);

						$res["status"] = 1;
					}					
					echo json_encode($res);
				break;
				
				
			case PRODUCT_STATE:
				$data = new stdClass();
				$data->atom_id = (int)trim($this->uriseg->id);
				$data->product_state = trim($this->uriseg->product_state);
				
				$questiontruefalse = $this->_Item->QuestionTrueFalse($this->Air->air_table, $data->product_state, $data->atom_id);

				echo json_encode($questiontruefalse);
				break;
			}
		else show_404();
  }
}