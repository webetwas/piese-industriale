<?php if(!is_null($echipa)) { ?>
  <div class="row team">
    <div class="col-md-offset-2 col-md-8">
      <h3 class="team-title">Echipa Agroteam Trading</h3>
    </div>
	<?php foreach($echipa as $membru) { ?>
	<?php
		$membru_image = base_url() . 'public/assets/image/team4.jpg';
		if(!is_null($membru->images))
		{
			$membru_image = base_url() . 'public/upload/img/echipa/m/' . explode(',', $membru->images)[0];
		}
	?>
    <div class="col-md-3 col-sm-3 col-xs-6 team1 ">
      <div class="img-block">
		<img alt="<?=$membru->atom_name?>" src="<?=$membru_image?>" class="img-responsive">
		</div>
      <div class="text-box">
        <h3 class="name"><?=$membru->atom_name?></h3>
        <div class="deg"><?=$membru->functie?></div>
        <div class="social-holder">
          <ul class="social">
			<?php if(!empty($membru->facebook)): ?>
            <li><a href="<?=$membru->facebook?>" class="facebook"><i class="fa fa-facebook"></i></a></li>
			<?php endif; ?>
			<?php if(!empty($membru->telefon)): ?>
            <li><a href="tel:<?=$membru->telefon?>" class="twitter"><i class="fa fa-phone"></i></a></li>
			<?php endif; ?>
			<?php if(!empty($membru->email)): ?>
            <li><a href="mailto:<?=$membru->email?>" class="pinterest"><i class="fa fa-envelope"></i></a></li>
			<?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
	<?php } ?>
  </div>
<?php } ?>