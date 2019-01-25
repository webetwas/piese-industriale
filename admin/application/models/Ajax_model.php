<?php
class Ajax_model extends CI_Model {
  private $objname;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    $this->objname = get_class($this);//Controller
  }

  /**
   * [ToggleTT Togle True False]
   * @param [type] $id [description]
   */
  public function ToggleTT($table = null, $id) {
    if(empty($table)) $this->sError("Specify a table", 1);
    if(empty($id)) $this->sError("Error on update Item(id missing)", 1);
    $res = array("status" => 1, "truefalse" => null);

    $truefalse = null;
    $getvalue = $this->askForValue($table, $id);
    if(!is_null($getvalue)) {
      if($getvalue) $truefalse = $this->updateItem($table, array("truefalse" => 0), $id);//updatefalse
      elseif(!$getvalue) $truefalse = $this->updateItem($table, array("truefalse" => 1), $id);//updatetrue
    }
    if(!is_null($truefalse)) {
      $res["status"] = 1;
      $res["truefalse"] = $truefalse;
    }
    return $res;
  }

  /**
   * [askForValue description]
   * @param  [type] $table [description]
   * @param  [type] $id    [description]
   * @return [type]        [description]
   */
  private function askForValue($table, $id)
  {
    $query = $this->db->query("SELECT truefalse FROM `" .$table. "` WHERE id = " .$id. ";");
    if($query->num_rows() > 0) return intval($query->row()->truefalse);
    return null;
  }

  /**
   * [updateItem description]
   * @param  [type] $table [description]
   * @param  [type] $data  [description]
   * @param  [type] $id    [description]
   * @return [type]        [description]
   */
  public function updateItem($table, $data, $id)
  {
    $item = false;
    $item = $this->getItem($table, array("id" => $id));
    if($item) {
      $this->db->where('id', $id);
      $this->db->update($table, $data);
      if($this->db->affected_rows() > 0) return $item;
    }
    return $item;;
  }

  public function DeleteItem($table, $data = array())
  {
    if(empty($table)) $this->sError("Specify a table", 1);
    if(empty($data)) $this->sError("Specify Data Array", 1);

		$item = false;
		$item = $this->getItem($table, $data);
		if($item) {
			$removeitem = $this->removeItem($table, $data);
			if(!$removeitem) return false;
		}
		return $item;
  }

  public function removeItem($table, $data)
  {
		foreach($data as $keyd => $d)
			$this->db->where($keyd, $d);
    $this->db->delete($table, $data);

    if($this->db->affected_rows() > 0) return true;
    return false;
  }

	private function insertItem($table, $data)
	{
    $this->db->insert($table, $data);

    if($this->db->affected_rows() > 0) return $this->db->insert_id();
    return false;
	}

	public function PutItem($table, $data)
	{
    if(empty($table)) $this->sError("Specify a table", 1);
    if(empty($data)) $this->sError("Specify a table", 1);

		$insert = $this->insertItem($table, $data);
		return $insert;
	}

	private function getItem($table, $data)
	{
		foreach($data as $keyd => $d)
			$this->db->where($keyd, $d);
    $query = $this->db->get($table);

    if($query->num_rows() > 0) return $query->row();
    return false;
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
}
