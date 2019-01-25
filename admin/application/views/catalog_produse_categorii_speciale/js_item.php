<script src="<?=SITE_URL;?>public/scripts/summernote/summernote.min.js" type="text/javascript"></script>
<!-- Chosen -->
<script src="<?=base_url()?>public/assets/js/plugins/chosen/chosen.jquery.js"></script>
<!--Nestable js -->
<script src="<?=base_url()?>public/assets/vendors/nestable2/jquery.nestable.js"></script>
<!--Jquery ui -->
<script src="<?=base_url()?>public/assets/scripts/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript">
<?php if(!is_null($item)):?>
$(document).ready(function() {

    $( "#sortable" ).sortable({
		update: function( event, ui ) {
			let serialize = $(this).sortable('toArray');
			
			order_product_images(serialize);
			// console.log(serialize);
		}
	});
    $( "#sortable" ).disableSelection();

	
	$('.chosen-sl-links').chosen({width: "100%"});
	  $('.chosen-sl-links').on('change', function(evt, params) {
		// console.log(evt, params);

			// console.log("idcontent", idcontent_object);
			
			// console.log($(this).find('option:selected'));
			
			linkRequest(params);
	  });
	  
	$('.chosen-opt-material-culoare').chosen({width: "100%"});	  
	$('.chosen-opt-material-culoare-bluza').chosen({width: "100%"});
	$('.chosen-opt-garnitura-culoare').chosen({width: "100%"});	
	$('.chosen-opt-marime').chosen({width: "100%"});	  	  
	$('.chosen-opt-produs').chosen({width: "100%"});	  	  
  
	$(".product_states").change(function() {
		
		var product_state = $(this).attr('id');
		console.log(product_state);
		
		console.log($(this).val());
	  // var thisid = $(this).attr('id');
	  
	  ajxtoggle(product_state);
		// console.log("thisid", thisid);
	}); 


	$('#ncontentro').summernote({
		toolbar: [
			['style', ['style']],
			['fontsize', ['fontsize']],
			['font', ['bold', 'italic', 'underline', 'clear']],
			['fontname', ['fontname']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['insert', ['picture', 'hr']],
			['table', ['table']]
		],
		height: 300,                 // set editor height
		minHeight: null,             // set minimum height of editor
		maxHeight: null,             // set maximum height of editor
	});

});

function order_product_images(serialize)
{
  var url = "<?=base_url() . AIRDROP_CONTROLLER;?>order_product_images";
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

function ajxtoggle(product_state) {
  var url = "<?=base_url().$controller_ajax;?>toggle_product_state/id/<?=$uri->id?>/product_state/" + product_state;

  $.ajax({
    url: url,
    dataType: "JSON",
    type: 'GET',
    beforeSend: function() {
     $(".cssload-container").show();
    },
    success: function( data ) {
      if(data.status == 1) {
				notif("success", "Catalog produse", "Produsul a fost actualizat..");
				
        $(".cssload-container").hide();
      } else if(data.status == 0) {
        //
      }
      // $.map(data, function(item) {
      //  // var = item.item;
      // })

    }
  });
}


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



function ajxdelimg(id) {
	ref = "poza";
  var url = "<?=base_url().$controller_ajax;?>d/id/" +"<?=$uri->id?>";
  $.ajax({
    url: url,
    dataType: "JSON",
    data: { fileid:id, fileref:ref },
    type: 'POST',
    beforeSend: function() {
			showloader();
    },
    success: function( data ) {
      if(data.status == 1) {
        hideloader();
        // removediv("p_img" +ref+ " #img" +ref+ "-" +id, ref);
        $("li#" + id).fadeOut(300, function() { $(this).remove() });
        // $(divimgs+id).fadeOut(300, function() { $(this).remove() });
				// upImagesStatus();

      } else if(data.status == 0) {
        //
      }
    }
  });
}

function removediv(id, ref) {
  $("#" +id).fadeOut(300, function() { $(this).remove() });

  // only for banners(the upload button will hide)
  if (ref.indexOf("banner") !=-1) {
    console.log("button#" +ref+ "btnup");
    $("button#" +ref+ "btnup").attr("style", "visibility:visible");
  }
}

function upFileSuccess(id, img) {
  var div = "sortable";
  var imgpath = "<?=$imgpathitem;?>";

	
  var html = '\
	<li class="ui-state-default" id="' +id+ '">\
	<div class="img-thumbnail" style="padding:2px;">\
		<img class="img-responsive" src="' +imgpath+img+ '">\
		<div class="thumbfooter">\
			<a href="javascript:void(0)" onClick="return ajxdelimg(' +id+ ');return false"><code-remove>Elimina</code-remove></a>\
		</div>\
	</div>\
	</li>\
  ';
  $("#" +div).append(html).hide().fadeIn(700);

  // only for banners(the upload button will hide)
  hideloader();
}
<?php endif; ?>
</script>