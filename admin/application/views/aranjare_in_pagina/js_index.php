<!-- Treeview -->
<script src="<?=base_url()?>public/assets/scripts/jquerytreeview/jquery.treeview.js"></script>
<!-- Nestable -->
<script src="<?=base_url();?>public/assets/scripts/nestable/jquery.nestable.min.js" type="text/javascript"></script>

<script type="text/javascript">

	
$(document).ready(function(){
	$("#browser").treeview();
	$("#browser .folder").each(function() {
    $(this).mouseenter(function() {
      $(this).css("background-color", "white");
      $(this).find("span.sh").first().addClass("sp").removeClass("sh");
    });
    $(this).mouseleave(function() {
      $(this).css("background-color", "transparent");
      $(this).find("span.sp").addClass("sh");
    });
  });
	
	// strs_a
	<?php if(!is_null($links)): ?>
		<?php foreach($links as $link): ?>
				$("#<?=$link->id_link?>").nestable({
					maxDepth: 1,
					group: <?=$link->id_link?>,
					callback: function(l,e) {

						ajaxelementmoved($("#<?=$link->id_link?>").nestable("serialize"), <?=$link->id_link?>);
					}
				});
				
				// strs_b
				<?php if(!is_null($link->strs_b)): ?>
					<?php foreach($link->strs_b as $linkb): ?>
						$("#<?=$linkb->id_link?>").nestable({
							maxDepth: 1,
							group: <?=$linkb->id_link?>,
							callback: function(l,e){
								
								ajaxelementmoved($("#<?=$linkb->id_link?>").nestable("serialize"), <?=$linkb->id_link?>);
							}
						});
						
						// strs_c
						<?php if(!is_null($linkb->strs_c)): ?>
							<?php foreach($linkb->strs_c as $linkc): ?>
								$("#<?=$linkc->id_link?>").nestable({
									maxDepth: 1,
									group: <?=$linkc->id_link?>,
									callback: function(l,e){
										
										ajaxelementmoved($("#<?=$linkc->id_link?>").nestable("serialize"), <?=$linkc->id_link?>);
									}
								});							
							<?php endforeach; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>
});


function ajaxelementmoved(serialize, id_link) {
	// return;
	// console.log(serialize);
  var url = "<?=base_url().$controller_ajax?>/ajxmoveelement/id_link/" +id_link;
  $.ajax({
    url: url,
    dataType: "JSON",
    data: { serialize:serialize },
    type: 'POST',
    beforeSend: function() {
			showloader();
    },
    success: function( data ) {
      if(data.status == 1) {
        hideloader();
      } else if(data.status == 0) {
        //
      }
    }
  });
}
</script>