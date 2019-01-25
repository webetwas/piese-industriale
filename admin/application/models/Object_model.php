<?php
class Object_model extends CI_Model {
  private $objname;

	// private $tbl_chain_links = null;
	
  private $tbl_obj_objects = null;
  private $tbl_obj_content = null;
  
  private $tbl_chain_links = null;
	
	public $idcontent_object = null;

  /**
   * [__construct description]
   */
  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    $this->objname = get_class($this);//Controller

		// $this->tbl_chain_links = TBL_CHAIN_LINKS;
		
    $this->tbl_obj_objects = TBL_OBJ_OBJECTS;
    $this->tbl_obj_content = TBL_OBJ_CONTENT;
    
    $this->tbl_chain_links = TBL_CHAIN_LINKS;
  }
	
  /**
   * getUnchainedObjets
   */
  public function getUnchainedObjets($table)
  {
    
    $sql = "SELECT {$this->tbl_obj_content}.id_link, {$table}.* FROM `{$table}`
      LEFT JOIN `{$this->tbl_obj_content}` ON {$this->tbl_obj_content}.id_object = {$table}.id_object
      AND ({$this->tbl_obj_content}.id_item = {$table}.id_item)
      WHERE id_link IS NULL;";
      
    $query = $this->db->query($sql);
    if($query->num_rows() > 0)
      return $query->result();
    
    return false;
  }
  
  /**
   * getObjectsSecondTableTransformedASItem
   *
   * params Array @items
   * params String @secondtable
   *
   */
  public function getObjectsSecondTableTransformedASItem($items = array(), $secondtable)
  {
    
    $res = array();
    
    if(!empty($items)) {
      foreach($items as $keyitem => $item) {
        
        $res[$keyitem] = (object) [
          'item' => $item
        ];
        $res[$keyitem]->item->images = $this->msqlGetAll($secondtable, array("id_item" => $item->id_item));
      }
      
      return $res;
    }
    
    return false;
  }
  
	/**
	 * getContentItemsFull
	 *
	 */
	public function getContentItemsFull($obj_name, $unique_id)
	{
		$object = $this->getObjectStructureByObjName($obj_name);
		$link = $this->msqlGet($this->tbl_chain_links, array("unique_id" => $unique_id));
		
		if($object && $link) {
			$getContentItemsStructure = $this->getContentItemsStructure($object->id_object, $link->id_link, $object->obj_table);
			
			if($getContentItemsStructure) {
				foreach($getContentItemsStructure as $keys => $s) {
					// Get Items
					$getContentItemsStructure[$keys]->item = $this->msqlGet($object->obj_table, array("id_item" => $s->id_item, "item_isactive" => 1));
					
					// Get Item's Images if Object's table_img is defined
					if(!is_null($object->obj_table_img))
						$getContentItemsStructure[$keys]->item->images = $this->msqlGetAll($object->obj_table_img, array("id_item" => $s->id_item));
				}
				return $getContentItemsStructure;
			} else return false;
		} else return false;
	}
  
	/**
	 * getObjectStructure
	 */
	public function getObjectStructureByObjName($obj_name)
	{
		$object = $this->msqlGet($this->tbl_obj_objects, array("obj_name" => trim(strtolower($obj_name))));
		
		return $object;
	}
  
	public function getContentItemsStructure($id_object, $id_link, $table_items)
	{
		$one_condition = "";
		if($table_items == "menuri") $one_condition = ", {$table_items}.i_idhtml, {$table_items}.fullpath";
		
		$sql = "SELECT {$this->tbl_obj_objects}.obj_controller, {$this->tbl_obj_objects}.obj_table, {$this->tbl_obj_objects}.obj_name,
			{$this->tbl_obj_content}.idcontent_object, {$this->tbl_obj_content}.orderby, {$this->tbl_obj_content}.id_object, {$this->tbl_obj_content}.id_item, {$this->tbl_obj_content}.id_link,
			{$table_items}.item_name, {$table_items}.item_parent_fake, {$table_items}.item_isactive {$one_condition}
			FROM `{$this->tbl_obj_content}`
			LEFT JOIN `{$this->tbl_obj_objects}` ON {$this->tbl_obj_objects}.id_object = {$this->tbl_obj_content}.id_object
			LEFT JOIN `{$table_items}` ON {$table_items}.id_item = {$this->tbl_obj_content}.id_item
			WHERE {$this->tbl_obj_content}.id_object = {$id_object}
			AND {$this->tbl_obj_content}.id_link = {$id_link} AND {$table_items}.item_isactive != 0 ORDER BY {$this->tbl_obj_content}.orderby";
			
		$query = $this->db->query($sql);
    if($query->num_rows() > 0) return $query->result();
    
		return false;			
	}
  
  /**
   * getAUTO_INCREMENT
   */
  public function getAUTO_INCREMENT($table)
  {
    
    $sql = 'SELECT AUTO_INCREMENT
      FROM information_schema.TABLES
      WHERE TABLE_SCHEMA = "' .DATABASE_NAME. '"
      AND TABLE_NAME = "' .$table. '"';
      
		$query = $this->db->query($sql);
    if($query->num_rows() > 0) return $query->row();
    
		return false;	
  }
  
	public function getAllObjects()
	{
		return $this->msqlGetAll($this->tbl_obj_objects);
	}
	
	public function getContentItemsByIdObjectxIdLink($id_object, $id_link)
	{
		return $this->msqlGetAll($this->tbl_obj_content, array("id_object" => $id_object, "id_link" => $id_link));
	}
	
	/**
	 * updateContentItemOrder
	 */
	public function updateContentItemOrder($idcontent_object, $orderby)
	{
		
		return $this->msqlUpdate($this->tbl_obj_content, array("orderby" => $orderby), array("c" => "idcontent_object", "v" => $idcontent_object));
	}
	

	public function getObjectsXContentByIdLink($id_link)
	{
		$objects = $this->getAllObjects();
		
		if($objects) {
			foreach($objects as $keyobj => $obj) {
				$items = $this->getContentItems($obj->id_object, $id_link, $obj->obj_table);
				if($items) $objects[$keyobj]->items = $items;
			}
			
			return $objects;
		}
		
		return false;
	}
	
	public function getContentItems($id_object, $id_link, $table_items)
	{
		$sql = "SELECT {$this->tbl_obj_objects}.obj_controller, {$this->tbl_obj_objects}.obj_table, {$this->tbl_obj_objects}.obj_name,
			{$this->tbl_obj_content}.idcontent_object, {$this->tbl_obj_content}.orderby, {$this->tbl_obj_content}.id_object, {$this->tbl_obj_content}.id_item, {$this->tbl_obj_content}.id_link,
			{$table_items}.item_name, {$table_items}.item_parent_fake
			FROM `{$this->tbl_obj_content}`
			LEFT JOIN `{$this->tbl_obj_objects}` ON {$this->tbl_obj_objects}.id_object = {$this->tbl_obj_content}.id_object
			LEFT JOIN `{$table_items}` ON {$table_items}.id_item = {$this->tbl_obj_content}.id_item
			WHERE {$this->tbl_obj_content}.id_object = {$id_object}
			AND {$this->tbl_obj_content}.id_link = {$id_link} ORDER BY {$this->tbl_obj_content}.orderby";
			
		$query = $this->db->query($sql);
    if($query->num_rows() > 0) return $query->result();
    
		return false;	
	}
	
	/**
	 * getObjectStructure
	 */
	public function getObjectStructure($controller)
	{
		$object = $this->msqlGet($this->tbl_obj_objects, array("obj_controller" => trim(strtolower($controller))));
		
		return $object;
	}
  
	/**
	 * getObjectStructure
	 */
	public function getDataObject($id_object)
	{
		$object = $this->msqlGet($this->tbl_obj_objects, array("id_object" => $id_object));
		
		return $object;
	}
	
	public function InsertContent($id_object, $id_item, $id_link)
	{
		$insert = $this->msqlInsert($this->tbl_obj_content, array("id_object" => $id_object, "id_item" => $id_item, "id_link" => $id_link));
		if($insert) {
			$this->idcontent_object = $insert;
			
			return true;
		}
		
		return false;
	}
	
	public function DeleteContent($id_object, $id_item, $id_link)
	{
		$getcontent = $this->msqlGet($this->tbl_obj_content, array(
			"id_object" => $id_object,
			"id_item" => $id_item,
			"id_link" => $id_link
		));
		if($getcontent) {
			$delete = $this->msqlDelete($this->tbl_obj_content, array(
					"idcontent_object" => $getcontent->idcontent_object
				)
			);
			
			if($delete) return true;
		}
		
		return false;
	}
	
	/**
	 * DeleteItemContent
	 */
	public function DeleteContentByItem($id_object, $id_item)
	{
		return $this->msqlDelete($this->tbl_obj_content, array("id_object" => $id_object, "id_item" => $id_item));
	}
	
	public function getObjectContentByIdLink($id_link)
	{
		$content = $this->msqlGetAll($this->tbl_obj_content, array("id_link" => $id_link));
		
		return $content;
	}
	
  /**
   * [msqlGet description]
   * @param  [type] $table [description]
   * @param  [type] $data  [description]
   * @return [type]        [description]
   */
  public function msqlGet($table, $data)
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
    $update = $this->db->update($table, $data);

    if($update) return true;
    return false;
  }
	
}
