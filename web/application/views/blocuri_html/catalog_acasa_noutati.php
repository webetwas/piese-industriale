<?php if(!is_null($produse["catalog_acasa"]["noutati"])) { ?>
<!--Product Area Start-->
<section class="product-area">
    <div class="product-carousel-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="p-feature-title-menu clearfix">
                        <div class="p-carousel-title">
                            <h2><?=($site_lang == "en" ? 'New products' : 'PRODUSE NOI')?></h2>
                        </div>
                        
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="tab-content">
                    <div id="women" role="tabpanel" class="tab-pane active">
                        <div class="single-p-slide-homepage-two" >
							<?php foreach($produse["catalog_acasa"]["noutati"] as $ca_n) { ?>
							<?php
								$prod_image = base_url() . 'public/assets/img/product/blank_product.jpg';
								$prod_image_second = base_url() . 'public/assets/img/product/blank_product.jpg';
								if(!is_null($ca_n->images))
								{
									$prod_images = explode(',', $ca_n->images);
									$prod_image = base_url() . 'public/upload/img/catalog_produse/m/' . $prod_images[0];
									if(isset($prod_images[1]))
									{
										$prod_image_second = base_url() . 'public/upload/img/catalog_produse/m/' . $prod_images[1];
									}
									else
									{
										$prod_image_second = base_url() . 'public/upload/img/catalog_produse/m/' . $prod_images[0];
									}
								}
							?>
							
                            <div class="col-lg-4 col-md-4 col-sm-4 single-product-items">
                                <div class="single-items">
                                    <a href="<?=base_url()?>catalog_produse/produs/<?=$ca_n->slug?>">
                                        <img class="primary-img" src="<?=$prod_image?>" alt="<?=$ca_n->{'atom_name' . '_' . $site_lang}?>">
                                        <img class="secondary-img" src="<?=$prod_image_second?>" alt="<?=$ca_n->{'atom_name' . '_' . $site_lang}?>">
                                    </a>
                                </div>
                                <div class="product-info">
                                    <h4><a href="<?=base_url()?>catalog_produse/produs/<?=$ca_n->slug?>"><?=$ca_n->{'atom_name' . '_' . $site_lang}?></a>
									</h4>
                                </div>
                            </div>
							<?php } ?>
  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End of Product Area-->
<?php } ?>