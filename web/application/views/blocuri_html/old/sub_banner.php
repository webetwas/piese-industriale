<div class="container-fluid"> 
	<div class="cms_banner">
	  <div class="row">
		<?php if(!is_null($categorii_principale)): ?>
		<?php foreach($categorii_principale as $key_welcome_ctp => $welcome_ctp): ?>
			<?php
			$welcome_ctp_img = base_url() . 'public/assets/img/product/category_subbaner_noimage.jpg';
			if(!is_null($welcome_ctp->images))
			{
				$welcome_ctp_img = base_url() . 'public/upload/img/nodes/l/' . explode(',', $welcome_ctp->images)[0];
			}
			?>
			<div class="col-md-3 <?=((count($categorii_principale) == 2 && $key_welcome_ctp == 0) ? 'col-md-offset-3' : '')?> col-sm-6 col-xs-12">
				  <div class="banner sub-hover">
					<a href="<?=base_url()?>catalog_produse/categorie/<?=$welcome_ctp->slug?>"><img src="<?=$welcome_ctp_img?>" alt="<?=$welcome_ctp->denumire_ro?>" class="img-responsive" /></a>
					<div class="bannertext">
					  <h2><?=$welcome_ctp->denumire_ro?></h2>
					  <p><?=$owner->owner?></p>
					  <a href="<?=base_url()?>catalog_produse/categorie/<?=$welcome_ctp->slug?>" class="btn">Vezi Categorie Produse</a>
					</div>            
				  </div>
			</div>
		<?php endforeach; ?>
		<?php endif; ?>
	  </div>
	</div>
</div>