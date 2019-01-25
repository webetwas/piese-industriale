        <div class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                <div class="ibox-content" style="padding:15px;margin-top:20px;">
                  <form name="<?=$form->item->name;?>" id="fidcpass" action="<?=base_url().$form->item->segments?>" method="POST" novalidate="">
                    <div class="header" style="text-align:center;"><h2><?=(isset($message) ? $message : "Schimba parola")?></h2></div>
                    <div class="content">
                      <div class="form-group">
                        <input class="form-control"
                        name="duser"
                        type="text"
                        value="<?=$user->user_name;?>"
                        disabled
                        />
                      </div>
                      <?php
                      if(!isset($message)) echo'
                        <div id="fiidcpass">
                         <div class="form-group">
                           <label class="control-label">Parola veche <star>*</star></label>
                           <input class="form-control"
                           name="' .$form->item->prefix. 'cpassop"
                           type="password"
                           required="true"
                           placeholder="Parola veche"
                           />
                         </div>
                       </div>
											 <div class="row">
													<div class="form-group">
															<div class="col-sm-12">
															 <button class="btn btn-white" type="button" onClick="location.href=\'' .base_url(). 'platforma/setari/utilizator/item/u/id/' .$user->id. '\'">Anuleaza</button>
															 <button id="fbidcpass" name="' .$form->item->prefix. 'submit" type="button" class="btn btn-fill btn-info" onClick="return cpass(' .$user->id. ');">Mai departe</button>
															</div>
													</div>
											 </div>
                       ';?>
                     </div>
                   </form>
                 </div>
               </div>
             </div>
           </div>
        </div>
