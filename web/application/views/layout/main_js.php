<script type="text/javascript">

$(document).ready(function() {
	$("span#close-cookies-popup").on('click', function() {
		  $.ajax({
			url: "<?=base_url()?>contact/close_cookies_popup",
			dataType: "JSON",
			type: 'GET',
			success: function( data ) {
			}
		  });
		  
		  $("#cookies-popup").remove();
	});
});
</script>