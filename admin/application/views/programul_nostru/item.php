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
							<a href="javascript:void(0);"><strong style="color:black;">Programul nostru:</strong></a>
						</li>
						<li role="presentation" class="active">
							<a href="#tab1" data-toggle="tab">Text informativ si Orar</a>
						</li>
					</ul>

						<div class="tab-content">
							<!--start#tab1-->
							<div id="tab1" class="tab-pane active">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<form class="form-horizontal" method="POST" name="<?=$form->item->name;?>" action="<?=base_url().$form->item->segments?>">
												<div class="content content-full-width">
													<div class="panel-group">

														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
																		<label><h3>Text informativ</h3></label>
                                    <div style="padding:30px;padding-top:0;">
                                      <textarea name="<?=$form->item->prefix;?>prtext" id="prtext" rows="2"><?=(!is_null($item) && !is_null($item->prtext) ? $item->prtext : "");?></textarea>
                                    </div>
                                </div>
															</div>
														</div>
                            
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
                                    <label><h3>Orar</h3></label>
                                    <div style="padding:30px;padding-top:0;">
																			<textarea name="<?=$form->item->prefix;?>tprext_orar_ro" id="tprext_orar_ro" rows="2"><?=(!is_null($item) && !is_null($item->tprext_orar_ro) ? $item->tprext_orar_ro : "");?></textarea>
                                    </div>
                                </div>
															</div>
														</div>
														
														<div class="row">
															<div class="col-md-12">
																<div class="form-group">
                                    <label><h3>Orar <span style="color:red;">ENG</span></h3></label>
                                    <div style="padding:30px;padding-top:0;">
																			<textarea name="<?=$form->item->prefix;?>tprext_orar_en" id="tprext_orar_en" rows="2"><?=(!is_null($item) && !is_null($item->tprext_orar_en) ? $item->tprext_orar_en : "");?></textarea>
                                    </div>
                                </div>
															</div>
														</div>

														<div class="hr-line-dashed"></div>
														<fieldset>
																<div class="form-group">
																	<div class="col-sm-12">
																		<button class="btn btn-white" type="button" onClick="location.href='<?=base_url()?>/textediverse'">Anuleaza</button>
																		<button class="btn btn-primary" type="submit" name="<?=$form->item->prefix;?>submit"><?=(isset($uri->item) && $uri->item == "i" ? "Creaza Text divers" : "Salveaza modificarile")?></button>
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