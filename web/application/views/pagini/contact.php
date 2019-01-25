<?php
if(strlen($company->adresa_pl) > 5) {

  $makeadr = $company->adresa_pl. '<br />' .$company->adresa_plloc. ', ' .$company->adresa_pljud;

} else {

  $makeadr = $company->adresa_ss. '<br />' .$company->adresa_ssloc. ', ' .$company->adresa_ssjud;

}
?>
<div class="container" style="margin-bottom:100px;">
        <!--Address Area Start-->
        <div class="address-main-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="single-c-item">
                            <div class="s-c-icon">
                                <img src="img/c-icon-1.png" alt="piese industriale, industrial parts">
                            </div>
                            <p><?=$makeadr?></p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="single-c-item">
                            <div class="s-c-icon">
                                <img src="img/c-icon-2.png" alt="piese industriale, industrial parts">
                            </div>
							<?php if(!empty($company->telefon_fix)): ?>
							<p><a href="tel:<?=$company->telefon_fix?>"><?=$company->telefon_fix?></a></p><br>
							<?php endif; ?>
							<?php if(!empty($company->telefon_mobil)): ?>
							<p><a href="tel:<?=$company->telefon_mobil?>"><?=$company->telefon_mobil?></a></p>
							<?php endif; ?>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="single-c-item">
                            <div class="s-c-icon">
                                <img src="img/c-icon-3.png" alt="piese industriale, industrial parts">
                            </div>
                            <p>Email : <a href="mailto:<?=$owner->oemail?>"><?=$owner->oemail?></a></p>
                            <p>Web : <a href="http://<?=$owner->website?>"><?=$owner->website?></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End of Address Area-->
        <!--Map Area start-->
		<!--
        <div class="map-main-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="map-area">
                            <div id="googleMap" style="width:100%;height:388px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		-->
        <!--End of Map Area-->
        <!--Contact Form Area Start-->
        <section class="contact-form-area">
            <div class="container">
				<?php if(is_null($form->item->success)): ?>
                <div class="row">
                    <form name="<?=$form->item->name?>" id="<?=$form->item->id?>" method="post" action="<?=base_url().$form->item->segments?>">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="contact-left-form">
                                <p>Name*</p>
                                <input type="text" name="cf-name" placeholder="" required>
                                <p>Email*</p>
                                <input type="email" name="cf-email" placeholder="" required>
                                <p>Phone*</p>
                                <input type="text" name="cf-phone" placeholder="">
                                <p>Subject*</p>
                                <input type="text" name="cf-subject" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <h3><?=($site_lang == "en" ? 'Leave a Message' : 'Trimite un mesaj')?></h3>
                            <p class="msg">Message*</p>
                            <textarea name="cf-message" required></textarea>
							<?=(!is_null($form->item->error) ? '<span style="color:red;font-weight:bold">' .$form->item->error. '</span><br />' : "")?>
								<label for="input-password" class="col-sm-2 control-label">Verificare</label>
								<input type="text" class="form-control" name="captcha" value="" placeholder="introduceti codul de mai sus" id="captcha" required>						
							
                            <input type="submit" name="cf-submit" value="<?=($site_lang == "en" ? 'Send messsage' : 'Trimite mesaj')?>">
                        </div>
                    </form>
                </div>
				<?php endif; ?>
				<?php if(!is_null($form->item->success)): ?>

					<h1 style="text-align:center;margin:100px;"><?=$form->item->success?></h1>

				<?php endif;?>
            </div>
</div>
        </section>
        <!--End of Contact Form Area-->
        <!-- Google Map js -->
		<!--
        <script src="https://maps.googleapis.com/maps/api/js"></script>	
		<script>
			function initialize() {
                var mapOptions = {
				zoom: 15,
				scrollwheel: false,
				center: new google.maps.LatLng(40.663293, -73.956351)
            };

			  var map = new google.maps.Map(document.getElementById('googleMap'),
				  mapOptions);
                
                
			  var marker = new google.maps.Marker({
				position: map.getCenter(),
				animation:google.maps.Animation.BOUNCE,
				icon: 'img/map-marker.png',
				map: map
            });
			}
			google.maps.event.addDomListener(window, 'load', initialize);
		</script>
		-->