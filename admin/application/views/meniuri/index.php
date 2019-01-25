<?php
// var_dump($atoms);
?>

<div class="wrapper wrapper-content">
	<div class="middle-box text-center animated fadeInRightBig" style="margin-top:0;padding-top:0;max-width:950px;">
		<div class="row">
			<div class="col-lg-12">
				<div class="wrapper wrapper-content animated fadeInUp">

					<div class="ibox">
						<div class="ibox-content" style="padding:0;">
						<?php if(is_null($atoms)): echo "Nu s-au gasit Iteme."; ?>
							<?php elseif(!is_null($atoms)): ?>
								<div class="project-list">

									<table class="table table-hover">
										<thead>
											<th></th>
											<th><i class="fa fa-star" style="color:red;"></i> Principal</th>
											<th>Afisare</th>
											<th></th>
										</thead>
										
										<tbody>
										<?php foreach($atoms as $key_atom => $atom): ?>
										<tr>
											<td class="project-title" style="text-decoration:underline;">
												<a href="<?=base_url().$controller_fake?>/atom/u/id/<?=$atom->atom_id?>">&nbsp;<?=$atom->atom_name_ro;?>&nbsp;</a>
												<!--<br/>-->
												<!--<small>Created 14.08.2014</small>-->
											</td>
											<td>
												<div class="switch">
													<div class="onoffswitch">
														<input type="checkbox" class="onoffswitch-checkbox abmenu" id="a_<?=$atom->atom_id?>" <?=$atom->parent_fake ? "checked" : ""?>>
														<label class="onoffswitch-label" for="a_<?=$atom->atom_id?>">
																<span class="onoffswitch-inner"></span>
																<span class="onoffswitch-switch"></span>
														</label>
													</div>
												</div>
											</td>
											<td>
												<div class="switch">
													<div class="onoffswitch">
														<input type="checkbox" class="onoffswitch-checkbox abmenu" id="b_<?=$atom->atom_id?>" <?=$atom->atom_isactive ? "checked" : ""?>>
														<label class="onoffswitch-label" for="b_<?=$atom->atom_id?>">
																<span class="onoffswitch-inner"></span>
																<span class="onoffswitch-switch"></span>
														</label>
													</div>
												</div>																		
											</td>
											<td class="project-actions">
												<a href="<?=base_url().$controller_fake?>/atom/u/id/<?=$atom->atom_id?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Editeaza </a>
												<a href="<?=base_url().$controller_fake?>/atom/d/id/<?=$atom->atom_id?>" class="btn btn-danger btn-sm ahrefaskconfirm"><i class="fa fa-trash"></i> Sterge </a>
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