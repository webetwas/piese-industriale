<?php
class Cos_model extends CI_Model {

  // public $tbl_articole = TBL_PRODUSE;
  // public $tbl_articole_images = TBL_ARTICOLE_IMAGES;

  // public $tbl_catalog = TBL_CATALOG;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
  }

  public function getsession()
  {
    $cart = false;
    if(!empty($this->session->userdata('cart'))) $cart = $this->session->userdata('cart');
	
    return $cart;
  }

  public function removeprodus($id)
  {
    $newcart = $this->getsession();
    if($newcart) {
      // var_dump($newcart[$id]);die();
      unset($newcart[trim(intval($id))]);//unsetitemfromcart
      $this->session->set_userdata('cart', $newcart);//setnewcart
      if(!$this->checkCartItem(trim(intval($id)))) return true;
      else return false;
    }
  }

  /**
   * [addprodus_session Adauga produs in sesiune(creeaza sesiune noua, in caz ca nu exista)]
   * @param  [type] $id  [description]
   * @param  [type] $qty [description]
   * @return [type]      [description]
   */
  public function addprodus_session($product)
  {
    $getsess = $this->getsession();
    if(!$getsess) $cart = array();//Cart doesn't exista
    elseif($getsess) $cart = $getsess;//Cart exist, use it's Array

    $cart[$product["id"]] = $product;//pass product to Cart

    $this->session->set_userdata('cart', $cart);
    if($this->checkCartItem($product["id"])) return true;

    return false;
  }
  
  public function get_cart_product($id)
  {
    $getsess = $this->getsession();
    if($getsess) $cart = $getsess;//Cart exist, use it's Array
	
	if(!isset($cart))
		return false;
	
    return $cart[$id];  
  }

  private function checkCartItem($id)
  {
    $cart = $this->getsession();
	if($cart)
		if (array_key_exists($id, $cart)) return true;
    else return false;
  }

  public function GetArticoleByCart($cart)
  {
    $cos_procesat = array("subtotal" => 0, "transport" => 0, "total" => 0, "items" => 0, "articole" => null);
	
	$transport = $this->get_transport();
	
    // $cos_procesat["items"] = count($cart);
	// var_dump($cart);
	// die();
    foreach($cart as $cartid)
	{
      $produs = $this->get_produs($cartid["id"]);

      if($produs)
	  {
			$produs->cantitate = trim(intval($cartid["qty"]));
			$produs->promo = false;
			$produs->pret_total = false;
			$produs->size = isset($cartid["size"]) ? $cartid["size"] : '';
			$produs->material_culoare = isset($cartid["opt_m_c_value"]) ? $cartid["opt_m_c_value"] : '';
			$produs->garnitura_culoare = isset($cartid["opt_g_c_value"]) ? $cartid["opt_g_c_value"] : '';
			$produs->opt_p_value = isset($cartid["opt_p_value"]) ? $cartid["opt_p_value"] : '';
			
			if(!empty($produs->material_culoare))
			{
				if($material_culoare = $this->get_material_culoare($produs->material_culoare))
				{
					$produs->material_culoare = 'Material produs: ' . $material_culoare->material . ' / Culoare : ' . $material_culoare->culoare;
				} else {
					$produs->material_culoare = '';
				}
			}
			
			if(!empty($produs->garnitura_culoare))
			{
				if($garnitura_culoare = $this->get_material_culoare($produs->garnitura_culoare))
				{
					$produs->garnitura_culoare = 'Culoare garnitura: ' . $garnitura_culoare->culoare;
				} else {
					$produs->garnitura_culoare = '';
				}
			}
			
			if(!empty($produs->opt_p_value))
			{
				$optiune_produs = explode(":", $produs->opt_p_value);
				if($opt_p_value = $this->get_optiuni_produs($optiune_produs[0]))
				{
					$produs->atom_name = $produs->atom_name . ' (' .preg_replace('(\(.*\))', '', $opt_p_value->{$optiune_produs[1]}). ')';
					
					$opt_value = $optiune_produs[1] . '_value';
					if($produs->pret_nou != 0.00)
					{
						$produs->pret_nou = $produs->pret_nou + $opt_p_value->{$opt_value};
					} else {
						$produs->pret = $produs->pret + $opt_p_value->{$opt_value};
					}
				}
			}
			
			$pret = false;			
			
			if($produs->pret_nou != 0.00)
			{
			  $pret = $produs->pret_nou;
			  $produs->promo = true;
			} else {
				$pret = $produs->pret;
			}

			if($pret)
			{
				$produs->pret = $pret;
				$produs->pret_total = $pret * $cartid["qty"];// Add Quantity
			}
			if($produs->pret_total)
			{
				$cos_procesat["subtotal"] = $cos_procesat["subtotal"] + intval($produs->pret_total);
				$cos_procesat["total"] = $cos_procesat["subtotal"];
			}
			
			$cos_procesat["articole"][$cartid["id"]] = $produs;
			$cos_procesat["items"] = trim(intval($cartid["qty"])) + $cos_procesat["items"];
      }
    }
	
	if($transport)
	{
		if($transport->cost_transport != "0")
		{
			$cos_procesat["total"] = $cos_procesat["total"] + $transport->cost_transport;
			$cos_procesat["transport"] = $transport->cost_transport;
			
			if($transport->suma_necesara != "0" && ($transport->suma_necesara < $cos_procesat["subtotal"]))
			{
				$cos_procesat["total"] = $cos_procesat["total"] - $transport->cost_transport;
				$cos_procesat["transport"] = 0;
			}
		}
	}
    return $cos_procesat;
  }
	
	private function get_transport()
	{
		$sql =
		'
			SELECT
				*
			FROM
				transport
			LIMIT 1
			;
		';
		
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;		
	}
	
	private function get_material_culoare($id)
	{
		$sql =
		'
			SELECT
				m.atom_name AS material,
				c.name AS culoare
			FROM
				optiuni_material_culori AS c INNER JOIN
				optiuni_material AS m ON c.atom_id = m.atom_id
			WHERE c.id = ' .(int)$id. '
			;
		';
		
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;
	}

	private function get_optiuni_produs($atom_id)
	{
		$sql =
		'
			SELECT
				*
			FROM
				optiuni_produs
			WHERE atom_id = ' .(int)$atom_id. '
			;
		';
		
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;
	}
	
  private function get_produs($atom_id)
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
				atoms.atom_id = ' .(int)$atom_id. ';		
		';
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}		
		
		return false;	  
  }
  
  public function get_articol($atom_id)
  {
		$sql =
		'
			SELECT
				atoms.*
			FROM
				catalog_produse as atoms
			WHERE
				atoms.atom_id = ' .$atom_id. '
		';
		
		$query = $this->db->query($sql);
		
		if($query->num_rows() > 0)
		{
			return $query->row();
		}		
		
		return false;	  
  }
  
  // private function GetArticol($id)
  // {
    // $articol = $this->msqlGet('id, idhttp_url, id_categorie, codarticol, producator, denumire_ro, produs_cantitate, produs_umasura, pretarticola, pretarticolb, detalii', $this->tbl_articole, array("id" => $id));
    // if($articol) {
      // $articol->img = $this->msqlGet('img', $this->tbl_articole_images, array("id_parent" => $articol->id));
      // $categorie = $this->msqlGet('idhttp_url', $this->tbl_catalog, array("id" => $articol->id_categorie));
      // if($categorie) $articol->categorie = $categorie->idhttp_url;
      // return $articol;
    // }
    // return false;
  // }

  /**
   * [msqlGet description]
   * @param  [type] $table [description]
   * @param  [type] $data  [description]
   * @return [type]        [description]
   */
  private function msqlGet($select, $table, $data)
	{
    $this->db->select($select);
    $query = $this->db->get_where($table, $data);

    if($query->num_rows() > 0) return $query->row();
    return false;
	}

  public function removesession()
  {
    $this->session->unset_userdata('cart');
  }
}
