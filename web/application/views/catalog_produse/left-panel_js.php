<script type="text/javascript">

var filter = {
	page       : <?=(!is_null($filters->page) ? $filters->page : 'null')?>,
	perpage    : <?=(!is_null($filters->perpage) ? $filters->perpage : 'null')?>,
	order_by   : <?=(!is_null($filters->order_by) ? $filters->order_by : 'null')?>,
}

function move_to_by_filters(actual_filter)
{
	// mapping actual filter
	$.map(actual_filter, function(value, id) {
		filter[id] = value;
	});
	
	filter.page = 1;
	// mapping the filter
	let string = '<?=$uriseg?>?';
	$.map(filter, function(value, id) {
		
		if(value !== null)
		{
			string += '&' + id + '=' + value;
		}
	});
	
	string = string.replace('?&', '?');
	
	// show_loader();
	window.location.href = string.replace(/"/g, '');
}

$(document).ready(function() {
	
	// console.log(filter);
	$("#ulpagination li").on('click', function(){
		// show_loader();
	});
	
	$("#select-filter-opt").on('change', function() {
		let value = $(this).val();
		if(value == "")
		{
			move_to_by_filters( { order_by : null } );
		} else {
			move_to_by_filters( { order_by : value } );
		}
	});
	
	$("#select-filter-pg").on('change', function() {
		let value = $(this).val();

		move_to_by_filters( { perpage : value } );
	});
});
</script>