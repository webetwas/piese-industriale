<?php
class Application_model extends CI_Model {

  private $tbl_pages = TBL_PAGES;
	private $tbl_pages_structure = TBL_PAGES_STRUCTURE;

  public function __construct()
  {
  	parent::__construct();
  	// Your own constructor code

  }

  /**
   * [getStatus description]
   * @return [type] [description]
   */
  public function getStatus() {
    $application = (object) ["mainapp" => (object) ["app" => MAIN_APP, "ver" => MAIN_APP_VER], "coreapp" => (object) ["app" => CORE_APP, "ver" => CORE_APP_VER]];
    return $application;
  }

  /**
   * [listPages description]
   * @param  boolean $is_active [description]
   * @return [type]             [description]
   */
  public function listPages($is_active) {
    $query = $this->db->query("
		SELECT {$this->tbl_pages}.id, {$this->tbl_pages}.id_page, {$this->tbl_pages_structure}.is_active, {$this->tbl_pages_structure}.is_page, {$this->tbl_pages}.title, {$this->tbl_pages}.title_ro, {$this->tbl_pages}.title_browser_ro FROM `" .$this->tbl_pages. "`
		LEFT JOIN `{$this->tbl_pages_structure}` ON {$this->tbl_pages_structure}.idpage = {$this->tbl_pages}.id
		WHERE {$this->tbl_pages_structure}.is_active = " .$is_active. ";");

    if($query->num_rows() > 0) {
      return $query->result();
    }
    else return false;
  }
  
  public function getCereriProduse()
  {
	  $query = $this->db->query("SELECT * FROM catalog_produse_cereri WHERE seen = 0");
	  
		return $query->num_rows();
  }
}
