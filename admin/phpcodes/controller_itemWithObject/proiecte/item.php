<?php
// var_dump($links);
// var_dump($item);
// var_dump($item_links);
?>

<div class="wrapper wrapper-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">

				<div class="tabs-container">

					<ul role="tablist" class="nav nav-tabs">
						<li role="presentation">
							<a href="javascript:void(0);"><strong style="color:black;">Proiect:</strong></a>
						</li>
						<li role="presentation" class="active">
							<a href="#tab1" data-toggle="tab">Tab1</a>
						</li>
						<li role="presentation">
							<a href="#tab2" data-toggle="tab">Tab2</a>
						</li>
					</ul>

						<div class="tab-content">
							<!--start#tab1-->
							<div id="tab1" class="tab-pane active">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<form class="form-horizontal" method="POST" name="<?=$form->item->name;?>" action="<?=base_url().$form->item->segments?>">
				
												<div class="form-group">
													<label class="col-sm-2 control-label"><span class="label label-success" style="font-size:13px;"><i class="fa fa-cogs"></i> Legaturi</span></label>
													<div class="col-sm-10">
														<?php if(is_null($links)): echo "Nu s-au gasit legaturi"; ?>
														<?php elseif(!is_null($links)): ?>
														<select multiple data-placeholder="Cauta legaturi..." class="chosen-sl-links" style="width:350px;" tabindex="4">
														
														<?php foreach($links as $link): ?>
															<?php
															$selected = "";
															if(!is_null($item_links) && array_key_exists($link->id_link, $item_links)) $selected = "selected";
															?>
															<option value="<?=$link->id_link?>" <?=$selected?>><?=$link->denumire_ro?></option>
														<?php endforeach; ?>
														</select>
														<?php endif; ?>
													</div>
												</div>
				
												<div class="form-group">
													<label class="col-sm-2 control-label">Nume proiect</label>
													<div class="col-sm-10">
														<input type="text" class="form-control" name="<?=$form->item->prefix;?>project_name" value="<?=(!is_null($item) && !is_null($item->project_name) ? $item->project_name : "");?>">
													</div>
												</div>

												<div class="hr-line-dashed"></div>
												<fieldset>
														<div class="form-group">
															<div class="col-sm-12">
																<button class="btn btn-white" type="button" onClick="location.href='<?=base_url()?>/portofoliu/proiecte'">Anuleaza</button>
																<button class="btn btn-primary" type="submit" name="<?=$form->item->prefix;?>submit"><?=(isset($uri->item) && $uri->item == "i" ? "Creaza proiect" : "Salveaza modificarile")?></button>
															</div>
														</div>
												</fieldset>
											</form>
										</div> <!-- end col-md-12 -->
									</div>
								</div>
							</div><!--end#tab1-->
							
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

						</div>
					</div>
				</div>
			</div>

</div>