<?php
// var_dump($item);
// var_dump($parent);
// var_dump($data_object);
?>

<div class="wrapper wrapper-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">

				<div class="tabs-container">

					<ul role="tablist" class="nav nav-tabs">
						<li role="presentation" class="active">
							<a href="#tab1" data-toggle="tab"><?=(!is_null($item) && !is_null($item->denumire_ro) ? $item->denumire_ro : "Creeaza " . strtolower($Prototype->air_identnewitem));?></a>
						</li>
						<?php if(!is_null($item)):?>
						<li role="presentation">
							<a href="#pagina_meta" data-toggle="tab">Meta</a>
						</li>
						<?php endif; ?>
					</ul>

						<div class="tab-content">
							<!--start#tab1-->
							<div id="tab1" class="tab-pane active">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<form class="form-horizontal" method="POST" name="<?=$form->item->name;?>" action="<?=base_url().$form->item->segments?>">
												
												<?php if(!is_null($parent)): ?>
												<div class="row">
													<div class="form-group"><label class="col-sm-2 control-label"><?=$Prototype->air_identnewitem?> parinte</label>
														<div class="col-sm-10"><input type="text" class="form-control" value="<?=$parent->denumire_ro?>" disabled></div>
													</div>
												</div>
												<?php endif; ?>
												
												<div class="row">
													<div class="form-group">
														<label class="col-sm-2 control-label">Nume <?=strtolower($Prototype->air_identnewitem)?></label>
														<div class="col-sm-10">
															<input type="text" class="form-control" name="<?=$form->item->prefix;?>denumire_ro" value="<?=(!is_null($item) && !is_null($item->denumire_ro) ? $item->denumire_ro : "");?>" required>
														</div>
													</div>
												</div>
												
												<?php if(!is_null($item)):?>
												
												<div class="row">
													<div class="form-group">
														<label class="col-sm-2 control-label">Nume <?=strtolower($Prototype->air_identnewitem)?> <span style="color:red;">ENG</span></label>
														<div class="col-sm-10">
															<input type="text" class="form-control" name="<?=$form->item->prefix;?>denumire_en" value="<?=(!is_null($item) && !is_null($item->denumire_en) ? $item->denumire_en : "");?>">
														</div>
													</div>
												</div>												
												
												<div class="row">
													<div class="form-group">
														<label class="col-sm-2 control-label">Titlu</label>
														<div class="col-sm-10">
															<input type="text" placeholder="Titlu" class="form-control" name="<?=$form->item->prefix;?>i_titlu_ro" value="<?=(!is_null($item) && !is_null($item->i_titlu_ro) ? $item->i_titlu_ro : "");?>">
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="form-group">
														<label class="col-sm-2 control-label">Titlu <span style="color:red;">ENG</span></label>
														<div class="col-sm-10">
															<input type="text" placeholder="Titlu" class="form-control" name="<?=$form->item->prefix;?>i_titlu_en" value="<?=(!is_null($item) && !is_null($item->i_titlu_en) ? $item->i_titlu_en : "");?>">
														</div>
													</div>
												</div>												
												
												<div class="row">
													<div class="form-group">
														<label class="col-sm-2 control-label">Subtitlu</label>
														<div class="col-sm-10">
															<input type="text" placeholder="Subtitlu" class="form-control" name="<?=$form->item->prefix;?>i_subtitlu_ro" value="<?=(!is_null($item) && !is_null($item->i_subtitlu_ro) ? $item->i_subtitlu_ro : "");?>">
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="form-group">
														<label class="col-sm-2 control-label">Subtitlu <span style="color:red;">ENG</span></label>
														<div class="col-sm-10">
															<input type="text" placeholder="Subtitlu" class="form-control" name="<?=$form->item->prefix;?>i_subtitlu_en" value="<?=(!is_null($item) && !is_null($item->i_subtitlu_en) ? $item->i_subtitlu_en : "");?>">
														</div>
													</div>
												</div>
												
												<hr>
												<div class="row">
													<div class="form-group">
																<div class="col-sm-3">
																	<div class="file-box" style="margin-top:15px;">
																		<div class="file">
																			<a href="javascript:void(0)" id="images-add-new">
																				<span class="corner"></span>

																				<div class="icon">
																					<i class="fa fa-file-image-o"></i>
																				</div>
																				<div class="file-name">
																					<strong style="font-size:16px;">Incarca imagine</strong>
																				</div>
																			</a>
																		</div>

																	</div>
																</div>
														<div class="col-sm-9">
															<div id="p_imgpoza">
																<?php
																	if(isset($item->i) && $item->i) {
																		foreach($item->i as $img) {
																			echo '
																				<div id="imgpoza-' .$img->id. '" class="col-lg-2 col-md-4 col-xs-6 col-xs-12 thumb-nomg">
																					<div class="img-thumbnail" style="padding:2px;">
																						<img class="img-responsive" src="' .$imgpathitem.$img->img. '">
																						<div class="thumbfooter">
																							<a href="javascript:void(0)" onClick="return ajxdelimg(' .$img->id. ', \'poza\');return false"><code-remove>Elimina</code-remove></a>
																						</div>
																					</div>
																				</div>
																			';
																		}
																	}
																?>
															</div>
														</div>
													</div>
												</div>												
												
												<?php endif; ?>												
												
												<hr style="border:0;padding:15px;">
												<fieldset>
														<div class="form-group">
															<div class="col-sm-12">
																<button class="btn btn-white" type="button" onClick="location.href='<?=base_url()?><?=$Prototype->air_controller?>'">Anuleaza</button>
																<button class="btn btn-primary" type="submit" name="<?=$form->item->prefix;?>submit"><?=(isset($uri->item) && $uri->item == "i" ? 'Creeaza ' . strtolower($Prototype->air_identnewitem) : "Salveaza modificarile")?></button>
															</div>
														</div>
												</fieldset>
											</form>
										</div> <!-- end col-md-12 -->
									</div>
								</div>
							</div><!--end#tab1-->
							
							<?php if(!is_null($item)):?>
							<!--start#pagina_meta-->
							<div id="pagina_meta" class="tab-pane">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<form method="POST" name="<?=$form->meta->name;?>" action="<?=base_url().$form->meta->segments?>">

												<?php
													// Admin
													if($application->user->privilege) {
														echo '
														<div class="row">
															<div class="col-sm-12">
																<div class="form-group">
																	<label>Slug ID</label>
																	<input type="text" name="' .$form->meta->prefix. 'slug" value="' .$item->slug. '" placeholder="Slug" class="form-control" readonly>
																</div>
															</div>
														</div>';
												}
												?>

												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>Titlu Browser</label>
															<input type="text" name="<?=$form->meta->prefix;?>title_browser_ro" value="<?=(!is_null($item->title_browser_ro) ? $item->title_browser_ro : "")?>" placeholder="Titlu Browser" class="form-control">
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>Meta description</label>
															<input type="text" name="<?=$form->meta->prefix;?>meta_description" value="<?=(!is_null($item->meta_description) ? $item->meta_description : "");?>" placeholder="Meta description" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-12">
														<div class="form-group">
															<label>Keywords</label>
															<input type="text" name="<?=$form->meta->prefix;?>keywords" value="<?=(!is_null($item->keywords) ? $item->keywords : "");?>" placeholder="Keywords" class="form-control">
															<span class="help-block">"cuvant, cuvant cheie, alt cuvant"</span>
														</div>
													</div>
												</div>
												<div class="hr-line-dashed"></div>
												<fieldset>
														<div class="form-group">
																<div class="col-sm-12">
																	<button class="btn btn-white" type="button" onClick="location.href='<?=base_url()?><?=$Prototype->air_controller?>'">Anuleaza</button>
																	<button type="submit" name="<?=$form->meta->prefix;?>submit" class="btn btn-info btn-fill btn-wd" onClick="return showloader();">Salveaza modificarile</button>
																</div>
														</div>
												</fieldset>
											</form>
										</div> <!-- end col-md-12 -->
									</div>
								</div>
							</div><!--end#pagina_meta-->
							<?php endif; ?>
							
						</div>
					</div>
				</div>
			</div>

</div>
<?php if(!is_null($item)): ?>
<div id="dialog-images" title="Proceseaza imagine" style="display:none;">
	<div class="row" style="margin-right:-14px;margin-left:-14px;">
	
		<div class="col-sm-2">
		
			<strong>Incarca o imagine si incepe procesarea..</strong>
			<hr>
		
			<div class="btn-group">
				<label title="Upload image file" for="imager-upload-image" class="btn btn-lg btn-success">
					<input type="file" accept="image/*" name="file" id="imager-upload-image" class="hide">
					<i class="fa fa-file-image-o"></i> Incarca o imagine
				</label>
			</div>
			<div class="btn-group" style="margin-top:10px;">
				<button class="btn btn-default" id="imager-removeoptimalsizes" style="display:none;color:red"><i class="fa fa-exclamation-circle"></i> Renunta la dimensiunile optime: <strong style="color:#000;"><?=$imager[0]->height?> x <?=$imager[0]->width?></strong></button>
			</div>
			<div class="btn-group" style="margin-top:10px;">
				<button class="btn btn-default" id="imager-applyoptimalsizes" style="display:none;font-weight:bold;color:#1c84c6;"><i class="fa fa-check"></i> Aplica dimensiunile optime: <strong style="color:#000;"><?=$imager[0]->height?> x <?=$imager[0]->width?></strong></button>
			</div>
		</div>
	
		<div class="col-sm-10">
			<div id="imager-upload-message" style="margin-top:200px;">
				<h2 style="text-align:center;color:#000;"><i class="fa fa-file-image-o"></i> Incarca o imagine pentru a incepe procesarea</h2>
			</div>
			
			<div id="imager-upload-wrap" style="display:none;">
				<div id="imager-croppie"></div>
			</div>
		</div>
	</div>

</div>
<form name="imager-form" id="imager-form">
	<input type="hidden" id="imager-form-data" name="data" />
</form>
<?php endif; ?>