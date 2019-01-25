<style>
	.cookie{
		position:fixed;
		bottom:0;
		background-color: rgba(0, 0, 0, 0.6);
		background: rgba(0, 0, 0, 0.6);
		color: rgba(0, 0, 0, 0.6);
		width:100%;
		text-align:center;
		padding:8px;
	}
</style>

<div class="cookie" style="" id="cookies-popup">

	<p style="color:#fff;"><?=($site_lang == "en" ? 'We use cookies to give you the best customer experience possible. If you continue to use our website, we will assume you are happy to receive cookies from us and our partners.' : 'Acest site foloseste cookies. Navigand in continuare, va exprimati acordul asupra folosirii cookie-urilor. ')?>
		<a class="p-d-btn" href="<?=base_url()?>p/politica-cookies"><?=($site_lang == "en" ? 'More info' : 'Afla mai multe')?></a>&nbsp;&nbsp;
		<span id="close-cookies-popup" style="font-weight:bold;cursor:pointer;font-size:15px;">X</span>
	</p>

</div>