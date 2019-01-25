<?php
// var_dump($cerere);die();
// var_dump($produs);die();
?>
<div class="content" style="background-color:#fff;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<ul role="tablist" class="nav nav-tabs">
						<li role="presentation">
							<a href="javascript:void(0);"><strong style="color:black;">Nr. cerere: </strong></a>
						</li>
						<li role="presentation" class="active">
							<a href="javascript:void(0)"> <?=(!is_null($cerere) ? '#' .$cerere->id : "")?></a>
						</li>
					</ul>
					
					<div class="tab-content">
						<div id="comanda" class="tab-pane active">
							<div class="row">
									<div class="col-md-12">
									<?php if(is_null($cerere)): echo "Comandat nu a fost gasita"; else:?>
									
										<div class="typo-line">
												<p class="category" style="font-wight:bold;color:orange;">Potential client</p>

												<div class="row">
														<div class="col-md-3">
															<h5>Date</h5>
															<ul class="list-unstyled" style="border-top:2px solid #ccc;">
																 <li>Nume<strong>: <?=(!is_null($cerere) ? $cerere->nume : "")?></strong></li>
																 <li>E-mail:<strong> <?=(!is_null($cerere) ? $cerere->email : "")?></strong></li>
																 <li>Telefon:<strong> <?=(!is_null($cerere) ? $cerere->telefon : "")?></strong></li>
															</ul>
														</div>
												</div>
										</div>
										<?php endif;?>
										<div class="typo-line">
											<p class="category" style="font-wight:bold;color:orange;">Cerere</p>
											<div class="row">
												<div class="col-md-3">
														<ul class="list-unstyled" style="border-top:2px solid #ccc;">
															 <li>Nr. cerere:<strong> #<?=(!is_null($cerere) ? $cerere->id : "")?></strong></li>
															 <li>Data cerere:<strong> <?=(!is_null($cerere) ? $cerere->insert_date : "")?></strong></li>
															 <br />
															 <li>Mesaj Client:<strong> <?=(!is_null($cerere) ? $cerere->mesaj : "")?></strong></li>
															 <br />
														</ul>
												</div>
												<div class="col-md-12">
													<form method="POST" id="<?=$form->item->id;?>" name="<?=$form->item->name;?>" action="<?=base_url().$form->item->segments?>">
														<div class="content table-responsive table-full-width">
																<table class="table table-hover" style="width:100%">
																		<thead>
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
																				if(!is_null($produs))
																					echo
																					'<tr>
																						<td>#' .$produs->id. '</td>
																						<td>' .$produs->codarticol. '</td>
																						<td>' .$produs->producator. '</td>
																						<td>' .$produs->denumire_ro. '</td>
																						<td>' .$produs->detalii. '</td>
																						<td>' .(!is_null($produs->pretarticola) ? $produs->pretarticola. ' Lei' : "-"). '</td>
																						<td>' .(!is_null($produs->pretarticolb) ? $produs->pretarticolb. ' Lei' : "-"). '</td>
																					</tr>';
																			?>
																			<?php
																				echo '<tr>
																					<td><strong style="color:orange;font-weight:800;font-size:18px;">Stare cerere</strong>:</td>
																					<td>
																						<select name="' .$form->item->prefix. 'starecerere" class="selectpicker" data-title="Stare cerere" data-style="btn-info btn-fill btn-default btn-block" data-menu-style="dropdown-blue">
																								<option ' .(!is_null($cerere) && !is_null($cerere->starecerere) && $cerere->starecerere == "NOUA" ? "selected" : ""). ' value="NOUA">Cerere noua</option>
																								<option ' .(!is_null($cerere) && !is_null($cerere->starecerere) && $cerere->starecerere == "IN_CURS" ? "selected" : ""). ' value="IN_CURS">In curs de procesare</option>
																								<option ' .(!is_null($cerere) && !is_null($cerere->starecerere) && $cerere->starecerere == "FINALIZATA" ? "selected" : ""). ' value="FINALIZATA">Finalizata</option>
																								<option ' .(!is_null($cerere) && !is_null($cerere->starecerere) && $cerere->starecerere == "ANULATA" ? "selected" : ""). ' value="ANULATA">Anulata</option>
																						</select>																				
																					</td>
																					<td colspan="6"></td>
																				</tr>';
																			?>
																		</tbody>
																</table>
														</div>
													 <div class="row" style="margin-top: 30px;">
															<fieldset>
																	<div class="form-group">
																			<div class="col-sm-12">
																				 <button type="submit" name="<?=$form->item->prefix;?>submit" class="btn btn-success btn-fill btn-wd" onClick="">Actualizeaza cerere</button>
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