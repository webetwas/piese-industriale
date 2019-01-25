<?php
	class Image_model extends CI_Model
	{	
		private $sizes;
		
		public function __construct()
		{
			parent::__construct();
			$this->sizes = new stdClass();
			
			$this->sizes->s = json_decode(IMG_SIZE_CULORI_S);
			$this->sizes->m = json_decode(IMG_SIZE_CULORI_M);
			$this->sizes->l = json_decode(IMG_SIZE_CULORI_L);
			
			$this->load->helper('upload');
		}
		
		public function upload_images($path)
		{
			$image = $this->create_image_name(true);
			foreach($this->sizes as $key => $size)
			{
				process_upload_photo('image-data', $image, $path . $key, $size->w, $size->h, $size->p);
			}
			
			return $image;
		}
		
		private function create_image_name($add_extension = false)
		{
			$type = $_FILES['image-data']['type'];
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
		
		public function remove_images($img, $path)
		{
			foreach($this->sizes as $key => $size)
			{
				$full_path = $path . $key . '/' . $img;
				if(file_exists($full_path)) unlink($full_path);
			}
			
		}
		
	}
?>