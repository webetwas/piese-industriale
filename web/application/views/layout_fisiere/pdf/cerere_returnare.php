<?php
// var_dump($data);die();
?>
<div class="row">
	<div class="col align-self-start"></div>
	<div class="col align-self-end">
			<?=$owner->company;?> - Cerere returnare produs<br /><br />
			<strong>Nume: </strong> <?=$data["nume"]?><br />
			<strong>Telefon : </strong> <?=$data["telefon"]?><br />
			<strong>Adresa E-mail: </strong> <?=$data["email"]?><br />
			<strong>Companie: </strong> <?=$data["companie"]?><br />
			<hr>
			<strong>Adresa: </strong> <?=$data["adresa"]?><br />
			<strong>Judet: </strong> <?=$data["judet"]?><br />
			<strong>Localitate: </strong> <?=$data["localitate"]?><br />
			<strong>Numar comanda: </strong> <?=$data["nr_comanda"]?><br />
			<strong>Data comenzii: </strong> <?=$data["data_comenzii"]?><br />
			<strong>Produs: </strong> <?=$data["produs"]?><br />
			<strong>Cod produs: </strong> <?=$data["cod_produs"]?><br />
			<hr>
			<strong>Motiv returnare: </strong> <?=$data["motiv_returnare"]?><br />
		<div class="clearfix"></div>
	</div>
</div>