<script type="text/javascript">
function upfile(id = null) {
  var inputfile = ("input[name=inpfile]");
  if($(inputfile).val() == "") {
    alert("Selecteaza un fisier");
    return false;
  }
  var fmuf = new FormData($("#fmodalupfile")[0]);
  fmuf.append("tf", "img");

  var url = "<?=base_url().$controller_ajax;?>/i/id/" +id;
  var dimglogo = "#dimglogo";
  $.ajax({
    url: url,
    dataType: "JSON",
    data: fmuf,
    mimeTypes: "multipart/form-data",
    cache: false,
    contentType: false,
    processData: false,
    type: 'POST',
    beforeSend: function() {
			$('#inpfileModal').modal('hide');
			showloader();
    },
    success: function( data ) {
      if(data.status == 1) {
				console.log(data);
        $(dimglogo).empty();
				hideloader();
				var html = '\
          <img src="<?=$img_path;?>' +data.image_logo+ '" class="img-responsive"/>\
          <div class="thumbfooter">\
            <a href="javascript:void(0);" onClick="ajxdellogo(<?=$application->owner->id;?>)"><code-remove>Schimba logo</code-remove></a>\
          </div>\
				';
				$(dimglogo).append(html).hide().fadeIn(700);
				$(inputfile).val("");
      } else if(data.status == 0) {
        //
      }
      // $.map(data, function(item) {
      //  // var = item.item;
      // })

    }
  });
}

function ajxdellogo(id = null) {
  var url = "<?=base_url().$controller_ajax;?>/d/id/" +id;
  var dimglogo = "#dimglogo";
  var btnup = '<button type="button" class="btn btn-success btn-fill" data-toggle="modal" data-target="#inpfileModal">Incarca imagine</button>';
  $.ajax({
    url: url,
    dataType: "JSON",
    type: 'GET',
    beforeSend: function() {
			showloader();
    },
    success: function( data ) {
      if(data.status == 1) {
				console.log(data);
				hideloader();
        // $(dimglogo).fadeOut(300, function() { $(this).empty() });
        $(dimglogo).empty();
        $(dimglogo).html(btnup).fadeIn(700);
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
