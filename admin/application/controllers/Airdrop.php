<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Airdrop extends CI_Controller
{
	private $controller;
	private $uriseg;

	public function __construct()
	{
		parent::__construct();
		// Your own constructor code

		$this->controller = $this->router->fetch_class();
		$this->uriseg = json_decode(json_encode($this->uri->uri_to_assoc(1)));

		if(!$this->user->id) redirect("login");
		
		$this->load->model("Nodes_model", "_Nodes");
	}
	
	// index
	//
	public function index()
	{
		show_404();
	}	
	
	// airdrop_request
	//
	public function airdrop_request()
	{
		header("Content-Type: application/json");
		$res = array("status" => 0, 'error' => null, 'success' => null, 'airdrop_id' => null);
		
		$atom_id = (isset($this->uriseg->id) && !is_null($this->uriseg->id))
			? (int)$this->uriseg->id : null;
		$air_id = (!empty($this->input->post("air_id")))
			? (int)$this->input->post("air_id") : null;
		$params = (!empty($this->input->post("params")))
			? $this->input->post("params") : null;
		if(is_null($atom_id) || is_null($air_id) || is_null($params))
		{
			$res["error"] = 'Params missing..';
			exit(json_encode($res));
		}

		$data = new stdClass();
		$data->atom_id     = $atom_id;
		$data->air_id      = $air_id;
		$data->airdrop_act = null;
		$data->node_id     = null;
		
		foreach($params as $airdrop_act => $node_id)
		{
			$data->airdrop_act = $airdrop_act;
			$data->node_id = $node_id;
		}

		switch($data->airdrop_act)
		{
			case 'selected':
				if($get_root_node_by_node_id = $this->_Nodes->get_root_node_by_node_id($data->node_id))
				{
					$data->node_id_root = (int)$get_root_node_by_node_id->path_id;
				}
				
				$airdrop_save = $this->_Nodes->airdrop_add_airdrop($data);
				if($airdrop_save)
				{
					$res["airdrop_id"] = $airdrop_save;
				}
				break;
				
			case 'deselected':
				$airdrop_save = $this->_Nodes->airdrop_rem_airdrop($data);
				break;
		}
		
		if($airdrop_save)
		{
			$res["status"] = 1;
			$res["success"] = 'Airdrop added..';
			exit(json_encode($res));
		}
		
		exit(json_encode($res));
	}
	
	// nodes_order_nodes
	//
	public function nodes_order_nodes()
	{
		header("Content-Type: application/json");
		$res = array("status" => 0, 'error' => null, 'success' => null, 'nodes_ordered' => null);
		
		$serialize = (!empty($this->input->post("serialize")))
			? $this->input->post("serialize") : null;
		if(is_null($serialize))
		{
			$res["error"] = 'Params missing..';
			exit(json_encode($res));
		}
		
		$node_order	= 0;
		foreach($serialize as $node)
		{
			$node_order++;
			
			$update_node_order = $this->_Nodes->nodes_update_node_order($node["id"], $node_order);
			
			if(!$update_node_order)
			{
				$res["status"] = 0;
				$res["error"] = 'A aparut o eroare.. Te rugam sa contactezi administratorul.';
				exit(json_encode($res));
			}
		}
		$res["status"] = 1;
		$res["nodes_ordered"] = $node_order;
		
		exit(json_encode($res));
	}
	
	// airdrop_order_airdrop
	//
	public function airdrop_order_airdrop()
	{
		header("Content-Type: application/json");
		$res = array("status" => 0, 'error' => null, 'success' => null, 'airdrops_ordered' => null);
		
		$serialize = (!empty($this->input->post("serialize")))
			? $this->input->post("serialize") : null;
		if(is_null($serialize))
		{
			$res["error"] = 'Params missing..';
			exit(json_encode($res));
		}
		// var_export($serialize);die();
		$airdrop_order = 0;
		foreach($serialize as $airdrop)
		{
			$airdrop_order++;
			
			$update_airdrop_order = $this->_Nodes->airdrop_update_airdrop_order($airdrop["id"], $airdrop_order);
			
			if(!$update_airdrop_order)
			{
				$res["status"] = 0;
				$res["error"] = 'A aparut o eroare.. Te rugam sa contactezi administratorul.';
				exit(json_encode($res));
			}
		}
		$res["status"] = 1;
		$res["airdrops_ordered"] = $airdrop_order;
		
		exit(json_encode($res));
	}
	
	public function order_product_images()
	{
		header("Content-Type: application/json");
		$res = array("status" => 0, 'error' => null, 'success' => null, 'airdrops_ordered' => null);

		$serialize = (!empty($this->input->post("serialize")))
			? $this->input->post("serialize") : null;
		if(is_null($serialize))
		{
			$res["error"] = 'Params missing..';
			exit(json_encode($res));
		}
		$order = 0;
		foreach($serialize as $id_item)
		{
			$order++;
			
			$update_airdrop_order = $this->_Nodes->products_order_product_images($id_item, $order);
			
			if(!$update_airdrop_order)
			{
				$res["status"] = 0;
				$res["error"] = 'A aparut o eroare.. Te rugam sa contactezi administratorul.';
				exit(json_encode($res));
			}
		}
		$res["status"] = 1;
		$res["airdrops_ordered"] = $order;
		
		exit(json_encode($res));
	}
	
	public function catalog_produse_order_opt_culoare()
	{
		header("Content-Type: application/json");
		$res = array("status" => 0, 'error' => null, 'success' => null, 'atoms_ordered' => null);
		
		$serialize = (!empty($this->input->post("serialize")))
			? $this->input->post("serialize") : null;
		if(is_null($serialize))
		{
			$res["error"] = 'Params missing..';
			exit(json_encode($res));
		}
		
		$order	= 0;
		foreach($serialize as $serialized)
		{
			$order++;
			
			$update_node_order = $this->_Nodes->order_atoms_by_serialize('optiuni_culoare', $serialized["id"], $order);
			
			if(!$update_node_order)
			{
				$res["status"] = 0;
				$res["error"] = 'A aparut o eroare.. Te rugam sa contactezi administratorul.';
				exit(json_encode($res));
			}
		}
		$res["status"] = 1;
		$res["atoms_ordered"] = $order;
		
		exit(json_encode($res));		
	}
	
	public function catalog_produse_order_opt_marime()
	{
		header("Content-Type: application/json");
		$res = array("status" => 0, 'error' => null, 'success' => null, 'atoms_ordered' => null);
		
		$serialize = (!empty($this->input->post("serialize")))
			? $this->input->post("serialize") : null;
		if(is_null($serialize))
		{
			$res["error"] = 'Params missing..';
			exit(json_encode($res));
		}
		
		$order	= 0;
		foreach($serialize as $serialized)
		{
			$order++;
			
			$update_node_order = $this->_Nodes->order_atoms_by_serialize('optiuni_marime', $serialized["id"], $order);
			
			if(!$update_node_order)
			{
				$res["status"] = 0;
				$res["error"] = 'A aparut o eroare.. Te rugam sa contactezi administratorul.';
				exit(json_encode($res));
			}
		}
		$res["status"] = 1;
		$res["atoms_ordered"] = $order;
		
		exit(json_encode($res));		
	}
}