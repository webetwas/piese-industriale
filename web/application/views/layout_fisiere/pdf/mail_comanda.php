<?php
// var_dump($client);
// var_dump($comanda);die();
?>
<div class="alert alert-info">Observatii: <?=(!is_null($comanda->observatii) ? $comanda->observatii : "")?></div>	
<table class="table table-hover table-sm table-responsive">
  <thead>
    <tr>
      <th>#</th>
      <th>Denumire produse</th>
      <th>Cod</th>
      <th>Marime/culori</th>
      <th>Cantitate</th>
      <th>Pret / RON</th>
      <th>Valoare / RON</th>
    </tr>
  </thead>

  <tbody>
			<?php
				$ctr = 0;
				foreach(json_decode($comanda->cosjson)->articole as $articol) {
					$ctr ++;
					echo '<tr>
					<th scope="row">' .$ctr. '</th>
					<td>' .$articol->atom_name. '</td>
					<td>' .(!is_null($articol->cod_produs) ? $articol->cod_produs : "-"). '</td>
					<td>
						' .(!empty($articol->size) ? 'Marime: ' . $articol->size : '-'). '
						' .(!empty($articol->material_culoare) ? '<br />' . $articol->material_culoare : ' -'). '
						' .(!empty($articol->garnitura_culoare) ? '<br />' . $articol->garnitura_culoare : ' -'). '
					</td>
					<td>x ' .$articol->cantitate. '</td>
					<td>' .$articol->pret. ' Lei</td>
					<td>' .$articol->pret_total. ' Lei</td>
					</tr>';
				}
			?>
  </tbody>
  <thead class="thead-default">
    <tr>
		<th colspan="5"></th>
      <th>Subtotal</th>
      <th><?=json_decode($comanda->cosjson)->subtotal?> Lei</th>
    </tr>
    <tr>
		<th colspan="5"></th>
      <th>Cost transport</th>
      <th><?=json_decode($comanda->cosjson)->transport?> Lei</th>
    </tr>
    <tr>
		<th colspan="5"></th>
      <th>Total</th>
      <th><?=json_decode($comanda->cosjson)->total?> Lei</th>
    </tr>
  </thead>
</table>


<?php ($email ? require_once "nota_email.php" : "")?>

<?php include("footer.php");?>