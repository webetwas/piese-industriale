<?php
// var_dump($site_lang);
?>
        <!--Header Top Area Strat-->
        <header>
            <div class="header-top-area">
                <div class="container">
                    <div class="row">
						<div class="header-top-right-menu">
							<nav>
								<ul>
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<?=($site_lang == "en" ? 'English' : 'Romana')?><i class="fa fa-angle-down"></i>
										</a>
										<ul class="dropdown-menu lang">
											<li><a href="<?=base_url()?>pagini/site_lang/<?=($site_lang == "ro" ? 'en' : 'ro')?>"><?=($site_lang == "ro" ? 'English' : 'Romana')?></a></li>
										</ul>
									</li>
								</ul>
							</nav>
						</div>
                    </div>
                </div>
            </div>
			<div class="header-main-area">
				<div class="container">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-4"></div>
						<div class="col-lg-4 col-md-4 col-sm-4">
							<div class="logo">
								<a href="<?=base_url()?>"><img src="<?=(isset($owner->image_logo) && !is_null($owner->image_logo) ? SITE_URL.PATH_IMG_MISC. '/' .$owner->image_logo : base_url().'public/upload/img/misc/photo-cvnrjry8.png');?>" title="<?=$owner->company?>" alt="<?=$owner->company?>" class="img-responsive" /></a>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4"></div>
					</div>
				</div>
			</div>
        </header>
        <!--End of Header Top Area-->