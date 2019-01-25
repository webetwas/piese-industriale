<?php
class Airdrop_model extends CI_Model
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
	
	public function get_products_similar($node_id, $excluded_atom)
	{
		$sql =
		'
			SELECT
				atoms.*,
				GROUP_CONCAT(atimg.img ORDER BY atimg.order ASC SEPARATOR ",") AS images
			FROM
				catalog_produse AS atoms LEFT JOIN
				catalog_produse_images AS atimg ON atoms.atom_id = atimg.id_item LEFT JOIN
				airs_airdrop AS ad ON atoms.atom_id = ad.atom_id AND atoms.atom_id != ' .(int)$excluded_atom. '
			WHERE
				atoms.atom_isactive = 1 AND
				ad.node_id_root = 1 AND
				ad.air_id = 4 AND
				ad.node_id = ' .(int)$node_id. '
			GROUP BY
				atoms.atom_id
			ORDER BY RAND()
			;		
		';
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return false;
	}	
	
	public function get_product_category($atom_id, $air_id)
	{
		$sql =
		'
			SELECT
				n.*,
				ad.airdrop_id,
				ad.node_id_root
			FROM
				airs_airdrop AS ad LEFT JOIN
				nodes AS n ON ad.node_id = n.node_id
			WHERE
				ad.atom_id = ' .$atom_id. ' AND
				ad.air_id = ' .$air_id. ' AND
				ad.node_id_root = 1
			ORDER BY ad.airdrop_id ASC
			LIMIT 1;		
		';
		// var_dump($sql);die();
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;
	}
	
	public function get_second_node_by_node($node_id)
	{
		$sql =
		'
			SELECT
				*
			FROM
				nodes_path
			WHERE
				node_id = ' .$node_id. ';
		';
		
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() >= 2)
		{
			return $query->result()[1];
		}
		
		return false;
	}
	
	public function product_get_text_divers($node_ids)
	{
		$sql =
		'
			SELECT
				*
			FROM
				texte_diverse
			WHERE
				additional_node_id IN(' .implode(',', $node_ids). ');		
		';
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;
	}
	
	
	// get_airdrops_by_air_controller_and_node_slug
	//
	public function get_airdrops_by_air_controller_and_node_slug($air_controller, $node_slug)
	{
		
		$air = $this->get_air_data_by_air_controller($air_controller);
		if(!$air)
		{
			return false;
		}
		
		$sql =
		'
			SELECT
				ad.airdrop_id,
				COALESCE(ad.airdrop_order, ad.airdrop_id) AS airdrop_order,
				ad.air_id,
				ad.node_id,
				nd.slug AS node_slug,
				nd.denumire_ro AS node_denumire_ro,
				atoms.*
			FROM
				' .self::TBL_AIRDROP. ' AS ad RIGHT JOIN
				' .$air->air_table. ' AS atoms ON ad.atom_id = atoms.atom_id LEFT JOIN
				' .self::TBL_NODES. ' AS nd ON ad.node_id = nd.node_id
			WHERE
				nd.is_active = 1 AND
				nd.slug = "' .$node_slug. '"
			ORDER BY airdrop_order ASC
			;		
		';
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return false;
	}
	
	// get_airdrops_and_images_by_air_controller_and_node_slug
	//
	public function get_airdrops_and_images_by_air_controller_and_node_slug($air_controller, $node_slug)
	{
		
		$air = $this->get_air_data_by_air_controller($air_controller);
		if(!$air)
		{
			return false;
		}
		
		$sql =
		'
			SELECT
				ad.airdrop_id,
				COALESCE(ad.airdrop_order, ad.airdrop_id) AS airdrop_order,
				ad.node_id,
				nd.slug AS node_slug,
				nd.denumire_ro AS node_denumire_ro,
				atoms.*,
				GROUP_CONCAT(atimg.img SEPARATOR ",") AS images
			FROM
				' .self::TBL_AIRDROP. ' AS ad RIGHT JOIN
				' .$air->air_table. ' AS atoms ON ad.atom_id = atoms.atom_id LEFT JOIN
				' .$air->air_table_img. ' AS atimg ON atoms.atom_id = atimg.id_item LEFT JOIN
				' .self::TBL_NODES. ' AS nd ON ad.node_id = nd.node_id 
			WHERE
				nd.is_active = 1 AND
				nd.slug = "' .$node_slug. '"
			GROUP BY atoms.atom_id
			ORDER BY airdrop_order ASC
			;		
		';
		
		// if($node_slug == 'bonete-medicale')
		// {
			// var_dump($sql);die();
		// }
		// var_dump($sql);die();
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return false;
	}
	
	
	
	// get_products
	//
	public function get_products($air_controller, $node_slug, $filters)
	{
		// var_dump($filters);
		$air = $this->get_air_data_by_air_controller($air_controller);
		if(!$air)
		{
			return false;
		}
		
		$sql =
		'
			SELECT
				SQL_CALC_FOUND_ROWS
				ad.airdrop_id,
				COALESCE(ad.airdrop_order, ad.airdrop_id) AS airdrop_order,
				ad.node_id,
				nd.slug AS node_slug,
				nd.denumire_ro AS node_denumire_ro,
				atoms.*,
				GROUP_CONCAT(atimg.img ORDER BY atimg.order ASC SEPARATOR ",") AS images
			FROM
				' .self::TBL_AIRDROP. ' AS ad RIGHT JOIN
				' .$air->air_table. ' AS atoms ON ad.atom_id = atoms.atom_id LEFT JOIN
				' .$air->air_table_img. ' AS atimg ON atoms.atom_id = atimg.id_item LEFT JOIN
				' .self::TBL_NODES. ' AS nd ON ad.node_id = nd.node_id 
			WHERE 1 = 1
		';
		
		$sql .=
		'
			AND
				nd.is_active = 1 AND
				nd.slug = "' .$node_slug. '"
			GROUP BY atoms.atom_id
		';
		
		if(is_null($filters->order_by))
		{
			$sql .= 'ORDER BY airdrop_order ASC';
		} else {
			$repl_filter_order_by = str_replace('"', '', $filters->order_by);
			
			if($repl_filter_order_by == "order_by_culoare")
			{
				$sql .= 'ORDER BY atoms.optiuni_culoare ASC';
			} elseif($repl_filter_order_by == "order_by_pret_asc") {
				$sql .= 'ORDER BY IF(atoms.pret_nou != 0.00, atoms.pret_nou, atoms.pret) ASC';
			} elseif($repl_filter_order_by == "order_by_pret_desc") {
				$sql .= 'ORDER BY IF(atoms.pret_nou != 0.00, atoms.pret_nou, atoms.pret) DESC';
			}
		}
		
		$start_from = ((int)$filters->page - 1) * (int)$filters->perpage;
		$sql .= ' LIMIT ' .(int)$start_from. ', ' . (int)$filters->perpage. '';
		
		
		// var_dump($sql);die();
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return false;
	}
	
	public function get_number_of_rows_found()
	{
		$sql = 'SELECT FOUND_ROWS() AS rowsfound;';
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;
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
	
	
	
	public function get_products_by_state($state, $limit = null)
	{
		$sql =
		'
			SELECT
			atoms.*,
			GROUP_CONCAT(atimg.img ORDER BY atimg.order ASC SEPARATOR ",") AS images
			FROM
				catalog_produse AS atoms LEFT JOIN
				catalog_produse_images AS atimg ON atoms.atom_id = atimg.id_item
			WHERE
				atoms.' .$state. ' = 1 AND
				atoms.atom_isactive = 1
			GROUP BY
				atoms.atom_id
		';
		
		if(!is_null($limit))
		{
			$sql .=
			'
				ORDER BY
					RAND()
				LIMIT
					' . $limit . ';
			';
		}
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return false;
	}
	
	public function get_products_by_state_rand_and_limit($state, $limit)
	{
		$sql =
		'
			SELECT
			atoms.*,
			GROUP_CONCAT(atimg.img ORDER BY atimg.order ASC SEPARATOR ",") AS images
			FROM
				catalog_produse AS atoms LEFT JOIN
				catalog_produse_images AS atimg ON atoms.atom_id = atimg.id_item
			WHERE
				atoms.' .$state. ' = 1 AND
				atoms.atom_isactive = 1
			GROUP BY
				atoms.atom_id
			ORDER BY
				RAND()
			LIMIT
				' . $limit . ';	
			;		
		';
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return false;
	}
	
	public function get_products_by_special_price($limit = null)
	{
		$sql =
		'
			SELECT
			atoms.*,
			GROUP_CONCAT(atimg.img ORDER BY atimg.order ASC SEPARATOR ",") AS images
			FROM
				catalog_produse AS atoms LEFT JOIN
				catalog_produse_images AS atimg ON atoms.atom_id = atimg.id_item
			WHERE
				atoms.pret_nou != 0.00 AND
				atoms.atom_isactive = 1
			GROUP BY
				atoms.atom_id	
		';
		
		if(!is_null($limit))
		{
			$sql .=
			'
				ORDER BY
					RAND()
				LIMIT
					' . $limit . ';
			';
		}
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return false;
	}
	
	public function get_products_random($limit)
	{
		$sql =
		'
			SELECT 
				atoms.*,
				GROUP_CONCAT(atimg.img ORDER BY atimg.order ASC SEPARATOR ",") AS images
			FROM
				catalog_produse AS atoms LEFT JOIN
				catalog_produse_images AS atimg ON atoms.atom_id = atimg.id_item
			WHERE
				atoms.atom_isactive = 1
			GROUP BY
				atoms.atom_id
			ORDER BY
				RAND()
			LIMIT
				' . $limit . ';	
		';
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		return false;		
	}
	
	
	// get_node_by_slug
	//
	public function get_node_by_slug($slug)
	{
		$query = $this->db->query('SELECT * FROM `' .self::TBL_NODES. '` WHERE slug = "' .$slug. '";');
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}		
		
		return false;
	}	
	
	
	public function get_product_by_slug($slug)
	{
		$sql =
		'
			SELECT
				atoms.*,
				GROUP_CONCAT(atimg.img ORDER BY atimg.order ASC SEPARATOR ",") AS images
			FROM
				catalog_produse as atoms LEFT JOIN
				catalog_produse_images as atimg ON atoms.atom_id = atimg.id_item
			WHERE
				atoms.atom_isactive = 1 AND
				atoms.slug = "' .$slug. '"
			GROUP BY
				atoms.atom_id
			;
		';
		// var_dump($sql);die();
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}		
		
		return false;
	}
	
	public function get_product_by_id($atom_id)
	{
		$sql =
		'
			SELECT
				atoms.*,
				GROUP_CONCAT(atimg.img SEPARATOR ",") AS images
			FROM
				catalog_produse as atoms RIGHT JOIN
				catalog_produse_images as atimg ON atoms.atom_id = atimg.id_item
			WHERE
				atoms.atom_isactive = 1 AND
				atoms.atom_id = "' .$atom_id. '";		
		';
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}		
		
		return false;
	}
	
	
	
	public function get_max_and_min_prices($air_controller, $node_slug)
	{
		
		$air = $this->get_air_data_by_air_controller($air_controller);
		if(!$air)
		{
			return false;
		}
		
		$sql =
		'
			SELECT
				MIN(IF(atoms.pret_nou != 0.00, atoms.pret_nou, atoms.pret)) AS min_price,
				MAX(atoms.pret) AS max_price
			FROM
				(
					SELECT
						ad.node_id,
						nd.slug AS node_slug,
						nd.denumire_ro AS node_denumire_ro,
						atoms.*
					FROM
						' .self::TBL_AIRDROP. ' AS ad RIGHT JOIN
						' .$air->air_table. ' AS atoms ON ad.atom_id = atoms.atom_id LEFT JOIN
						' .self::TBL_NODES. ' AS nd ON ad.node_id = nd.node_id 
					WHERE
						nd.is_active = 1 AND
						nd.slug = "' .$node_slug. '"
					GROUP BY atoms.atom_id
				) AS atoms
		';
		// var_dump($sql);die();
		
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;
	}
	
	
	
	public function get_sizes($air_controller, $node_slug)
	{
		
		$air = $this->get_air_data_by_air_controller($air_controller);
		if(!$air)
		{
			return false;
		}
		
		$sql =
		'
			SELECT
				GROUP_CONCAT(atoms.optiuni_marime SEPARATOR \',\') AS sizes
			FROM
				(
					SELECT
						ad.node_id,
						nd.slug AS node_slug,
						nd.denumire_ro AS node_denumire_ro,
						atoms.*
					FROM
						' .self::TBL_AIRDROP. ' AS ad RIGHT JOIN
						' .$air->air_table. ' AS atoms ON ad.atom_id = atoms.atom_id LEFT JOIN
						' .self::TBL_NODES. ' AS nd ON ad.node_id = nd.node_id 
					WHERE
						nd.is_active = 1 AND
						nd.slug = "' .$node_slug. '"
					GROUP BY atoms.atom_id
				) AS atoms
		';
		
		// var_dump($sql);die();
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;
	}	
	
	
	public function get_products_w_new_price_and_category()
	{
		$sql = 
		'
			SELECT
				atoms.*,
				GROUP_CONCAT(atoms_img.img ORDER BY atoms_img.order ASC) AS images,
				airdrop.node_id,
				node.denumire_ro
			FROM
				catalog_produse AS atoms INNER JOIN
				airs_airdrop AS airdrop ON atoms.atom_id = airdrop.atom_id AND airdrop.air_id = 4 AND airdrop.node_id_root = 1 LEFT JOIN
				catalog_produse_images AS atoms_img ON atoms.atom_id = atoms_img.id_item LEFT JOIN
				nodes AS node ON node.node_id = airdrop.node_id
			WHERE atoms.pret_nou != 0.00
			GROUP BY atom_id
			;
		';
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			$res = array();
			foreach($query->result() as $product)
			{
				if(!array_key_exists($product->node_id, $res))
				{
					$res[$product->node_id] = array('denumire_ro' => $product->denumire_ro, 'products' => array());
				}
				
				$res[$product->node_id]["products"][] = $product;
			}
			
			return $res;
		}
		
		return false;		
	}
	
	public function get_products_by_search($string)
	{
		$sql = 
		'
			SELECT
				atoms.*,
				GROUP_CONCAT(atoms_img.img ORDER BY atoms_img.order ASC) AS images
			FROM
				catalog_produse AS atoms LEFT JOIN
				catalog_produse_images AS atoms_img ON atoms.atom_id = atoms_img.id_item
			WHERE
				atoms.atom_name LIKE "%' .$string. '%"
			GROUP BY atom_id
			;
		';
		
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			return $query->result();
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
					ORDER by node_id, parent_id
				) AS nodes_sorted, (SELECT @pv := ' .(int)$node_id. ') initialisation
			WHERE
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
	public function get_all_nodes_and_images_by_node($node_id)
	{
		$sql =
		'
			SELECT
				nodes_sorted.*,
				GROUP_CONCAT(ndimg.img ORDER BY ndimg.order ASC SEPARATOR ",") AS images
			FROM
				(
					SELECT
						*
					FROM
						' .self::TBL_NODES. '
					ORDER by node_id, parent_id
				) AS nodes_sorted LEFT JOIN nodes_images AS ndimg ON nodes_sorted.node_id = ndimg.id_item, (SELECT @pv := ' .(int)$node_id. ') initialisation
			WHERE
				find_in_set(parent_id, @pv) > 0
			AND @pv := concat(@pv, \',\', node_id)
			GROUP BY nodes_sorted.node_id
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
	
	
	// public function get_categories_by_node_id($node_id)
	// {
		// $sql =
		// '
			// SELECT
				// nd.*,
				// GROUP_CONCAT(ndimg.img SEPARATOR ",") AS images
			// FROM
				// nodes AS nd LEFT JOIN
				// nodes_images AS ndimg ON nd.node_id = ndimg.id_item
			// WHERE
				// nd.parent_id = ' .$node_id. '
			// GROUP BY
				// nd.node_id	
			// ;
		// ';
		
		// $query = $this->db->query($sql);
		// if($query->num_rows() > 0)
		// {
			// return $query->result();
		// }
		
		// return false;
	// }	
	
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
	
	// get_all_atoms_by_air
	//
	public function get_all_atoms_by_air($air_table)
	{
		$query = $this->db->query('SELECT * FROM `' .$air_table. '`;');
		
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
			WHERE ad.airdrop_id = ' .(int)$airdrop_id. '
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
	public function fetch_atoms_by_node_airdrop_ordered($air_table, $air_id, $node_id)
	{
		$airdrops_by_ids = array();
		
		$sql =
		'
			SELECT
				COALESCE(ad.airdrop_order, ad.airdrop_id) AS airdrop_order,
				ad.airdrop_id,
				atoms.*
			FROM
				' .self::TBL_AIRDROP. ' AS ad INNER JOIN
				' .$air_table. ' AS atoms ON ad.atom_id = atoms.atom_id
			WHERE ad.air_id = ' .(int)$air_id. ' AND ad.node_id = ' .(int)$node_id. '
			ORDER BY airdrop_order ASC
			;
		';
		
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
	
	// fetch_atoms_miss_airdrop_or_root_node
	//
	// Fetching atoms that miss an Airdrop or Root node
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
				' .self::TBL_AIRDROP. ' AS ad ON atoms.atom_id = ad.atom_id AND ad.air_id = ' .$air_id. '
			WHERE
				ad.atom_id
					!= ALL
						(
							SELECT
								atom_id
							FROM
								' .self::TBL_AIRDROP. ' AS ad
							WHERE
								ad.node_id_root = ' .$node_id. '
						)
			OR
				ad.airdrop_id IS NULL
			;		
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
					if($fetch_atoms_by_node_airdrop_ordered = $this->fetch_atoms_by_node_airdrop_ordered($air_val["air_table"], $air_val["air_id"], $node_val["node_id"]))
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
}
