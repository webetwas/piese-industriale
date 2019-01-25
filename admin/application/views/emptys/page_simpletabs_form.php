<?php
?>
<div class="wrapper wrapper-content animated fadeIn">

		<div class="row">
			<div class="col-md-12">

				<div class="tabs-container">

					<ul role="tablist" class="nav nav-tabs">
						<li role="presentation">
							<a href="javascript:void(0);"><strong style="color:black;">Actiune:</strong></a>
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
											<form method="POST" name="<?=$form->item->name;?>" action="<?=base_url().$form->item->segments?>">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>Titlu</label>
															<input type="text" name="<?=$form->item->prefix;?>title_ro" value="<?=(isset($var) ? $var : "")?>" placeholder="Titlu" class="form-control">
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>Titlu Browser</label>
															<input type="text" name="<?=$form->item->prefix;?>title_browser_ro" value="<?=(isset($var) ? $var : "")?>" placeholder="Titlu Browser" class="form-control">
														</div>
													</div>
												</div>
												<div class="hr-line-dashed"></div>
												<fieldset>
														<div class="form-group">
																<div class="col-sm-12">
																	<button class="btn btn-white" type="button" onClick="location.href='<?=base_url()?>'">Anuleaza</button>
																	<button type="submit" name="<?=$form->item->prefix;?>submit" class="btn btn-info btn-fill btn-wd" onClick="return showloader();">Salveaza modificarile</button>
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