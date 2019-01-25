<?php if(!is_null($echipa)) { ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="our-team">
			<h3><?=($site_lang == "en" ? 'Our team ' : 'Echipa')?> - <?=$owner->company?></h3>
		</div>
	</div>
	<?php foreach($echipa as $membru) { ?>
	<?php
		$membru_image = base_url() . 'public/assets/image/team4.jpg';
		if(!is_null($membru->images))
		{
			$membru_image = base_url() . 'public/upload/img/echipa/m/' . explode(',', $membru->images)[0];
		}
	?>	
	<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
		<div class="single-team-item">
			<a href="javascript:void(0);"><img src="<?=$membru_image?>" alt="<?=$membru->atom_name?>"></a>
			<div class="team-hover">
				<a href="javascript:void(0);"><i class="fa fa-plus"></i></a>
				<div class="team-links">
					<?php if(!empty($membru->facebook)): ?>
					<a href="<?=$membru->facebook?>" class="portfolio-facebook"><i class="fa fa-facebook"></i></a>
					<?php endif; ?>
					<?php if(!empty($membru->telefon)): ?>
					<a href="tel:<?=$membru->telefon?>" class="portfolio-twitter"><i class="fa fa-phone"></i></a>
					<?php endif; ?>
					<?php if(!empty($membru->email)): ?>
					<a href="mailto:<?=$membru->email?>" class="portfolio-pinterest"><i class="fa fa-envelope"></i></a>
					<?php endif; ?>					
				</div>
			</div>
		</div>
		<div class="team-text">
			<h2><a href="javascript:void(0);"><?=$membru->atom_name?></a></h2>
			<h3><?=$membru->functie?></h3>
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>