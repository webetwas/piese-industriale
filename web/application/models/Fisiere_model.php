<?php
class Fisiere_model extends CI_Model {


  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
  }

  public function factura($applicationdata, $client, $comanda, $email = false)
  {
		$html = $this->load->view("layout_fisiere/pdf/header", $applicationdata, true);
		if($email ) $html .= $this->load->view("layout_fisiere/pdf/nota_comanda", null, true);
		$html .= $this->load->view("layout_fisiere/pdf/date_firma", array("client" => $client, "comanda" => $comanda, "email" => $email), true);
		$html .= $this->load->view("layout_fisiere/pdf/mail_comanda", array("email" => $email), true);
		
		return $html;
  }

}
