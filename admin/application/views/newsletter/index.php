<?php
// var_dump($items);
?>

<div class="wrapper wrapper-content">
	<div class="middle-box animated fadeInRightBig" style="margin-top:0;padding-top:0;max-width:950px;">
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
																	<th>Adresa E-mail</th>
																	<th>Inregistrat la data:</th>
																	<th></th>
																</thead>
																<?php foreach($items as $keyitem => $item): ?>
																<tbody>
																<tr>
																		<td>
																			<?=$item->email?>
																		</td>
																		<td>
																			<?=$item->date_insert?>
																		</td>
																		<td class="project-actions">
																			<a href="<?=base_url().$controller_fake?>/sterge_participant/<?=$item->id_item?>" class="btn btn-danger btn-sm ahrefaskconfirm"><i class="fa fa-trash"></i> Sterge </a>
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