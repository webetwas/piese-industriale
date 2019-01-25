<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meniuri extends CI_Controller {

	private $Air;

	private $controller;
	private $controller_fake;
	private $controller_ajax;

	private $uriseg;

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code

		$this->controller = $this->router->fetch_class();
		
		$this->controller_fake = $this->controller;
		$this->controller_ajax = $this->controller;
		$this->uriseg = json_decode(json_encode($this->uri->uri_to_assoc(2)));

		if(!$this->user->id) redirect("login");

		if(!(bool)$this->frontend->user->privilege) redirect("/");
		
		$this->load->model("Item_model", "_Item");
		$this->load->model('Nodes_model', "_Nodes");
		
		$this->Air = $this->_Nodes->get_air_data_by_air_controller(strtolower($this->controller));
		
		if(!$this->Air) exit("Couldn't find The Air..");
	}
	

	public function index()
	{
		$viewdata = array
		(
			"atoms" => null,
			"controller_fake" => $this->controller_fake,
			"controller_ajax" => $this->controller_fake. "/ajax/",
			"uri" => $this->uriseg
		);
		
		if($atoms = $this->_Nodes->get_all_atoms_by_air($this->Air->air_table))
		{
			$viewdata["atoms"] = $atoms;
		}

		//breacrumb
		$breadcrumb = array
		(
			"bb_titlu" => $this->Air->air_identplural,
			"bb_button" => null,
			"breadcrumb" => array()
		);
		$breadcrumb["bb_button"] = array
		(
			"text" => '<i class="fa fa-plus-square"></i> Adauga ' . $this->Air->air_ident,
			"linkhref" => $this->controller_fake ."/atom/i"
		);

		$breadcrumb["breadcrumb"][0] = array
		(
			"text" => "Administrare",
			"url" => ''
		);
		$breadcrumb["breadcrumb"][1] = array
		(
			"text" => $this->Air->air_identplural,
			"url" => null
		);
		$view = (object) [ 'html' => array
			(
				0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
				1 => (object) ["viewhtml" => str_replace(' ', '_', strtolower($this->Air->air_identplural)) . "/index", "viewdata" => $viewdata]
			), 'javascript' => array
			(
				1 => (object) ["viewhtml" => str_replace(' ', '_', strtolower($this->Air->air_identplural)) . "/js_index", "viewdata" => null],
			)
		];
		$this->frontend->render($view);
	}	
	
	/**
	 * atom
	 */
	public function atom()
	{
		
		$viewdata = array
		(
			"air" => $this->Air,
			"controller" => $this->controller,
			"controller_fake" => $this->controller_fake,
			"controller_ajax" => $this->controller_fake. "/ajax/",
			"atom" => null,
			"airdrop" => null,
			"nodes" => null,
			"uri" => $this->uriseg,
			"form" => (object) []
		);
	
		// FORM - NEW Item - Page
		$viewdata["form"]->atom = (object)
		[
			"name" => "atom",
			"prefix" => "it",
			"segments" => $this->controller_fake. "/atom/" .$this->uriseg->atom. ($this->uriseg->atom == "u" && isset($this->uriseg->id) && !is_null($this->uriseg->id) ? "/id/" .trim(intval($this->uriseg->id)) : "")
		];
		$form_submit_atom = $viewdata["form"]->atom->prefix. "submit";//submit<button>	
		switch($this->uriseg->atom)
		{
		  case UPDATE:
			if(isset($this->uriseg->id) && !is_null($this->uriseg->id))
			{
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
				if(!empty($temp_nodes)) $viewdata["nodes"] = $temp_nodes;
				
				// Atom
				if($atom = $this->_Item->msqlGet($this->Air->air_table, array("atom_id" => trim(intval($this->uriseg->id)))))
				{
					$viewdata["atom"] = $atom;
				}
				
				// Airdrop
				if($airdrop = $this->_Nodes->airdrop_get_all_nodes_ids_assoc_by_atom($this->Air->air_id, $viewdata["atom"]->atom_id))
				{
					$viewdata["airdrop"] = $airdrop;
				}
				
				/* form @atom */
				if(isset($_REQUEST["{$form_submit_atom}"]))
				{

					$newDBPattern = (object)
					[
						"table" => $this->Air->air_table,
						"database" => UPDATE,
						"type" => GET,
						"design" => array(
							"atom_isactive" => false,
							"parent_fake" => false
						)
					]; 
					$update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->atom->prefix, $newDBPattern, array("c" => "atom_id", "v" => trim(intval($this->uriseg->id))));// update@Item
					if($update) $this->_Session->setFB_Pozitive(array("ref" => $atom->atom_name, "text" => "Modificarile tale au fost salvate!"));
					redirect($viewdata["form"]->atom->segments);
				}
			}
			break;
			
		//
		case INSERT:
			/* form @atom */
			$redirect = $this->controller_fake;
			if(isset($_REQUEST["{$form_submit_atom}"]))
			{
				$newDBPattern = (object)
				[
					"table" => $this->Air->air_table,
					"database" => INSERT,
					"type" => GET,
					"design" => array
					(
						"air_id" => $this->Air->air_id
					)
				]; 
				$insert = $this->_Item->INSItem($newDBPattern->table, $viewdata["form"]->atom->prefix, $newDBPattern);// insert@Item

				if($insert) {
				$this->_Session->setFB_Pozitive(array("ref" => $this->Air->air_identplural, "text" => "Ai creat un " .$this->Air->air_ident. " nou!"));
				$redirect = $this->controller_fake. "/atom/u/id/". $insert;
				}
				redirect($redirect);
			}
			break;
				
			//
			case DELETE:
				if(isset($this->uriseg->id) && !is_null($this->uriseg->id))
				{
					
					$data = new stdClass();
					$data->air_id = (int)$this->Air->air_id;
					$data->atom_id = (int)$this->uriseg->id;
					
					$delete_airdrops = $this->_Nodes->airdrop_rem_airdrops($data);
					if($delete_airdrops)
					{
						$delete_atom = $this->_Item->msqlDelete($this->Air->air_table, array("atom_id" => $data->atom_id));
						if($delete_atom)
						{
							$this->_Session->setFB_Pozitive(array("ref" => $this->Air->air_identplural, "text" => "Ai sters un " .$this->Air->air_ident. "!"));
							redirect($this->controller_fake);
						}
					}
				}
				$this->_Session->setFB_Negative(array("ref" => 'Te rugam sa contactezi administratorul..', "text" => "A aparut o eroare!"));
				redirect($this->controller_fake);
				break;
		}
	
		
		//breacrumb
		$breadcrumb = array
		(
			"bb_titlu" => $this->Air->air_identplural,
			"bb_button" => null,
			"breadcrumb" => array()
		);
		
		$breadcrumb["breadcrumb"][0] = array
		(
			"text" => $this->Air->air_identplural,
			"url" => $this->controller_fake
		);
		$breadcrumb["breadcrumb"][1] = array
		(
			"text" => (!is_null($viewdata["atom"]) ? 'Editeaza ' . $viewdata["atom"]->atom_name_ro : 'Creeaza ' . strtolower($this->Air->air_ident)),
			"url" => null
		);
		
		$view = (object) [ 'html' => array
			(
				0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
				1 => (object) ["viewhtml" => str_replace(' ', '_', strtolower($this->Air->air_identplural)) . "/item", "viewdata" => $viewdata]
			), 'javascript' => array(
				1 => (object) ["viewhtml" => str_replace(' ', '_', strtolower($this->Air->air_identplural)) . "/js_item", "viewdata" => null],
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
			case AJXTOGGLE:
				$column = false;
				$id = false;
				$xplodeid = explode("_", trim($this->uriseg->id));
				if(isset($xplodeid[0]) && $xplodeid[0] == "a") $column = "parent_fake";
				elseif(isset($xplodeid[0]) && $xplodeid[0] == "b") $column = "atom_isactive";
				if(isset($xplodeid[1])) $id = $xplodeid[1];
				
				echo json_encode($this->_Item->QuestionTrueFalse($this->Air->air_table, $column, $id));
				break;
		}
		else
		{
			show_404();
		}
		
  }
}
