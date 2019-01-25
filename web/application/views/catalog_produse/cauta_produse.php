<div class="content col-sm-9">
	<div class="container-fluid" style="margin-top:-20px;">
			<div class="row">
				<?php
				if(is_null($categories_cp) && is_null($products))
					echo '<h4 style="margin:30px;">Nu s-au gasit produse in urma cautarilor tale.<br />Mergi la <a href="' .base_url(). 'catalog_produse">Catalog produse</a></h4>';
				?>	
				<?php if(!is_null($categories_cp)): ?>
				<?php foreach($categories_cp as $welcome_ctp): ?>
					<?php
					$welcome_ctp_img = base_url() . 'public/assets/img/product/category_subbaner_noimage.jpg';
					if(!is_null($welcome_ctp["images"]))
					{
						$welcome_ctp_img = base_url() . 'public/upload/img/nodes/l/' . explode(',', $welcome_ctp["images"])[0];
					}
					?>
					<div class="col-md-6 col-sm-6 col-xs-12">
						  <div class="banner sub-hover">
							<a href="<?=base_url()?>catalog_produse/categorie/<?=$welcome_ctp["slug"]?>"><img src="<?=$welcome_ctp_img?>" alt="<?=$welcome_ctp["denumire_ro"]?>" class="img-responsive" /></a>
							<div class="bannertext">
							  <h2><?=$welcome_ctp["denumire_ro"]?></h2>
							  <a href="<?=base_url()?>catalog_produse/categorie/<?=$welcome_ctp["slug"]?>" class="btn">Vezi Categorie Produse</a>
							</div>            
						  </div>
					</div>
				<?php endforeach; ?>
				<?php endif; ?>		
			</div>
	</div>

		<?php if(!is_null($products)): ?>
			<div class="grid-list-wrapper">
				<?php foreach($products as $prod_ca_prod): ?>
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
			
			
				<div class="product-layout product-list col-xs-12">
					<div class="product-thumb">
					  <div class="image product-imageblock"> <a href="<?=base_url()?>catalog_produse/produs/<?=$prod_ca_prod->slug?>">
						<img src="<?=$prod_image?>" class="img-responsive" alt="piese industriale" />
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
							if($prod_ca_prod->pret_nou != "0.00")
							{
								$prod_pret = '<p class="price product-price">' . $prod_ca_prod->pret_nou . ' Lei<span class="less">' . $prod_ca_prod->pret . ' Lei</span></p>';
							}
							else
							{
								$prod_pret = '<p class="price product-price">' . $prod_ca_prod->pret . ' Lei</p>';								
							}
							echo $prod_pret;
						?>
						<p class="product-desc"><?=$prod_ca_prod->content_ro?></p>
					  </div>
					</div>
				</div>
				
				<?php endforeach; ?>
			</div>
			
		<?php endif; ?>
		
	<?php if(!empty($pagination)): ?>
      <div class="category-page-wrapper">
        <div class="result-inner">Pagini produse</div>
			<div class="pagination-inner">
                <ul id="ulpagination" class="pagination">
					<?php echo $pagination; ?>
                </ul>
            </div>
        </div>
    </div>
	<?php endif; ?>
</div>