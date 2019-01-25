<?php
// var_dump($homesliders);die();

?>

 <div id="container" class="slideshow hidden-xs">
        <!--Set your own slider options. Look at the v_RevolutionSlider() function in 'theme-core.js' file to see options-->
        <div class="home-slider-wrap fullwidthbanner-container" id="home">
            <div class="v-rev-slider" data-slider-options='{"fullScreen":"on", "fullScreenOffsetContainer": "fw-slider-spacer", "navigationStyle":"preview3"}'>
                <ul>
								<?php foreach($homesliders as $slider): ?>
									<li data-transition="fade" data-slotamount="7" data-masterspeed="600">
										<img src="<?=$pathimgbanners.$slider->img?>" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat">
										<div class="tp-caption v-caption-big-white lfb stb"
												 data-x="center" data-hoffset="0"
												 data-y="center" data-voffset="-60"
												 data-speed="800"
												 data-start="600"
												 data-easing="Circ.easeInOut"
												 data-splitin="none"
												 data-splitout="none"
												 data-elementdelay="0"
												 data-endelementdelay="0"
												 data-endspeed="600">
												<?=(!is_null($slider->titlu) ? $slider->titlu : '')?>
										</div>

										<div class="tp-caption v-caption-h1 lfb st center"
											data-x="center" data-hoffset="0"
											data-y="bottom" data-voffset="-205"
											data-speed="700"
											data-start="1100"
											data-easing="Circ.easeInOut"
											data-splitin="none"
											data-splitout="none"
											data-elementdelay="0"
											data-endelementdelay="0"
											data-endspeed="600">
											<?=(!is_null($slider->subtitlu) ? $slider->subtitlu : '')?>
										</div>

										<div class="tp-caption lfb stb"
											data-x="center" data-hoffset="0"
											data-y="bottom" data-voffset="-110"
											data-speed="700"
											data-start="1700"
											data-easing="Circ.easeInOut"
											data-splitin="none"
											data-splitout="none"
											data-elementdelay="0"
											data-endelementdelay="0"
											data-endspeed="600">
										<?=(!is_null($slider->href) ? '<a href="' .$slider->href. '" class="btn v-btn v-second-light">' .(!is_null($slider->thref) ? $slider->thref : "Vezi mai mult"). '</a>' : '')?>
										</div>
									</li>
								<?php endforeach; ?>
                </ul>

            </div>

        </div>

</div>