<div class="footer-top-cms parallax-container">
  <div class="parallax"><img src="<?=base_url()?>public/assets/image/news.png" alt="#" class="img-news"></div>
  <div class="container">
    <div class="row">
      <div class="newslatter">
        <form name="newsletter">
          <h5>INSCRIETI-VA PENTRU A DESCOPERII CELE MAI NOI PRODUSE!</h5>
          <h4 class="title-subline">Asigurati-va ca urmariti site-ul nostru pentru a beneficia de catalogul nostru actualizat!</h4>
          <div class="input-group">
            <input type="mail" class="form-control" name="inregnl" id="register_newsletter_data" placeholder="Introdu emailul tau">
            <button type="button" value="Sign up" class="btn btn-large btn-primary" id="register_newsletter">Inscrie-te</button>
          </div>
        </form>
      </div>
      <div class="footer-social">
        <ul>
		<?=(!empty($owner->facebook) ? '<li class="facebook"><a href="' .$owner->facebook. '" target="_blank"><i class="fa fa-facebook"></i></a></li>' : '')?>
		<?=(!empty($owner->twitter) ? '<li class="twitter"><a href="' .$owner->twitter. '" target="_blank"><i class="fa fa-twitter"></i></a></li>' : '')?>
		<?=(!empty($owner->googleplus) ? '<li class="gplus"><a href="' .$owner->googleplus. '" target="_blank"><i class="fa fa-google-plus"></i></a></li>' : '')?>
		<?=(!empty($owner->youtube) ? '<li class="youtube"><a href="' .$owner->youtube. '" target="_blank"><i class="fa fa-youtube-play"></i></a></li>' : '')?>
        </ul>
      </div>
    </div>
  </div>
</div>
<script src="<?=base_url()?>public/assets/javascript/jquery.parallax.js"></script>
<script>
    jQuery(document).ready(function ($) {
        $('.parallax').parallax();
    });
</script>