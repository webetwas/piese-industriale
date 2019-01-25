<!--Footer Widget Area Start-->
<section class="footer-widget-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                <div class="footer-widget">
                    <div class="bottom-logo">
                        <img src="<?=(isset($owner->image_logo) && !is_null($owner->image_logo) ? SITE_URL.PATH_IMG_MISC. '/' .$owner->image_logo : base_url().'public/upload/img/misc/photo-cvnrjry8.png');?>" title="<?=$owner->company?>" alt="piese industriale, industrial parts">
                    </div>
                    <div class="social-text">
                        <div class="social-icons">
							<?=(!empty($owner->facebook) ? '<a href="' .$owner->facebook. '" target="_blank"><i class="fa fa-facebook"></i></a>' : '')?>
							<?=(!empty($owner->twitter) ? '<a href="' .$owner->twitter. '" target="_blank"><i class="fa fa-twitter"></i></a>' : '')?>
							<?=(!empty($owner->googleplus) ? '<a href="' .$owner->googleplus. '" target="_blank"><i class="fa fa-google-plus"></i></a>' : '')?>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
                <div class="footer-widget">
                    <div class="single-footer">
                        <div class="contact-info">
                            <h4>Contact</h4>
                            <p><strong><?=$owner->company?></strong></p>
                            <p><?=($site_lang == "en" ? 'Contact name: ' : 'Persoana contact:')?> <?=$company->nume?> <?=$company->prenume?></p>
                            <p><?=($site_lang == "en" ? 'Phone' : 'Telefon')?>:
								<?php if(!empty($company->telefon_fix)): ?>
								<a href="tel:<?=$company->telefon_fix?>"><?=$company->telefon_fix?></a><br>
								<?php endif; ?>
								<?php if(!empty($company->telefon_mobil)): ?>
								<a href="tel:<?=$company->telefon_mobil?>"><?=$company->telefon_mobil?></a>
								<?php endif; ?>			
							</p>
                            <p>Email : <a href="mailto:<?=$owner->oemail?>"><?=$owner->oemail?></a></p>
                            <p>Web : <a href="http://<?=$owner->website?>" target="_blank"><?=$owner->website?></a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 hidden-sm hidden-xs">
                <div class="footer-widget">
                    <div class="single-footer right">
                        <div class="contact-info">
                        <h4><?=($site_lang == "en" ? 'Opening times' : 'Programul nostru')?></h4>
						<?=$program->{'tprext_orar_' .$site_lang}?>
                    </div>
                        <!-- Scroll to top -->
                        <a class="scrollup" href="#">
                            <img src="../web/public/assets/img/scrollup.png" alt="piese industriale, industrial parts">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--End of Footer Widget Area-->
<!--Footer Area Start-->
<footer class="footer-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <div class="footer-left">
                    <p>
                        Copyright &copy; 2018<a href="#"><?=$owner->owner?></a>. <?=($site_lang == "en" ? 'All rights reserved' : 'Toate drepturile rezervate.')?> <br />
                        <?=($site_lang == "en" ? 'Website developed by <a href="http://www.webetwas.com" target="_blank">WebEtwas</a>' : 'website realizat de <a href="http://www.webetwas.com" target="_blank">WebEtwas</a>')?>
                    </p>
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
                <div class="footer-right">
                    <nav>
						<?php if(!empty($menu_footer)): ?>
						  <ul id="footer-menu">
							<?php foreach($menu_footer as $mf): ?>
							<?php
							if($mf->fullpath == "/" || $mf->fullpath == "acasa" || $mf->fullpath == "homepage" || $mf->fullpath == "index" || $mf->fullpath == "index.php") $mf->fullpath = "";
							?>
								<li><a href="<?=$mf->fullpath?>" <?=strstr($mf->fullpath, 'http') ? 'target="_blank"' : ''?>><?=$mf->{'atom_name' . '_' . $site_lang}?></a></li>
							<?php endforeach; ?>
						  </ul>
						<?php endif; ?>
						
                    </nav>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--End of Footer Area-->

