<?php
class User {

	public $CI;
	public $id = false;
	public $uniqueid = false;
	
	public $favorite = 0;

  // We'll use a constructor, as you can't directly call a function
  // from a property definition.
  public function __construct()
  {
    $this->CI =& get_instance();
    $this->CI->load->model('User_model', 'UserModel');

    $this->CheckSession();
	
	if($this->id){
		$this->favorite = $this->CI->UserModel->count_favorite($this->id);
	}
  }

  public function LogIn($email = null, $parola = null) {
    if($email && $parola) {
      $credentials = $this->CI->UserModel->callCredentials($email, $parola);
      if($credentials) {
        $this->CreateSession($credentials->id, $credentials->email);
        $this->CheckSession();
      }
    }
  }

  public function CheckSession() {
    if(is_null($this->CI->session->userdata('userweb'))) {
      $this->id = false;
			$this->uniqueid = false;
      return false;
    } else {
      $this->CI->UserModel->VerifySession($this->CI->session->userdata('userweb'));
      if($this->CI->UserModel->id) {
				$this->id = $this->CI->UserModel->id;
				$this->uniqueid = $this->CI->UserModel->uniqueid;
			}
    }
  }
	
	public function CheckAdminSession() {
		$adminsession = $this->CI->session->userdata('user');//session@userexists
		if($adminsession)
			if(array_key_exists("user_name", json_decode($adminsession, true))) return true;//checkifsessiongot@user_name
		return false;
	}

  public function CreateSession($id, $email) {
    $user = json_encode((object) ['id' => $id,
                                  'email' => $email]);
    $this->CI->session->set_userdata('userweb', $user);
  }

  public function logout() {
    $this->CI->session->unset_userdata('userweb');
    $this->CheckSession();

    return false;
  }
}
