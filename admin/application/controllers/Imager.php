<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

class Imager extends CI_Controller
{
	
	private $controller;
	
	public function index()
	{
		show_404();
	}
	
	public function __construct()
	{
		parent::__construct();
		// Your own constructor code

		$this->controller = $this->router->fetch_class();

		if(!$this->user->id) redirect("login");

		// $this->load->model("Item_model", "_Item");
		$this->load->model('Imager_model', '_Imager');
	}
	
	public function ajax_upcreateimages($atom_id)
	{
		$res = array('status' => false, 'error' => null);
		$data = new stdClass();
		
		$data->atom_id   = $atom_id;
		$data->air_id    = $this->input->post('air_id');
		$data->file_name = $_FILES['data']['name'];
		$data->imager    = $this->input->post('imager');
		
		// var_dump($data->air_id);
		// die();
		
		foreach($data as $d)
		{
			if(is_null($d))
			{
				$res['error'] = 'Input data missing..';
				exit(json_encode($res));
			}
		}
		
		$image = $this->_Imager->upcreateimages($data);
		if(is_array($image))
		{
			$res["status"] = true;
			$res["id"] = $image["id"];
			$res["img"] = $image["img"];
		}
		
		exit(json_encode($res));
	}
	
	public function ajax_delimage($id)
	{
		$res = array('status' => false, 'error' => null);
		
		$data = new stdClass();
		$data->air_id = $this->input->post('air_id');
		$data->id = $id;
		
		foreach($data as $d)
		{
			if(is_null($d))
			{
				$res['error'] = 'Input data missing..';
				exit(json_encode($res));
			}
		}
		
		$delete = $this->_Imager->deleteimages($data);
		
		if($delete) {
			$res['status'] = true;
		}

		exit(json_encode($res));
	}
	
}