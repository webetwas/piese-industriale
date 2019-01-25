<?php
class Pagini_model extends CI_Model {

  private $tbl_pages;
	private $tbl_structura;
  private $tbl_pages_images;
	private $tbl_banners_page;


  public function __construct()
  {
    $this->tbl_pages = TBL_PAGES;
		$this->tbl_structura = TBL_PAGES_STRUCTURE;
    $this->tbl_pages_images = TBL_PAGES_IMAGES;
		$this->tbl_banners_page = TBL_PAGES_BANNERS;

    parent::__construct();
    // Your own constructor code
  }

  /**
   * [GetPage description]
   * @param [type] $id_page [description]
   */
  public function GetPage($id_page)
  {
    $res = (object) ["p" => null, "i" => null, "s" => null, "b" => null];

    $page = $this->getPageById_Page($id_page);
    if($page) {
			$res->p = $page;
			
			$structura = $this->getPageStructura($page->id);
			if($structura) $res->s = $structura;
			
			$images = $this->getImagesByIdPage($page->id);
			if($images) $res->i = $images;
			
			$banners = $this->fetchBannersAssocByRef(array("idpage" => $page->id));
			if($banners) $res->b = $banners;
		} else return false;

    return $res;
  }
 
  /**
   * [GetPage description]
   * @param [type] $id_page [description]
   */
  public function GetPageBySlug($slug)
  {
    $res = (object) ["p" => null, "i" => null, "s" => null, "b" => null];

    $page = $this->getPageBySlug_Page($slug);
    if($page) {
			$res->p = $page;
			
			$structura = $this->getPageStructura($page->id);
			if($structura) $res->s = $structura;
			
			$images = $this->getImagesByIdPage($page->id);
			if($images) $res->i = $images;
			
			$banners = $this->fetchBannersAssocByRef(array("idpage" => $page->id));
			if($banners) $res->b = $banners;
		} else return false;

    return $res;
  }
	
	
  /**
   * [fetchWithRefIndex description]
   * @param  [type] $table     [description]
   * @param  [type] $querydata [description]
   * @return [Array]           [Associative array by @ref]
   */
  public function fetchBannersAssocByRef($querydata) {
    $res = array();

    $this->db->select('*');
	$this->db->order_by("img_ref", "asc");
    $query = $this->db->get_where($this->tbl_banners_page, $querydata);

    if($query->num_rows() > 0) {
      foreach($query->result() as $result)
        $res[$result->img_ref] = $result;
      return $res;
    } else return false;
  }	

  /**
   * [getPageById_Page description]
   * @param  [type] $id_page [description]
   * @return [type]          [description]
   */
  private function getPageById_Page($id_page)
  {
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_pages. "` WHERE `id_page` = '" .$id_page. "';");

    if($query->num_rows() > 0) {
      return $query->row();
    }
    else return false;
  }
  
  /**
   * [getPageById_Page description]
   * @param  [type] $id_page [description]
   * @return [type]          [description]
   */
  private function getPageBySlug_Page($slug)
  {
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_pages. "` WHERE `slug` = '" .$slug. "';");

    if($query->num_rows() > 0) {
      return $query->row();
    }
    else return false;
  }

	public function getPageStructura($idpage)
	{
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_structura. "` WHERE `idpage` = '" .$idpage. "';");

    if($query->num_rows() > 0) {
      return $query->row();
    }
    else return false;		
	}
	
  /**
   * [getImagesByIdPage description]
   * @param  [type] $idpage [description]
   * @return [type]         [description]
   */
  private function getImagesByIdPage($idpage)
  {
    $query = $this->db->query("SELECT * FROM `" .$this->tbl_pages_images. "` WHERE `idpage` = '" .$idpage. "' ORDER BY `id` ASC;");

    if($query->num_rows() > 0) {
      return $query->result();
    }
    else return false;
  }
}
