<?php
// var_dump($items);
?>

<div class="wrapper wrapper-content">
	<div class="middle-box text-center animated fadeInRightBig" style="margin-top:0;padding-top:0;max-width:1050px;">
		<div class="row">
				<div class="col-lg-12">
						<div class="wrapper wrapper-content animated fadeInUp">

								<div class="ibox">
										<div class="ibox-content">
										<?php if(is_null($items)): echo "Nu s-au gasit Iteme."; ?>
											<?php elseif(!is_null($items)): ?>
												<div class="project-list">

														<table class="table table-hover">
																<tbody>
																<?php foreach($items as $keyitem => $item): ?>
																<tr>
																		<td class="project-title">
																				<a href="<?=base_url().$controller_fake?>/item/u/id/<?=$item->atom_id?>"><?=$item->atom_name;?></a>
																				<!--<br/>-->
																				<!--<small>Created 14.08.2014</small>-->
																		</td>
																		
																		<td class="project-title">
																			<?=(!is_null($item->email) ? $item->email : "")?>
																		</td>

																		<td class="project-title">
																			<?=(!is_null($item->telefon) ? $item->telefon : "")?>
																		</td>																		
																		
																		<td class="project-people">
																		<?php if($item->i): ?>
																			<?php foreach($item->i as $img): ?>
																				<a href=""><img alt="image" class="img-rounded" src="<?=$imgpathitem.$img->img?>"></a>
																			<?php endforeach; ?>
																		<?php endif; ?>
																		</td>																	
																		
																		<td class="project-actions">
																			<a href="<?=base_url().$controller_fake?>/item/u/id/<?=$item->atom_id?>" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Editeaza </a>
																			<a href="<?=base_url().$controller_fake?>/item/d/id/<?=$item->atom_id?>" class="btn btn-danger btn-sm ahrefaskconfirm"><i class="fa fa-trash"></i> Sterge </a>
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