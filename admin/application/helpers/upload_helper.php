<?php
function process_upload_photo($input_name, $base = null, $folder_name,$width=null,$height=null,$mentain_ratio=true)
{
  $CI = &get_instance();
  $CI->load->library('image_lib');
  $CI->load->helper('string');


  // process image
  if (isset($_FILES[$input_name]['name']) && $_FILES[$input_name]['name']!='')
  {
    $original_name = $_FILES[$input_name]['name'];
    $tmp_name = $_FILES[$input_name]['tmp_name'];
    $type=$_FILES[$input_name]['type'];


    $path_info = pathinfo($original_name);
    $extension = $path_info['extension'];

    if ($type == "image/jpeg" || $type=="image/png" || $type="image/pjpeg")
    {
			// Create an name for the FILE
			if(is_null($base)) {
				// file name handling
				$rnd = strtolower(random_string('alnum', 8));
				$base = "photo-$rnd.$extension";
				$base = strtolower($base);
			}


			if (! is_writable("$folder_name/")) show_error('read only folder!');

      // se aduce fisierul la locul lui
      copy($tmp_name,"$folder_name/$base");

      // se redimensioneaza thumbu
      $config = array();
      $config['image_library'] = 'GD2';
      $config['source_image'] = "$folder_name/$base";
      $config['new_image'] = "$folder_name/$base";
      $config['maintain_ratio'] = $mentain_ratio;



      if (isset($width) && ! isset($height))
      {
        $config['width'] = $width;
        $config['height'] = $width;
      }
      else if (!isset($width) && isset($height))
      {
        $config['height'] = $height;
        $config['width'] = $height;
      }

      else if (isset($width) && isset($height))
      {
        $config['width'] = $width;
        $config['height'] = $height;
      }


      // resize only if width or height is set
      if (isset($width) || isset($height))
      {
        $CI->image_lib->initialize($config);

        // daca nu e ok, va sterge imaginea si va returna ''
        if (! $CI->image_lib->resize() )
        {
          if(is_writable("$folder_name/$base")) unlink ("$folder_name/$base");
          return '';
        }
      }

      return $base;
    }
    else
    {
      return false;
    }
  } else return false;
}


function process_upload_file($input_name,$upload_folder)
{

  // process image
  if (isset($_FILES[$input_name]['name']) && $_FILES[$input_name]['name']!='')
  {
    $original_name = $_FILES[$input_name]['name'];
    $tmp_name = $_FILES[$input_name]['tmp_name'];

    // cod de creare a numelui de fisier, ca sa nu suprascrie ceva existent
    $new_name = $original_name;
    if (is_file("$upload_folder/$original_name")) $new_name = substr(md5(time()),0,8)."_".$original_name;

		if (! is_writable("$upload_folder/")) show_error('read only folder! - '."$upload_folder/");

    copy($tmp_name,"$upload_folder/$new_name");

    return $new_name;
  }

  return null;
}

function deletefile($path, $file, $imaginaryfolder = null) {
	if(!empty($imaginaryfolder)) {
		foreach($imaginaryfolder as $keyimgpath => $imgpath) {
			$targetfile = $path.$keyimgpath. "/" .$file;
			if(file_exists($targetfile)) unlink($targetfile);
		}
	} elseif(is_null($imaginaryfolder)) {
		$targetfile = $path.$file;
		if(file_exists($targetfile)) unlink($targetfile);
	}
}

?>
