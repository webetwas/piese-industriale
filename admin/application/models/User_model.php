<?php
class User_model extends CI_Model {

  private $tbl;
  public $user = null;
  public $id = false, $user_name = false;


  public function __construct()
  {
    $this->tbl = 'be_users';
    parent::__construct();// Your own constructor code
  }

  public function callCredentials($user_name, $password) {
    $this->db->where('user_name', $user_name);
    $this->db->where('user_password', md5($password));
    $query = $this->db->get($this->tbl);
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }

  public function callCredentialsById($id, $password) {
    $this->db->where('id', $id);
    $this->db->where('user_password', md5($password));
    $query = $this->db->get($this->tbl);
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }

  public function VerifySession($session) {
    $dsession = json_decode($session);
    $user = $this->getUser($dsession->id, $dsession->user_name);
    if($user) {
      $this->id = $user->id;
      $this->user_name = $user->user_name;

      unset($user->user_password);//remove password from user
      $this->user = $user;
      return true;
    }

    return false;
  }

  public function getUser($id, $user_name = null) {
    $this->db->where('id', $id);
    if(!is_null($user_name)) $this->db->where('user_name', $user_name);
    $query = $this->db->get($this->tbl);
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }

  public function changePassword($id, $password) {
    $this->db->set('user_password', md5($password));

    $this->db->where('id', $id);
    $this->db->update($this->tbl);
    if($this->db->affected_rows() > 0)
      return true;
    else return false;
  }

  public function updateUser($id, $data) {
    foreach($data as $keyd => $d) {
      $this->db->set($keyd, $d);
    }

    $this->db->where('id', $id);
    $this->db->update($this->tbl);
    if($this->db->affected_rows() > 0)
      return true;
    else return false;
  }
}
