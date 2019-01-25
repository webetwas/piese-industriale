<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
		// Your own constructor code

		if(!$this->user->id) redirect("login");
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$breadcrumb = array("bb_titlu" => "Administrare", "bb_button" => null, "breadcrumb" => array());
		$breadcrumb["breadcrumb"][0] = array("text" => "WebEtwas", "url" => '');
		$breadcrumb["breadcrumb"][1] = array("text" => "Administrare", "url" => '');
		
    $view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
      1 => (object) ["viewhtml" => "welcome", "viewdata" => null]
      ), 'javascript' => null
    ];

		$this->frontend->render($view);
	}
}
