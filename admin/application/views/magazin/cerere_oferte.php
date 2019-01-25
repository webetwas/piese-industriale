<?php
// var_dump($comenzi);
// var_dump($cerere_oferte);die();
?>
<div class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<div class="content">
					<ul role="tablist" class="nav nav-tabs">
						<li role="presentation">
							<a href="javascript:void(0);"><strong style="color:black;">Client - Cerere:</strong></a>
						</li>
						<li role="presentation" class="active">
							<a href="#clienti" data-toggle="tab">Oferte</a>
						</li>
						<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li>
						<li style="background-color:white;">
							<a href="javascript:void(0);"><strong style="color:black;">Cerere noua</strong></a>
						</li>
						<li style="background-color:yellow;">
							<a href="javascript:void(0);"> <strong style="color:black;">In curs de procesare</strong></a>
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
									<?php if(is_null($cerere_oferte)): echo "Nu exista cereri"; else:?>
										<div class="content table-responsive table-full-width">
												<table class="table table-hover">
														<thead>
															<th>Nr. comanda</th>
															<th>Nume</th>
															<th>Data comanda</th>
															<th>Stare comanda</th>
															<th>Detalii</th>
															<th>Stergere</th>
														</thead>
														<tbody>
														<?php
															foreach($cerere_oferte as $cerere) {
																// var_dump($comanda);die();
																$stare = null; $color = null;
																switch($cerere->starecerere):
																	case "NOUA":
																		$stare = "Cerere noua";
																		$color = "white";
																	break;
																	case "IN_CURS":
																		$stare = "In curs de procesare";
																		$color = "yellow";
																	break;
																	case "FINALIZATA":
																		$stare = "Cerere finalizata";
																		$color = "green";
																	break;
																	case "ANULATA":
																		$stare = "Cerere anulata";
																		$color = "red";
																	break;
																endswitch;
																echo '
																	<tr style="background-color:white;">
																		<td style="background-color:' .$color. '">#' .$cerere->id. '</td>
																		<td>' .$cerere->nume. '</td>
																		<td>' .$cerere->insert_date. '</td>
																		<td>' .$stare. '</td>
																		<td><a href="' .base_url(). 'magazin/cerere/u/id/' .$cerere->id. '"><i class="fa fa-info-circle fa-lg" aria-hidden="true" style="color:' .$color. ';"></i> <span style="color:black;text-decoration:underline;">Detalii</span></a></td>
																		<td>
																			<a type="button" style="margin-top:-3px" href="#"onclick="return showloader();return false" data-placement="left" title="Sterge" class="btn btn-danger btn-simple btn-icon ">
																					<i class="fa fa-times-circle fa-2x"></i>
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