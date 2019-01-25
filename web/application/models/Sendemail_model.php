<?php
class Sendemail_model extends CI_Model {

  private $from_address;
  private $from_name;
  
  private $tbl_emailing = 'be_emailing';
  private $id_emailing = 1;
  
  private $smtp_user = null;
  private $smtp_addr = null;
  private $smtp_pass = null;
  private $smtp_port = null;
  
  
  private $owner = null;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

    $this->load->library('email');
	
	$this->getOwner();
	$this->getEmailing();

  }
	
  /**
   * [getOwner description]
   * @return [type] [description]
   */
  public function getEmailing() {
		$query = $this->db->query("SELECT * FROM `" .$this->tbl_emailing. "` WHERE id = " .$this->id_emailing. ";");

		if($query->num_rows() > 0)
		{
			foreach($query->row() as $kr => $r)
			{
				$this->{$kr} = trim($r);
				
				if($kr == "smtp_user")
					$this->from_address = $r;
			}
		}
		// echo '<pre>';
		// var_dump($this);
		// echo '</pre>';
		// die();
  }
  
  /**
   * [getOwner description]
   * @return [type] [description]
   */
  public function getOwner() {
		$query = $this->db->query("SELECT * FROM `be_owner` WHERE id = 1;");

		if($query->num_rows() > 0)
		{
			$r = $query->row();
			$this->from_name = $r->company;
			
			$this->owner = $r;
		}
		else return false;
  }
	
	public function contnou($to, $utilizator)
	{
		$subject = "Bine ai venit! " . $this->from_name;
		$fromname = $this->from_name;
		$fromemail = $this->from_address;
		
		$html = $this->load->view("layout_fisiere/pdf/header", array('owner' => $this->owner), true);
		$html .= $this->load->view("layout_fisiere/pdf/mail_inregistrare", array("utilizator" => $utilizator), true);
		
		// var_dump($html);die();
		// return $html;
		
		$this->send($to, $subject, $html, "html", $fromname, $fromemail);
	}
	
	public function trimitemesajcerereprodus($to)
	{
		$subject = $this->from_name . " - Cerere produs";
		$fromname = $this->from_name;
		$fromemail = $this->from_address;		
		
		$this->send($to, $subject, 'Cerere produs - Vezi cererea in administrare.', "text", $fromname, $fromemail);
	}
	
	public function trimitemesajcontact($data, $to)
	{
		$subject = $this->from_name . " - Mesaj nou";
		$fromname = $this->from_name;
		$fromemail = $this->from_address;
		
		$html = $this->load->view("layout_fisiere/pdf/header", array('owner' => $this->owner), true);
		$html .= $this->load->view("layout_fisiere/pdf/admin_mesajnou", array("data" => $data), true);
		
		$this->send($to, $subject, $html, "html", $fromname, $fromemail);
	}
	
	public function trimitecererereturnare($data, $to)
	{
		$subject = $this->from_name . " - Cerere returnare produs";
		$fromname = $this->from_name;
		$fromemail = $this->from_address;
		
		$html = $this->load->view("layout_fisiere/pdf/header", array('owner' => $this->owner), true);
		$html .= $this->load->view("layout_fisiere/pdf/cerere_returnare", array("data" => $data), true);
		
		$this->send($to, $subject, $html, "html", $fromname, $fromemail);		
	}
	
	public function trimiteFactura($to, $html)
	{
		$subject = $this->from_name . " - Comanda noua!";
		$fromname = $this->from_name;
		$fromemail = $this->from_address;
		
		$this->send($to, $subject, $html, "html", $fromname, $fromemail);				
	}
	
	public function resetareparola($to, $data)
	{
		$subject = $this->from_name . " - Resetare parola";
		$fromname = $this->from_name;
		$fromemail = $this->from_address;
		
		$html = $this->load->view("layout_fisiere/pdf/header", array('owner' => $this->owner), true);
		$html .= $this->load->view("layout_fisiere/pdf/resetare_parola", array("data" => $data), true);
		
		$this->send($to, $subject, $html, "html", $fromname, $fromemail);
		
	}
	
  private function send($to, $subj, $mess, $type, $fromname, $fromemail)
  {
    $type = strtoupper($type);
    $config['protocol']  = 'smtp';
	$config['mailpath']  = '/usr/sbin/sendmail';
	
    $config['smtp_host'] = $this->smtp_addr;
    $config['smtp_port'] = $this->smtp_port; // 8025, 587 and 25 can also be used. Use Port 465 for SSL.
    $config['smtp_crypto'] = 'tls';
    $config['smtp_user'] = $this->smtp_user;
    $config['smtp_pass'] = $this->smtp_pass;

    $config['charset']   = 'utf-8';
    $config['newline']   = "\r\n";
    $config['send_multipart'] = FALSE;
    
		if ($type == 'HTML') {
			$config['mailtype'] = "html";
			$config['wordwrap']  = TRUE;
		}
		else $config['mailtype'] = "text";


		$this->email->initialize($config);
		$this->email->from($fromemail, $fromname);
		$this->email->to($to);
		$this->email->subject($subj);
		$this->email->message($mess);

		$send = $this->email->send();
		// if(!$send) {
			// echo $this->email->print_debugger();
		// }
  }
}