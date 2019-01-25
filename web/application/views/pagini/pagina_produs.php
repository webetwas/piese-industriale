<?php
	if(strstr($product->images, ','))
	{
		$product_images = explode(',', $product->images);
	}
	else
	{
		$product_images = array($product->images);
	}
?>
        <!--Product Details Area Start-->
        <section class="product-details-area">
            <div class="container">
                <div class="row">
				<?php if(!is_null($cerere_error)): ?>
					<div class="alert alert-danger" role="alert"><?=$cerere_error?></div>
				<?php endif; ?>
				<?php if(!is_null($cerere_success)): ?>
					<div class="alert alert-success" role="alert"><?=$cerere_success?></div>
				<?php endif; ?>					
                    <div class="col-lg-5 col-md-5 col-sm-5">
                        <div class="product-s-l">
                            <div class="product-large">
                                <div class="tab-content">
									
									<?php if(!empty($product->images)): ?>
									<?php foreach($product_images as $keypd => $pd): ?>
                                    <div class="tab-pane <?=($keypd == 0 ? 'active in' : '')?>" id="img-<?=$keypd?>">
                                        <a id="a-pd-mimg" href="<?=base_url()?>public/upload/img/catalog_produse/l/<?=$pd?>" class="fancybox" title="<?=$product->{'atom_name_'. $site_lang}?>">
											<img alt="<?=$product->{'atom_name_'. $site_lang}?>" id="pd-mimg" src="<?=base_url()?>public/upload/img/catalog_produse/l/<?=$pd?>">
										</a>
                                    </div>									
									<?php endforeach; ?>
									<?php else: ?>
									<img id="pd-mimg" src="<?=base_url()?>public/assets/img/product/blank_product_product.jpg" alt="<?=$product->{'atom_name_'. $site_lang}?>">
									<?php endif; ?>
                                </div>
                            </div>
                            <div class="product-small">
                                <ul class="nav nav-tabs" role="tablist">
									<?php if(!empty($product->images)): ?>
									<?php foreach($product_images as $keypd => $pd): ?>
                                    <li class="">
                                        <a class="primary-img" title="<?=$product->{'atom_name_'. $site_lang}?>">
											<?php if(!is_null($pd)): ?>
                                            <img src="<?=base_url()?>public/upload/img/catalog_produse/s/<?=$pd?>" alt="<?=$product->{'atom_name_'. $site_lang}?>" />
											<?php else: ?>
											<img src="<?=base_url()?>public/assets/img/product/blank_product_product.jpg" alt="<?=$product->{'atom_name_'. $site_lang}?>" />
											<?php endif; ?>
                                        </a>
                                    </li>
									<?php endforeach; ?>
									<?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-sm-7">
                        <div class="product-right-details">
                            <h2><?=$product->{'atom_name_'. $site_lang}?></h2>
							<?php if(!is_null($product->fisa_tehnica_pdf))
							{
								echo '<i class="fa fa-arrow-right" aria-hidden="true"></i> <a href="' .base_url(). 'public/upload/pdf/' .$product->fisa_tehnica_pdf. '" target="_blank">' .($site_lang == "en" ? 'Open technical details for this product' : 'Deschide fisa tehnica a produsului'). '</a>';
							}
							?>
					<p class="p-d-price">
					<?php
					if($product->pret != "0.00") {
						if($product->pret_nou != '0.00')
							echo $product->pret_nou. ' RON' . '<span>' .$product->pret. ' RON</span>';
						else {
							echo $product->pret . ' RON';
						}
					}
					?>				
					</p>
							
                            <p><?=($site_lang == "en" ? 'Availability' : 'Disponibilitate')?> :
							<span class="stock"><?=((bool)$product->atom_instock ? ($site_lang == "en" ? 'Yes' : 'In stoc') : ($site_lang == "en" ? 'pre-order' : 'La comanda'))?></span> </p>
							<br />
							<?=(!empty($product->producator) ? '<p> ' .($site_lang == "en" ? 'Manufacturer' : 'Producator'). ': ' .$product->producator. '</p>' : '')?>
							<?=(!empty($product->cod_produs) ? '<p>' .($site_lang == "en" ? 'Product code' : 'Cod produs'). ': ' .$product->cod_produs. '</p>' : '')?>
							<hr>
                            <?=$product->{'content_' . $site_lang}?>
							<hr>
							<?php if($product->pret == "0.00"): ?>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ask-ofer" data-whatever="@getbootstrap" style="margin-bottom:50px;"><?=($site_lang == "en" ? 'Ask for offer for this product' : 'Cerere Oferta pentru acest produs')?></button>
							<?php endif; ?>
                        </div>
					</div>
                </div>
            </div>
        </section>
        <!--End of product-details Area-->
		
<?php if($product->pret == "0.00") { ?>
<style type="text/css">
    .modal-dialog {
    margin: 50px auto;
    z-index: 99998; !important;}

    .modal {
    z-index: 99997 !important;
    }

</style>
<div class="modal fade" id="ask-ofer" tabindex="-1" role="dialog" aria-labelledby="ask-ofer" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form name="cerere-produs" id="cerere-produs-form" method="POST">
		  <div class="modal-header">
			<h5 class="modal-title" id="ask-ofer"><?=($site_lang == "en" ? 'Ask for offer' : 'Cerere Oferta')?></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="alert alert-danger" role="alert" style="display:none;" id="form-cerere-error"><?=($site_lang == "en" ? 'Please complete all fields listed bellow' : 'Te rugam sa completezi campurile de mai jos..')?></div>
			  <div class="form-group">
				<label for="recipient-name" class="col-form-label"><?=($site_lang == "en" ? 'Product name' : 'Denumire Produs')?></label>
				<input type="text" class="form-control" name="atom_name_ro" value="<?=$product->atom_name_ro?>" required readonly>
				<input type="hidden" name="atom_id" id="form-cerere-atom-id" value="<?=$product->atom_id?>">
			  </div>
			  <div class="form-group">
				<label for="recipient-name" class="col-form-label"><?=($site_lang == "en" ? 'First name / Last name' : 'Nume / Prenume:')?></label>
				<input type="text" name="cerere-nume" id="form-cerere-nume" class="form-control" required>
			  </div>
			  <div class="form-group">
				<label for="recipient-name" class="col-form-label"><?=($site_lang == "en" ? 'Phone number' : 'Telefon:')?></label>
				<input type="text" name="cerere-telefon" id="form-cerere-telefon" class="form-control" required>
			  </div>
			  <div class="form-group">
				<label for="recipient-name" class="col-form-label">Email:</label>
				<input type="text" name="cerere-email" id="form-cerere-email" class="form-control" required>
			  </div>
			  <div class="form-group">
				<label for="message-text" class="col-form-label" required><?=($site_lang == "en" ? 'Your message:' : 'Mesaj:')?></label>
				<textarea class="form-control" name="cerere-mesaj" id="form-cerere-mesaj"></textarea>
			  </div>
			  <div class="form-group">
				<label for="input-password" class="col-sm-2 control-label"><?=($site_lang == "en" ? 'Catpcha:' : 'Verificare')?></label>
					<input type="text" class="form-control" name="captcha" value="" placeholder="<?=($site_lang == "en" ? 'Type catpcha' : 'introduceti codul de mai sus')?>" id="captcha" required>
					<input type="hidden" name="captchaHash" id="captchaHash" value="">
			   </div>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><?=($site_lang == "en" ? 'Cancel' : 'Inchide')?></button>
			<button type="submit" name="cerere-produs-submit" class="btn btn-primary"><?=($site_lang == "en" ? 'Send' : 'Trimite cerere')?></button>
		  </div>
		</form>
    </div>
  </div>
</div>
<?php } ?>