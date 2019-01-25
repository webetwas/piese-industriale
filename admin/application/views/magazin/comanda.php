<?php
// var_dump($comanda);
// var_dump(json_decode($comanda->cosjson));
// die();
// var_dump($client);
?>
<div class="wrapper wrapper-content animated fadeIn">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<ul role="tablist" class="nav nav-tabs">
						<li role="presentation">
							<a href="javascript:void(0);"><strong style="color:black;">Nr. Comanda: </strong></a>
						</li>
						<li role="presentation" class="active">
							<a href="javascript:void(0)"> <?=(!is_null($comanda) ? '#' .$comanda->id : "")?></a>
						</li>
						<li role="presentation">
							<a href="javascript:void(0)"> <?=(!is_null($client) ? '<strong style="color:black;">Client: </strong>' : "")?></a>
						</li>
						<li role="presentation" class="active">
							<a href="javascript:void(0)"> <?=(!is_null($client) ? $client->nume. " "  . $client->prenume : "")?></a>
						</li>
					</ul>
					
					<div class="tab-content">
						<div id="comanda" class="tab-pane active">
							<div class="row">
									<div class="col-md-12">
									<?php if(is_null($comanda)): echo "Comandat nu a fost gasita"; else:?>
									
										<div class="typo-line" style="margin-top:20px;">
												<p class="category" style="font-wight:bold;color:orange;">Client</p>

												<div class="row">
														<div class="col-md-3">
															<h5>Date</h5>
															<ul class="list-unstyled" style="border-top:2px solid #ccc;">
																 <li>Nume/Prenume<strong>: <?=(!is_null($client) ? $client->nume. " "  .$client->prenume : "")?></strong></li>
																 <li>Telefon:<strong> <?=(!is_null($client) ? $client->telefon : "")?></strong></li>
																 <li>Adresa E-mail:<strong> <?=(!is_null($client) ? $client->email : "")?></strong></li>
																 <li>Persoana:<strong> <?=(!is_null($client) ? ($client->pfpj == "PF" ? "Fizica" : "Juridica") : "")?></strong></li>
															</ul>
														</div>
														<?php if(!is_null($client) && $client->pfpj == "PJ"): ?>
														<div class="col-md-3">
															<h5>Companie</h5>
															<ul class="list-unstyled" style="border-top:2px solid #ccc;">
																<li>Companie:<strong> <?=(!is_null($client) ? $client->pj_firma : "")?></strong></li>
																<li>Comert:<strong> <?=(!is_null($client) ? $client->pj_comert : "")?></strong></li>
																<li>Fiscal:<strong> <?=(!is_null($client) ? $client->pj_fiscal : "")?></strong></li>
																<li>Banca:<strong> <?=(!is_null($client) ? $client->pj_banca : "")?></strong></li>
																<li>Cont banca:<strong> <?=(!is_null($client) ? $client->pj_contbanca : "")?></strong></li>
																<li>Adresa Companie:<strong> <?=(!is_null($client) ? $client->pj_adresa : "")?></strong></li>
																<li>E-mail:<strong> <?=(!is_null($client) ? $client->pj_email : "")?></strong></li>
																<li>Companie Telefon:<strong> <?=(!is_null($client) ? $client->pj_telefon : "")?></strong></li>
															</ul>
														</div>
														<?php endif; ?>
														<div class="col-md-3">
																<h5>Date livrare</h5>
																<ul class="list-unstyled" style="border-top:2px solid #ccc;">
																	 <li>Adresa:<strong> <?=(!is_null($client) ? $client->adresa : "")?></strong></li>
																	 <li>Oras:<strong> <?=(!is_null($client) ? $client->oras : "")?></strong></li>
																	 <li>Judet:<strong> <?=(!is_null($client) ? $client->judet : "")?></strong></li>
																</ul>
														</div>
												</div>
										</div>
										<?php endif;?>
										<div class="typo-line">
											<p class="category" style="font-wight:bold;color:orange;">Comanda</p>
											<div class="row">
												<div class="col-md-3">
														<ul class="list-unstyled" style="border-top:2px solid #ccc;">
															 <li>Nr. comanda:<strong> #<?=(!is_null($comanda) ? $comanda->id : "")?></strong></li>
															 <li>Data comanda:<strong> <?=(!is_null($comanda) ? $comanda->insert_date : "")?></strong></li>
															 <li>Total de plata: <strong> <?=(!is_null($comanda) ? $comanda->totalcomanda : "")?> Lei</strong></li>
															 <li>Metoda de plata:<strong> <?=(!is_null($comanda) ? $comanda->metodaplata : "")?></strong></li>
															 <li>Metoda de livrare:<strong> <?=(!is_null($comanda) ? $comanda->metodalivrare : "")?></strong></li>
															 <li>Observatii:<strong> <?=(!is_null($comanda) ? $comanda->observatii : "")?></strong></li>
															 <br />
														</ul>
												</div>
												<div class="col-md-12">
													<form method="POST" id="<?=$form->item->id;?>" name="<?=$form->item->name;?>" action="<?=base_url().$form->item->segments?>">
														<div class="content table-responsive table-full-width">
																<table class="table table-hover" style="width:100%">
																		<thead>
																			<th></th>
																			<th>ID Produs</th>
																			<th>Cod Articol</th>
																			<th>Producator</th>
																			<th>Denumire Produs</th>
																			<th>Detalii</th>
																			<th>Cantitate</th>
																			<th>Pret</th>
																			<th>Pret nou</th>
																		</thead>
																		<tbody>
																			<?php
																				foreach(json_decode($comanda->cosjson)->articole as $produs) {
																					$image = null;
																					if(!empty($produs->images)) {
																						$images = explode(',', $produs->images);
																						$image = '<img src="' . SITE_URL. 'public/upload/img/catalog_produse/s/' . $images[0] . '" height="50px" />';
																					} else {
																						$image = '<img src="' . SITE_URL. 'public/assets/img/product/blank_product.jpg" height="50px" />';
																					}
																					echo
																					'<tr>
																						<td>' .(!is_null($image) ? $image : ''). '</td>
																						<td>#' .$produs->atom_id. '</td>
																						<td>' .$produs->cod_produs. '</td>
																						<td>' .$produs->producator. '</td>
																						<td>' .$produs->atom_name. '</td>
																						<td>'
																						.(!empty($produs->size) ? 'Marime: ' .$produs->size : '').
																						(!empty($produs->material_culoare) ? '<br />' . $produs->material_culoare : '').
																						(!empty($produs->garnitura_culoare) ? '<br />' . $produs->garnitura_culoare : '').
																						'</td>
																						<td><strong>x ' .$produs->cantitate. '</strong></td>
																						<td>' .(!is_null($produs->pret) ? $produs->pret. ' Lei' : "-"). '</td>
																						<td>' .(!is_null($produs->pret_nou) ? $produs->pret_nou. ' Lei' : "-"). '</td>
																					</tr>';
																				}
																			?>
																			<tr style="color:#000;">
																				<td colspan="6">&nbsp;</td>
																				<td>Subtotal</td>
																				<td><?=$comanda->subtotal?> Lei</td>
																			</tr>
																			<tr style="color:#000;">
																				<td colspan="6">&nbsp;</td>
																				<td>Cost transport</td>
																				<td><?=$comanda->cost_transport?> Lei</td>
																			</tr>
																			<?php
																				echo '<tr>
																					<td><strong style="color:orange;font-weight:800;font-size:18px;">Stare Comanda</strong>:</td>
																					<td>
																						<select name="' .$form->item->prefix. 'starecomanda" class="selectpicker" data-title="Stare comanda" data-style="btn-info btn-fill btn-default btn-block" data-menu-style="dropdown-blue">
																								<option ' .(!is_null($comanda) && !is_null($comanda->starecomanda) && $comanda->starecomanda == "CMD_NOUA" ? "selected" : ""). ' value="CMD_NOUA">Comanda noua</option>
																								<option ' .(!is_null($comanda) && !is_null($comanda->starecomanda) && $comanda->starecomanda == "IN_CURS" ? "selected" : ""). ' value="IN_CURS">In curs de procesare</option>
																								<option ' .(!is_null($comanda) && !is_null($comanda->starecomanda) && $comanda->starecomanda == "EXPEDIATA" ? "selected" : ""). ' value="EXPEDIATA">Expediata</option>
																								<option ' .(!is_null($comanda) && !is_null($comanda->starecomanda) && $comanda->starecomanda == "FINALIZATA" ? "selected" : ""). ' value="FINALIZATA">Finalizata</option>
																								<option ' .(!is_null($comanda) && !is_null($comanda->starecomanda) && $comanda->starecomanda == "ANULATA" ? "selected" : ""). ' value="ANULATA">Anulata</option>
																						</select>																				
																					</td>
																					<td colspan="4"></td>
																					<td><strong style="color:black;font-weight:800;font-size:18px;">Total: </strong></td>
																					<td><strong style="color:red;font-weight:800;font-size:18px;">' .$comanda->totalcomanda. ' Lei</strong></td>
																				</tr>';
																			?>
																		</tbody>
																</table>
														</div>
													 <div class="row" style="margin-top: 30px;">
															<fieldset>
																	<div class="form-group">
																			<div class="col-sm-12">
																				 <button type="submit" name="<?=$form->item->prefix;?>submit" class="btn btn-success btn-fill btn-wd" onClick="">Actualizeaza comanda</button>
																			</div>
																	</div>
															</fieldset>
														</div>													
													</form>
												</div>
											</div>
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>