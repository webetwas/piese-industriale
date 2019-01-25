<?php
// var_dump($produse);
?>
<div id="center">
  <div class="container">
    <div class="row">
      <div class="content col-sm-12">
        <div class="customtab">
          <h3 class="productblock-title">catalogul nostru</h3>
          <div id="tabs" class="customtab-wrapper">
            <ul class='customtab-inner'>
			<?php foreach($produse["catalog_acasa"] as $keyprod_ca => $prod_ca): if(is_null($prod_ca)) continue;?>
              <li class='tab'><a href="#tab-<?=$keyprod_ca?>"><?=ucfirst($keyprod_ca)?></a></li>
			<?php endforeach; ?>
            </ul>
          </div>
        </div>
		<?php foreach($produse["catalog_acasa"] as $keyprod_ca => $prod_ca): if(is_null($prod_ca)) continue;?>
        <!-- tab-->
        <div id="tab-<?=$keyprod_ca?>" class="tab-content">
			<?php $counter_prod_ca_prod = 0; foreach($prod_ca as $key_prod_ca_prod => $prod_ca_prod): $counter_prod_ca_prod++;?>
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
			<?php if($counter_prod_ca_prod == 1) echo '<div class="row">'; ?>
				<div class="product-layout  product-grid  col-lg-3 col-md-4 col-sm-6 col-xs-12">
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
				</div>
			<?php if($counter_prod_ca_prod == 4) { echo '</div>'; $counter_prod_ca_prod = 0; } ?>
			<?php endforeach; ?>
            <div class="viewmore">
              <a href="<?=base_url()?>catalog_produse" class="btn">Vezi produsele noastre</a>
            </div>
        </div>
		<?php endforeach; ?>
      </div>
    </div>
  </div>
</div>