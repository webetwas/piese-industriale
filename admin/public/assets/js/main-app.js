$(document).ready(function() {
	$('.ahrefaskconfirm').click(function(e){
		if(confirm('Esti sigur ca vrei sa stergi acest item?')){
				// The user pressed OK
				// Do nothing, the link will continue to be opened normally
		} else {
				// The user pressed Cancel, so prevent the link from opening
				e.preventDefault();
		}
	});
});

// notif("success", "asd", "afd");
function notif(type, ref, mess) {
	setTimeout(function() {
			toastr.options = {
					closeButton: true,
					progressBar: true,
					showMethod: 'slideDown',
					timeOut: 4000,
					positionClass : "toast-top-left",
			};
			if(type == "success")
				toastr.success(ref, mess);
			else toastr.error(ref, mess);
	}, 300);
};

function showloader() { $(".cssload-container").show(); }
function hideloader() { $(".cssload-container").hide(); }
$(".swloader").click(function(){ showloader(); });
$(document).ready(function() { hideloader(); });
