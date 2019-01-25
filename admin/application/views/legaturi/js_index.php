<!--Nestable js -->
<script src="<?=base_url()?>public/assets/vendors/nestable2/jquery.nestable.js"></script>
<script src="<?=base_url()?>public/assets/vendors/jquerytreeview/jquery.treeview.js"></script>

<script type="text/javascript">

$(document).ready(function(){
	
	$("#browser").treeview({
		animated: "fast",
		collapsed: true,
		// collapsed: false,
		unique: true,
		// toggle: function() {
			// window.console && console.log("%o was toggled", this);
		// }
	});
	
	// $("#browser li.clsnd").each(function() {
	$("#browser span.lispmn").each(function() {
    $(this).mouseover(function() {
      // $(this).css("background-color", "white");
      $(this).find("span.sp").attr("style", "visibility:visibile;");
    });
    $(this).mouseleave(function() {
      // $(this).css("background-color", "transparent");
      $(this).find("span.sp").attr("style", "visibility:hidden;");
    });
  });	
	

	$('.atdel').click(function(e){
		
		if(confirm('Esti sigur ca vrei sa stergi?')){
				// The user pressed OK
				// Do nothing, the link will continue to be opened normally
		} else {
				// The user pressed Cancel, so prevent the link from opening
				
				e.preventDefault();
				// e.stopImmediatePropagation();
		}
	});

	
	<?php
	if(!empty($nodes))
	{
		//first nodes
		$dd_id_fi = 0;
		$dd_id_prefix = 'nd';
		echo
		'
		// Nodes ' .$dd_id_fi. '
		$("#' . $dd_id_prefix . $dd_id_fi . '").nestable({
			// maxDepth: 1,
			rootClass: "dd' . $dd_id_fi . '",
			group: "#' .$dd_id_prefix . $dd_id_fi . '",
			callback: function(l,e) {
				// console.log($("#' . $dd_id_prefix . $dd_id_fi . '").nestable("serialize"));
				nodes_order_nodes($("#' . $dd_id_prefix . $dd_id_fi . '").nestable("serialize"));
			},
		});
		';
		
		function nodes_to_nestable($nodes, $dd_id, $dd_prefix)
		{
			foreach($nodes as $nodesjs)
			{
				if(!empty($nodesjs["_nodes"]) && $dd_id !== 0)
				{
					echo
					'
					// Nodes ' .$dd_id. '
					$("#' . $dd_prefix . $dd_id . '").nestable({
						// maxDepth: 1,
						rootClass: "dd' . $dd_id . '",
						group: "#' .$dd_prefix . $dd_id . '",
						callback: function(l,e) {
							// console.log($("#' . $dd_prefix . $dd_id . '").nestable("serialize"));
							nodes_order_nodes($("#' . $dd_prefix . $dd_id . '").nestable("serialize"));
						},
					});
					';
				}
				nodes_to_nestable($nodesjs["_nodes"], $nodesjs["node_id"], 'nd');
				if(!empty($nodesjs['_airdrop']))
				{
					$create_id = $nodesjs["node_id"] . join(array_keys($nodesjs["_airs"]));
					airdrop_to_nestable($create_id, 'ad');
				}
			}
		}
		nodes_to_nestable($nodes, 0, 'nd');
	}
	function airdrop_to_nestable($dd_id, $dd_prefix)
	{
		echo
		'
		// Airdrop ' .$dd_id. '
		$("#' . $dd_prefix . $dd_id . '").nestable({
			// maxDepth: 1,
			rootClass: "dd' . $dd_id . '",
			group: "#' .$dd_prefix . $dd_id . '",
			callback: function(l,e) {
				// console.log($("#' . $dd_prefix . $dd_id . '").nestable("serialize"));
				airdrop_order_airdrop($("#' . $dd_prefix . $dd_id . '").nestable("serialize"));
			},
		});
		';				
	}
	?>

});


function nodes_order_nodes(serialize)
{
  var url = "<?=base_url() . AIRDROP_CONTROLLER;?>nodes_order_nodes";
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
        hideloader();
		window.alert(data.error);
      }
    }
  });	
}

function airdrop_order_airdrop(serialize)
{
  var url = "<?=base_url() . AIRDROP_CONTROLLER;?>airdrop_order_airdrop";
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
        hideloader();
		window.alert(data.error);
      }
    }
  });	
}

</script>