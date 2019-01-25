<?php
class Session_model extends CI_Model {
	
	public $feedback_pozitive = null;
	public $feedback_negative = null;

  public function __construct()
  {
    parent::__construct();// Your own constructor code
		
		$this->load->library('session');
		
		if($this->session->has_userdata('feedback_pozitive'))
			$this->feedback_pozitive = $this->session->userdata('feedback_pozitive');
		
		if($this->session->has_userdata('feedback_negative'))
			$this->feedback_negative = $this->session->userdata('feedback_negative');
  }
	
	public function setFB_Pozitive($data)
	{
		$this->session->set_userdata('feedback_pozitive', $data);
	}
	
	public function setFB_Negative($data)
	{
		$this->session->set_userdata('feedback_negative', $data);
	}
	
	public function retrieveFeedBack()
	{
		if(!is_null($this->feedback_pozitive)) {
			$this->feedback_pozitive["status"] = "pozitive";
			$this->session->unset_userdata('feedback_pozitive');
			return $this->feedback_pozitive;
		}
		if(!is_null($this->feedback_negative)) {
			$this->feedback_negative["status"] = "negative";
			$this->session->unset_userdata('feedback_negative');
			return $this->feedback_negative;
		}
		
		return false;
	}
}
