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
							<a href="#clienti" data-toggle="tab"> Utilizatori Magazin</a>
						</li>
					</ul>
					
					<div class="tab-content">
						<div id="clienti" class="tab-pane active">
							<div class="row">
									<div class="col-md-12">
									<?php if(is_null($utilizatori)): echo "Nu exista utilizatori inregistrati"; else:?>
										<div class="content table-responsive table-full-width">
												<table class="table table-hover table-striped">
														<thead>
															<th>Nume / Prenume</th>
															<th>E-mail</th>
															<th>Telefon</th>
															<th>Inregistrat</th>
															<th></th>
														</thead>
														<tbody>
														<?php
															foreach($utilizatori as $utilizator) {
																echo '
																	<tr>
																		<td><i class="fa fa-user-circle" aria-hidden="true" style="color:green;"></i> ' .$utilizator->nume. '</td>
																		<td>' .$utilizator->email. '</td>
																		<td>' .$utilizator->telefon.'</td>
																		<td>' .$utilizator->date_insert.'</td>
																		<td>
																			<a type="button" style="margin-top:-3px" href="' .base_url(). 'magazin/sterge_utilizator/' .$utilizator->id. '" title="Sterge" class="btn btn-danger btn-simple btn-icon ahrefaskconfirm">
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