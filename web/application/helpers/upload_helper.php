<?php

function process_upload_photo($input_name, $base = null, $folder_name,$width=null,$height=null,$mentain_ratio=true)
{
	// echo 'start_upload';
  $CI = &get_instance();
  $CI->load->library('image_lib');
  $CI->load->helper('string');


  // process image
  if (isset($_FILES[$input_name]['name']) && $_FILES[$input_name]['name']!='')
  {
    $original_name = $_FILES[$input_name]['name'];
    $tmp_name = $_FILES[$input_name]['tmp_name'];
    $type=$_FILES[$input_name]['type'];
	
	// var_dump($type);


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
		
		// var_dump("$folder_name/$base");die();
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