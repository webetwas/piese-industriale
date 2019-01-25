<script type="text/javascript">
<?php if($session["status"] == "pozitive") $toastr = "toastr.success";?>
<?php if($session["status"] == "negative") $toastr = "toastr.error";?>

$(document).ready(function() {
		setTimeout(function() {
				toastr.options = {
						closeButton: true,
						progressBar: true,
						showMethod: 'slideDown',
						timeOut: 4000,
						positionClass : "toast-top-left",
				};
				<?=$toastr;?>('<?=$session["ref"]?>', '<?=$session["text"]?>');
		}, 300);
		
});
</script>