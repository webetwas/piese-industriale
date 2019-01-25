<?php if(!empty($categorii_speciale)) { ?>
<section class="product-banner-area">
	<div class="container">
		<div class="row">
			<?php foreach($categorii_speciale as $welcome_cs) { ?>
			<?php
				$welcome_cs_image = base_url() . 'public/assets/img/ctgspec-noimage.jpg';
				
				if(!is_null($welcome_cs["images"]))
				{
					$welcome_cs_image = base_url() . 'public/upload/img/nodes/l/' . explode(',', $welcome_cs["images"])[0];
				}
			?>
			
			<div class="col-lg-4 col-md-4 col-sm-4">
				<div class="product-left-banner right" style="border:3px solid #f1f1f1;">
					<a href="<?=base_url()?>catalog_produse/categorie/<?=$welcome_cs["slug"]?>">
						<img src="<?=$welcome_cs_image?>" alt="piese industriale"/>
						<div class="banner-left-text">
							<h2 style="font-size:30px;"><span class=""><?=$welcome_cs["i_titlu_" . $site_lang]?></span><span><?=$welcome_cs["i_subtitlu_" . $site_lang]?></span></h2>
						</div>	
					</a>	
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</section>
<?php } ?>