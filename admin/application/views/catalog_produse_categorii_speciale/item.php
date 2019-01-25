<?php
// var_dump($links);
// var_dump($item);
// var_dump($item_links);

// echo '<pre>';
// var_dump($nodes);
// var_dump($opt_materiale);
// echo '</pre>';
?>

  <style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 450px; }
  #sortable li { margin: 3px 3px 3px 0; padding: 1px; float: left; width: 100px; text-align: center; cursor:pointer; }
  </style>

<div class="wrapper wrapper-content animated fadeIn">


        <div class="row">
			<?php if(!is_null($item)):?>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-content mailbox-content">
                        <div class="file-manager">
                            <!--<a class="btn btn-block btn-primary compose-mail" href="mail_compose.html">Compose Mail</a>-->
														
														<div class="row">
														<div class="form-group" style="margin:0;">
														<label class="control-label" style="text-align:left;color:#1ab394;margin-top:-3px;"><span style="font-size:17px;font-weight:normal;"><sub><i class="fa fa-plug" style="color:#1ab394;;font-size:25px;"></i></sub>&nbsp;&nbsp;Afi&scedil;eaz&abreve; pe sit..&nbsp;</span> <i class="fa fa-angle-double-down" style="font-size:15px;"></i></label>
														</div>
														</div>
														<div class="row" style="margin-left:-20px;margin-right:-20px;margin-bottom:20px;padding:7px;">
															<div class="form-group" style="margin:0;">
																	<?php if(is_null($nodes)): echo "Nu s-au gasit legaturi"; ?>
																	<?php elseif(!is_null($nodes)): ?>
																	<select multiple data-placeholder="Acest item nu se afiseaza pe sit." class="chosen-sl-links" tabindex="4">
																	
																	<?php foreach($nodes as $node): ?>
																		<?php
																		$selected = "";
																		if(!is_null($airdrop) && array_key_exists($node["node_id"], $airdrop)) $selected = "selected";
																		?>
																		<option value="<?=$node["node_id"]?>" <?=$selected?>><?=$node["denumire_ro"]?></option>
																	<?php endforeach; ?>
																	</select>
																	<?php endif; ?>
																	<p style="margin-top:10px;"><i>Creeaza o legatura intre acest item si sit - alege din lista de mai sus</i></p>
																	
																	
																	
																	<?php if(!is_null($item)):?>
																	<div class="row" style="margin-top:50px;">

																		
																		<div class="col-sm-12">
																			<div class="row">

																			<div class="col-sm-6">
																				<h3>Produs Activ</h3>
																				<div class="switch">
																					<div class="onoffswitch">
																						<input type="checkbox" class="onoffswitch-checkbox product_states" id="atom_isactive" <?=((bool)$item->atom_isactive ? 'checked' : '')?>>
																						<label class="onoffswitch-label" for="atom_isactive">
																							<span class="onoffswitch-inner"></span>
																							<span class="onoffswitch-switch"></span>
																						</label>
																					</div>
																				</div>
																				</div>

																			
																			<div class="col-sm-6">

																				<h3>In stoc</h3>
																				<div class="switch">
																					<div class="onoffswitch">
																						<input type="checkbox" class="onoffswitch-checkbox product_states" id="atom_instock" <?=((bool)$item->atom_instock ? 'checked' : '')?>>
																						<label class="onoffswitch-label" for="atom_instock">
																							<span class="onoffswitch-inner"></span>
																							<span class="onoffswitch-switch"></span>
																						</label>
																					</div>
																				</div>
																				
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-sm-6">

																				<h3>Produs nou</h3>
																				<div class="switch">
																					<div class="onoffswitch">
																						<input type="checkbox" class="onoffswitch-checkbox product_states" id="atom_newproduct" <?=((bool)$item->atom_newproduct ? 'checked' : '')?>>
																						<label class="onoffswitch-label" for="atom_newproduct">
																							<span class="onoffswitch-inner"></span>
																							<span class="onoffswitch-switch"></span>
																						</label>
																					</div>
																				</div>
																				
																			</div>

																			<div class="col-sm-6">

																				<h3>Recomandat</h3>
																				<div class="switch">
																					<div class="onoffswitch">
																						<input type="checkbox" class="onoffswitch-checkbox product_states" id="atom_recomanded" <?=((bool)$item->atom_recomanded ? 'checked' : '')?>>
																						<label class="onoffswitch-label" for="atom_recomanded">
																							<span class="onoffswitch-inner"></span>
																							<span class="onoffswitch-switch"></span>
																						</label>
																					</div>
																				</div>
																				
																			</div>																	
																		</div>
																		<div class="row" style="margin-top:10px;">
																			<div class="col-sm-6">
																				
																			</div>

																			<div class="col-sm-6">

																				<h3>Special</h3>
																				<div class="switch">
																					<div class="onoffswitch">
																						<input type="checkbox" class="onoffswitch-checkbox product_states" id="atom_special" <?=((bool)$item->atom_special ? 'checked' : '')?>>
																						<label class="onoffswitch-label" for="atom_special">
																							<span class="onoffswitch-inner"></span>
																							<span class="onoffswitch-switch"></span>
																						</label>
																					</div>
																				</div>
																				
																			</div>																	
																		</div>
																	<?php endif; ?>
															</div>
														</div>
														</div>
														</div>
														
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
			<?php endif; ?>
            <div class="col-lg-<?=(!is_null($item) ? '9' : '12')?> animated fadeInRight">
			
            <div class="mail-box-header">
				<!--
                <div class="pull-right tooltip-demo">
                    <a href="mailbox.html" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Move to draft folder"><i class="fa fa-pencil"></i> Draft</a>
                    <a href="mailbox.html" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Discard email"><i class="fa fa-times"></i> Discard</a>
                </div>
				-->
                <h2 style="font-weight:bold;">
                    <?=(!is_null($item) ? $item->atom_name : 'Adauga produs')?>
                </h2>
            </div>
                <div class="mail-box">


                <div class="mail-body">

											<form class="form-horizontal" method="POST" name="<?=$form->item->name;?>" action="<?=base_url().$form->item->segments?>">

														
														<div class="row" style="margin-bottom:15px;">
															<div class="col-sm-12">
																<div class="form-group">
																	<div class="col-sm-12">
																		<label>Nume produs</label>
																		<input type="text" placeholder="Numele complet al produsului" class="form-control" name="<?=$form->item->prefix;?>atom_name" value="<?=(!is_null($item) && !is_null($item->atom_name) ? $item->atom_name : "");?>" required>
																	</div>
																	
																</div>
															</div>
														</div>
														<?php if(!is_null($item)): ?>
														<div class="row" style="margin-bottom:10px;">
															<div class="col-sm-12">
																<div class="form-group">
																
																
																	<div class="col-sm-4">
																		<label>Cantitate</label>
																		<input type="number" placeholder="Unitati disponibile" class="form-control" name="<?=$form->item->prefix;?>cantitate" value="<?=(!is_null($item) && !is_null($item->cantitate) ? $item->cantitate : "");?>">
																	</div>

																	
																	<div class="col-sm-4">
																		<label>Cod produs</label>
																		<input type="text" placeholder="Codul produsului" class="form-control" name="<?=$form->item->prefix;?>cod_produs" value="<?=(!is_null($item) && !is_null($item->cod_produs) ? $item->cod_produs : "");?>">
																	</div>
																	
																	<div class="col-sm-4">
																		<label>Producator</label>
																		<input type="text" placeholder="Productor" class="form-control" name="<?=$form->item->prefix;?>producator" value="<?=(!is_null($item) && !is_null($item->producator) ? $item->producator : "");?>">
																	</div>
																	
																	
																</div>
															</div>
														</div>
														<?php endif; ?>
														
														
														<div class="row" style="margin-bottom:15px;">
															<div class="col-sm-12">
																<div class="form-group">
																	<div class="col-sm-6">
																		<label>Pret</label>
																		<input type="text" placeholder="Pret produs. ex: 145.99" class="form-control" name="<?=$form->item->prefix;?>pret" value="<?=(!is_null($item) && !is_null($item->pret) && $item->pret != 0.00 ? $item->pret : "");?>" required>
																	</div>
																	
																	<div class="col-sm-6">
																		<label style="color:#22A7F0">Pret nou</label>
																		<input type="text" placeholder="Pret oferta" class="form-control" name="<?=$form->item->prefix;?>pret_nou" value="<?=(!is_null($item) && !is_null($item->pret_nou) && $item->pret_nou != 0.00 ? $item->pret_nou : "");?>">
																	</div>
																	
																	
																</div>
															</div>
														</div>
														
														<?php if(!is_null($item)):?>
														
														<div class="row" style="margin-top:10px;">
															<div class="col-sm-12">
																<div class="form-group">
																	<div class="col-sm-12">
																		<label>Optiuni produs</label>
																		<?php if(is_null($opt_produs)): echo "Nu s-au gasit optiuni produs"; ?>
																		<?php elseif(!is_null($opt_produs)): ?>
																		<select multiple data-placeholder="Alege optiune produs" class="chosen-opt-produs" tabindex="4" name="<?=$form->item->prefix;?>optiuni_produs[]">
																		
																		<?php foreach($opt_produs as $optprodus): ?>
																			<?php
																			$optiuni_produs = array();
																			if(!is_null($item->optiuni_produs))
																			{
																				$optiuni_produs = explode(",", $item->optiuni_produs);
																			}

																			$selected = "";
																			if(!empty($optiuni_produs) && in_array($optprodus->atom_id, $optiuni_produs)) $selected = "selected";
																			?>
																			<option value="<?=$optprodus->atom_id?>" <?=$selected?>><?=$optprodus->atom_name?></option>
																		<?php endforeach; ?>
																		</select>
																		<?php endif; ?>														
																	</div>
																</div>
															</div>
														</div>													
														
														<div class="row" style="margin-top:20px;">
															<div class="col-sm-12">
																<div class="form-group">
																	<div class="col-sm-12">
																		<label>Optiuni material si culori</label>
																		<?php if(is_null($opt_culoare)): echo "Nu s-au gasit optiuni pentru materiale"; ?>
																		<?php elseif(!is_null($opt_culoare)): ?>
																		<select multiple data-placeholder="Alege culori disponibile" class="chosen-opt-material-culoare" tabindex="4" name="<?=$form->item->prefix;?>optiuni_material_culoare[]" id="optiuni_material_culoare">
																	
																		<?php
																			$optiuni_material_culoare = null;
																			if(!is_null($item->optiuni_material_culoare))
																			{
																				$optiuni_material_culoare = explode(",", $item->optiuni_material_culoare);
																			}
							
																		?>
																		
																		<?php foreach($opt_materiale as $opt_material): ?>
																		<optgroup label="<?=$opt_material->atom_name?>">
																		<?php foreach($opt_material->culori as $opt_culoare): ?>
																			<?php
																			
																			$selected = "";
																			if(!empty($optiuni_material_culoare) && in_array($opt_culoare->id, $optiuni_material_culoare)) $selected = "selected";
																			?>
																			<option value="<?=$opt_culoare->id?>" <?=$selected?>><?=$opt_culoare->name?></option>
																		<?php endforeach; ?>
																		</optgroup>
																		<?php endforeach; ?>
																		</select>
																		<?php endif; ?>														
																	</div>
																</div>
															</div>
														</div>
														
														<div class="row" style="margin-top:20px;">
															<div class="col-sm-12">
																<div class="form-group">
																	<div class="col-sm-12">
																		<label>Culori bluza</label>
																		<?php if(is_null($opt_culoare)): echo "Nu s-au gasit optiuni pentru materiale"; ?>
																		<?php elseif(!is_null($opt_culoare)): ?>
																		<select multiple data-placeholder="Alege culori disponibile" class="chosen-opt-material-culoare-bluza" tabindex="4" name="<?=$form->item->prefix;?>optiuni_material_culoarebluza[]" id="optiuni_material_culoarebluza">
																	
																		<?php
																			$optiuni_material_culoarebluza = null;
																			if(!is_null($item->optiuni_material_culoarebluza))
																			{
																				$optiuni_material_culoarebluza = explode(",", $item->optiuni_material_culoarebluza);
																			}
							
																		?>
																		
																		<?php foreach($opt_materiale as $opt_material): ?>
																		<optgroup label="<?=$opt_material->atom_name?>">
																		<?php foreach($opt_material->culori as $opt_culoare): ?>
																			<?php
																			
																			$selected = "";
																			if(!empty($optiuni_material_culoarebluza) && in_array($opt_culoare->id, $optiuni_material_culoarebluza)) $selected = "selected";
																			?>
																			<option value="<?=$opt_culoare->id?>" <?=$selected?>><?=$opt_culoare->name?></option>
																		<?php endforeach; ?>
																		</optgroup>
																		<?php endforeach; ?>
																		</select>
																		<?php endif; ?>														
																	</div>
																</div>
															</div>
														</div>
														
														<div class="row" style="margin-top:20px;">
															<div class="col-sm-12">
																<div class="form-group">
																	<div class="col-sm-12">
																		<label>Culori fusta/pantaloni</label>
																		<?php if(is_null($opt_culoare)): echo "Nu s-au gasit optiuni pentru materiale"; ?>
																		<?php elseif(!is_null($opt_culoare)): ?>
																		<select multiple data-placeholder="Alege culori disponibile" class="chosen-opt-material-culoare" tabindex="4" name="<?=$form->item->prefix;?>optiuni_fustapantaloni_culoare[]" id="optiuni_fustapantaloni_culoare">
																	
																		<?php
																			$optiuni_fustapantaloni_culoare = null;
																			if(!is_null($item->optiuni_fustapantaloni_culoare))
																			{
																				$optiuni_fustapantaloni_culoare = explode(",", $item->optiuni_fustapantaloni_culoare);
																			}
							
																		?>
																		
																		<?php foreach($opt_materiale as $opt_material): ?>
																		<optgroup label="<?=$opt_material->atom_name?>">
																		<?php foreach($opt_material->culori as $opt_culoare): ?>
																			<?php
																			
																			$selected = "";
																			if(!empty($optiuni_fustapantaloni_culoare) && in_array($opt_culoare->id, $optiuni_fustapantaloni_culoare)) $selected = "selected";
																			?>
																			<option value="<?=$opt_culoare->id?>" <?=$selected?>><?=$opt_culoare->name?></option>
																		<?php endforeach; ?>
																		</optgroup>
																		<?php endforeach; ?>
																		</select>
																		<?php endif; ?>														
																	</div>
																</div>
															</div>
														</div>														
														
														<div class="row" style="margin-top:20px;">
															<div class="col-sm-12">
																<div class="form-group">
																	<div class="col-sm-12">
																		<label>Optiuni garnitura - culori</label>
																		<?php if(is_null($opt_culoare)): echo "Nu s-au gasit optiuni pentru materiale"; ?>
																		<?php elseif(!is_null($opt_culoare)): ?>
																		<select multiple data-placeholder="Alege culori disponibile" class="chosen-opt-garnitura-culoare" tabindex="4" name="<?=$form->item->prefix;?>optiuni_garnitura_culoare[]" id="optiuni_garnitura_culoare">
																	
																		<?php
																			$optiuni_garnitura_culoare = null;
																			if(!is_null($item->optiuni_garnitura_culoare))
																			{
																				$optiuni_garnitura_culoare = explode(",", $item->optiuni_garnitura_culoare);
																			}
							
																		?>
																		
																		<?php foreach($opt_materiale as $opt_material): ?>
																		<optgroup label="<?=$opt_material->atom_name?>">
																		<?php foreach($opt_material->culori as $opt_culoare): ?>
																			<?php
																			
																			$selected = "";
																			if(!empty($optiuni_garnitura_culoare) && in_array($opt_culoare->id, $optiuni_garnitura_culoare)) $selected = "selected";
																			?>
																			<option value="<?=$opt_culoare->id?>" <?=$selected?>><?=$opt_culoare->name?></option>
																		<?php endforeach; ?>
																		</optgroup>
																		<?php endforeach; ?>
																		</select>
																		<?php endif; ?>														
																	</div>
																</div>
															</div>
														</div>														
														
														<div class="row" style="margin-top:10px;">
															<div class="col-sm-12">
																<div class="form-group">
																	<div class="col-sm-12">
																		<label>Optiuni marimi ale produsului</label>
																		<?php if(is_null($opt_marime)): echo "Nu s-au gasit optiuni pentru marimi"; ?>
																		<?php elseif(!is_null($opt_marime)): ?>
																		<select multiple data-placeholder="Alege culori disponibile" class="chosen-opt-marime" tabindex="4" name="<?=$form->item->prefix;?>optiuni_marime[]">
																		
																		<?php foreach($opt_marime as $optmarime): ?>
																			<?php
																			$opt_marimi = array();
																			if(!is_null($item->optiuni_marime))
																			{
																				$opt_marimi = explode(",", $item->optiuni_marime);
																			}
																			
																			$selected = "";
																			if(!empty($opt_marimi) && in_array($optmarime->atom_name, $opt_marimi)) $selected = "selected";
																			?>
																			<option value="<?=$optmarime->atom_name?>" <?=$selected?>><?=$optmarime->atom_name?></option>
																		<?php endforeach; ?>
																		</select>
																		<?php endif; ?>														
																	</div>
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

<div class="col-sm-12">
<div id="p_imgpoza">		
<ul id="sortable">
<?php if(isset($item->i) && $item->i): ?>	
<?php foreach($item->i as $img): ?>
  <li class="ui-state-default" id="<?=$img->id?>">
	<?php
	echo '

		<div class="img-thumbnail" style="padding:2px;">
			<img class="img-responsive" src="' .$imgpathitem.$img->img. '">
			<div class="thumbfooter">
				<a href="javascript:void(0)" onClick="return ajxdelimg(' .$img->id. ');return false"><code-remove>Elimina</code-remove></a>
			</div>
		</div>

	';
		?>
  </li>
 <?php endforeach; ?>
</ul>																
<?php endif; ?>
</div>
</div>
																</div>
															</div>
														</div>
														
														<div class="mail-text h-200" style="margin-left:-20px;margin-right:-20px;margin-bottom:10px;">

															<textarea name="<?=$form->item->prefix;?>content_ro" id="ncontentro" rows="4"><?=(!empty($item->content_ro) ? $item->content_ro : "Descriere produs..");?></textarea>
															<div class="clearfix"></div>
														</div>
														
														<div class="row">
															<div class="col-sm-12">
																<div class="form-group">
																	<div class="col-sm-12">
																		<label>Titlu browser</label>
																		<input type="text" placeholder="Titlu browser" class="form-control" name="<?=$form->item->prefix;?>title_browser_ro" value="<?=(!is_null($item) && !is_null($item->title_browser_ro) ? $item->title_browser_ro : "");?>">
																	</div>
																</div>
															</div>
														</div>															
														
														<div class="row" style="margin-bottom:20px;">
															<div class="col-sm-12">
																<div class="form-group">
																	<div class="col-sm-6">
																		<label>Meta descriere</label>
																		<input type="text" placeholder="Descriere meta" class="form-control" name="<?=$form->item->prefix;?>meta_description" value="<?=(!is_null($item) && !is_null($item->meta_description) ? $item->meta_description : "");?>">
																	</div>
																	
																	<div class="col-sm-6">
																		<label>Meta keywords</label>
																		<input type="text" placeholder="Cuvinte cheie" class="form-control" name="<?=$form->item->prefix;?>meta_keywords" value="<?=(!is_null($item) && !is_null($item->meta_keywords) ? $item->meta_keywords : "");?>">
																	</div>
																	
																	
																</div>
															</div>
														</div>														
														
														<?php endif; ?>
														<fieldset>
																<div class="form-group">
																	<button class="btn btn-white" type="button" onClick="location.href='<?=base_url()?>/catalog_produse'">Anuleaza</button>
																	<button class="btn btn-primary" type="submit" name="<?=$form->item->prefix;?>submit"><?=(isset($uri->item) && $uri->item == "i" ? "Creeaza produsul" : "Salveaza modificarile")?></button>
																</div>
														</fieldset>

											</form>

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