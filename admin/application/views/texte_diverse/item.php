<?php
// echo '<pre>';
// var_dump($cp_main_nodes);
// echo '</pre>';
?>
<div class="wrapper wrapper-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">

				<div class="tabs-container">

					<ul role="tablist" class="nav nav-tabs">
						<li role="presentation">
							<a href="javascript:void(0);"><strong style="color:black;">Text divers:</strong></a>
						</li>
						<li role="presentation" class="active">
							<a href="#tab1" data-toggle="tab"><?=(!is_null($atom) && !is_null($atom->atom_name_ro) ? $atom->atom_name_ro : "Nou");?></a>
						</li>
					</ul>

						<div class="tab-content">
							<!--start#tab1-->
							<div id="tab1" class="tab-pane active">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<form class="form-horizontal" method="POST" name="<?=$form->atom->name;?>" action="<?=base_url().$form->atom->segments?>">
												<div class="content content-full-width">
													<div class="panel-group">
														<?php if(!is_null($atom)):?>
															<?php if($atom->atom_id != '8' && $atom->atom_id != '9' && $atom->atom_id != '10' && $atom->atom_id != '11'): ?>
															<div class="row" style="background-color:#f1f1f1;margin-left:-20px;margin-right:-20px;border-bottom:30px solid #fdfdfd;padding:7px;padding-bottom:10px;">
																<div class="form-group" style="margin:0;">
																	<label class="col-sm-2 control-label" style="text-align:left;"><span style="color:black;font-size:17px;font-weight:normal;"><sub><i class="fa fa-plug" style="color:orange;font-size:25px;"></i></sub>&nbsp;&nbsp;Afi&scedil;eaz&abreve; pe&nbsp;</span> <i class="fa fa-angle-double-right" style="font-size:15px;"></i></label>
																	
																	<div class="col-sm-10">
																		<?php if(is_null($nodes)): echo "Nu s-au gasit legaturi"; ?>
																		<?php elseif(!is_null($nodes)): ?>
																		<select multiple data-placeholder="Acest item nu se afiseaza pe sit. Creeaza o legatura intre acest item si sit, alegand din lista de mai jos:" class="chosen-sl-links" tabindex="4">
																		
																		<?php foreach($nodes as $node): ?>
																			<?php
																			$selected = "";
																			if(!is_null($airdrop) && array_key_exists($node["node_id"], $airdrop)) $selected = "selected";
																			?>
																			<option value="<?=$node["node_id"]?>" <?=$selected?>><?=$node["denumire_ro"]?></option>
																		<?php endforeach; ?>
																		</select>
																		<?php endif; ?>
																	</div>
																</div>
															</div>
															<?php endif; ?>
														<?php endif; ?>
														
														<div class="row">
															<div class="form-group">
																<label class="col-sm-2 control-label">Nume</label>
																<div class="col-sm-10">
																	<input type="text" placeholder="Numele Text divers" class="form-control" name="<?=$form->atom->prefix;?>atom_name_ro" value="<?=(!is_null($atom) && !is_null($atom->atom_name_ro) ? $atom->atom_name_ro : "");?>" required>
																</div>
															</div>
														</div>
														
														
														<?php if(!is_null($atom)):?>
														<!--
														<div class="row">
															<div class="form-group">
																<label class="col-sm-2 control-label">Link de legatura</label>
																<div class="col-sm-10">
																	<input type="text" placeholder="Link-ul Textului accesat din browser" class="form-control" name="<?=$form->atom->prefix;?>i_linkhref" value="<?=(!is_null($atom) && !is_null($atom->i_linkhref) ? $atom->i_linkhref : "");?>">
																</div>
															</div>
														</div>
														-->
														
														<div class="row">
															<div class="form-group">
																<label class="col-sm-2 control-label">Titlu</label>
																<div class="col-sm-10">
																	<input type="text" placeholder="Titlu" class="form-control" name="<?=$form->atom->prefix;?>i_titlu" value="<?=(!is_null($atom) && !is_null($atom->i_titlu) ? $atom->i_titlu : "");?>">
																</div>
															</div>
														</div>
														
														<!--
														<div class="row">
															<div class="form-group">
																<label class="col-sm-2 control-label">Subtitlu</label>
																<div class="col-sm-10">
																	<input type="text" placeholder="Subtitlu" class="form-control" name="<?=$form->atom->prefix;?>i_subtitlu" value="<?=(!is_null($atom) && !is_null($atom->i_subtitlu) ? $atom->i_subtitlu : "");?>">
																</div>
															</div>
														</div>
														-->
														
														<div class="row">
															<div class="form-group">
																<label class="col-sm-2 control-label">Pictograma</label>
																<div class="col-sm-10">
																	<input type="text" placeholder="Pictograma tip html" class="form-control" name="<?=$form->atom->prefix;?>i_pictograma" value="<?=(!is_null($atom) && !is_null($atom->i_pictograma) ? htmlspecialchars($atom->i_pictograma) : "");?>">
																</div>
															</div>
														</div>
								
														<div class="row">
															<div class="form-group">
																<label class="col-sm-2 control-label">Nume <span style="color:red;"> ENG</span></label>
																<div class="col-sm-10">
																	<input type="text" placeholder="Numele Text divers" class="form-control" name="<?=$form->atom->prefix;?>atom_name_en" value="<?=(!is_null($atom) && !is_null($atom->atom_name_en) ? $atom->atom_name_en : "");?>">
																</div>
															</div>
														</div>
                            
                            <hr>
                            
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																		<label><h3>Continut</h3></label>
																			<textarea name="<?=$form->atom->prefix;?>i_content_ro" id="ncontentro" rows="4"><?=(!is_null($atom) && !is_null($atom->i_content_ro) ? $atom->i_content_ro : "");?></textarea>
																</div>
															</div>
														</div>												
														
														<?php endif; ?>

														<div class="hr-line-dashed"></div>
														<fieldset>
																<div class="form-group">
																	<div class="col-sm-12">
																		<button class="btn btn-white" type="button" onClick="location.href='<?=base_url()?>/textediverse'">Anuleaza</button>
																		<button class="btn btn-primary" type="submit" name="<?=$form->atom->prefix;?>submit"><?=((isset($uri->atom) && $uri->atom == "i") ? "Creaza Text divers" : "Salveaza modificarile")?></button>
																	</div>
																</div>
														</fieldset>
													</div>
												</div>
											</form>
										</div> <!-- end col-md-12 -->
									</div>
								</div>
							</div><!--end#tab1-->
							
						</div>
					</div>
				</div>
			</div>

</div>