<?php
class Nodes_model extends CI_Model
{
	const TBL_NODES      = 'nodes';
	const TBL_NODES_PATH = 'nodes_path';
	
	const TBL_AIRS       = 'airs';
	const TBL_AIRDROP    = 'airs_airdrop';
	
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
	}
	
	public function getFirstNode($node_id)
	{
		$sql =
		'
			SELECT 
				n.*
			FROM
				' .self::TBL_NODES_PATH. ' AS np LEFT JOIN
				' .self::TBL_NODES. ' AS n ON np.path_id = n.node_id
			WHERE
				np.node_id = ' .(int)$node_id. ' AND
				np.level = 1
			;
		';
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;		
	}
	
	// get_root_node_by_node_id
	//
	public function get_root_node_by_node_id($node_id)
	{
		$query = $this->db->query('SELECT * FROM `' .self::TBL_NODES_PATH. '` WHERE node_id = ' .(int)$node_id. ' AND level = 0');
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;
	}
	
	// get_all_nodes
	//
	public function get_all_nodes()
	{
		$query = $this->db->query('SELECT * FROM `' .self::TBL_NODES. '` ORDER BY parent_id, node_order;');
		
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// get_self_and_all_nodes_by_node
	//
	public function get_self_and_all_nodes_by_node($node_id)
	{
		$sql =
		'
			SELECT
				nodes_sorted.*
			FROM
				(
					SELECT
						*
					FROM
						' .self::TBL_NODES. '
					ORDER by node_id, parent_id
				) AS nodes_sorted, (SELECT @pv := ' .(int)$node_id. ') initialisation
			WHERE
				find_in_set(node_id, @pv) OR
				find_in_set(parent_id, @pv) > 0
			AND @pv := concat(@pv, \',\', node_id)
			ORDER BY nodes_sorted.parent_id, nodes_sorted.node_order
			;		
		';
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// get_all_nodes_by_node
	//
	public function get_all_nodes_by_node($node_id)
	{
		$sql =
		'
			SELECT
				nodes_sorted.*
			FROM
				(
					SELECT
						*
					FROM
						' .self::TBL_NODES. '
						LEFT JOIN nodes_images ON nodes.node_id = nodes_images.id_item
					ORDER by node_id, parent_id
				) AS nodes_sorted, (SELECT @pv := ' .(int)$node_id. ') initialisation
			WHERE
				find_in_set(parent_id, @pv) > 0
			AND @pv := concat(@pv, \',\', node_id)
			GROUP BY nodes_sorted.node_id
			ORDER BY nodes_sorted.parent_id, nodes_sorted.node_order
			;		
		';
		
		// var_dump($sql);die();
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// returning all nodes by @parent_id
	//
	public function get_all_nodes_by_parent_id($parent_id)
	{
		$query = $this->db->query('SELECT * FROM `' .self::TBL_NODES. '` WHERE parent_id = ' .$parent_id. ' ORDER BY node_order;');
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return false;
	}
	
	// returning node by @node_id
	//
	public function get_node($node_id)
	{
		$query = $this->db->query('SELECT * FROM `' .self::TBL_NODES. '` WHERE node_id = ' .(int)$node_id. ';');
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}		
		
		return false;
	}
	
	// nodes_add_node
	//
	public function nodes_add_node($node_id, $parent_id)
	{
		// var_dump($node_id, $parent_id);
		
		$level = 0;
		
		$query = $this->db->query("SELECT * FROM `" .self::TBL_NODES_PATH. "` WHERE node_id = '" . (int)$parent_id . "' ORDER BY `level` ASC");
		
		// var_dump($query->result());die();
		
		foreach ($query->result() as $result) {
			$this->db->query("INSERT INTO `" .self::TBL_NODES_PATH. "` SET `node_id` = '" . (int)$node_id . "', `path_id` = '" . (int)$result->path_id . "', `level` = '" . (int)$level . "'");

			$level++;
		}		
		
		$this->db->query("INSERT INTO `" .self::TBL_NODES_PATH. "` SET `node_id` = '" . (int)$node_id . "', `path_id` = '" . (int)$node_id . "', `level` = '" . (int)$level . "'");
	}
	
	// nodes_rem_node
	//
	public function nodes_rem_node($node_id)
	{
		$this->db->query('DELETE FROM ' .self::TBL_NODES_PATH. ' WHERE node_id = ' .(int)$node_id. ';');
		
		$query = $this->db->query('SELECT * FROM ' .self::TBL_NODES_PATH. ' WHERE path_id = ' .(int)$node_id. ';');
		foreach($query->result() as $result)
		{
			$this->nodes_rem_node($result->node_id);
		}
		
		$this->airdrop_rem_airdrops_by_node((int)$node_id);
		$this->db->query('DELETE FROM ' .self::TBL_NODES. ' WHERE node_id = ' .(int)$node_id. ';');
	}
	
	// get_all_nodes_by_conditions
	//
	public function get_all_nodes_by_conditions($conditions)
	{
		$this->db->or_where_in($conditions->column, $conditions->values);
		$query = $this->db->get(self::TBL_NODES);
		
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// nodes_update_node_order
	//
	public function nodes_update_node_order($node_id, $node_order)
	{
		$sql =
		'
			UPDATE
				' .self::TBL_NODES. ' AS nd
			SET nd.node_order = ' .(int)$node_order. '
			WHERE nd.node_id = ' .(int)$node_id. '
			;
		';
		
		return (bool)$this->db->query($sql);
	}
	
	// get_air_data_by_air_controller
	//
	public function get_air_data_by_air_controller($air_controller)
	{
		$query = $this->db->query('SELECT * FROM `' .self::TBL_AIRS. '` WHERE air_controller = "' . $air_controller . '";');
		
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		
		return false;
	}
	
	// get_air_data_by_air_id
	//
	public function get_air_data_by_air_id($air_id)
	{
		$query = $this->db->query('SELECT * FROM `' .self::TBL_AIRS. '` WHERE air_id = ' . $air_id . ';');
		
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		
		return false;		
	}
	
	// get_all_atoms_by_air
	//
	public function get_all_atoms_by_air($air_table, $order = null)
	{
		$query = $this->db->query('SELECT * FROM `' .$air_table. '`' .(!is_null($order) ? ' ORDER BY atom_order ' .$order. '' : ''). ';');
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return false;
	}
	
	// airdrop_add_airdrop
	//
	public function airdrop_add_airdrop($data)
	{
		$query_check_if_already_exist = $this->db->query('SELECT COUNT(airdrop_id) AS airdrops FROM ' .self::TBL_AIRDROP. ' WHERE air_id = ' .$data->air_id. ' AND atom_id = ' .$data->atom_id. ' AND node_id = ' .$data->node_id. ';');
		
		if($query_check_if_already_exist->num_rows() > 0)
		{
			if($query_check_if_already_exist->row()->airdrops == 0)
			{
				
				$sql =
				'
					INSERT INTO
						' .self::TBL_AIRDROP. '
					(air_id, atom_id, node_id' .(isset($data->node_id_root) ? ', node_id_root' : ''). ')
					VALUES
					(' .$data->air_id. ', ' .$data->atom_id. ', ' .$data->node_id. '' .(isset($data->node_id_root) ? ', ' .$data->node_id_root : ''). ')
					;
				';
				
				$query_add_airdrop = $this->db->query($sql);
				
				if($query_add_airdrop)
				{
					return $this->db->insert_id();
				}
			}
		}
			
		return false;
	}
	
	// airdrop_rem_airdrop
	//
	// removing airdrop by @air_id @atom_id @node_id
	public function airdrop_rem_airdrop($data)
	{
		return $this->db->query('DELETE FROM ' .self::TBL_AIRDROP. ' WHERE air_id = ' .$data->air_id. ' AND atom_id = ' .$data->atom_id. ' AND node_id = ' .$data->node_id. ' LIMIT 1;');
	}
	
	// airdrop_rem_airdrops
	//
	// removing airdrops by @air_id @atom_id
	public function airdrop_rem_airdrops($data)
	{
		return $this->db->query('DELETE FROM ' .self::TBL_AIRDROP. ' WHERE air_id = ' .$data->air_id. ' AND atom_id = ' .$data->atom_id. ';');
	}
	
	// airdrop_rem_airdrops_by_node
	//
	// removing airdrops by @node_id
	public function airdrop_rem_airdrops_by_node($node_id)
	{
		return $this->db->query('DELETE FROM ' .self::TBL_AIRDROP. ' WHERE node_id = ' .(int)$node_id. ';');
	}
	
	// airdrop_get_all_nodes_ids_assoc_by_atom
	//
	public function airdrop_get_all_nodes_ids_assoc_by_atom($air_id, $atom_id)
	{
		$nodes_ids = array();
		
		$nodes = $this->airdrop_get_all_nodes_ids_by_atom($air_id, $atom_id);
		if($nodes)
		{
			foreach($nodes as $node_key => $node_val)
			{
				$nodes_ids[$node_val->node_id] = $node_val;
			}
			
			return $nodes_ids;
		}
		
		return false;
	}
	
	// airdrop_update_airdrop_order
	//
	public function airdrop_update_airdrop_order($airdrop_id, $airdrop_order)
	{
		$sql =
		'
			UPDATE
				' .self::TBL_AIRDROP. ' AS ad
			SET ad.airdrop_order = ' .(int)$airdrop_order. '
				WHERE
			ad.airdrop_id = ' .(int)$airdrop_id. '
			;
		';
		
		return (bool)$this->db->query($sql);		
	}
	
	//airdrop_get_all_nodes_ids_by_atom
	//
	public function airdrop_get_all_nodes_ids_by_atom($air_id, $atom_id)
	{
		$sql =
		'
			SELECT
				' .self::TBL_AIRDROP. '.airdrop_id,
				' .self::TBL_AIRDROP. '.air_id,
				' .self::TBL_AIRDROP. '.atom_id,
				' .self::TBL_AIRDROP. '.node_id,
				' .self::TBL_NODES. '.denumire_ro
			FROM
				' .self::TBL_AIRDROP. ' LEFT JOIN
				' .self::TBL_NODES. ' ON ' .self::TBL_AIRDROP. '.node_id = ' .self::TBL_NODES. '.node_id
			WHERE
				' .self::TBL_AIRDROP. '.air_id = ' .$air_id. ' AND
				' .self::TBL_AIRDROP. '.atom_id = ' .$atom_id. '
			;
		';
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return false;
	}
	
	// airdrop_get_involved_airs_by_node_id
	//
	public function airdrop_get_involved_airs_by_node_id($node_id)
	{	
		$airs_by_ids = array();
		
		$sql =
		'
			SELECT
				ad.node_id,
				a.*
			FROM
				' .self::TBL_AIRDROP. ' AS ad INNER JOIN
				' .self::TBL_AIRS. ' AS a ON ad.air_id = a.air_id
			WHERE ad.node_id = ' .$node_id. '
			GROUP BY ad.air_id;
		';
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $air_value)
			{
				$airs_by_ids[$air_value["air_id"]] = $air_value;
			}
			
			return $airs_by_ids;
		}
		
		return array();
	}
	
	// fetch_atoms_by_node_airdrop_ordered
	//
	public function fetch_atoms_by_node_airdrop_ordered($air_table, $air_table_img, $air_id, $node_id)
	{
		$airdrops_by_ids = array();
		
		$sql =
		'
			SELECT
				COALESCE(ad.airdrop_order, ad.airdrop_id) AS airdrop_order,
				ad.airdrop_id,
				atoms.*
				' .(!is_null($air_table_img) ? ', GROUP_CONCAT(atoms_img.img ORDER BY atoms_img.order ASC) AS images' : ''). '
			FROM
				' .self::TBL_AIRDROP. ' AS ad INNER JOIN
				' .$air_table. ' AS atoms ON ad.atom_id = atoms.atom_id
				' .(!is_null($air_table_img) ? ' LEFT JOIN ' .$air_table_img. ' AS atoms_img ON atoms.atom_id = atoms_img.id_item' : ''). '
			WHERE ad.air_id = ' .(int)$air_id. ' AND ad.node_id = ' .(int)$node_id. '
			GROUP BY airdrop_id
			ORDER BY airdrop_order ASC
			;
		';
		
		// echo $sql;die();
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			foreach($query->result_array() as $airdrop_value)
			{
				$airdrops_by_ids[$airdrop_value["airdrop_order"]] = $airdrop_value;
			}
			
			return $airdrops_by_ids;
		}
		
		return false;
	}
	
	public function fetch_atoms_miss_airdrop_or_root_node($table_atoms, $air_id, $node_id)
	{
		$sql =
		'
			SELECT
				ad.airdrop_id,
				ad.node_id,
				ad.node_id_root,
				atoms.*
			FROM 
				' .$table_atoms. ' AS atoms LEFT JOIN
				' .self::TBL_AIRDROP. ' AS ad ON atoms.atom_id = ad.atom_id AND ad.air_id = ' .$air_id. ' AND ad.node_id_root = ' .$node_id. '
			WHERE
				ad.airdrop_id IS NULL
			GROUP BY
				atoms.atom_id
		';		
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		
		return false;
	}
	
	// public function fetch_atoms_by_null
	//
	
	// build_nodes_airs_airdrops
	//
	public function build_nodes_airs_airdrops($nodes)
	{
		foreach($nodes as $node_key => $node_val)
		{
			// Airs
			if($get_airs_involved = $this->airdrop_get_involved_airs_by_node_id($node_val["node_id"]))
			{
				$nodes[$node_key]['_airs'] = $get_airs_involved;
			}
			
			// Airdrop
			$nodes[$node_key]["_airdrop"] = array();
			if(!empty($get_airs_involved))
			{
				foreach($get_airs_involved as $air_key => $air_val)
				{
					if($fetch_atoms_by_node_airdrop_ordered = $this->fetch_atoms_by_node_airdrop_ordered($air_val["air_table"], $air_val["air_table_img"], $air_val["air_id"], $node_val["node_id"]))
					{
						$nodes[$node_key]["_airdrop"] += $fetch_atoms_by_node_airdrop_ordered;
					}
				}
			}
			
			// Sort Airdrop
			if(!empty($nodes[$node_key]["_airdrop"]))
			{
				ksort($nodes[$node_key]["_airdrop"]);
			}
		}
		return $nodes;
	}
	
	// airdrop_update_airdrop_order
	//
	public function products_order_product_images($id, $order)
	{
		$sql =
		'
			UPDATE
				catalog_produse_images AS cpi
			SET cpi.order = ' .(int)$order. '
			WHERE cpi.id = ' .(int)$id. '
			;
		';
		
		return (bool)$this->db->query($sql);		
	}
	
	// order_atoms_by_serialize
	//
	public function order_atoms_by_serialize($table, $atom_id, $order)
	{
		$sql =
		'
			UPDATE
				' .$table. ' AS atoms
			SET atoms.atom_order = ' .(int)$order. '
			WHERE atoms.atom_id = ' .(int)$atom_id. '
			
			;
		';
		
		return (bool)$this->db->query($sql);
	}
}
