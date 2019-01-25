<!-- Chosen -->
<script src="<?=base_url()?>public/assets/js/plugins/chosen/chosen.jquery.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	console.log("documentrdy");
	
	$('.chosen-sl-links').chosen({width: "100%"});
  $('.chosen-sl-links').on('change', function(evt, params) {
    console.log(evt, params);

		// console.log("idcontent", idcontent_object);
		
		// console.log($(this).find('option:selected'));
		
		linkRequest(params);
  });	
});

function linkRequest(params) {
  var url = "<?=base_url().$controller_ajax;?>linkrequest/id/" + "<?=$uri->id?>";
  $.ajax({
    url: url,
    dataType: "JSON",
    type: 'POST',
		data: { params: params },
    beforeSend: function() {
			showloader();
    },
    success: function( data ) {
      if(data.status == 1) {
				// console.log(data);
				hideloader();
        // $(dimglogo).fadeOut(300, function() { $(this).empty() });
        // $(dimglogo).empty();
        // $(dimglogo).html(btnup).fadeIn(700);
				// upImagesStatus();
      } else if(data.status == 0) {
        //
      }
      // $.map(data, function(item) {
      //  // var = item.item;
      // })

    }
  });
}


</script>