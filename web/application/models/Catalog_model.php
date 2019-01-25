<?php
class Catalog_model extends CI_Model {
  private $objname;

  private $tbl_catalog = null;
  private $tbl_catalog_images = null;
  private $tbl_produse = null;
  private $tbl_produse_images = null;

  /**
   * [private description]
   * @var [int] $lastitem [id of the last Item]
   */
  private $lastitem;

  /**
   * [__construct description]
   */
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    $this->objname = get_class($this);//Controller

    // $this->tbl_catalog = TBL_CATALOG;
    // $this->tbl_catalog_images = TBL_CATALOG_IMAGES;
    // $this->tbl_produse = TBL_PRODUSE;
    // $this->tbl_produse_images = TBL_ARTICOLE_IMAGES;
  }

  public function getIdCategorieByIdHttp_url($idhttp_url)
  {
    $query = $this->db->query('SELECT id FROM `' .$this->tbl_catalog. '` WHERE idhttp_url = "' .trim($idhttp_url). '";');
    if($query->num_rows() > 0) return $query->row();

    return false;
  }

  public function fetchCategorii($where) {
    // $query = $this->db->query("SELECT id, idhttp_url, denumire_ro FROM `" .$this->tbl_catalog. "` WHERE id_categorie = {$where};");
    // if($query->num_rows() > 0) return $query->result();
    // else return false;

    $this->db->select('id, idhttp_url, denumire_ro');
    $query = $this->db->get_where($this->tbl_catalog, $where);

    if($query->num_rows() > 0) return $query->result();
    else return false;
  }

  public function FetchCategoriiW_img($where) {
    $categorii = $this->fetchCategorii($where);
    if($categorii) {
      foreach($categorii as $keyctg => $ctg) {
        $categorii[$keyctg]->img = $this->getCategorie_img($ctg->id);
      }
    } else return false;

    return $categorii;
  }

  private function getCategorie_img($id) {
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_catalog_images. "` WHERE id_parent = " .trim($id). ";");
    if($query->num_rows() > 0) return $query->result();

    return false;
  }

  /**
   * [fetchItems description]
   * @param  [String] $table    [description]
   * @param  [Object] $anyWHERE [description]
   * @return [type]           [description]
   */
  public function fetchItems($table = null, $anyWHERE = null) {
    if(empty($table)) $this->sError("Specify a table", 1);

    $query = $this->db->query("SELECT * FROM `" .trim($table). "` " .(!empty($anyWHERE) ? "WHERE {$anyWHERE->c} = {$anyWHERE->v}" : ""). ";");
    if($query->num_rows() > 0) return $query->result();
    else return false;
  }

  public function fetchCategorie($id)
  {
    if($id) {
      $query = $this->db->query("SELECT * FROM `" .$this->tbl_catalog. "` WHERE id = " .trim($id). ";");
      if($query->num_rows() > 0) {
        return $query->row();
      } else return false;
    }
  }

  public function fetchProdus($id) {
    if($id) {
      $query = $this->db->query("SELECT * FROM `" .$this->tbl_produse. "` WHERE id = " .trim($id). ";");
      if($query->num_rows() > 0) {
        return $query->row();
      } else return false;
    }
  }

  public function fetchProdusByHTTPid($idhttp_url) {
    if($idhttp_url) {
      $query = $this->db->query('SELECT * FROM `' .$this->tbl_produse. '` WHERE idhttp_url = "' .trim($idhttp_url). '";');
      if($query->num_rows() > 0) {
        $produs = $query->row();
        $produs->images = $this->getImagesByParent($this->tbl_produse_images, $produs->id);

        return $produs;
      } else return false;
    }
  }

  /**
   * [sError description]
   * @param  [string]  $error [Error message]
   * @param  boolean $die     [description]
   * @return [string]         [Message]
   */
  private function sError($error, $die = false)
  {
    echo $this->objname. "/ ".$error;
    if($die) die();
  }

  /**
   * GetCategoriiFull
   *
   */
  function GetCategoriiFull($onlyids = false) {
    $strs_a = $this->getCategoriesByIdParinte(0, $onlyids);
    foreach($strs_a AS $keystr_a => $str_a) {
      $strs_a[$keystr_a]->strs_b = null;//createemptynewstrs_B

      $strs_b = $this->getCategoriesByIdParinte($str_a->id, $onlyids);
      if($strs_b) {
        $strs_a[$keystr_a]->strs_b = $strs_b;//passcategoriestoparent_B
        foreach($strs_a[$keystr_a]->strs_b AS $keystr_b => $str_b) {
          $strs_a[$keystr_a]->strs_b[$keystr_b]->strs_c = null;//createemptynewstrs_C

          $strs_c = $this->getCategoriesByIdParinte($str_b->id, $onlyids);
          if($strs_c) {
            $strs_a[$keystr_a]->strs_b[$keystr_b]->strs_c = $strs_c;//passcategoriestoparent_C
          }
        }
      }
    }
    return $strs_a;
  }

  /**
   * GetCategoriiIds
   *
   */
  function GetCategoriiIds($onlyids = true) {
    $strs = array();
    $strs_a = $this->getCategoriesByIdParinte(array("rtd" => 0, "id_categorie" => 0));
    foreach($strs_a AS $keystr_a => $str_a) {
      $strs[$str_a->id]["id"] = $str_a->id;
      $strs[$str_a->id]["denumire"] = $str_a->denumire_ro;
      $strs[$str_a->id]["idhttp_url"] = $str_a->idhttp_url;
      $strs[$str_a->id]["strs"] = array();//createemptynewstrs_B

      $strs_b = $this->getCategoriesByIdParinte(array("rtd" => 0, "id_categorie" => $str_a->id));
      if($strs_b) {
        $strs_a[$keystr_a]->strs_b = $strs_b;//passcategoriestoparent_B
        foreach($strs_a[$keystr_a]->strs_b AS $keystr_b => $str_b) {
            $strs[$str_a->id]["strs"][$str_b->id]["id"] = $str_b->id;
            $strs[$str_a->id]["strs"][$str_b->id]["denumire"] = $str_b->denumire_ro;
            $strs[$str_a->id]["strs"][$str_b->id]["idhttp_url"] = $str_b->idhttp_url;
            $strs[$str_a->id]["strs"][$str_b->id]["strs"] = array();
          $strs_a[$keystr_a]->strs_b[$keystr_b]->strs_c = null;//createemptynewstrs_C

          $strs_c = $this->getCategoriesByIdParinte(array("rtd" => 0, "id_categorie" => $str_b->id));
          if($strs_c) {
            $strs[$str_a->id]["strs"][$str_b->id]["strs"][$strs_c[0]->id]["id"] = $strs_c[0]->id;
            $strs[$str_a->id]["strs"][$str_b->id]["strs"][$strs_c[0]->id]["denumire"] = $strs_c[0]->denumire_ro;
            $strs[$str_a->id]["strs"][$str_b->id]["strs"][$strs_c[0]->id]["idhttp_url"] = $strs_c[0]->idhttp_url;
            $strs_a[$keystr_a]->strs_b[$keystr_b]->strs_c = $strs_c;//passcategoriestoparent_C
          }
        }
      }
    }
    // return $strs_a;
    return $strs;
  }

  /**
   * FetchCatalog
   *
   */
   function FetchCatalog($onlyids = true) {
     $strs = array();
     $strs_a = $this->getCategoriesByIdParinte(array("rtd" => 0, "id_categorie" => 0));
     foreach($strs_a AS $keystr_a => $str_a) {
       $strs[$str_a->id]["id"] = $str_a->id;
       $strs[$str_a->id]["denumire"] = $str_a->denumire_ro;
       $strs[$str_a->id]["idhttp_url"] = $str_a->idhttp_url;
       $strs[$str_a->id]["strs"] = array();//createemptynewstrs_B
       $strs[$str_a->id]["art"] = $this->GetArticoleByIdCategorie(array("rtd" => 0, "activ" => 1, "id_categorie" => $str_a->id));
       $strs[$str_a->id]["images"] = $str_a->images;

       $strs_b = $this->getCategoriesByIdParinte(array("rtd" => 0, "id_categorie" => $str_a->id));
       if($strs_b) {
         $strs_a[$keystr_a]->strs_b = $strs_b;//passcategoriestoparent_B
         foreach($strs_a[$keystr_a]->strs_b AS $keystr_b => $str_b) {
             $strs[$str_a->id]["strs"][$str_b->id]["id"] = $str_b->id;
             $strs[$str_a->id]["strs"][$str_b->id]["denumire"] = $str_b->denumire_ro;
             $strs[$str_a->id]["strs"][$str_b->id]["idhttp_url"] = $str_b->idhttp_url;
             $strs[$str_a->id]["strs"][$str_b->id]["strs"] = array();
             $strs[$str_a->id]["strs"][$str_b->id]["images"] = $str_b->images;
             $strs_a[$keystr_a]->strs_b[$keystr_b]->strs_c = null;//createemptynewstrs_C

           $strs_c = $this->getCategoriesByIdParinte(array("rtd" => 0, "id_categorie" => $str_b->id));
           if($strs_c) {
             $strs[$str_a->id]["strs"][$str_b->id]["strs"][$strs_c[0]->id]["id"] = $strs_c[0]->id;
             $strs[$str_a->id]["strs"][$str_b->id]["strs"][$strs_c[0]->id]["denumire"] = $strs_c[0]->denumire_ro;
             $strs[$str_a->id]["strs"][$str_b->id]["strs"][$strs_c[0]->id]["idhttp_url"] = $strs_c[0]->idhttp_url;
             $strs[$str_a->id]["strs"][$str_b->id]["strs"][$strs_c[0]->id]["images"] = $strs_c[0]->images;
             $strs_a[$keystr_a]->strs_b[$keystr_b]->strs_c = $strs_c;//passcategoriestoparent_C
           }
         }
       }
     }
     // return $strs_a;
     return $strs;
   }

   /**
    * getCategoriesByIdParinte
    */
   function getCategoriesByIdParinte($data)
   {
     $this->db->select('*');
     $query = $this->db->get_where($this->tbl_catalog, $data);

     if($query->num_rows() > 0) {
       $categorii = $query->result();
       foreach($categorii as $keycateg => $categ) {
         $categorii[$keycateg]->images = $this->getImagesByParent($this->tbl_catalog_images, $categ->id);
       }
       return $categorii;
     }
     else return false;
   }

   /**
    * GetArticoleByIdCategorie
    */
   function GetArticoleByIdCategorie($data)
   {
     $this->db->select('*');
		 $this->db->order_by('order', 'ASC');
     $query = $this->db->get_where($this->tbl_produse, $data);

     if($query->num_rows() > 0) {
       $articole = $query->result();
       foreach($articole as $keyart => $art) {
         $articole[$keyart]->images = $this->getImagesByParent($this->tbl_produse_images, $art->id);
       }
       return $articole;
     }
     else return false;
   }

	 public function getArticoleByKeySearch($key)
	 {
		 $query = $this->db->query("SELECT * FROM `" .$this->tbl_produse. "` WHERE rtd = 0 AND activ = 1 AND `denumire_ro` LIKE '%{$key}%' OR `descriere_ro` LIKE '%{$key}%';");

		 if($query->num_rows() > 0) {
			 $arr = $query->result();
			 foreach($arr as $keyar => $ar) {
				 $arr[$keyar]->images = $this->getImagesByParent($this->tbl_produse_images, $ar->id);
				 
				 $categ = $this->fetchCategorie($ar->id_categorie);
				 if($categ) {
					 $arr[$keyar]->categ_idhttp_url = $categ->idhttp_url;
				 }
			 }
			 return $arr;
		 }
		 else return false;		 
	 }
	 
   /**
    * GetArticoleByCondition
    */
   function GetArticoleByCondition($data)
   {
     $this->db->select('*');
     $query = $this->db->get_where($this->tbl_produse, $data);

     if($query->num_rows() > 0) {
       $articole = $query->result();
       foreach($articole as $keyart => $art) {
         $articole[$keyart]->images = $this->getImagesByParent($this->tbl_produse_images, $art->id);
         $articole[$keyart]->idhttpcategorie_url = $this->fetchCategorie($art->id_categorie)->idhttp_url;
       }
       return $articole;
     }
     else return false;
   }

   /**
    * GetArticoleRandom
    */
   function GetArticoleRandom($data = null, $limit = 7)
   {
    //  $this->db->select('*');
    //  $query = $this->db->get_where($this->tbl_produse, $data);
    $query = $this->db->query("SELECT * FROM catalog_articole" .(!is_null($data) ? " WHERE `{$data["c"]}` = {$data["v"]}": ""). " ORDER BY RAND() LIMIT 0,{$limit};");

     if($query->num_rows() > 0) {
       $articole = $query->result();
       foreach($articole as $keyart => $art) {
         $articole[$keyart]->images = $this->getImagesByParent($this->tbl_produse_images, $art->id);
         $articole[$keyart]->idhttpcategorie_url = $this->fetchCategorie($art->id_categorie)->idhttp_url;
       }
       return $articole;
     }
     else return false;
   }

	 /**
		* [getImagesByParent description]
		* @param  [type] $table     [description]
		* @param  [type] $id_parent [description]
		* @return [type]            [description]
		*/
	 function getImagesByParent($table, $id_parent)
	 {
		 $query = $this->db->query("SELECT * FROM `" .$table. "` WHERE `id_parent` = " .$id_parent. ";");

		 if($query->num_rows() > 0) return $query->result();
		 else return false;
	 }

	public function getCategorieNumeHref($id) {
		$query = $this->db->query("SELECT denumire_ro, idhttp_url, shit_tipcomanda FROM `" .$this->tbl_catalog. "` WHERE `id` = " .$id. ";");

		if($query->num_rows() > 0) return $query->row();
		else return false;
	}
}
