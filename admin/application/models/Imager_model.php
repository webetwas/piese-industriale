<?php
class Imager_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();// Your own constructor code
		
		$this->load->helper('imager');
		$this->load->helper('string');
	}
	
	public function get_page_structure($idpage)
	{
		$query = $this->db->query("SELECT * FROM `" .TBL_PAGES_STRUCTURE. "` WHERE idpage = '" .$idpage. "';");

		if($query->num_rows() > 0)
		return $query->row();

		return false;		
	}
	
	public function get_air($air_id)
	{
		$query = $this->db->query('SELECT * FROM `' .TBL_AIRS. '` WHERE air_id = ' . (int)$air_id . ';');
		
		if($query->num_rows() == 1)
		{
			return $query->row();
		}
		
		return false;		
	}
	
	public function deleteimages($data)
	{
		$air = $this->get_air($data->air_id);
		
		$delete = $this->RetrieveAndRemove($air->air_table_img, array('id' => $data->id));
		
		if($delete)
		{
			$path = '../web/public/upload/img/' . $air->air_path_img. '/';
			deletefile($path, $delete->img, array("s" => true, "m" => true, "l" => true));
			return true;
		}
	}
	
	/**
	 *  Creating full set of images
	 *
	 *  @param $air_id
	 *  @param $imager
	 *  @param $data
	 *
	 */
	public function upcreateimages($data)
	{
		$air = $this->get_air($data->air_id);

		$imager = json_decode($data->imager);
		
		$image = $this->create_image_name();
		
		$path = '../web/public/upload/img/' . $air->air_path_img;
		foreach($imager as $key => $imager_size)
		{
			if($imager_size->size == "l")
			{
				$main_image = false;
				
				$path_by_size_main = $path . '/' . $imager_size->size;
				if(!($temp_upload_main = croppie_upload_image('data', $path_by_size_main, $image)))
				{
					break;
				}
			} else {
				$path_by_size = $path . '/' . $imager_size->size;
				$temp_upload = upload_by_data($temp_upload_main, $path_by_size, $image . '.jpg', $imager_size->height, $imager_size->width, false);
			}
		}
		$data_insert = array('id_item' => $data->atom_id, 'img_ref' => 'poza', 'img' => $image . '.jpg');
		$insert = $this->insert_image($air->air_table_img, $data_insert);
		
		return array('id' => $insert, 'img' => $image . '.jpg');
	}
	
	private function create_image_name($add_extension = false)
	{
		$type = $_FILES['data']['type'];
		$extension = null;
		
		if($add_extension)
		{
			if ($type == "image/jpeg" || $type == "image/pjpeg")
				$extension = '.jpg';
			elseif($type == "image/png")
				$extension = '.png';
			else return false;			
		}
		
		return 'image-' . date('YmdHis') . $extension;
	}
	
	public function get_images_sizes($idpage, &$return)
	{
		
		$result = array();
		
		$structure = $this->get_page_structure($idpage);
		if(!$structure)
			return false;
		
		if(!empty($structure->image_lh) && $structure->image_lh
			&& !empty($structure->image_lw) && $structure->image_lw
		)
		{
			$result[] = (object) [ 'size' => 'l', 'height' => $structure->image_lh, 'width' => $structure->image_lw, "selected" => false ];
			$result[] = (object) [ 'size' => 'm', 'height' => $structure->image_mh, 'width' => $structure->image_mw, "selected" => false ];
			$result[] = (object) [ 'size' => 's', 'height' => $structure->image_sh, 'width' => $structure->image_sw, "selected" => false ];
			$return = true;
		}
		elseif(!empty($structure->image_mh) && $structure->image_mh
			&& !empty($structure->image_mw) && $structure->image_mw
		)
		{
			$result[] = (object) [ 'size' => 'm', 'height' => $structure->image_mh, 'width' => $structure->image_mw, "selected" => false ];
			$result[] = (object) [ 'size' => 'l', 'height' => $structure->image_lh, 'width' => $structure->image_lw, "selected" => false ];
			$result[] = (object) [ 'size' => 's', 'height' => $structure->image_sh, 'width' => $structure->image_sw, "selected" => false ];
			$return = true;			
		}
		elseif(!empty($structure->image_sh) && $structure->image_sh
			&& !empty($structure->image_sw) && $structure->image_sw
		)
		{
			$result[] = (object) [ 'size' => 's', 'height' => $structure->image_sh, 'width' => $structure->image_sw, "selected" => false ];
			$result[] = (object) [ 'size' => 'm', 'height' => $structure->image_mh, 'width' => $structure->image_mw, "selected" => false ];
			$result[] = (object) [ 'size' => 'l', 'height' => $structure->image_lh, 'width' => $structure->image_lw, "selected" => false ];
			$return = true;
		}
		
		return $result;
	}
	
	public function insert_image($table, $data)
	{
		$insert = $this->db->insert($table, $data);
		if($insert)
			return $this->db->insert_id();
		else return false;		
	}
	
	
	// workaround
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
	public function msqlGet($table, $data)
	{
		foreach($data as $keyd => $d)
			$this->db->where($keyd, $d);
		$query = $this->db->get($table);

		if($query->num_rows() > 0) return $query->row();
		return false;
	}
	public function msqlDelete($table, $data)
	{
		$delete = $this->db->delete($table, $data);
		
		if($this->db->affected_rows() > 0)
			return true;

		return false;
	}
}