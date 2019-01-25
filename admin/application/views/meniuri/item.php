<?php
// var_dump($nodes);
// var_dump($item);
// var_dump($airdrop);
?>

<div class="wrapper wrapper-content animated fadeIn">

	<div class="row">
		<div class="col-md-12">

			<div class="tabs-container">

				<ul role="tablist" class="nav nav-tabs">
					<li role="presentation">
						<a href="javascript:void(0);"><strong style="color:black;">Meniu:</strong></a>
					</li>
					<li role="presentation" class="active">
						<a href="#tab1" data-toggle="tab"><?=(!is_null($atom) && !is_null($atom->atom_name_ro) ? $atom->atom_name_ro : "Nou");?></a>
					</li>
					<?php if(!is_null($atom)):?>
					<li role="presentation">
						<a href="#tab2" data-toggle="tab">Tab2</a>
					</li>
					<?php endif; ?>
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
												
												<div class="row">
													<div class="form-group">
														<label class="col-sm-2 control-label">Nume meniu</label>
														<div class="col-sm-10">
															<input type="text" placeholder="Numele meniului" class="form-control" name="<?=$form->atom->prefix;?>atom_name_ro" value="<?=(!is_null($atom) && !is_null($atom->atom_name_ro) ? $atom->atom_name_ro : "");?>" required>
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="form-group">
														<label class="col-sm-2 control-label" style="color:#1c84c6;">Calea meniului</label>
														<div class="col-sm-10">
															<input type="text" placeholder="Adresa care este folosita in Link" class="form-control" name="<?=$form->atom->prefix;?>fullpath" value="<?=(!is_null($atom) && !is_null($atom->fullpath) ? $atom->fullpath : "");?>" required>
															<span class="help-block">Ex: folder/folder/fisier "masina/dacia/logan"</span>
														</div>
													</div>
												</div>
												
												<?php if(!is_null($atom)):?>
												<div class="row">
													<div class="form-group">
														<label class="col-sm-2 control-label">Pictograma</label>
														<div class="col-sm-10">
															<input type="text" placeholder="Pictograma tip html" class="form-control" name="<?=$form->atom->prefix;?>i_icon" value="<?=(!is_null($atom) && !is_null($atom->i_icon) ? htmlspecialchars($atom->i_icon) : "");?>">
														</div>
													</div>
												</div>
												
												<div class="row">
													<div class="form-group">
														<label class="col-sm-2 control-label">Badge</label>
														<div class="col-sm-10">
															<input type="text" placeholder="Badge tip html" class="form-control" name="<?=$form->atom->prefix;?>i_badge" value="<?=(!is_null($atom) && !is_null($atom->i_badge) ? htmlspecialchars($atom->i_badge) : "");?>">
														</div>
													</div>
												</div>
												
												
												<div class="row">
													<div class="form-group">
														<label class="col-sm-2 control-label">Nume meniu <span style="color:red;">ENG</span></label>
														<div class="col-sm-10">
															<input type="text" placeholder="Numele meniului" class="form-control" name="<?=$form->atom->prefix;?>atom_name_en" value="<?=(!is_null($atom) && !is_null($atom->atom_name_en) ? $atom->atom_name_en : "");?>">
														</div>
													</div>
												</div>												
												<?php endif; ?>														

												<div class="hr-line-dashed"></div>
												<fieldset>
														<div class="form-group">
															<div class="col-sm-12">
																<button class="btn btn-white" type="button" onClick="location.href='<?=base_url()?>/meniuri'">Anuleaza</button>
																<button class="btn btn-primary" type="submit" name="<?=$form->atom->prefix;?>submit"><?=(isset($uri->atom) && $uri->atom == "i" ? "Creaza meniu" : "Salveaza modificarile")?></button>
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
					
					<?php if(!is_null($atom)):?>
					<!--start#tab2-->
					<div id="tab2" class="tab-pane">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
								content II
								</div> <!-- end col-md-12 -->
							</div>
						</div>
					</div><!--end#content-->											
					<?php endif; ?>
					
				</div>
			</div>
		</div>
	</div>

</div>