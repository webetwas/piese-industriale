<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Platforma extends CI_Controller {
	protected $CI;

	/**
	 * [private Controller]
	 * @var [type]
	 */
	private $controller;
	private $controller_ajax;

	/**
	 * [private URI - Segment]
	 * @var [type]
	 */
	private $uriseg;

	public function __construct() {
		parent::__construct();// Your own constructor code
		$this->CI =& get_instance();

		$this->controller = $this->router->fetch_class();//Controller
		$this->controller_ajax = $this->controller;
		$this->uriseg = json_decode(json_encode($this->uri->uri_to_assoc(2)));

		$this->load->model("Platforma_model", "_Platforma");// model/_Platforma
		$this->load->model("Item_model", "_Item");// model/_Item
		$this->load->model("Upload_model", "_Upload");// model/_Upload
		$this->load->model("Ajax_model", "_Ajax");// model/_Upload
		if(!$this->user->id) redirect("login");
	}


	/**
	 * [index Index]
	 * @return [type] [description]
	 */
	public function index()
	{
		echo show_404();
	}

	public function setari()
	{
 		$this->controller = $this->controller. "/" .$this->router->fetch_method();
		 /**
		  * [$viewdata CORE]
		  * @var array
		  */ $viewdata = array("controller" => $this->controller, "controller_ajax" => $this->controller_ajax. "/ajax", "uri" => null, "form" => (object) []);
			$viewdata["uri"] = $this->uriseg;
			$viewdata["img_path"] = SITE_URL.PATH_IMG_MISC;

			switch($this->uriseg->setari)
			{
				case SET_COMPANIE:
					if(isset($this->uriseg->item) && isset($this->uriseg->id) && !is_null($this->uriseg->item)) {
						$viewdata["owner"] = null;//needed
						$viewdata["company"] = null;//needed
						$viewdata["emailing"] = null;//needed
						switch($this->uriseg->item)
						{
							case UPDATE:
								// FORM - NEW
								$viewdata["form"]->item = (object) [];
								$viewdata["form"]->item->name = "item";
								$viewdata["form"]->item->prefix = "it";
								$viewdata["form"]->item->segments = $this->controller. "/companie/item/" .$this->uriseg->item. "/id/" .$this->uriseg->id;

								$form_submit = $viewdata["form"]->item->prefix. "submit";//submit<button>
								//FORM - ACT
								if(isset($_REQUEST["{$form_submit}"])) {
									/**
									 * [$newDBPattern_OWNER description]
									 * @var [type]
									 */ $newDBPattern_OWNER = (object) [ "table" => "be_owner", "database" => UPDATE, "type" => GET, "design" => array() ];
									// the @id won't appear(it has No Default value(ex:NULL) and No _REQUEST Value)
									$newDBPattern_OWNER->design["image_logo"] = false;// @image_logo(AJAXMove)
									$newDBPattern_OWNER->design["td_owner"] = false;
									$newDBPattern_OWNER->design["td_initial"] = false;
									$newDBPattern_OWNER->design["td_company"] = false;
									$newDBPattern_OWNER->design["td_email"] = false;
									$newDBPattern_OWNER->design["td_phone"] = false;
									$newDBPattern_OWNER->design["td_website"] = false;
									$newDBPattern_OWNER->design["td_location"] = false;

									/**
									 * [$newDBPattern_COMPANY description]
									 * @var [type]
									 */ $newDBPattern_COMPANY = (object) [ "table" => "be_ocompany", "database" => UPDATE, "type" => GET, "design" => array() ];
									// the @id won't appear(it has No Default value(ex:NULL) and No _REQUEST Value)
									$newDBPattern_COMPANY->design["id"] = false;
									$newDBPattern_COMPANY->design["idowner"] = false;
									
									
									$newDBPattern_EMAILING = (object) [ "table" => "be_emailing", "database" => UPDATE, "type" => GET, "design" => array() ];
									$newDBPattern_EMAILING->design["id"] = false;
									
									$update_owner = $this->_Item->UPitem($newDBPattern_OWNER->table, $viewdata["form"]->item->prefix, $newDBPattern_OWNER, $this->uriseg->id);
									$update_company = $this->_Item->UPitem($newDBPattern_COMPANY->table, $viewdata["form"]->item->prefix, $newDBPattern_COMPANY, $this->uriseg->id);
									
									$update_emailing = $this->_Item->UPitem($newDBPattern_EMAILING->table, $viewdata["form"]->item->prefix, $newDBPattern_EMAILING, 1);
									
									if($update_owner || $update_company || $update_emailing) $this->_Session->setFB_Pozitive(array("ref" => "Contul meu", "text" => "Modificarile tale au fost salvate!"));
									redirect($viewdata["form"]->item->segments);
								}
							break;
						}
					} else redirect(base_url());//therearenoactionsforthiscontroller

					$viewdata["owner"] = $this->_Platforma->getOwner();
					$viewdata["company"] = $this->_Platforma->getCompany();
					
					$viewdata["emailing"] = $this->_Platforma->getEmailing();
					
					$breadcrumb = array("bb_titlu" => "Contul meu", "bb_button" => null, "breadcrumb" => array());
					$breadcrumb["bb_button"] = array("text" => '<i class="fa fa-user-circle-o"></i> ' .$this->CI->frontend->user->user_name, "linkhref" => "platforma/setari/utilizator/item/u/id/".$this->CI->frontend->user->id);
					
					$breadcrumb["breadcrumb"][0] = array("text" => "Administrare", "url" => '');
					$breadcrumb["breadcrumb"][1] = array("text" => "Companie", "url" => null);					
					
					$view = (object) [
						'html' => array(
							0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
							1 => (object) ["viewhtml" => "platforma/setari/companie", "viewdata" => $viewdata]
						),
						'javascript' => array(
							1 => (object) ["viewhtml" => "platforma/setari/js_companie", "viewdata" => null],
						)];

					/**
					* [$this->frontend->render Render the View]
					* @var [type]
					*/ $this->frontend->render($view);
				break;
				case SET_UTILIZATOR:
					if(isset($this->uriseg->item) && isset($this->uriseg->id) && !is_null($this->uriseg->item)) {
						$viewdata["owner"] = null;//needed
						$viewdata["user"] = null;//needed
						$viewdata["owner"] = $this->_Platforma->getOwner();
						$viewdata["user"] = $this->_Platforma->getUser($this->CI->frontend->user->id);

						switch($this->uriseg->item)
						{
							case UPDATE:
								// FORM - NEW
								$viewdata["form"]->item = (object) [];
								$viewdata["form"]->item->name = "item";
								$viewdata["form"]->item->prefix = "it";
								$viewdata["form"]->item->segments = $this->controller. "/utilizator/item/" .$this->uriseg->item. "/id/" .$this->uriseg->id;

								$form_submit = $viewdata["form"]->item->prefix. "submit";//submit<button>
								//FORM - ACT
								if(isset($_REQUEST["{$form_submit}"])) {
									/**
									 * [$newDBPattern description]
									 * @var array
									 */ $newDBPattern = (object) [ "table" => "be_users", "database" => UPDATE, "type" => PUT, "design" => array() ];
									$newDBPattern->design["email"] = true;

									$update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern, $this->CI->frontend->user->id);// update@userLogged

									if($update) $this->_Session->setFB_Pozitive(array("ref" => "Contul meu", "text" => "Modificarile tale au fost salvate!"));
									redirect($viewdata["form"]->item->segments);
								}
							
								$breadcrumb = array("bb_titlu" => "Contul meu", "bb_button" => null, "breadcrumb" => array());
								$breadcrumb["bb_button"] = array("text" => '<i class="fa fa-key"></i> Schimba parola', "linkhref" => "platforma/setari/utilizator/item/cp/id/{$this->CI->frontend->user->id}", "class" => "btn-danger");
								
								$breadcrumb["breadcrumb"][0] = array("text" => "Companie", "url" => "platforma/setari/companie/item/u/id/{$this->CI->frontend->owner->id}");
								$breadcrumb["breadcrumb"][1] = array("text" => $this->CI->frontend->user->user_name, "url" => null);
								$view = (object) [
									'html' => array(
										0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
										1 => (object) ["viewhtml" => "platforma/setari/utilizator", "viewdata" => $viewdata]
									),
									'javascript' => array(
										1 => (object) ["viewhtml" => "platforma/setari/js_utilizator", "viewdata" => null],
									)];
							break;
							case CHANGEPASSWORD:
								// FORM - NEW
								$viewdata["form"]->item = (object) [];
								$viewdata["form"]->item->name = "item";
								$viewdata["form"]->item->prefix = "it";
								$viewdata["form"]->item->segments = $this->controller. "/utilizator/item/" .$this->uriseg->item. "/id/" .$this->uriseg->id;

								$form_submit = $viewdata["form"]->item->prefix. "submit";//submit<button>
								//FORM - ACT
								if(isset($_REQUEST["{$form_submit}"])) {
									$viewdata["message"] = '<div class="alert alert-danger"><span><b> Eroare! - </b> Te rugam sa contactezi Administratorul</span></div>';

									$pa_input = $viewdata["form"]->item->prefix. "cpassnp_a";
									$pb_input = $viewdata["form"]->item->prefix. "cpassnp_b";
									$pass_a = (!empty($this->input->post($pa_input)) ? trim($this->input->post($pa_input)) : false);
									$pass_b = (!empty($this->input->post($pb_input)) ? trim($this->input->post($pb_input)) : false);
									if($pass_a && $pass_b) {
										if($pass_a == $pass_b)
											if($this->UserModel->changePassword($this->user->id, $pass_a))
												$viewdata["message"] = '<div class="alert alert-success"><span><b> Succes - </b> Parola a fost schimbata!</span></div>';
									}
								}
								
								$breadcrumb = array("bb_titlu" => "Contul meu", "bb_button" => null, "breadcrumb" => array());
								
								$breadcrumb["breadcrumb"][0] = array("text" => "Contul meu", "url" => "platforma/setari/utilizator/item/u/id/".$this->CI->frontend->user->id);
								$breadcrumb["breadcrumb"][1] = array("text" => "Schimbare parola", "url" => null);
								$view = (object) [
									'html' => array(
										0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
										1 => (object) ["viewhtml" => "platforma/setari/utilizator/cp", "viewdata" => $viewdata]
									),
									'javascript' => array(
										1 => (object) ["viewhtml" => "platforma/setari/utilizator/js_cp", "viewdata" => null],
									)];
							break;
						}
					} else redirect(base_url());//therearenoactionsforthiscontroller

					/**
					* [$this->frontend->render Render the View]
					* @var [type]
					*/ $this->frontend->render($view);
				break;
			}
		}

	/**
	 * [Ajax description]
	 */
  public function Ajax()
	{
		//
		// var_dump($this->uriseg);die();
		if(!empty($this->uriseg->ajax) && isset($this->uriseg->id) && !is_null($this->uriseg->id))
	    switch($this->uriseg->ajax)
			{
				case INSERT:
					$res = array("status" => 0);

					if($this->input->post("tf") == "img") {
						// Upload logo
						$logo = $this->_Upload->uploadImage('../web/' .PATH_IMG_MISC, array("image_logo" => true), false);
						if($logo["img"]) {
							// Result
							$res["image_logo"] = $logo["img"];
							$logo["image_logo"] = $logo["img"];
							unset($logo["img"]);
							//Insert image to database
							$table = TBL_OWNER;
							$updateitem = $this->_Ajax->updateItem($table, $logo, $this->uriseg->id);
							if($updateitem) $res["status"] = 1;
						}
					}
					echo json_encode($res);
				break;
				case DELETE:
					$res = array("status" => 0);

					$table = TBL_OWNER;
					$data = array("image_logo" => null);
					$update = $this->_Ajax->updateItem($table, $data, $this->uriseg->id);
					if($update) {
						$res["status"] = 1;
						deletefile('../web/' .PATH_IMG_MISC, $update->image_logo);
					}
					echo json_encode($res);
				break;
				case CHANGEPASSWORD:
					$res = array("status" => 0, "data" => null);

					$oldpassword = false;
					if($this->input->post("postdata")) $oldpassword = trim($this->input->post("postdata"));

					if($oldpassword) {
						$check = $this->UserModel->callCredentialsById($this->user->id, $oldpassword);//checkoldpassword
						if($check) $res["status"] = 1;
					}
					// var_dump($res);die();
					echo json_encode($res);
				break;
			}
		else show_404();
  }
}
