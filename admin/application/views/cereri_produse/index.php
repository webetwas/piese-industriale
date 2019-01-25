<?php
// var_dump($items);
?>

<div class="wrapper wrapper-content">
	<div class="animated fadeInRightBig" style="margin-top:0;padding-top:0;">
		<div class="row">
				<div class="col-lg-12">
						<div class="wrapper wrapper-content animated fadeInUp">

								<div class="ibox">
										<div class="ibox-content" style="padding:0;">
										<?php if(is_null($items)): echo "Nu s-au gasit Iteme."; ?>
											<?php elseif(!is_null($items)): ?>
												<div class="project-list">

														<table class="table table-hover">
																
																<thead>
																	<th>Produs</th>
																	<th>Nume</th>
																	<th>Telefon</th>
																	<th>Email</th>
																	<th style="max-width:20%;">Mesaj</th>
																	<th>Data</th>
																	<th></th>
																	<th></th>
																</thead>
																<?php foreach($items as $keyitem => $item): ?>
																<tbody>
																<tr>
																		<td>
																			<a href="<?=base_url()?>catalog_produse/item/u/id/<?=$item->atom_id?>"><?=$item->atom_name_ro?></a>
																		</td>
																		<td>
																			<?=$item->nume?>
																		</td>
																		<td>
																			<?=$item->telefon?>
																		</td>
																		<td>
																			<?=$item->email?>
																		</td>
																		<td>
																			<?=$item->mesaj?>
																		</td>
																		<td>
																			<?=$item->date?>
																		</td>
																		<td class="project-actions">
																			<?php if($item->seen == 0): ?>
																			<a href="<?=base_url().$controller_fake?>/finalizata/<?=$item->cerere_id?>" class="btn btn-primary btn-sm">Vazut </a>
																			<?php endif; ?>
																		</td>
																		<td class="project-actions">
																			<a href="<?=base_url().$controller_fake?>/sterge_participant/<?=$item->cerere_id?>" class="btn btn-danger btn-sm ahrefaskconfirm"><i class="fa fa-trash"></i> Sterge </a>
																		</td>
																</tr>
																<?php endforeach; ?>
																</tbody>
														</table>
												</div>
											<?php endif; ?>
										</div>
								</div>
						</div>
				</div>
		</div>	
	</div>
</div>