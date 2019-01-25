<?php if(!is_null($produse["ultimele_utilaje_pe_stoc"])): ?>
<div class="container">
  <div class="row">
    <div class="content col-sm-12">
      <div class="customtab">
        <h3 class="productblock-title">Ultimile Utilaje pe stoc</h3>
        <h4 class="title-subline">Ai gasit un produs pentru tine? <a href="tel: 0728877100">Achizitioneazal!</a></h4>
      </div>
      <div id="tab-random-products" class="tab-content">
          <div id="special-slidertab" class="row owl-carousel product-slider">
		  
			<?php foreach($produse["ultimele_utilaje_pe_stoc"] as $prod_ca_prod): ?>
			<?php
				$prod_image = base_url() . 'public/assets/img/product/product-m-noimage.jpg';
				$prod_image_second = base_url() . 'public/assets/img/product/product-m-noimage.jpg';
				if(!is_null($prod_ca_prod->images))
				{
					$prod_images = explode(',', $prod_ca_prod->images);
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
			
            <div class="item">
					<div class="product-thumb">
					  <div class="image product-imageblock"> <a href="<?=base_url()?>catalog_produse/produs/<?=$prod_ca_prod->slug?>">
						<img src="<?=$prod_image?>" class="img-responsive" />
						<img src="<?=$prod_image_second?>" alt="<?=$prod_ca_prod->atom_name?>" title="<?=$prod_ca_prod->atom_name?>" class="img-responsive" /> </a>
						<ul class="button-group">
						  <li>
							<a href="<?=base_url()?>catalog_produse/produs/<?=$prod_ca_prod->slug?>" class="addtocart-btn" title="Vezi produs"> Vezi produs </a>
						  </li>
						</ul>
					  </div>
					  <div class="caption product-detail">
						
						<h4 class="product-name"><a href="<?=base_url()?>catalog_produse/produs/<?=$prod_ca_prod->slug?>" title="Titlu Produs"><?=$prod_ca_prod->atom_name?></a></h4>
						
						<?php
							if($prod_ca_prod->pret != "0.00") {
								if($prod_ca_prod->pret_nou != "0.00")
								{
									$prod_pret = '<p class="price product-price">' . $prod_ca_prod->pret_nou . ' Lei<span class="less">' . $prod_ca_prod->pret . ' Lei</span></p>';
								}
								else
								{
									$prod_pret = '<p class="price product-price">' . $prod_ca_prod->pret . ' Lei</p>';								
								}
								echo $prod_pret;
							}
						?>
						
					  </div>
					</div>
            </div>
			<?php endforeach; ?>

          </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>