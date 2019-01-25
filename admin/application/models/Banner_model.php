<?php
class Banner_model extends CI_Model {

	private $tbl_banners_page;
	
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
		
		$this->tbl_banners_page = TBL_PAGES_BANNERS;
  }

  /**
   * [fetchWithRefIndex description]
   * @param  [type] $table     [description]
   * @param  [type] $querydata [description]
   * @return [Array]           [Associative array by @ref]
   */
  public function fetchAssocByRef($table, $querydata) {
    $res = array();

    $this->db->select('id, img, img_ref, titlu, subtitlu, text, href1, thref1, href2, thref2');
    $query = $this->db->get_where($table, $querydata);

    if($query->num_rows() > 0) {
      foreach($query->result() as $result)
        $res[$result->img_ref] = $result;
      return $res;
    } else return false;
  }
	
	public function updateBannerFDATA($data, $conditions)
	{
		if(is_array($conditions) && !empty($conditions))
		foreach($conditions as $keycond => $cond) {
			// $this->db->where('id', intval($idarray));
			$this->db->where($keycond, $cond);
		}
		
		$this->db->update($this->tbl_banners_page, $data);
		
    // if($this->db->affected_rows() > 0) return true;
    return true;
	}
}
