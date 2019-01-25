<?php
class Frontend {
	protected $CI;

	// Frontend
	public $header = true, $footer = true;
	public $html_start = true, $html_end = true;
	public $body_start = false, $body_end = true;
	
	public $wrapper_start = true, $wrapper_end = true;
	public $navbar_left = true;
	public $pagewrapper_start = true, $pagewrapper_end = true;
	public $navbar_top = true;

	public $footer_frontend = true;
	
	public $application = null;

	public $owner = null;
	public $company = null;
	public $user = null;

	public $listpages = null;
	
	public $cereri_produse = 0;
	

	// We'll use a constructor, as you can't directly call a function
	// from a property definition.
	public function __construct()
	{
		/**
		 * [$this->CI Assign the CodeIgniter super-object]
		 * @var [type]
		 */ $this->CI =& get_instance();
		$this->CI->load->model("Session_model", "_Session");
		
		// var_dump($this->CI->_Session);die();
		$this->CI->load->model("Application_model", "_Application");
		$this->CI->load->model('Owner_model', 'OwnerModel');


		$this->application = $this->CI->_Application->getStatus();
		$this->listpages = $this->CI->_Application->listPages(1);//@is_active true

		
		$this->owner = $this->CI->OwnerModel->get();
		$this->company = $this->CI->OwnerModel->getCompany();
		$this->user = $this->CI->UserModel->user;// ???????????
		
		$this->cereri_produse = $this->CI->_Application->getCereriProduse();

	}

	/**
	 * render
	 * Render Page
	 *
	 * params Object @data
	 * params @viewhtml @viewdata
	 */
	public function render($data) {
		if(empty($data)) { echo "empty data on render";die(); }
		// $fdata = array("application" => $this->application, "owner" => $this->owner, "company" => $this->company, "user" => $this->user);//frontenddata
		$fdata = array("application" => (object) [
			"app" => $this->application,
			"owner" => $this->owner,
			"company" => $this->company,
			"user" => $this->user,
			], "listpages" => $this->listpages, "cereri_produse" => $this->cereri_produse);
			
		if($this->html_start) $this->CI->load->view('_layout/html_start', (!empty($fdata) ? $fdata : null));
		if($this->header) $this->CI->load->view('layout/header', null);
		$this->body_start = true;
		if($this->body_start) $this->CI->load->view('layout/body_start', null);
		if($this->wrapper_start) $this->CI->load->view('layout/wrapper_start', null);
		if($this->navbar_left) $this->CI->load->view('layout/navbar_left', null);
		if($this->pagewrapper_start) $this->CI->load->view('layout/pagewrapper_start', null);
		if($this->navbar_top) $this->CI->load->view('layout/navbar_top', null);
		
		foreach($data->html as $keyh => $h)//content
			if(!is_null($h->viewdata)) {
				$this->CI->load->view($h->viewhtml, $h->viewdata);
			} else $this->CI->load->view($h->viewhtml);
		if($this->footer_frontend) $this->CI->load->view('layout/footer_frontend', null);
		if($this->pagewrapper_end) $this->CI->load->view('layout/pagewrapper_end', null);
		if($this->wrapper_end) $this->CI->load->view('layout/wrapper_end', null);
		if($this->footer) $this->CI->load->view('layout/footer');
		if(!empty($data->javascript))
			foreach($data->javascript as $keyj => $j)
				if(!is_null($j->viewdata))
					$this->CI->load->view($j->viewhtml, $j->viewdata);
				else
					$this->CI->load->view($j->viewhtml);
		
		$retrieveFeedBack = $this->CI->_Session->retrieveFeedBack();
		if($retrieveFeedBack) {
			$this->CI->load->view('_layout/notifications.php', array("session" => $retrieveFeedBack));
		}
		if($this->body_end) $this->CI->load->view('_layout/body_end', null);
		if($this->html_end) $this->CI->load->view('_layout/html_end', null);
	}
	
	/**
	 * renderclean
	 * RenderClean Page
	 *
	 * params Object @data
	 * params @viewhtml @viewdata
	 */
	public function renderclean($data = null) {

		$fdata = array("application" => (object) [
			"app" => $this->application,
			"owner" => $this->owner,
			"company" => $this->company,
			"user" => $this->user
			], "listpages" => $this->listpages);
		
		if($this->html_start) $this->CI->load->view('_layout/html_start', (!empty($fdata) ? $fdata : null));
		foreach($data->html as $keyh => $h)//content
			if(!is_null($h->viewdata)) {
				$this->CI->load->view($h->viewhtml, $h->viewdata);
			} else $this->CI->load->view($h->viewhtml);

		if(!empty($data->javascript))
			foreach($data->javascript as $keyj => $j)
				if(!is_null($j->viewdata))
					$this->CI->load->view($j->viewhtml, $j->viewdata);
				else
					$this->CI->load->view($j->viewhtml);
		if($this->body_end) $this->CI->load->view('_layout/body_end', null);
		if($this->html_end) $this->CI->load->view('_layout/html_end', null);
	}
}
