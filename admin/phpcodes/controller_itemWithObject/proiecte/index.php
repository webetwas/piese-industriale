<?php
// var_dump($proiecte);
?>

<div class="wrapper wrapper-content">
	<div class="text-center animated fadeInRightBig">
		<div class="row">
				<div class="col-lg-12">
						<div class="wrapper wrapper-content animated fadeInUp">

								<div class="ibox">
										<div class="ibox-content">
										<?php if(is_null($proiecte)): echo "Nu s-au gasit Proiecte."; ?>
											<?php elseif(!is_null($proiecte)): ?>
												<div class="project-list">

														<table class="table table-hover">
																<tbody>
																<?php foreach($proiecte as $keyproict => $proiect): ?>
																<tr>
																		<td class="project-title">
																				<a href="project_detail.html"><?=$proiect->project_name;?></a>
																				<br/>
																				<small>Created 14.08.2014</small>
																		</td>
																		<td class="project-completion">
																						<small>Completion with: 48%</small>
																						<div class="progress progress-mini">
																								<div style="width: 48%;" class="progress-bar"></div>
																						</div>
																		</td>
																		<td class="project-people">
																				<a href=""><img alt="image" class="img-circle" src="img/a3.jpg"></a>
																				<a href=""><img alt="image" class="img-circle" src="img/a1.jpg"></a>
																				<a href=""><img alt="image" class="img-circle" src="img/a2.jpg"></a>
																				<a href=""><img alt="image" class="img-circle" src="img/a4.jpg"></a>
																				<a href=""><img alt="image" class="img-circle" src="img/a5.jpg"></a>
																		</td>
																		<td class="project-actions">
																				<a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View </a>
																				<a href="<?=base_url().$controller_fake?>/item/u/id/<?=$proiect->id_project?>" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i> Editeaza </a>
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