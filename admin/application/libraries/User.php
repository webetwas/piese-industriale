<?php
class User {

  public $CI;
  public $id = false;

  // We'll use a constructor, as you can't directly call a function
  // from a property definition.
  public function __construct()
  {
    $this->CI =& get_instance();
    $this->CI->load->model('User_model', 'UserModel');

    $this->CheckSession();
  }

  public function LogIn($user_name = null, $password = null) {
    if($user_name && $password) {
      $credentials = $this->CI->UserModel->callCredentials($user_name, $password);
      if($credentials) {
        $this->CreateSession($credentials->id, $credentials->user_name);
        $this->CheckSession();
      }
    }
  }

  public function CheckSession() {
    if(is_null($this->CI->session->userdata('user'))) {
      $this->id = false;
      return;
    } else {
      $this->CI->UserModel->VerifySession($this->CI->session->userdata('user'));
      if($this->CI->UserModel->id) $this->id = $this->CI->UserModel->id;
    }
  }

  public function CreateSession($id, $user_name) {
    $user = json_encode((object) ['id' => $id,
                                  'user_name' => $user_name]);
    $this->CI->session->set_userdata('user', $user);
  }

  public function logout() {
    $this->CI->session->unset_userdata('user');
    $this->CheckSession();

    return false;
  }
}