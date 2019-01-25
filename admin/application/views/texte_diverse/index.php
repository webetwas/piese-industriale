<?php
// var_dump($atoms);
?>

<div class="wrapper wrapper-content">
	<div class="middle-box text-center animated fadeInRightBig" style="margin-top:0;padding-top:0;max-width:1050px;">
		<div class="row">
				<div class="col-lg-12">
						<div class="wrapper wrapper-content animated fadeInUp">

								<div class="ibox">
										<div class="ibox-content">
										<?php if(is_null($atoms)): echo "Nu s-au gasit Iteme."; ?>
											<?php elseif(!is_null($atoms)): ?>
												<div class="project-list">

														<table class="table table-hover">
																<tbody>
																<?php foreach($atoms as $key_atom => $atom_value): ?>
																<tr>
																		<td class="project-title">
																				<a href="<?=base_url().$controller_fake?>/atom/u/id/<?=$atom_value->atom_id?>"><?=$atom_value->atom_name_ro;?></a>
																				<!--<br/>-->
																				<!--<small>Created 14.08.2014</small>-->
																		</td>																
																		
																		<td class="project-actions">
																			<a href="<?=base_url().$controller_fake?>/atom/u/id/<?=$atom_value->atom_id?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Editeaza </a>
																			<a href="<?=base_url().$controller_fake?>/atom/d/id/<?=$atom_value->atom_id?>" class="btn btn-danger btn-sm ahrefaskconfirm"><i class="fa fa-trash"></i> Sterge </a>
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