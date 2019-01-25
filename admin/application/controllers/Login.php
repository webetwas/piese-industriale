<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

  private $error = null;

  public function __construct() {
    parent::__construct();
    // Your own constructor code
    if($this->user->id) {
      if(!$this->uri->segment(2) == "getout") redirect("/");//allowlogout
    }

    $this->CI =& get_instance();

    $this->frontend->head = false;
    $this->frontend->sidebar = false;
    $this->frontend->mainpanel_head = false;
    $this->frontend->navbar = false;
    $this->frontend->foot = false;
    $this->frontend->mainpanel_foot = false;
    $this->frontend->footerbyheader = false;
  }

  /**
   * Index Page for this controller.
   *
   * Maps to the following URL
   *    http://example.com/index.php/welcome
   *  - or -
   *    http://example.com/index.php/welcome/index
   *  - or -
   * Since this controller is set as the default controller in
   * config/routes.php, it's displayed at http://example.com/
   *
   * So any other public methods not prefixed with an underscore will
   * map to /index.php/welcome/<method_name>
   * @see https://codeigniter.com/user_guide/general/urls.html
   */

  public function index() {
    $view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "login/header", "viewdata" => null],
			1 => (object) ["viewhtml" => "login/body_start", "viewdata" => null],
      2 => (object) ["viewhtml" => "login/login", "viewdata" => (!is_null($this->error) ? array('error' => $this->error) : null)],
			3 => (object) ["viewhtml" => "login/footer", "viewdata" => null]
      ), 'javascript' => null
    ];
		// $view = null;
    $this->frontend->renderclean($view);
  }

  public function getin() {
    $user_name = trim($this->input->post("username"));
    $password = trim($this->input->post("password"));

    if(strlen($user_name) >= 2 && strlen($password) >= 2) {
      $this->user->LogIn($user_name, $password);
      if($this->user->id) redirect("/");//Authentication successfully
      elseif(!$this->user->id) {
        $this->error = "Login failed";
        $this->index();//Authentication failed
      }
    } else {
      $this->index();//Authentication failed
    }
  }

  public function getout() {
    if($this->user->id) {
      $this->user->logout();
      if(!$this->user->id) redirect("/");
      elseif($this->user->id) {
        echo "er23";
        die();//Logout failed
      }
    } else redirect("/");
  }
}
