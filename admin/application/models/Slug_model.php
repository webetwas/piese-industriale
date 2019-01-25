<?php
class Slug_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code
		
		$this->load->helper('text');
	}
	
	public function slug_it($table, $string, $has_slug = false)
	{
		if($has_slug)
		{
			if($this::slug_create($string) == $has_slug)
			{
				return false;
			}
		}
		
		return $this::slug_create
		(
			$string,
			$this::get_slugs($table, $this::slug_create($string))
		);
	}
	
	/**
	 * slug_create
	 *
	 * param @string
	 * param @delimiter
	 * param @slugs      [ Array of slugs that must be ignored]
	 */
	public static function slug_create($string, $slugs = null)
	{
		
		$delimiter = "-";
		
		$slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', convert_accented_characters($string))))), $delimiter));
		
		if(!is_null($slugs)) {
			
			if(in_array($slug, $slugs)) {
				
				$slug_randomizer = true;
				for($i = rand(1,20); $i < rand(21, 999); $i++) {
					
					$newslug = $slug. '_' .$i;
					if(!in_array($newslug, $slugs))
						return $newslug;
				}
			}
		}
		
		if(isset($slug_randomizer) && $slug_randomizer) {
			
			exit("Couldn't create a slug, maybe there are few randoms to be resolved. Try to increase the Randomizer.");
		}
		
		return $slug;
	}
	
	public function get_slugs($table, $current_slug)
	{
		
		$sql = "SELECT slug FROM `{$table}`";
		$sql .= " WHERE `slug` LIKE'{$current_slug}%'";

			
		$query = $this->db->query($sql);
		if($query->num_rows() > 0)
		{
			$res = array();
			foreach($query->result_array() as $row)
			{
				$res[] = $row["slug"];
			}
			return $res;
		}
			
    
		return null;		
	}
}
