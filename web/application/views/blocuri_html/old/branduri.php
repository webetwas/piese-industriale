<?php if(!is_null($branduri)): ?>
<div class="container">
  <h3 class="client-title">Brand-uri Favorite</h3>
  <h4 class="title-subline">Produse de cea mai inalta calitate!</h4>
  <div id="brand_carouse" class="owl-carousel brand-logo">
	<?php foreach($branduri as $brand): ?>
	<?php
		if(!is_null($brand->images))
		{
			$b_image = base_url() . 'public/upload/img/branduri/m/' . explode(',', $brand->images)[0];
		}
		
	?>
		<div class="item text-center"> <a href="javascript:void(0);"><img src="<?=$b_image?>" alt="<?=$brand->atom_name?>" class="img-responsive" /></a> </div>
	<?php endforeach; ?>
  </div>
</div>
<?php endif; ?>