<?php
$banner = base_url(). 'public/assets/img/banner-noimage.jpg';
if(!empty($page->b) && isset($page->b["banner1"]))
{
	$banner = base_url(). "public/upload/img/page/banners/" .$page->b['banner1']->img;
}
?>
<div class="breadcrumb parallax-container">
  <div class="parallax"><img src="<?=$banner?>" alt="#"></div>
  <h1 class="category-title"><?=$page->p->title_ro?></h1>
  <?php if(!empty($breadcrumb)) { ?>
  <ul>
	<?php foreach($breadcrumb as $bb) { ?>
		<li><a href="<?=$bb["href"]?>"><?=$bb["text"]?></a></li>
	<?php } ?>
  </ul>
  <?php } ?>
</div>


<style type="text/css">
.active{
	font-weight: bold;
}
</style>
<script src="<?=base_url();?>public/assets/javascript/jquery.parallax.js"></script>
<script>
    jQuery(document).ready(function ($) {
        $('.parallax').parallax();
    });
</script>