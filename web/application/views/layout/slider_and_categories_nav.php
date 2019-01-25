<?php
// var_dump($homesliders);die();
// var_dump($categorii_speciale);
// var_dump($categories);

?>

<div class="mainbanner">
  <div id="main-banner" class="owl-carousel home-slider">
	<?php $slider_ct = 0; foreach($homesliders as $key_slider_s => $slideritem) {
		$slider_ct++;
		if($slider_ct == 2)
		{
			break;
		}
			echo '<div class="item"> <a href="javascript:void(0);"><img src="' . $pathimgbanners.$slideritem->img. '" alt="main-banner1" class="img-responsive" /></a> </div>';
		}
		?>
  </div>
</div>

<!--Main Slider Area Start-->
<div class="main-slider-area">
    <div class="container">
        <div class="row">
            <!-- Categories nav -->
			
			<div class="col-lg-3 col-md-3 col-sm-4 left-sidebar">
				
				<ul class="l-sidebar">
					<li>
						<a href="javascript:void(0);" class="left-sidebar-title">
							<i class="fa fa-navicon"></i>
							<?=($site_lang == "en" ? 'Products' : 'Catalog PRODUSE')?><img src="img/sidebar-icon.png" alt="piese industriale, industrial parts">
						</a>
					</li>
					<?php if(!is_null($categories)) { ?>
					<?php foreach($categories as $sl_a_c_ctg) { ?>
					<li><a href="<?=base_url()?>catalog_produse/categorie/<?=$sl_a_c_ctg["slug"]?>" <?=(!empty($sl_a_c_ctg["_nodes"]) ? 'class="show-submenu"' : '')?>><?=$sl_a_c_ctg["denumire_" . $site_lang]?><i class="fa fa-caret-right rotate"></i></a>
						<?php if(!empty($sl_a_c_ctg["_nodes"])) { ?>
						<ul class="left-sub-navbar submenu">
							<?php foreach($sl_a_c_ctg["_nodes"] as $sl_a_c_ctg_n) { ?>
							<li><a href="<?=base_url()?>catalog_produse/categorie/<?=$sl_a_c_ctg_n["slug"]?>"><?=$sl_a_c_ctg_n["denumire_" . $site_lang]?></a></li>
							<?php } ?>
						</ul>
						<?php } ?>
					<?php } ?>
					</li>
					<?php } ?>
				</ul>
				
			</div>
            <!-- /Categories nav -->
            
			<!-- Slider -->
			
			<div class="col-lg-6 col-md-6 col-sm-8">
				<div class="slider-area">
					<!--Slider Area Start-->
					<div class="fullwidthbanner-container">					
						<div class="fullwidthbanner-two">
							<?php if($homesliders) { ?>
							<ul>
								<?php foreach($homesliders as $key_s_l => $slideritem) { ?>
								<!-- Slide One -->
								<li class="slider" data-transition="random" data-slotamount="7" data-masterspeed="300">
									<!-- Main Image-->
										<img src="<?=$pathimgbanners.$slideritem->img?>" alt="piese industriale, industrial parts"  data-bgposition="center top" data-bgrepeat="no-repeat" data-bgpositionend="center center"> 
								</li>
								<?php if($key_s_l == "banner2") break; } ?>
							</ul>
							<?php } ?>
						</div>					
					</div>
					<!--End of Slider Area-->
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-12 right-side-banner">
				<!--
				<?php if(!empty($categorii_speciale)) { ?>
					<?php foreach($categorii_speciale as $welcome_cs) { ?>
					<?php
						$welcome_cs_image = base_url() . 'public/assets/img/ctg-spec-noimage.jpg';
						
						if(!is_null($welcome_cs["images"]))
						{
							$welcome_cs_image = base_url() . 'public/upload/img/nodes/l/' . explode(',', $welcome_cs["images"])[0];
						}
					?>
					<div class="right-single-banner">
						<a href="<?=base_url()?>catalog_produse/categorie/<?=$welcome_cs["slug"]?>">
							<img src="<?=$welcome_cs_image?>" alt="">
						</a>
					</div>
					<?php } ?>
				<?php } ?>
				-->
				
				<?php if(!empty($homesliders) && (isset($homesliders["banner3"]) || $homesliders["banner4"] || $homesliders["banner5"])) {
					foreach($homesliders as $key_rsb => $right_slider_banner) {
						if($key_rsb == "banner1" || $key_rsb == "banner2")
						{
							continue;
						}
						
						$rsb_href1 = null;
						
						$r_s_b = base_url(). "public/upload/img/page/banners/" .$right_slider_banner->img;
						
						if(!is_null($right_slider_banner->href1))
						{
							$rsb_href1 = $right_slider_banner->href1;
							if(!strstr($right_slider_banner->href1, 'http://') || !strstr($right_slider_banner->href1, 'https://')) {
								$rsb_href1 = 'http://' . $right_slider_banner->href1;
							}							
						}

						echo '
							<div class="right-single-banner">
								<a href="' .(!is_null($rsb_href1) ? $rsb_href1 : 'javascript:void(0);'). '">
									<img src="' . $r_s_b . '" alt="piese industriale, industrial parts">
								</a>
							</div>						
						';
					}
				}
				?>
			</div>			
			
			<!-- /Slider -->
        </div>
    </div>
</div>
<!--End of Main Slider Area-->