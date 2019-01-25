        <div class="wrapper wrapper-content animated fadeIn">

              <div class="row">
          			<div class="col-md-12">

          				<div class="tabs-container">

          					<ul role="tablist" class="nav nav-tabs">
          						<li role="presentation" class="active">
          							<a href="#tuser" data-toggle="tab">Utilizator</a>
          						</li>
          					</ul>
                    <div class="tab-content">
	        						<div id="tuser" class="tab-pane active">
												<div class="panel-body">
													<div class="row">
														<div class="col-md-12">
															<form name="<?=$form->item->name;?>" method="POST" action="<?=base_url().$form->item->segments?>">
																	<div class="row">
																			<div class="col-md-2">
																					<div class="form-group">
																							<label>Utilizator</label>
																							<input type="text" class="form-control" placeholder="Utilizator" name="<?=$form->item->prefix;?>user_name" value="<?=$user->user_name;?>" disabled>
																					</div>
																			</div>
																			<div class="col-md-10">
																					<div class="form-group has-error">
																							<label style="color:red;">Adresa E-mail</label>
																							<input type="email" class="form-control" placeholder="Adresa de E-mail" name="<?=$form->item->prefix;?>email" value="<?=(!is_null($user->email) ? $user->email: "");?>">
																							<span class="help-block m-b-none">Aceasta adresa este folosita pentru a comunica cu Website-ul tau. Aici vei primit mesaje, notificari, erori etc.</span>
																					</div>
																			</div>
																	</div>
																	<div class="hr-line-dashed"></div>
																	<div class="row">
																			<div class="form-group">
																					<div class="col-sm-12">
																						 <button class="btn btn-white" type="button" onClick="location.href='<?=base_url()?>'">Anuleaza</button>
																						 <button type="submit" name="<?=$form->item->prefix;?>submit" class="btn btn-info btn-fill btn-wd" onClick="return updateUt();">Salveaza modificarile</button>
																					</div>
																			</div>																	
																	</div>
																	<div class="clearfix"></div>
															</form>
														</div>
													</div>
												</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        </div>
