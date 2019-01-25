<!--  Forms Validations Plugin -->
<script src="<?=base_url()?>public/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript">
// $().ready(function(){
	// $("#fspin").hide();
// });
function cpass(id) {
	var htmlnp = '<div class="row"><div class="col-md-6">\
                    <div class="form-group">\
                        <label class="control-label">Parola noua<star>*</star></label>\
                        <input type="password" class="form-control" placeholder="Parola noua" name="<?=$form->item->prefix;?>cpassnp_a" required="true" value="" id="idcpassnp">\
                    </div>\
                </div>\
                <div class="col-md-6">\
                    <div class="form-group">\
                        <label class="control-label">Confirma parola<star>*</star></label>\
                        <input type="password" class="form-control" placeholder="Confirma parola" name="<?=$form->item->prefix;?>cpassnp_b" value="" required="true" equalTo="#idcpassnp">\
                    </div>\
                </div></div>';
	var url = "<?=base_url().$controller_ajax?>/cp/id/" +id;
	var op = $("input[name=<?=$form->item->prefix?>cpassop]").val();
	$.ajax({
		url: url,
		dataType: "JSON",
		data: { postdata : op },
		type: 'POST',
		beforeSend: function() {
			showloader();
		},
		success: function( data ) {
			if(data.status == 1) {
				$("#fiidcpass").empty();
				$("#fiidcpass").html(htmlnp);
				$("button#fbidcpass").text("Schimba parola");$("button#fbidcpass").removeAttr("onclick");$("button#fbidcpass").attr("type", "submit").removeClass("btn-info").addClass("btn-danger");
				$('#fidcpass').validate();
				hideloader();
			} else if(data.status == 0) {
				hideloader();
				// swal('Parola introdusa nu corespune');
				toastr.error('Parola introdusa nu corespunde!', 'Eroare');
				$("input[name=<?=$form->item->prefix;?>cpassop]").val("");
			}
		}
	});
}
</script>
