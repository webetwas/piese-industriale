<!-- Chosen -->
<script src="<?=base_url()?>public/assets/js/plugins/chosen/chosen.jquery.js"></script>

<script type="text/javascript">
$(document).ready(function() {

	<?php if(!is_null($atom)):?>
	$('.chosen-sl-links').chosen({width: "100%"});
	
	$('.chosen-sl-links').on('change', function(evt, params) {
		linkRequest(params);
	});
	<?php endif; ?>
});

<?php if(!is_null($atom)):?>
function linkRequest(params) {
  var url = "<?=base_url().AIRDROP_CONTROLLER;?>airdrop_request/id/" + "<?=$uri->id?>";
  $.ajax({
    url: url,
    dataType: "JSON",
    type: 'POST',
	data: { air_id: <?=$air->air_id?>, params: params },
    beforeSend: function() {
			showloader();
    },
    success: function( data ) {
      if(data.status == 1) {
		hideloader();
      } else if(data.status == 0) {
        // do something
      }
    }
  });
}
<?php endif; ?>
</script>