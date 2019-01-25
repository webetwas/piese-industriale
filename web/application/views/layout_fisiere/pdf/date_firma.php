<style>
	ul{
		font-size: 11px;
		list-style-type:none;
	}
</style>

<?php

$logoimg = null;
if(!$email) {
	$image = "../web/public/upload/img/misc/" .$owner->image_logo;
	$image_info = pathinfo($image);
	$logoimg = "data:image/" .$image_info["extension"]. ";base64, " .base64_encode(file_get_contents($image));
}
elseif($email)
	$logoimg = SITE_URL. "public/upload/img/misc/" .$owner->image_logo;
?>

<?php
$telefon = $company->telefon_mobil;
if(empty($telefon) && !empty($company->telefon_fix))
$telefon = $company->telefon_fix;
if(!empty($company->telefon_fax))
$telefon .= ' / ' . $company->telefon_fax;
?>


<table class="table">
	<tr>
	  <td>
		<ul>
			<li><strong>Furnizor: <?=$owner->company;?></strong></li>
			<li>Nr.ord.reg.com/an: <?=$company->nrinreg;?></li>
			<li>C.I.F.: <?=$company->cui;?></li>
			<li>Sediul: <?=$company->adresa_ss?> <?=$company->adresa_ssloc?> <?=$company->adresa_ssjud?></li>
			<li>Banca <?=$company->banca_banca;?></li>
			<li>Cont: <?=$company->banca_iban;?></li>
			<li>Tel/Fax: <?=$telefon;?></li>
			<li>Email: <?=$owner->oemail;?></li>
			<li>Web: <?=$owner->website;?></li>
		</ul>
	  </td>
	  <td valign="top">
	  	<ul>
	  		<?php if($client->pfpj == "PJ"): ?>
			<li><strong>Societate: <?=$client->pj_firma?></strong></li>
			<li>Nr.ord.reg.com/an: <?=$client->pj_comert;?></li>
			<li>C.I.F.: <?=$client->pj_fiscal?></li>
			<li>Sediul / Adresa : <?=$client->pj_adresa?></li>
			<li>Cont: <?=$client->pj_contbanca?></li>
			<li>Banca: <?=$client->pj_banca?></li>
			<?php endif; ?>
			<li><strong>Cumparator: <?=$client->nume?> <?=$client->prenume?></strong></li>
			<li>Adresa : <?=$client->adresa?>, <?=$client->oras?>, <?=$client->judet?></li>
			<li>Tel/Fax: <?=$client->telefon?></li>
			<li>Email: <?=$client->email?></li>
		</ul>
	  </td>
	  
	</tr>
	<tr>
		<td align="center" colspan="2">
			<div class="col-md-12 text-center">
				<img src="<?=$logoimg?>" class="img-responsive" alt="" title=""><br>
				<h4 style="margin-top:10px;">Factura Proforma  </h4>Nr. <?=$comanda->id?>; Data: <?=date("d.m.Y", strtotime($comanda->insert_date));?>
			</div>
			<hr />
		</td>
	</tr>

  
</table>