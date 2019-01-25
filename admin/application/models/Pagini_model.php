<?php
class Pagini_model extends CI_Model {

  private $id = null;

	private $tbl_pages_structure = TBL_PAGES_STRUCTURE;
  private $tbl_pages = TBL_PAGES;
  private $tbl_pages_images = TBL_PAGES_IMAGES;
  private $tbl_pages_banners = TBL_PAGES_BANNERS;


  public function __construct()
  {
    parent::__construct();// Your own constructor code
  }

	/**
	 * GetPagina
	 *
	 * @s - fe_pages_structure
	 * @p - fe_pages
	 * @i - fe_pages_images
	 * @b - fe_pages_banners AS null (Use Banners model to assign data)
	 */
  public function GetPagina($id)
  {
    $res = array("s" => null, "p" => null, "i" => null, "b" => null);

    $page = $this->getPageById($id);
    if($page) {
      $this->id = $page->id;//@id
      $res["p"] = $page;//assign@p
			
			$structure = $this->getStructure();
			if($structure) $res["s"] = $structure;//assign@s
			$images = $this->getImages();
			if($images) $res["i"] = $images;//assign@i
    } else return false;
		
		return $res;
  }

  private function getPageById($id)
  {
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_pages. "` WHERE id = '" .$id. "';");

    if($query->num_rows() > 0) {
      return $query->row();
    }
    else return false;
  }
	
	public function getStructure($return = "obj", $id = null)
	{
		if(is_null($id)) $id = $this->id;
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_pages_structure. "` WHERE idpage = '" .$id. "';");

    if($query->num_rows() > 0)
			if($return == "obj") return $query->row();
      elseif($return == "array") return $query->row_array();
			
		return false;	
	}

  private function getImages()
  {
		
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_pages_images. "` WHERE idpage = '" .$this->id. "';");

    if($query->num_rows() > 0) {
      return $query->result();
    }
    else return false;
  }

  private function getBanners()
  {
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_pages_banners. "` WHERE idpage = '" .$this->id. "';");

    if($query->num_rows() > 0) {
      return $query->result();
    }
    else return false;
  }

  public function UpdatePage($id_page, $title_ro, $browser_title_ro, $keywords, $meta_description, $content_ro, $poza_s, $poza_m, $poza_l)
  {
    $this->updatePagecore($id_page, $title_ro, $browser_title_ro, $keywords, $meta_description, $content_ro);

    if(!is_null($poza_s)) {
      $this->insertImageByPage($id_page, $poza_s, $poza_m, $poza_l);
    }
  }

  private function updatePagecore($id_page, $title_ro, $browser_title_ro, $keywords, $meta_description, $content_ro)
  {
    $query = $this->db->query("UPDATE `" .$this->tbl_pagini. "` SET `title_ro` = '{$title_ro}', `browser_title_ro` = '{$browser_title_ro}', `keywords` = '{$keywords}', `meta_description` = '{$meta_description}', `content_ro` = '{$content_ro}' WHERE id_page = '" .$id_page. "';");

   if($this->db->affected_rows() > 0) return true;
   else return false;
  }

  private function insertImageByPage($id_page, $poza_s, $poza_m, $poza_l)
  {
    $query = $this->db->query("INSERT INTO `" .$this->tbl_imagini. "` (id_page, poza_s, poza_m, poza_l) VALUES ('" .$id_page. "', '" .$poza_s. "', '".$poza_m."', '".$poza_l."');");
    if($query) return true;
    else return false;
  }

  public function deleteImage($id) {
    $query = $this->db->query("DELETE FROM `" .$this->tbl_imagini. "` WHERE id = " .$id. ";");

   if($this->db->affected_rows() > 0) return true;
   else return false;
  }
	
	public function getSlugs($anyslug_id = null)
	{
		
		$sql = "SELECT id_page FROM `" .$this->tbl_pages. "`";
		if(!is_null($anyslug_id))
			$sql .= " WHERE id != {$anyslug_id}";
		
    $query = $this->db->query($sql);

    if($query->num_rows() > 0) {
			
			$r = array();
			
      $res = $query->result_array();
			foreach($res as $slug) {
				
				$r[] = $slug["id_page"];
			}
			
			return $r;
    }
    else return null;		
	}
	
	public function insertStructure($idpage)
	{
		
    $query = $this->db->query("INSERT INTO `" .$this->tbl_pages_structure. "` (idpage, is_active, is_page, filehtml, filejs) VALUES ('" .$idpage. "', 1, 1, 'pagina', 'js_pagina');");
    if($query) return true;
    else return false;		
	}
	
	public function RemovePage($idpage)
	{
		
		$delete_p = $this->db->query("DELETE FROM `" .$this->tbl_pages. "` WHERE id = " .$idpage. ";");
		
		if($this->db->affected_rows() > 0) {
			
			$delete_s = $this->db->query("DELETE FROM `" .$this->tbl_pages_structure. "` WHERE idpage = " .$idpage. ";");
			
			if($this->db->affected_rows() > 0)
				return true;
		}
		return false;
	}
}
