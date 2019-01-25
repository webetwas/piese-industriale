<?php include("header.php");?>
<section>
	<h4>Buna ziua</h4>
	<hr />
	<div class="row ml-10">
		<span>V-ati inregistrat in site-ul <a href="http://<?=$owner->website;?>">&nbsp;<?=$owner->company;?></a>.</span>
		<br />
		<br />
		<span>
			Bine ai venit, <?=$utilizator->nume?>. Contul tau a fost creat.
		</span>
	</div>
</section>
<hr />
<?php include("nota_inregistrare.php");?>

<?php include("footer.php");?>