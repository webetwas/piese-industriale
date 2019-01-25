<div class="container" style="margin-bottom:100px;">
  <div class="about-heading">
	  <div class="row">
		<div class="wwd">
			<?php if($page->i): ?>
				<div class="col-sm-5"><img class="img-responsive" src="<?=base_url().'public/upload/img/page/page/m/'.$page->i[0]->img?>" alt="piese industriale, industrial parts"></div>
			<?php endif; ?>
		  <div class="col-sm-<?=($page->i ? '7' : '12')?>">
			<div class="column-inner ">
			  <div class="wrapper">
				<h4 class="aboutus-title"><?=$page->p->{'title_content_' . $site_lang}?></h4>
				<div class="desc">
				  <p><?=$page->p->{'content_' . $site_lang}?></p>
				</div>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
  </div>