<script type="text/javascript">
$(document).ready(function() {
	$('#captcha').realperson({length: 4});
	
	$('a.primary-img').each(function() {
		$(this).on('click', function() {
			let img = $(this).find('img');
			let imgsrc = img.attr('src').replace('/s/', '/l/');
			$("a#a-pd-mimg").attr('href', imgsrc);
			$("a#a-pd-mimg").find('img').attr('src', imgsrc);
		});
	});
	
});
$(document).ready(function() {
	$("a.fancybox").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'overlayShow'	:	false
	});

});

function rphash(value) 
{
    var hash = 5381;
    for (var i = 0; i < value.length; i++)
    {
      hash = ((hash << 5) + hash) + value.charCodeAt(i);
    }
    return hash;
}

$("#cerere-produs-form").submit(function (e) {
	e.preventDefault();
	
	var atom_id = $("#form-cerere-atom-id").val();
	var nume = $("#form-cerere-nume").val();
	var telefon = $("#form-cerere-telefon").val();
	var email = $("#form-cerere-email").val();
	var mesaj = $("#form-cerere-mesaj").val();

	var catpchaprgrm = rphash($("#captcha").val());
	var catpchaprgrmhash = $('#captcha').realperson('getHash');
	
	if ((catpchaprgrmhash !== catpchaprgrm) || (email.length < 1 || telefon.length < 1 || nume.length < 1 || mesaj.length < 1)) {
	  $("#form-cerere-error").show();
	  return false;
	}
	
	$("#captchaHash").val($('#captcha').realperson('getHash'))
	e.currentTarget.submit();
}); 
</script>