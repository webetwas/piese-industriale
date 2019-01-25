<?php

// croppie_upload_image
//
function croppie_upload_image($input, $folder, $name)
{
	$base_image = $folder . '/' . $name . '.png';
	$new_image = $folder . '/' . $name . '.jpg';
	
    $tmp_name = $_FILES[$input]['tmp_name'];
    $type=$_FILES[$input]['type'];
	
	// var_dump($folder);die();
	if (! is_writable("$folder/")) show_error('read only folder!');

	move_uploaded_file($tmp_name, $base_image);

	$input_file = $base_image;
	$output_file = $new_image;
	$input = imagecreatefrompng($input_file);
	list($width, $height) = getimagesize($input_file);
	$output = imagecreatetruecolor($width, $height);
	$white = imagecolorallocate($output,  255, 255, 255);
	imagefilledrectangle($output, 0, 0, $width, $height, $white);
	imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
	imagejpeg($output, $output_file);
	unlink($input_file);
	
	if(file_exists($new_image))
	{
		return $new_image;
	}
	
	return false;
}

// upload_by_data
// @image_full_path @folder @image name @height @width @radio
//
function upload_by_data($image_full_path, $folder, $name, $h = null, $w = null, $r = true)
{
	$CI = &get_instance();
	$CI->load->library('image_lib');
	$CI->load->helper('string');	
	// var_dump($image_full_path);
	// var_dump($folder);
	// var_dump($name);
	// var_dump($h);
	// var_dump($w);
	// die();
	
	
	if (! is_writable("$folder/")) show_error('read only folder!');

	// se redimensioneaza thumbu
	$config = array();
	$config['image_library'] = 'GD2';
	// $config['source_image'] = "$folder/$name";
	$config['source_image'] = $image_full_path;
	$config['new_image'] = "$folder/$name";
	$config['maintain_ratio'] = $r;



	if(!is_null($w) && is_null($h))
	{
		$config['width'] = $w;
		$config['height'] = $w;
	}
	elseif(is_null($w) && !is_null($h))
	{
		$config['height'] = $h;
		$config['width'] = $h;
	}

	elseif(!is_null($w) && !is_null($h))
	{
		$config['width'] = $w;
		$config['height'] = $h;
	}


	// resize only if width or height is set
	if (!is_null($w) || !is_null($h))
	{
		// var_dump($config);
		$CI->image_lib->initialize($config);

		// daca nu e ok, va sterge imaginea si va returna ''
		if (! $CI->image_lib->resize() )
		{
			return false;
		}
	}
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