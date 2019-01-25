<script type="text/javascript">
<?php if(!is_null($item)):?>
function ajxdelimg(id, ref) {
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
        removediv("p_img" +ref+ " #img" +ref+ "-" +id, ref);
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
  var div = "p_imgpoza";
  var imgpath = "<?=$imgpathitem;?>";
  var fileref = 'poza';

	
  var html =
  '<div id="img' +fileref+ "-" +id+ '" class="col-lg-2 col-md-4 col-xs-6 col-xs-12 thumb-nomg">\
    <div class="img-thumbnail" style="padding:2px;">\
      <img class="img-responsive" src="' +imgpath+img+ '">\
      <div class="thumbfooter">\
        <a href="javascript:void(0)" onClick="return ajxdelimg(' +id+ ', \'' +fileref+ '\');return false"><code-remove>Elimina</code-remove></a>\
      </div>\
    </div>\
  </div>';
  $("#" +div).append(html).hide().fadeIn(700);

  // only for banners(the upload button will hide)
  hideloader();
}
<?php endif; ?>
</script>

<!--Jquery ui -->
<script src="<?=base_url()?>public/assets/scripts/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url()?>public/assets/vendors/croppiejs/croppie.min.js"></script>

<script type="text/javascript">
$(document).ready(function()
{
	window.APPLICATION = window.APPLICATION ? window.APPLICATION : {};
	(
		function(o)
		{
			var obj = {};

			obj.dialog = {
				add_image : window.document.getElementById('images-add-new'),
				
				y : window.document.getElementById('dialog-images'),
				
				imager : {
					
					data : <?=(!is_null($imager) ? 'JSON.parse(\'' .json_encode($imager). '\')' : null)?>,
					
					upload_image : window.document.getElementById('imager-upload-image'),
					remove_optimal_sizes : window.document.getElementById('imager-removeoptimalsizes'),
					apply_optimal_sizes : window.document.getElementById('imager-applyoptimalsizes'),
					
					imager_wrap : window.document.getElementById('imager-upload-wrap'),
					
					imager_message : window.document.getElementById('imager-upload-message'),
					imager_croppie : window.document.getElementById('imager-croppie'),
					
					croppie : null,
					file_ext : null,
					
					form : window.document.getElementById('imager-form'),
				}
			}
			
			obj.dialog.imager.initCroppie = function(resizeable = false, enforceboundary = false, h = null, w = null) {
				let height = h !== null ? h : this.data[0].height;
				let width = w !== null ? w : this.data[0].width;
				
				let b_height = parseInt(height) +50;
				let b_width = parseInt(width) +50;
				
				this.croppie = new Croppie(this.imager_croppie, {
					viewport : { height : parseInt(height), width : parseInt(width) },
					boundary : { height : b_height, width : b_width },
					enableExif: true,
					enableResize : resizeable,
					enforceBoundary : enforceboundary
				});
				
				// console.log(this.croppie);
			};
			
			obj.dialog.imager.toggleOptimalSizes = function(trigger) {
				let data_url = this.croppie.data.url;
				let original_image_height = this.croppie._originalImageHeight;
				let original_image_width = this.croppie._originalImageWidth;				
				
				this.croppie.destroy();
				switch(trigger)
				{
					case 'remove':
						$(this.remove_optimal_sizes).css('display', 'none');
						$(this.apply_optimal_sizes).css('display', 'block');
						
						let height = null;
						let width = null;
						if(this.data[0].height > original_image_height || this.data[0].width > original_image_width)
						{
							height = original_image_height;
							width = original_image_width;
						}
						this.initCroppie(true, true, height, width);
						break;
						
					case 'apply':
						$(this.apply_optimal_sizes).css('display', 'none');
						$(this.remove_optimal_sizes).css('display', 'block');
						
						this.initCroppie();
						break;
				}
				this.croppie.bind({ url : data_url });
			}

			
			function readFile(input) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();
					
					reader.onload = function (e) {
						get_file_type = input.files[0].type.match(/image\/=?(png|jpeg)/);
						if(get_file_type === null)
						{
							alert('Fisierul nu este valid. Foloseste fisiere de tip JPG/PNG..');
							return false;
						} else {
							obj.dialog.imager.file_ext = get_file_type[1];
						}
						
						obj.dialog.imager.croppie.bind({ url : e.target.result })
						.then(function() {
							$(obj.dialog.imager.imager_wrap).css('display', 'block');
							$(obj.dialog.imager.imager_message).css('display', 'none');
							
							$(obj.dialog.imager.remove_optimal_sizes).css('display', 'block');
							$(obj.dialog.imager.apply_optimal_sizes).css('display', 'none');
							
							obj.dialog.imager.croppie.bind();
							
							// console.log('bounded..');
						});
						
					}
					
					reader.readAsDataURL(input.files[0]);
				}
				else {
					alert("Sorry - you're browser doesn't support the FileReader API");
				}
			}
			
			/*
			events binding
			*/
			$(obj.dialog.add_image).on('click', function() {
				$(obj.dialog.y).dialog('open');
				this.initCroppie();
			}.bind(obj.dialog.imager));//uploadimage
			
			$(obj.dialog.imager.upload_image).on('change', function () {
				readFile(this);
			});//readfile

			$(obj.dialog.imager.remove_optimal_sizes).on('click', function() {
				obj.dialog.imager.toggleOptimalSizes('remove');

			});//removeoptimalsizes
			
			$(obj.dialog.imager.apply_optimal_sizes).on('click', function() {
				obj.dialog.imager.toggleOptimalSizes('apply');

			});//applyoptimalsizes
			
			/*
			self-invoked
			*/

			/*
			prerequisites
			*/
			$(obj.dialog.y).dialog({
				autoOpen: false,
				// height: 500,
				// width: 600,
				height: $( window ).height() -10,
				width: $( window ).width() -10,
				modal: true,
				resizeable: false,
				buttons: {
					"Gata.. salveaza imaginea!" : function() {
						
						let postdata = new FormData();
						postdata.append('air_id', 3);
						postdata.append('imager', JSON.stringify(obj.dialog.imager.data));
						// result({ type, size, format, quality, circle }) Promise
						// obj.dialog.imager.croppie.result({ type : 'blob', format : obj.dialog.imager.file_ext }).then(function(result) {
						obj.dialog.imager.croppie.result('blob').then(function(result) {
							
							if(result === null)
							{
								alert('Nu ai procesat nicio imagine..');
								return false;
							}
							
							postdata.append('data', result);
							
							$.ajax({
								// context : this.context,
								url: '<?=base_url()?>imager/ajax_upcreateimages/<?=$item->node_id?>',
								data: postdata,
								dataType: "JSON",
								type: 'POST',
								cache: false,
								processData: false,
								contentType: false,
								mimeTypes: "multipart/form-data",
								beforeSend: function() {
									// showloader();
								},
								error: function () {
									// location.reload();
								},
								complete: function() {
									// if(dom.loader)
									// {
										// hideloader();=]
										// dom.loader = false;
									// }
								},
								success: function(response) {
									if(response.status)
									{
										// do something
										$(obj.dialog.y).dialog('close');
										upFileSuccess(response.id, response.img);
										// hideloader();
									}
								}
							});
						});
					},
					Cancel: function() {
						$(this).dialog("close");
					}
				},
				close: function() {
					// do something
					obj.dialog.imager.croppie.destroy();
					
					$(obj.dialog.imager.imager_wrap).css('display', 'none');
					$(obj.dialog.imager.imager_message).css('display', 'block');
					
					$(obj.dialog.imager.remove_optimal_sizes).css('display', 'none');
					$(obj.dialog.imager.apply_optimal_sizes).css('display', 'none');
				}
			});
		}
	)
	(window.APPLICATION);
}, false);
</script>