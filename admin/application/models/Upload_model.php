<?php
class Upload_model extends CI_Model {

  private $inpfile = "inpfile";//POST/name

  public function __construct()
  {
  	parent::__construct();
  	// Your own constructor code
  	//
    $this->load->helper('upload');
	$this->load->helper('string');
  }

  /**
   * [uploadImage description]
   * @param  [String] $this->inpfile [description]
   * @param  [String] $folder    [description]
   * @param  [Array]  $data      [description]
   * @return [Array]             [Images namepath]
   */
  public function uploadImage($folder, $data = array(), $imaginaryfolder = null) {
    // $images = $this->_Upload->uploadImage($inputfile, '../web/' .PATH_IMG_PAGINA, array("s" => true, "m" => true, "l" => true));
		$img_name = $this->createImageName($this->inpfile);

    $temp_upload = false;
		if($img_name) {
      if(!empty($data)) {
        // var_dump($data);die();
  			foreach($data as $keyd => $d) {
          $newfolder = (!empty($imaginaryfolder) ? $folder.$keyd : $folder);
          
          if($keyd == "image_logo") {
            $d = array("w" => IMG_LOGO_W, "h" => IMG_LOGO_H, "p" => IMG_LOGO_P);
          }
  		    $temp_upload = process_upload_photo($this->inpfile, $img_name, $newfolder, $d["w"], $d["h"], $d["p"] == "1" ? true : false);
  			  if($temp_upload) $data[$keyd] = true;
  			  else $data[$keyd] = false;
  			}
      } else $temp_upload = process_upload_photo($this->inpfile, $img_name, $folder, null, null, true);
  	}
    if($temp_upload) $data["img"] = $temp_upload;
    else $data["img"] = false;

    return $data;
  }

	private function createImageName() {
		$type = $_FILES[$this->inpfile]['type'];

    if ($type == "image/jpeg" || $type == "image/png" || $type == "image/pjpeg") {
			$original_name = $_FILES[$this->inpfile]['name'];

			$path_info = pathinfo($original_name);
			$extension = $path_info['extension'];

			// file name handling
			$rnd = strtolower(random_string('alnum', 8));
			$base = "photo-$rnd.{$extension}";
			$base = strtolower($base);

			return $base;
		} else return false;
	}
}
