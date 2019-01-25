<?php
// var_dump($comenzi);
// var_dump($client);die();
?>
<div class="wrapper wrapper-content animated fadeIn">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<ul role="tablist" class="nav nav-tabs">
						<li role="presentation" class="active">
							<a href="#comenzi" data-toggle="tab"> <?=(!is_null($client) ? $client->nume. ' ' .$client->prenume : "Comenzi")?></a>
						</li>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
						<li style="background-color:white;">
							<a href="javascript:void(0);"><strong style="color:black;">Comanda noua</strong></a>
						</li>
						<li style="background-color:yellow;">
							<a href="javascript:void(0);"> <strong style="color:black;">In curs de procesare</strong></a>
						</li>
						<li style="background-color:orange;">
							<a href="javascript:void(0);"> <strong style="color:black;">Expediata</strong></a>
						</li>
						<li style="background-color:green;">
							<a href="javascript:void(0);"> <strong style="color:black;">Finalizata</strong></a>
						</li>
						<li style="background-color:red;">
							<a href="javascript:void(0);"> <strong style="color:black;">Anulata</strong></a>
						</li>
					</ul>
					
					<div class="tab-content">
						<div id="comenzi" class="tab-pane active">
							<div class="row">
									<div class="col-md-12">
									<?php if(is_null($comenzi)): echo "Nu exista comenzi"; else:?>
										<div class="content table-responsive table-full-width">
												<table class="table table-hover">
														<thead>
															<th>Nr. comanda</th>
															<th>Client</th>
															<th>Total comanda</th>
															<th>Data comanda</th>
															<th>Stare comanda</th>
															<th>PDF</th>
															<th>Detalii</th>
															<th>Stergere</th>
														</thead>
														<tbody>
														<?php
															foreach($comenzi as $comanda) {
																// var_dump($comanda);die();
																$stare = null; $color = null;
																switch($comanda->starecomanda):
																	case "CMD_NOUA":
																		$stare = "Comanda noua";
																		$color = "white";
																	break;
																	case "IN_CURS":
																		$stare = "In curs de procesare";
																		$color = "yellow";
																	break;
																	case "EXPEDIATA":
																		$stare = "Comanda expediata";
																		$color = "orange";
																	break;
																	case "FINALIZATA":
																		$stare = "Comanda finalizata";
																		$color = "green";
																	break;
																	case "ANULATA":
																		$stare = "Comanda anulata";
																		$color = "red";
																	break;
																endswitch;
																echo '
																	<tr style="background-color:white;">
																		<td style="background-color:' .$color. '">#' .$comanda->id. '</td>
																		<td>' .$comanda->client_numeprenume. '</td>
																		<td>' .$comanda->totalcomanda. ' Lei</td>
																		<td>' .$comanda->insert_date. '</td>
																		<td>' .$stare. '</td>
																		<td><a href="' .SITE_URL. 'afiseazafisiere/factura/' .$comanda->id_client. '/' .$comanda->id. '/pdf/admin" target="_blank"><i class="fa fa-file-pdf-o"></i> Vizualizare PDF</a></a></td>
																		<td><a href="' .base_url(). 'magazin/item/u/id/' .$comanda->id. '"><i class="fa fa-info-circle fa-lg" aria-hidden="true" style="color:' .$color. ';"></i> <span style="color:black;text-decoration:underline;">Detalii</span></a></td>
																		<td>
																			<a type="button" style="margin-top:-3px" href="' .base_url(). 'magazin/item/d/id/' .$comanda->id. '" title="Sterge" class="btn btn-danger btn-simple btn-icon ahrefaskconfirm">
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