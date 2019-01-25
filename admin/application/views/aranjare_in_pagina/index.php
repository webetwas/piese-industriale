<?php
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
?>
<?php
// var_dump($links);die();
?>

<div class="wrapper wrapper-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">

				<div class="tabs-container">

					<ul role="tablist" class="nav nav-tabs">
						<li role="presentation">
							<a href="javascript:void(0);"><strong style="color:black;">Aranjare in Pagina:</strong></a>
						</li>
						<li role="presentation" class="active">
							<a href="#legaturi" data-toggle="tab">Toate elementele din Website</a>
						</li>
					</ul>

						<div class="tab-content">
							<!--start#legaturi-->
							<div id="legaturi" class="tab-pane active">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<?php if(is_null($links)): echo "Nu s-au gasit legaturi disponibile"; ?><!--strs_a-->
											<?php elseif(!is_null($links)): ?><!--strs_a-->
											<div class="float">
												<ul id="browser" class="filetree">
													<?php foreach($links as $keylink => $link): ?><!--link-->
													<li class="closed">
														<span class="folder">
															&nbsp;&nbsp;<?=$link->denumire_ro?>
															<span class="sh">
                                <?php if((bool)$link->admin_addable): ?>
																<a href="<?=base_url().$controller_actions?>/item/i/parent/<?=$link->id_link?>"><i class="fa fa-plus-square-o"></i> Adauga Sublegatura</a>
                                <?php endif; ?>
                                <?php if((bool)$link->admin_editable): ?>
																<a href="<?=base_url().$controller_actions?>/item/u/id/<?=$link->id_link?>"><i class="fa fa-edit" style="color:green;"></i> Editeaza</a>
                                <?php endif; ?>
																<?php if((bool)$link->admin_deletable): ?>
                                <a href="<?=base_url().$controller_actions?>/item/d/id/<?=$link->id_link?>" class="ahrefaskconfirm"><i class="fa fa-trash" style="color:red;"></i> Sterge</a>
                                <?php endif; ?>
                              </span>
														</span>
														<ul>
															<?php if(!is_null($link->strs_b)): ?><!--strs_b-->
															<?php foreach($link->strs_b as $keylinkb => $linkb): ?><!--linkb-->
															<li class="closed">
																<span class="folder">
																	&nbsp;&nbsp;<?=$linkb->denumire_ro?>
																	<span class="sh">
                                    <?php if((bool)$linkb->admin_addable): ?>
																		<a href="<?=base_url().$controller_actions?>/item/i/parent/<?=$linkb->id_link?>"><i class="fa fa-plus-square-o"></i> Adauga Sublegatura</a>
                                    <?php endif; ?>
                                    <?php if((bool)$linkb->admin_editable): ?>
																		<a href="<?=base_url().$controller_actions?>/item/u/id/<?=$linkb->id_link?>"><i class="fa fa-edit" style="color:green;"></i> Editeaza</a>
                                    <?php endif; ?>
                                    <?php if((bool)$linkb->admin_deletable): ?>
																		<a href="<?=base_url().$controller_actions?>/item/d/id/<?=$linkb->id_link?>" class="ahrefaskconfirm"><i class="fa fa-trash" style="color:red;"></i> Sterge</a>
                                    <?php endif; ?>
                                  </span>
																</span>
																<ul>
																	<?php if(!is_null($linkb->strs_c)): ?><!--strs_c-->
																	<?php foreach($linkb->strs_c as $keylinkc => $linkc): ?><!--linkc-->
																	<li class="closed">
																		<span class="folder">
																		&nbsp;&nbsp;<?=$linkc->denumire_ro?>
																		<span class="sh">
                                      <?php if((bool)$linkc->admin_editable): ?>
																			<a href="<?=base_url().$controller_actions?>/item/u/id/<?=$linkc->id_link?>"><i class="fa fa-edit" style="color:green;"></i> Editeaza</a>
                                      <?php endif; ?>
                                      <?php if((bool)$linkc->admin_deletable): ?>
                                      <a href="<?=base_url().$controller_actions?>/item/d/id/<?=$linkc->id_link?>" class="ahrefaskconfirm"><i class="fa fa-trash" style="color:red;"></i> Sterge</a>
                                      <?php endif; ?>
                                    </span>
																		</span>
																		<ul>
																			<!-- linkc items -->
																			<?php if($linkc->objects): ?>
																				<?php foreach($linkc->objects as $objkey => $obj): ?>
																					<?php if(isset($obj->items)): ?>
																					<li class="closed">
																						<span>
																							&nbsp;<i class="fa fa-pagelines" style="color:#1c84c6;"></i> <?=$obj->obj_name?>
																						</span>
																						<ul>
																							<div class="dd" id="<?=$linkc->id_link?>">
																								<ol class="dd-list">
																								<?php foreach($obj->items as $itemkey => $item): ?>
																									<li class="dd-item" data-id="<?=$item->idcontent_object?>"><span <?=(!$item->item_parent_fake ? 'class="tvfile"' : "")?>><div class="dd-handle">&nbsp;<?=($item->item_parent_fake ? '&nbsp;<i class="fa fa-star" style="color:red;"></i> ' : "")?><?=$item->item_name?></div></span></li>
																								<?php endforeach; ?>
																								</ol>
																							</div>
																						</ul>
																					</li>
																					<?php endif; ?>
																				<?php endforeach; ?>
																			<?php endif; ?>
																			<!-- linkc items -->
																		</ul>
																	</li>
																	<?php endforeach; ?><!--linkc-->
																	<?php endif; ?><!--strs_c-->
																	<!-- linkb items -->
																	<?php if($linkb->objects): ?>
																		<?php foreach($linkb->objects as $objkey => $obj): ?>
																			<?php if(isset($obj->items)): ?>
																			<li class="closed">
																				<span>
																					&nbsp;<i class="fa fa-pagelines" style="color:#1c84c6;"></i> <?=$obj->obj_name?>
																				</span>
																				<ul>
																					<div class="dd" id="<?=$linkb->id_link?>">
																						<ol class="dd-list">
																						<?php foreach($obj->items as $itemkey => $item): ?>
																							<li class="dd-item" data-id="<?=$item->idcontent_object?>"><span <?=(!$item->item_parent_fake ? 'class="tvfile"' : "")?>><div class="dd-handle">&nbsp;<?=($item->item_parent_fake ? '&nbsp;<i class="fa fa-star" style="color:red;"></i> ' : "")?><?=$item->item_name?></div></span></li>
																						<?php endforeach; ?>
																						</ol>
																					</div>
																				</ul>
																			</li>
																			<?php endif; ?>
																		<?php endforeach; ?>
																	<?php endif; ?>
																	<!-- linkb items -->
																</ul>
															</li>
															<?php endforeach; ?><!--linkb-->
															<?php endif; ?><!--strs_b-->		
																<!-- link items -->
																<?php if($link->objects): ?>
																	<?php foreach($link->objects as $objkey => $obj): ?>
																		<?php if(isset($obj->items)): ?>
																		<li class="closed">
																			<span>
																				&nbsp;<i class="fa fa-pagelines" style="color:#1c84c6;"></i> <?=$obj->obj_name?>
																			</span>
																			<ul>														
																				<div class="dd" id="<?=$link->id_link?>">
																					<ol class="dd-list">
																					<?php foreach($obj->items as $itemkey => $item): ?>
																						<li class="dd-item" data-id="<?=$item->idcontent_object?>"><span <?=(!$item->item_parent_fake ? 'class="tvfile"' : "")?>><div class="dd-handle">&nbsp;<?=($item->item_parent_fake ? '&nbsp;<i class="fa fa-star" style="color:red;"></i> ' : "")?><?=$item->item_name?></div></span></li>
																					<?php endforeach; ?>
																					</ol>
																				</div>
																			</ul>
																		</li>
																		<?php endif; ?>
																	<?php endforeach; ?>
																<?php endif; ?>
																<!-- link items -->
														</ul>
													</li>
													<?php endforeach; ?><!--link-->
												</ul>
											</div>
											<?php endif; ?><!--strs_a-->
										</div> <!-- end col-md-12 -->
									</div>
								</div>
							</div><!--end#legaturi-->
							
						</div>
					</div>
				</div>
			</div>

</div>