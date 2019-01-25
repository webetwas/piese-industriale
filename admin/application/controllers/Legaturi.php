<?php
defined('BASEPATH') OR exit('No direct script access allowed');


ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

class Legaturi extends CI_Controller
{
	private $Air_prototype;
	private $Air = null;
	private $Prototype;
	
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
		$this->load->model("Slug_model", "_Slug");
		$this->load->model("Nodes_model", "_Nodes");
		$this->load->model('Pagini_model', '_Pagini');// model/_Pagini
		// $this->load->model("Upload_model", "_Upload");// model/_Upload
		$this->load->model("Imager_model", "_Imager");
		
		$this->Prototype = new stdClass();
		$this->Air_prototype = $this->_Nodes->get_air_data_by_air_controller(strtolower($this->controller));
		$this->initialize_prototype();
		
		if(!$this->Air_prototype) exit("Couldn't find The Air..");
		
		$this->load->helper('matrix');
	}
	
	public function index()
	{
		
		$viewdata = array
		(
			"nodes" => null,
			"controller" => $this->controller,
			"controller_ajax" => $this->controller_ajax,
			"uri" => $this->uriseg
		);
		
		// Nodes
		if($nodes = $this->_Nodes->get_all_nodes())
		{
			$build_nodes_airs_airdrops = $this->_Nodes->build_nodes_airs_airdrops($nodes);
			
			$viewdata["nodes"] = buildMatrix($build_nodes_airs_airdrops, 'parent_id', 'node_id');
		}
		
		//breacrumb
		$breadcrumb = array("bb_titlu" => "Legaturi", "bb_button" => null, "breadcrumb" => array());
		$breadcrumb["bb_button"] = array("text" => '<i class="fa fa-plus-square"></i> Legatura noua', "linkhref" => "legaturi/item/i");
		
		
		$breadcrumb["breadcrumb"][0] = array("text" => "Administrare", "url" => '');
		$breadcrumb["breadcrumb"][1] = array("text" => "Legaturi", "url" => null);
		$view = (object) [ 'html' => array
			(
				0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
				1 => (object) ["viewhtml" => "legaturi/index", "viewdata" => $viewdata]
			), 'javascript' => array
			(
				1 => (object) ["viewhtml" => "legaturi/js_index", "viewdata" => null],
			)
		];
		$this->frontend->render($view);		
	}
	
	private function initialize_prototype()
	{
		$this->Prototype->air_controller  = $this->Air_prototype->air_controller;
		$this->Prototype->air_name        = $this->Air_prototype->air_name;
		$this->Prototype->air_ident       = $this->Air_prototype->air_ident;
		$this->Prototype->air_identplural = $this->Air_prototype->air_identplural;		
		$this->Prototype->air_identnewitem = $this->Air_prototype->air_identnewitem;		
	}
	
	private function initialize_air($air_id)
	{
		$this->Air = $this->_Nodes->get_air_data_by_air_id($air_id);
		
		$this->Prototype->air_controller  = $this->Air->air_controller;
		$this->Prototype->air_name        = $this->Air->air_name;
		$this->Prototype->air_ident       = $this->Air->air_ident;
		$this->Prototype->air_identplural = $this->Air->air_identplural;
		$this->Prototype->air_identnewitem = $this->Air->air_identnewitem;
	}
	
	public function item()
	{
		if(isset($this->uriseg->air_id) && !is_null($this->uriseg->air_id))
		{
			$this->initialize_air((int)$this->uriseg->air_id);
		}
		
		$viewdata = array
		(
			"Prototype" => $this->Prototype,
			"Air" => $this->Air,
			"controller" => $this->controller,
			"id_item" => null,
			"item" => null,
			"parent" => null,
			"uri" => $this->uriseg,
			"imgpathitem" => SITE_URL.PATH_IMG_NODES."m/",
			"controller_ajax" => $this->Air_prototype->air_controller. "/ajax/",
			"form" => new stdClass(),
			"imager" => null
		);
		
		if(isset($this->uriseg->ext) && $this->uriseg->ext == "categorii_speciale")
		{
			$imager_page = 56;
		} else {
			$imager_page = 57;
		}		
		
		$imager_return = false;
		$imager_sizes = $this->_Imager->get_images_sizes($imager_page, $imager_return);
		if($imager_return)
		{
			$viewdata["imager"] = $imager_sizes;
		}		
		
		if(isset($this->uriseg->id) && !is_null($this->uriseg->id))
		{
			$viewdata["id_item"] = (int)trim($this->uriseg->id);
		}
		
		$viewdata["form"]->item = (object)
		[
			"name" => "item",
			"prefix" => "it",
			"segments" => $this->controller . "/item/" . $this->uriseg->item
		];
		if(!is_null($this->Air))
		{
			$viewdata["form"]->item->segments .= '/air_id/' . $this->Air->air_id;
		}
		$form_submit_item = $viewdata["form"]->item->prefix . 'submit';
		
		// FORM - Meta
		$viewdata["form"]->meta = (object)
		[
			"name" => "meta",
			"prefix" => "mt",
			"segments" =>
			$this->controller. "/item/" .$this->uriseg->item
		];
		if(!is_null($this->Air))
		{
			$viewdata["form"]->meta->segments .= '/air_id/' . $this->Air->air_id;
		}
		$form_submit_meta = $viewdata["form"]->meta->prefix. "submit";//submit<button>
		
		
		// var_dump($viewdata);
		
		switch($this->uriseg->item)
		{
			//
			case UPDATE:
				$viewdata["form"]->item->segments .= "/id/" .$this->uriseg->id;//create2ndsegment
				$viewdata["form"]->meta->segments .= "/id/" .$this->uriseg->id;//create2ndsegment
				
				if($item = $this->_Item->msqlGet($this->Air_prototype->air_table, array("node_id" => trim(intval($this->uriseg->id)))))
				{
					$item->i = $this->_Item->msqlGetAll($this->Air_prototype->air_table_img, array("id_item" => $item->node_id));
					if($item) $viewdata["item"] = $item;
				} else {
					redirect($this->Prototype->air_controller);
				}
				
				/* form @item */
				if(isset($_REQUEST["{$form_submit_item}"]))
				{
				
					$slug = $this->_Slug->slug_it('nodes', $this->input->post("{$viewdata["form"]->item->prefix}denumire_ro"), $item->slug);
					
					$newDBPattern = (object) [ // Design Database Pattern
						"table" => $this->Air_prototype->air_table,
						"database" => UPDATE,
						"type" => PUT,
						"design" => array(
							"denumire_ro" => true,
							"denumire_en" => true,
							"i_titlu_ro" => true,
							"i_titlu_en" => true,
							"i_subtitlu_ro" => true,
							"i_subtitlu_en" => true,
							"slug" => $slug
						)
					]; $update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern, array("c" => "node_id", "v" => trim(intval($this->uriseg->id))));// update@Item
					if($update) $this->_Session->setFB_Pozitive(array("ref" => $this->Prototype->air_identplural, "text" => "Modificarile tale au fost salvate!"));
					redirect($viewdata["form"]->item->segments);
				
				/* form @meta */
				} elseif(isset($_REQUEST["{$form_submit_meta}"])) {
					
					$newDBPattern = (object) [ // Design Database Pattern
						"table" => $this->Air_prototype->air_table,
						"database" => UPDATE,
						"type" => PUT,
						"design" => array(
							"title_browser_ro" => true,
							"meta_description" => true,
							"keywords" => true
						)
					]; $update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->meta->prefix, $newDBPattern, array("c" => "node_id", "v" => trim(intval($this->uriseg->id))));// update@Meta
					if($update) $this->_Session->setFB_Pozitive(array("ref" => "Metadate " . $this->Prototype->air_ident, "text" => "Modificarile tale au fost salvate!"));
					redirect($viewdata["form"]->item->segments);
				}
				
				break;
			//
			case INSERT:
				$parent_id = 0;
				if(isset($this->uriseg->parent_id) && !is_null($this->uriseg->parent_id))
				{
					$parent_id = (int)trim($this->uriseg->parent_id);
				  
					$viewdata["form"]->item->segments .= "/parent_id/" .$parent_id;//create2ndsegment
					
					$parent = $this->_Nodes->get_node($parent_id);//fetchparent
					if($parent) $viewdata["parent"] = $parent;          
				}
				
				if(isset($_REQUEST["{$form_submit_item}"]))
				{
					if(empty($this->input->post("{$viewdata["form"]->item->prefix}denumire_ro")))
					{
						redirect($this->controller);
					}
					
					else
					{
						$slug = $this->_Slug->slug_it('nodes', $this->input->post("{$viewdata["form"]->item->prefix}denumire_ro"));
						
						// var_dump($viewdata);
						
						// $admin_editable = false;
						// $admin_deletable = false;
						// $god_deletable = false;

						// if(!is_null($viewdata["id_object"])) {
						// $admin_editable = 1;
						// $admin_deletable = 1;
						// $god_deletable = 1;
						// }

						$newDBPattern = (object)
						[
							"table" => 'nodes',
							"database" => INSERT,
							"type" => PUT,
							"design" => array
							(
								"denumire_ro" => true,
								"parent_id" => $parent_id,
								"slug" => $slug
								// "admin_editable" => $admin_editable,
								// "admin_deletable" => $admin_deletable,
								// "god_deletable" => $god_deletable
							)
						];
						$insert = $this->_Item->INSItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern);// insert@Item						
						if($insert)
						{
							$this->_Session->setFB_Pozitive(array("ref" => "Continua redactarea..", "text" => "Succes!"));
							
							$this->_Nodes->nodes_add_node($insert, $parent_id);
							
							
							redirect($this->controller. "/item/u" .(!is_null($this->Air) ? '/air_id/' . $this->Air->air_id : ''). "/id/" .$insert);
						}
						

					}
				
				}
				break;
				
			//
			case DELETE:
				$node_id = (isset($this->uriseg->id) && !is_null($this->uriseg->id)) ? trim(intval($this->uriseg->id)) : false;
				
				// var_dump($node_id);
				// die();
				
				if($node_id)
				{
					$node = $this->_Nodes->get_node($node_id);
					if($node)
					{
						$remove_node = $this->_Nodes->nodes_rem_node($node->node_id);
						
						$this->_Session->setFB_Pozitive(array("ref" => $this->Prototype->air_identplural, "text" => "Succes!"));
						redirect($this->Prototype->air_controller);
					}
					else
					{
						redirect($this->Prototype->air_controller);
					}
				}
				else
				{
					redirect($this->Prototype->air_controller);
				}
				break;
		}
		
		
		//breacrumb
		$breadcrumb = array("bb_titlu" => $this->Prototype->air_identplural, "bb_button" => null, "breadcrumb" => array());
		
		$breadcrumb["breadcrumb"][1] = array("text" => (isset($item) ? $item->denumire_ro : "Creaza " . strtolower($this->Prototype->air_identnewitem)) , "url" => null);
		$view = (object) [ 'html' => array
			(
				0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
				1 => (object) ["viewhtml" => "legaturi/item", "viewdata" => $viewdata]
			), 'javascript' => array(
				1 => (object) ["viewhtml" => "legaturi/js_item", "viewdata" => null],
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
					
					$pagestruct = $this->_Pagini->getStructure("array", 56);//getpagestructure
					$locations = (object) ["table" => null, "path" => null];
					$imaginaryfolder = null;//usetrueformultiplefiles[s,m,l]
					$filesdata = null;
					$insertdata = null;
					switch($this->input->post("filetarget"))
					{
						case UPIMGPOZA:
							$locations->table = $this->Air_prototype->air_table_img;
							$locations->path = '../web/' .PATH_IMG_NODES;
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
						$locations->path = '../web/' .PATH_IMG_NODES;
						$locations->table = $this->Air_prototype->air_table_img;
						$imaginaryfolder = array("s" => true, "m" => true, "l" => true);
					}
					
					$deleteitem = $this->_Item->RetrieveAndRemove($locations->table, array("id" => intval(trim($fileid)), "id_item" => intval(trim($this->uriseg->id))));
					if($deleteitem) {
						deletefile('../web/' .$locations->path, $deleteitem->img, $imaginaryfolder);

						$res["status"] = 1;
					}					
					echo json_encode($res);
				break;
			}
		else show_404();
  }
}