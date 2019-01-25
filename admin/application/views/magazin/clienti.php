<?php
// echo "<pre>";
// var_dump($clienti);
// echo "</pre>";
?>

<div class="wrapper wrapper-content animated fadeIn">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<ul role="tablist" class="nav nav-tabs">
						<li role="presentation" class="active">
							<a href="#clienti" data-toggle="tab"> Clienti</a>
						</li>
					</ul>
					
					<div class="tab-content">
						<div id="clienti" class="tab-pane active">
							<div class="row">
									<div class="col-md-12">
									<?php if(is_null($clienti)): echo "Nu exista clienti"; else:?>
										<div class="content table-responsive table-full-width">
												<table class="table table-hover table-striped">
														<thead>
															<th>Nume / Prenume</th>
															<th>E-mail</th>
															<th>Telefon</th>
															<th></th>
															<th></th>
															<th>Total comenzi</th>
															<th></th>
														</thead>
														<tbody>
														<?php
															foreach($clienti as $client) {
																echo '
																	<tr>
																		<td>' .$client->nume." ".$client->prenume. '</td>
																		<td>' .$client->email. '</td>
																		<td>' .$client->telefon.'</td>
																		<td><a href="' .base_url(). 'magazin/comenzi/' .$client->uniqueid. '">Istoric comenzi </a>																		
																		</td>
																		<td>' .(!is_null($client->id_utilizator) ? 'Cont <i class="fa fa-user-circle" aria-hidden="true" style="color:green;"></i>' : ""). '</td>
																		<td>' .(is_null($client->total) ? "Fara comenzi" : $client->total. " Lei"). '</td>
																		<td>
																			<a type="button" style="margin-top:-3px" href="' .base_url(). 'magazin/sterge_client/' .$client->id. '" title="Sterge" class="btn btn-danger btn-simple btn-icon ahrefaskconfirm">
																					<i class="fa fa-times-circle"></i>
																			</a>																		
																		</td>
																	</tr>
																';
															}
														?>
														</tbody>
												</table>
										</div>
										<?php endif;?>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>