<?php
class Chain_model extends CI_Model {
  private $objname;

  private $tbl_chain_links = null;
	
	private $tbl_obj_content = null;

  /**
   * [__construct description]
   */
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    $this->objname = get_class($this);//Controller

    $this->tbl_chain_links = TBL_CHAIN_LINKS;
		$this->tbl_obj_content = TBL_OBJ_CONTENT;
  }
	
	/**
	 * getChildrensOf
	 *
	 * Gettings Childrens of a Link
	 * First Children and his next Children
	 *
	 * Total of 2 beside the Link you given
	 */
	public function getChildrensOf($id_link)
	{
		$childrens = $this->msqlGetAll($this->tbl_chain_links, array("id_parent" => $id_link));
		if($childrens) {
			foreach($childrens as $childkey => $child) {
				$nextchildrens = $this->msqlGetAll($this->tbl_chain_links, array("id_parent" => $child->id_link));
				
				if($nextchildrens) {
					$childrens[$childkey]->childrens = $nextchildrens;
				}
			}
			
			return $childrens;
		}
		
		return false;
	}
	
	/**
	 * deleteChildrenOf
	 */
	public function deleteChildrensxContentOf($id_link)
	{
		$res = true;
		$childrens = $this->getChildrensOf($id_link);
		if($childrens) {
			foreach($childrens as $child) {
				$deletechild = $this->_Item->msqlDelete($this->tbl_chain_links, array("id_link" => $child->id_link));//deleteLink
				if($deletechild) {
					
					$deletecontentitems = $this->_Item->msqlDelete($this->tbl_obj_content, array("id_link" => $child->id_link));//deleteContentItems
				} else return false;
				
				if($child->childrens) {
					foreach($child->childrens as $child) {
						$deletechild = $this->_Item->msqlDelete($this->tbl_chain_links, array("id_link" => $child->id_link));//deleteLink
						if($deletechild){
							
							$deletecontentitems = $this->_Item->msqlDelete($this->tbl_obj_content, array("id_link" => $child->id_link));//deleteContentItems
						} else return false;
					}
				}
			}
		}
		
		return $res;
	}
	
	/**
	 * deleteLinkxContentOf
	 */
	public function deleteLinkxContentOf($id_link)
	{
		$deletelink = $this->_Item->msqlDelete($this->tbl_chain_links, array("id_link" => $id_link));//deleteLink
		if($deletelink) {
			
			$deletecontentitems = $this->_Item->msqlDelete($this->tbl_obj_content, array("id_link" => $id_link));//deleteContentItems
		} else return false;
		
		return true;
	}
	
	public function getLinksByAnObjectItem($id_object, $id_item)
	{
		$sql = "SELECT {$this->tbl_obj_content}.idcontent_object, {$this->tbl_obj_content}.id_object, {$this->tbl_obj_content}.id_item, {$this->tbl_obj_content}.id_link, {$this->tbl_chain_links}.denumire_ro FROM `{$this->tbl_obj_content}`
			LEFT JOIN `{$this->tbl_chain_links}` ON {$this->tbl_chain_links}.id_link = {$this->tbl_obj_content}.id_link
			WHERE {$this->tbl_obj_content}.id_object = {$id_object} AND {$this->tbl_obj_content}.id_item = {$id_item};";
			
    $query = $this->db->query($sql);
    if($query->num_rows() > 0)
      return $query->result();
    
		return false;
	}
	
	public function getIIDS_LinksByAnObjectItem($id_object, $id_item)
	{
		$array_idlinks = array();
		
		$links = $this->getLinksByAnObjectItem($id_object, $id_item);
		if($links) {
			foreach($links as $keylink => $link)
				$array_idlinks[$link->id_link] = $link;
			
			return $array_idlinks;
		}
		
		return false;
	}
	
	
  /**
   * getParentByIdLink
   */
	public function getParentByIdLink($id_link)
	{
		$category = $this->msqlGet($this->tbl_chain_links, array("id_link" => $id_link));
		if($category) return $category;
		
		return false;
	}	
	
  /**
   * getAllLinks
   */
	public function getAllLinks()
	{
		$links = $this->msqlGetAll($this->tbl_chain_links);
		if($links) return $links;
		
		return false;
	}
	
  /**
   * getAllLinksByParent
   */	
	public function getAllLinksByParent($id_parent)
	{
		$links = $this->msqlGetAll($this->tbl_chain_links, array("id_parent" => $id_parent));
		if($links) return $links;
		
		return false;		
	}
	
  /**
   * MapAllLinks
   */
  function MapAllLinks()
	{
    $strs_a = $this->getAllLinksByParent(0);
		if($strs_a)
			foreach($strs_a AS $keystr_a => $str_a) {
				$strs_a[$keystr_a]->strs_b = null;//createemptynewstrs_B

				$strs_b = $this->getAllLinksByParent($str_a->id_link);
				if($strs_b) {
					$strs_a[$keystr_a]->strs_b = $strs_b;//passcategoriestoparent_B
					foreach($strs_a[$keystr_a]->strs_b AS $keystr_b => $str_b) {
						$strs_a[$keystr_a]->strs_b[$keystr_b]->strs_c = null;//createemptynewstrs_C

						$strs_c = $this->getAllLinksByParent($str_b->id_link);
						if($strs_c) {
							$strs_a[$keystr_a]->strs_b[$keystr_b]->strs_c = $strs_c;//passcategoriestoparent_C
						}
					}
				}
			}
    return $strs_a;
  }	
	
	
  /**
   * [msqlGet description]
   * @param  [type] $table [description]
   * @param  [type] $data  [description]
   * @return [type]        [description]
   */
  private function msqlGet($table, $data)
	{
		foreach($data as $keyd => $d)
			$this->db->where($keyd, $d);
    $query = $this->db->get($table);

    if($query->num_rows() > 0) return $query->row();
    return false;
	}

  /**
   * [msqlGetAll description]
   * @param  [type] $table [description]
   * @param  [type] $data  [description]
   * @return [type]        [description]
   */
  public function msqlGetAll($table, $data = null)
	{
		if(!is_null($data))
		foreach($data as $keyd => $d)
			$this->db->where($keyd, $d);
		
    $query = $this->db->get($table);

    if($query->num_rows() > 0) return $query->result();
    return false;
	}

  /**
   * [msqlDelete description]
   * @param  [String] $table [description]
   * @param  [Array]  $data  [description]
   * @return [boolean]       [description]
   */
  public function msqlDelete($table, $data)
  {
    $this->db->delete($table, $data);

    if($this->db->affected_rows() > 0) return true;
    return false;
  }


  /**
   * [msqlInsert description]
   * @param  [type] $table [description]
   * @param  [type] $data  [description]
   * @return [boolean]     [description]
   */
  public function msqlInsert($table, $data)
  {
    $insert = $this->db->insert($table, $data);
    if($insert) return $this->db->insert_id();
    else return false;
  }

  /**
   * [msqlUpdate description]
   * @param  [type] $table [description]
   * @param  [type] $data  [description]
   * @param  [type] $idarray    [description]
   * @return [boolean]     [description]
   */
  public function msqlUpdate($table, $data, $idarray)
  {
    if(empty($table)) $this->sError("Specify a table", 1);

    if(!is_array($idarray)) $this->db->where('id', intval($idarray));
		elseif(is_array($idarray)) $this->db->where($idarray["c"], intval($idarray["v"]));
    $this->db->update($table, $data);

    if($this->db->affected_rows() > 0) return true;
    return false;
  }
}
