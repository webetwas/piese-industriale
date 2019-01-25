<?php
class User_model extends CI_Model {

  private $tbl;
  public $user = null;
  public $id = false, $uniqueid = false, $email = false;


  public function __construct()
  {
    $this->tbl = TBL_UTILIZATORI;
    parent::__construct();// Your own constructor code
  }

  
  public function count_favorite($id_utilizator)
  {
    $this->db->where('id_utilizator', (int)$id_utilizator);
    $query = $this->db->get('shop_favorite');
    if($query->num_rows() > 0) return $query->num_rows();
    else return false;	  
  }
  
  public function callCredentials($user_name, $password) {
    // var_dump($user_name); var_dump($password);die();
    $this->db->where('email', $user_name);
    $this->db->where('parola', md5($password));
    $query = $this->db->get($this->tbl);
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }

  public function callCredentialsById($id, $password) {
    $this->db->where('id', $id);
    $this->db->where('parola', md5($password));
    $query = $this->db->get($this->tbl);
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }

  public function VerifySession($session) {
    $dsession = json_decode($session);
    $user = $this->getUser($dsession->id, $dsession->email);
    if($user) {
      $this->id = $user->id;
			$this->uniqueid = $user->uniqueid;
      $this->email = $user->email;

      unset($user->parola);//remove password from user
      $this->user = $user;
      return true;
    }

    return false;
  }

  public function getUser($id, $email = null) {
    $this->db->where('id', $id);
    if(!is_null($email)) $this->db->where('email', $email);
    $query = $this->db->get($this->tbl);
    if($query->num_rows() > 0) return $query->row();
    else return false;
  }

  public function changePassword($id, $password) {
    $this->db->set('parola', md5($password));

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
