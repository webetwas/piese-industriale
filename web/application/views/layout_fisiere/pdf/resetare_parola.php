<?php
// var_dump($data);die();
?>
<div class="row">
	<div class="col align-self-start"></div>
	<div class="col align-self-end">
		
		<blockquote>
		<img src="<?=SITE_URL?>public/vatra-bunicii/blockquote.png" style="float: left;" width="5%" height="auto">
			Echipa,<br />
			<strong><?=$owner->company;?></strong><br /><br />
			<span>Acesta este linkul dvs. pentru schimbare parola: <a href="<?=SITE_URL;?>contul_meu/schimba_parola/<?=$data["tokenpassword"]?>">Link schimbare parola</a></span>
		</blockquote>	

		<div class="clearfix"></div>
	</div>
</div>