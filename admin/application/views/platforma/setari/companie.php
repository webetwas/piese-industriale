<?php
// var_dump($company);die();
?>

        	<div class="wrapper wrapper-content animated fadeIn">

        		<div class="row">						
        			<div class="col-md-12">

        				<div class="tabs-container">

        					<ul class="nav nav-tabs">
        						<li role="presentation" class="active">
        							<a href="#tcompanie" data-toggle="tab">Companie</a>
        						</li>
        						<li>
        							<a href="#tsocial" data-toggle="tab">Social</a>
        						</li>
        						<li>
        							<a href="#tdfirma" data-toggle="tab">Date firma</a>
        						</li>
        						<li>
        							<a href="#temailing" data-toggle="tab">Setari Emailing</a>
        						</li>
        					</ul>
        					<form name="<?=$form->item->name;?>" method="POST" action="<?=base_url().$form->item->segments?>">
	        					<div class="tab-content">
	        						<div id="tcompanie" class="tab-pane active">
												<div class="panel-body">
													<div class="row">
														<div class="col-md-5">
															<div class="form-group">
																<label>Proprietar</label>
																<input type="text" name="<?=$form->item->prefix;?>owner" class="form-control" <?=($application->user->privilege ? 'style="border-color:red;"' : "")?> placeholder="Proprietar" value="<?=$owner->owner;?>" <?=(!$application->user->privilege ? "disabled" : "")?>>
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label>Companie</label>
																<input type="text" name="<?=$form->item->prefix;?>company" class="form-control" placeholder="Companie" value="<?=$owner->company;?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label>Initiale</label>
																<input type="text" name="<?=$form->item->prefix;?>initial" class="form-control" placeholder="Initiale" value="<?=(!is_null($owner->initial) ? $owner->initial : "");?>">
															</div>
														</div>
													</div>

													<div class="row">
														<?php
														//imagelogo
														if(is_null($application->owner->image_logo))
														echo '
															<div class="col-md-2">
																<div class="form-group">
																	<label style="color:#23ccef;">Logo</label>
																	<br />
																	<div id="dimglogo">
																		<button type="button" class="btn btn-success btn-fill" data-toggle="modal" data-target="#inpfileModal">
																			Incarca imagine
																		</button>
																	</div>
																</div>
															</div>
														';
														else {
															echo '
															<div class="col-md-2">
																<label style="color:#23ccef;">Logo</label>
																<div id="dimglogo">
																	<img src="' .$img_path.$application->owner->image_logo. '" class="img-responsive"/>
																	<div class="thumbfooter">
																		<a href="javascript:void(0);" onClick="ajxdellogo(' .$application->owner->id. ')"><code-remove>Schimba logo</code-remove></a>
																	</div>
																</div>
															</div>
															';
														}
														?>                           
                            
															<div class="col-md-5">
																<div class="form-group">
																	<label style="color:#23ccef;">WWW - Website</label>
																	<input type="text" name="<?=$form->item->prefix;?>website" class="form-control" placeholder="Website" value="<?=$owner->website;?>">
																</div>
															</div>
															<div class="col-md-5">
																<div class="form-group">
																	<label style="color:#23ccef;">E-mail</label>
																	<input type="email" name="<?=$form->item->prefix;?>oemail" class="form-control" placeholder="E-mail" value="<?=$owner->oemail;?>">
																</div>
															</div>
													</div>
													<!--
													<div class="row" style="margin-top:10px;">
														<div class="col-md-5">
															<div class="form-group">
																<label>Text scurt sub-logo</label>
																<input type="text" name="<?=$form->item->prefix;?>sublogo_text" class="form-control" placeholder="Text scurt afisat sub logo-ul sit-ului" value="<?=$owner->sublogo_text;?>">
															</div>
														</div>													
													</div>
													-->
													<!--
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label>Harta</label>
																<input type="text" name="<?=$form->item->prefix;?>map" class="form-control" placeholder="Map" value="<?=(!is_null($owner->map) ? $owner->map : '');?>">
															</div>
														</div>
													</div>
													-->
													<hr />
													<div class="row">
														<div class="col-md-12">
															<div class="form-group">
																<label>Despre / Slogan</label>
																<textarea rows="5" name="<?=$form->item->prefix;?>about" class="form-control" placeholder="Aici poti descrie afacerea ta/ slogan" value=""><?=$owner->about;?></textarea>
															</div>
														</div>
													</div>
												</div>
											</div>
											
	        						<div id="tsocial" class="tab-pane">
												<div class="panel-body">
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label>Facebook</label>
																<input type="text" name="<?=$form->item->prefix;?>facebook" class="form-control" placeholder="Facebook" value="<?=(!is_null($owner->facebook) ? $owner->facebook : '');?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label>YouTube</label>
																<input type="text" name="<?=$form->item->prefix;?>youtube" class="form-control" placeholder="Youtube" value="<?=(!is_null($owner->youtube) ? $owner->youtube : '');?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label>Google+</label>
																<input type="text" name="<?=$form->item->prefix;?>googleplus" class="form-control" placeholder="Google+" value="<?=(!is_null($owner->googleplus) ? $owner->googleplus : '');?>">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label>Twitter</label>
																<input type="text" name="<?=$form->item->prefix;?>twitter" class="form-control" placeholder="Twitter" value="<?=(!is_null($owner->twitter) ? $owner->twitter : '');?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label>Instagram</label>
																<input type="text" name="<?=$form->item->prefix;?>instagram" class="form-control" placeholder="Instagram" value="<?=(!is_null($owner->instagram) ? $owner->instagram : '');?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label>Pinterest</label>
																<input type="text" name="<?=$form->item->prefix;?>pinterest" class="form-control" placeholder="Pinterest" value="<?=(!is_null($owner->pinterest) ? $owner->pinterest : '');?>">
															</div>
														</div>
													</div>
												</div>
									</div>
	        						<div id="tdfirma" class="tab-pane">
												<div class="panel-body">
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label>Nume</label>
																<input type="text" name="<?=$form->item->prefix;?>nume" class="form-control" placeholder="Nume" value="<?=(!empty($company->nume) ? $company->nume : '');?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label>Prenume</label>
																<input type="text" name="<?=$form->item->prefix;?>prenume" class="form-control" placeholder="Prenume" value="<?=(!empty($company->prenume) ? $company->prenume : '');?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">E-mail</label>
																<input type="email" name="<?=$form->item->prefix;?>cemail" class="form-control" placeholder="E-mail" value="<?=(!empty($company->cemail) ? $company->cemail : '');?>">
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>CUI</label>
																<input type="text" name="<?=$form->item->prefix;?>cui" class="form-control" placeholder="CUI" value="<?=(!empty($company->cui) ? $company->cui : '');?>">
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Nr. inrg. fiscala</label>
																<input type="text" name="<?=$form->item->prefix;?>nrinreg" class="form-control" placeholder="Nr. inreg. fiscala" value="<?=(!empty($company->nrinreg) ? $company->nrinreg : '');?>">
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>Adresa sediu social</label>
																<input type="text" name="<?=$form->item->prefix;?>adresa_ss" class="form-control" placeholder="Adresa sediu social" value="<?=(!empty($company->adresa_ss) ? $company->adresa_ss : '');?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>Localitate</label>
																<input type="text" name="<?=$form->item->prefix;?>adresa_ssloc" class="form-control" placeholder="Adresa sediu social Localitate" value="<?=(!empty($company->adresa_ssloc) ? $company->adresa_ssloc : '');?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>Judet</label>
																<input type="text" name="<?=$form->item->prefix;?>adresa_ssjud" class="form-control" placeholder="Adresa sediu social Judet" value="<?=(!empty($company->adresa_ssjud) ? $company->adresa_ssjud : '');?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>Cod postal</label>
																<input type="text" name="<?=$form->item->prefix;?>adresa_sscodpostal" class="form-control" placeholder="Adresa sediu social Cod postal" value="<?=(!empty($company->adresa_sscodpostal) ? $company->adresa_sscodpostal : '');?>">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>Adresa punct lucru</label>
																<input type="text" name="<?=$form->item->prefix;?>adresa_pl" class="form-control" placeholder="Adresa punct lucru" value="<?=(!empty($company->adresa_pl) ? $company->adresa_pl : '');?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>Localitate</label>
																<input type="text" name="<?=$form->item->prefix;?>adresa_plloc" class="form-control" placeholder="Adresa punct lucru Localitate" value="<?=(!empty($company->adresa_plloc) ? $company->adresa_plloc : '');?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>Judet</label>
																<input type="text" name="<?=$form->item->prefix;?>adresa_pljud" class="form-control" placeholder="Adresa punct lucru Judet" value="<?=(!empty($company->adresa_pljud) ? $company->adresa_pljud : '');?>">
															</div>
														</div>
														<div class="col-md-2">
															<div class="form-group">
																<label>Cod postal</label>
																<input type="text" name="<?=$form->item->prefix;?>adresa_plcodpostal" class="form-control" placeholder="Adresa punct lucru Cod postal" value="<?=(!empty($company->adresa_plcodpostal) ? $company->adresa_plcodpostal : '');?>">
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Telefon Fix</label>
																<input type="text" name="<?=$form->item->prefix;?>telefon_fix" class="form-control" placeholder="Telefon fix" value="<?=(!empty($company->telefon_fix) ? $company->telefon_fix : '');?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Telefon Mobil</label>
																<input type="text" name="<?=$form->item->prefix;?>telefon_mobil" class="form-control" placeholder="Telefon mobil" value="<?=(!empty($company->telefon_mobil) ? $company->telefon_mobil : '');?>">
															</div>
														</div>
														<div class="col-md-4">
															<div class="form-group">
																<label for="exampleInputEmail1">Fax</label>
																<input type="text" name="<?=$form->item->prefix;?>telefon_fax" class="form-control" placeholder="Fax" value="<?=(!empty($company->telefon_fax) ? $company->telefon_fax : '');?>">
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">Banca</label>
																<input type="text" name="<?=$form->item->prefix;?>banca_banca" class="form-control" placeholder="Banca" value="<?=(!empty($company->banca_banca) ? $company->banca_banca : '');?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">Cont Banca</label>
																<input type="text" name="<?=$form->item->prefix;?>banca_iban" class="form-control" placeholder="Iban" value="<?=(!empty($company->banca_iban) ? $company->banca_iban : '');?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">Trezorerie</label>
																<input type="text" name="<?=$form->item->prefix;?>trezorerie_trezorerie" class="form-control" placeholder="Trezorerie" value="<?=(!empty($company->trezorerie_trezorerie) ? $company->trezorerie_trezorerie : '');?>">
															</div>
														</div>
														<div class="col-md-3">
															<div class="form-group">
																<label for="exampleInputEmail1">Trezorerie Iban</label>
																<input type="text" name="<?=$form->item->prefix;?>trezorerie_iban" class="form-control" placeholder="Iban" value="<?=(!empty($company->trezorerie_iban) ? $company->trezorerie_iban : '');?>">
															</div>
														</div>
													</div>
												</div>
	        						</div>
									
	        						<div id="temailing" class="tab-pane">
												<div class="panel-body">
													<div class="row">
													
														<div class="col-md-12">
															<div class="form-group">
																<label>SMTP User</label>
																<input type="text" name="<?=$form->item->prefix;?>smtp_user" class="form-control" placeholder="Smtp username" value="<?=(!empty($emailing->smtp_user) ? $emailing->smtp_user : '');?>">
															</div>
														</div>
														
														<div class="col-md-12">
															<div class="form-group">
																<label>SMTP Addr</label>
																<input type="text" name="<?=$form->item->prefix;?>smtp_addr" class="form-control" placeholder="Smtp Addres" value="<?=(!empty($emailing->smtp_addr) ? $emailing->smtp_addr : '');?>">
															</div>
														</div>
														
														<div class="col-md-12">
															<div class="form-group">
																<label>SMTP Pass</label>
																<input type="text" name="<?=$form->item->prefix;?>smtp_pass" class="form-control" placeholder="Smtp Password" value="<?=(!empty($emailing->smtp_pass) ? $emailing->smtp_pass : '');?>">
															</div>
														</div>
														
														
														<div class="col-md-12">
															<div class="form-group">
																<label>SMTP Port</label>
																<input type="text" name="<?=$form->item->prefix;?>smtp_port" class="form-control" placeholder="Smtp Port" value="<?=(!empty($emailing->smtp_port) ? $emailing->smtp_port : '');?>">
															</div>
														</div>

													</div>
												</div>
	        						</div>									
									
											<div style="margin-top:10px;"></div>
											<div class="row">
												<div class="form-group">
													<div class="col-sm-12">
														<button class="btn btn-white" type="button" onClick="location.href='<?=base_url()?>'">Anuleaza</button>
														<button name="<?=$form->item->prefix;?>submit" type="submit" class="btn btn-fill btn-info">Salveaza</button>
													</div>
												</div>
											</div>
	        					</div>
        					</form>
        				</div>
        			</div>

        		</div>
        	</div>
        <!-- Modal upload image -->
        <form method="POST" id="fmodalupfile" class="form-horizontal" enctype="multipart/form-data">
          <div class="modal fade" id="inpfileModal" tabindex="-1" role="dialog" aria-labelledby="inpfileModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="inpfileModalLabel">Incarca imagine</h4>
                </div>
                <div class="modal-body">
                  <input type="file" name="inpfile" size="50" class="form-control" />
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default btn-simple" data-dismiss="modal">Renunta</button>
                  <button type="button" class="btn btn-primary btn-fill" onClick="return upfile(<?=$application->owner->id;?>);return false;">Incarca imaginea</button>
                </div>
              </div>
            </div>
          </div>
        </form>
