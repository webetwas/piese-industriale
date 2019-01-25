<?php
class Item_model extends CI_Model {
  private $objname;

  private $i_schema = false;
  private $i_schema_new = null;

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
  }

  private function askRTD($table, $querydata)
  {
    $this->db->select('id');
    $query = $this->db->get_where($table, $querydata);

    if($query->num_rows() > 0) return $query->row();
    else return false;
  }

  public function GetNewRTD($table, $querydata, $insertdata)
  {
    $askRTD = $this->askRTD($table, $querydata);
    if($askRTD) return $askRTD->id;
    else {
      $rtd = $this->msqlInsert($table, $insertdata);
      if($rtd) return $rtd;
      else return false;
    }
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

  public function fetchItem($table = null, $id)
  {
    if(empty($table)) $this->sError("Specify a table", 1);

    if($id) {
      $query = $this->db->query("SELECT * FROM `" .$table. "` WHERE id = " .trim($id). ";");
      if($query->num_rows() > 0) {
        return $query->row();
      } else return false;
    }
  }

  /**
   * [INSItem INSERT An Item]
   * @param [type] $table      [description]
   * @param [type] $formprefix [description]
   * @param [type] $Pattern    [description]
   */
  public function INSItem($table = null, $formprefix = null, $Pattern)
  {
    if(empty($table)) $this->sError("Specify a table", 1);

    /**
     * [$this->GetISCHEMA PrepareDesign]
     * @var [type]
     */ $this->GetISCHEMA($table);
     $this->CDesignBy_ISCHEMA($Pattern);


    $insertArray = array();
    foreach($this->i_schema_new as $column => $Design) {
      /**
       * [$input description]
       * @var [type]
       */ $input = $formprefix.$column;//input name

      if(is_string($Design["newvalue"]) || is_numeric($Design["newvalue"])) {
        $insertArray[$column] = $Design["newvalue"];
      } else {
        // Process _REUQUESTS
        if(!empty($this->input->post("{$input}"))) $insertArray[$column] = trim($this->input->post("{$input}"));//valid Value
        else {
          if(trim($this->input->post("{$input}")) == "0")
            $insertArray[$column] = "0";// catch 0 AS String
          elseif(empty($this->input->post("{$input}")) && $Design["IS_NULLABLE"] == "YES")//set NULL value
            $insertArray[$column] = null;
					elseif(empty($this->input->post("{$input}")) && $Design["COLUMN_DEFAULT"] != null)//set Default value
						$updateArray[$column] = $Design["COLUMN_DEFAULT"];
        }
      }
    }
    // var_dump($insertArray);die();
    return $this->msqlInsert($table, $insertArray);
  }

  /**
   * [UPitem UPDATE An Item]
   * @param  [type] $table      [description]
   * @param  [type] $formprefix [description]
   * @param  [type] $Pattern    [description]
   * @param  [type] $idarray         [description]
   * @return [type]             [description]
   */
  public function UPitem($table = null, $formprefix = null, $Pattern, $idarray)
  {
    if(empty($table)) $this->sError("Specify a table", 1);
    if(empty($idarray)) $this->sError("Error on update Item(idarray missing)", 1);

    /**
     * [$this->GetISCHEMA PrepareDesign]
     * @var [type]
     */ $this->GetISCHEMA($table);
    $this->CDesignBy_ISCHEMA($Pattern);

    /**
     * [$updateArray The DB Data]
     * @var array
     */
    $updateArray = array();
    // var_dump($this->i_schema_new);die();
		// var_dump($this->i_schema_new);die();
    foreach($this->i_schema_new as $column => $Design) {

      /**
       * [$input description]
       * @var [type]
       */ $input = $formprefix.$column;//input name

      if(is_string($Design["newvalue"]) || is_numeric($Design["newvalue"])) {
        $updateArray[$column] = $Design["newvalue"];
      } else {
        // Process _REUQUESTS
        if(!empty($this->input->post("{$input}"))) $updateArray[$column] = trim($this->input->post("{$input}"));//valid Value
        else {
          if(trim($this->input->post("{$input}")) == "0")
            $updateArray[$column] = "0";// catch 0 AS String
          elseif(empty($this->input->post("{$input}")) && $Design["IS_NULLABLE"] == "YES")//set NULL value
            $updateArray[$column] = null;
					elseif(empty($this->input->post("{$input}")) && $Design["COLUMN_DEFAULT"] != null)//set Default value
						$updateArray[$column] = $Design["COLUMN_DEFAULT"];
        }
      }
    }
	// echo '<pre>';
    // var_dump($updateArray);
	// echo '</pre>';

    return $this->msqlUpdate($table, $updateArray, $idarray);
  }

  public function RetrieveAndRemove($table, $data)
  {
    $item = false;
		$item = $this->msqlGet($table, $data);
		if($item) {
			$removeitem = $this->msqlDelete($table, $data);
			if(!$removeitem) return false;
		}
		return $item;
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
	
	public function msqlGetAllIIDS($table, $data = null, $indexby = "id")
	{
		$res = array();
		
		$getdata = $this->msqlGetAll($table, $data);
		if($getdata) {
			foreach($getdata as $gdata) {
				$res[$gdata->{$indexby}] = $gdata;
			}
			return $res;
		} else return false;
	}

  /**
   * [msqlDelete description]
   * @param  [String] $table [description]
   * @param  [Array]  $data  [description]
   * @return [boolean]       [description]
   */
  public function msqlDelete($table, $data)
  {
    $delete = $this->db->delete($table, $data);
		
		if($this->db->affected_rows() > 0)
			return true;

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

  /**
   * [CDesignBy_ISCHEMA description]
   * @param [type] $design [description]
   */
  public function CDesignBy_ISCHEMA($DBPattern)
  {
    if(!$this->i_schema) return false;//verify @schema @design
		// var_dump($this->i_schema);die();
		
    /**
     * [$this->PrepareISCHEMA Preparation of How Data array should looklike]
     * @var [type]
     */ $this->PrepareISCHEMA($DBPattern->design, $DBPattern->type);

    foreach($DBPattern->design as $dnvkey => $dnewval)
      // STRING / INT Values will go straight to the NewValue (as Value defined by System)
      if(is_string($dnewval) || is_numeric($dnewval))
        $this->i_schema_new[$dnvkey]["newvalue"] = $dnewval;
  }

  /**
   * [PrepareISCHEMA description]
   * @param [type] $Pattern [description]
   * @param [type] $Type    [description]
   */
  private function PrepareISCHEMA($Pattern, $Type)
  {
    $newschema = $this->i_schema;//prepare newschema
		
		if(!empty($Pattern))
			foreach($newschema as $keyns => $ns) {
				switch($Type)
				{
					case GET:
						if(isset($Pattern[$keyns]) && !$Pattern[$keyns]) unset($newschema[$keyns]);
					break;
					case PUT:
						if(isset($Pattern[$keyns]) && $Pattern[$keyns]) continue;
						else unset($newschema[$keyns]);
					break;
				}
			}
		// var_dump($newschema);die();
    $this->i_schema_new = $newschema;//assign newschema
  }


  /**
   * [GetISCHEMA description]
   * @param [type] $table [description]
   */
  private function GetISCHEMA($table)
  {
    if(empty($table)) $this->sError("Specify a table", 1);

    $i_schema = array();
    $information_schema = $this->getTableDesign($table);
		// var_dump($information_schema);die();
    if($information_schema)
      foreach($information_schema as $isKey => $is) {
        $is["newvalue"] = true;//assign @newvalue (place for the newest Value that will come from Design)
        $i_schema[$is["COLUMN_NAME"]] = $is;//set index as COLUMN_NAME
      }
    else return false;//designfailed

    $this->i_schema = $i_schema;
		
		// var_dump($this->i_schema);die();
  }

  /**
   * [getTableDesign description]
   * @param  [type] $table [description]
   * @return [type]        [description]
   */
  private function getTableDesign($table = null)
  {
    if(empty($table)) $this->sError("Specify a table", 1);
    $sql = 'SELECT COLUMN_NAME, DATA_TYPE, IS_NULLABLE, COLUMN_DEFAULT,
  	COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
  	WHERE table_name = "' .$table. '" AND table_schema = "' .DATABASE_NAME. '"';

    $query = $this->db->query($sql);
    if($query->num_rows() > 0) return $query->result_array();
    else return false;
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
   * [askLastItem description]
   * @param [type] $table [description]
   */
  public function askLastItem($table = null) {
    if(empty($table)) $this->sError("Specify a table", 1);

    $query = $this->db->query("SELECT * FROM `" .$table. "` WHERE id=(SELECT MAX(id) FROM `" .$table. "`);");
    if($query->num_rows() > 0) {
      $lastitem = $query->row();
      return $lastitem;
    } else return false;
  }

  public function QuestionTrueFalse($table, $column, $id_item) {
    $res = array("status" => 0, "value" => null);

    $query = $this->db->query("SELECT " .$column. " FROM `" .$table. "` WHERE id_item = " .trim(intval($id_item)). ";");
    if($query->num_rows() > 0) {
      if($query->row_array()[$column]) {
        $querychange = $this->db->query("UPDATE `" .$table. "` SET `" .trim($column). "` = 0 WHERE id_item = " .trim(intval($id_item)). ";");
        $value = 0;
      } else {
        $querychange = $this->db->query("UPDATE `" .$table. "` SET `" .trim($column). "` = 1 WHERE id_item = " .trim(intval($id_item)). ";");
        $value = 1;
      }
      if($this->db->affected_rows() > 0) {
        $res["status"] = 1;
        $res["value"] = $value;
      }
    }
    return $res;
  }
  
  public function get_favorit($id_utilizator, $id_produs)
  {
    $query = $this->db->query("SELECT * FROM `shop_favorite` WHERE id_utilizator = " .$id_utilizator. " AND id_produs = " .$id_produs. ";");
	
    if($query->num_rows() > 0) {
      return $query->row();
    } else return false;	  
  }
  
  public function get_favorite($id_utilizator)
  {
    $query = $this->db->query("SELECT * FROM `shop_favorite` WHERE id_utilizator = " .$id_utilizator. ";");
	
    if($query->num_rows() > 0) {
      return $query->result();
    } else return false;	  
  }
  
  public function insert_favorit($id_utilizator, $id_produs)
  {
    
	return $query = $this->db->query("INSERT INTO `shop_favorite` SET id_utilizator = " .$id_utilizator. ", id_produs = " .$id_produs. ";");
  }
  
  public function get_optiuni_material_culoare($string)
  {
	  $query = $this->db->query("SELECT * FROM `optiuni_material_culori` WHERE id IN(" .$string. ");");
	  
		if($query->num_rows() > 0) {
		  return $query->result();
		} else return false;
  }
  
  public function get_optiuni_produs($string)
  {
	  $query = $this->db->query("SELECT * FROM `optiuni_produs` WHERE atom_id IN(" .$string. ");");
	  
		if($query->num_rows() > 0) {
		  return $query->result();
		} else return false;
  }
}
