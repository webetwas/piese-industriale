<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-sm-4">
				<h2><?=(isset($bb_titlu) && !is_null($bb_titlu) ? $bb_titlu : "")?></h2>
				<ol class="breadcrumb">
				<?php
				if(isset($breadcrumb) && !is_null($breadcrumb)) {
					foreach($breadcrumb as $keybb => $bb) {
						if($keybb == 0) {
							echo '<li><a href="' .base_url().$bb["url"]. '">' .$bb["text"]. '</a></li>';
							continue;
						}
						echo '<li class="active"><strong>' .$bb["text"]. '</strong></li>';
					}
				}
				?>
				</ol>
		</div>
		<div class="col-sm-8">
				<div class="title-action">
					<?php if(isset($bb_button) && !is_null($bb_button)) echo '<a href="' .base_url().$bb_button["linkhref"]. '" class="btn ' .(isset($bb_button) && !is_null($bb_button) && isset($bb_button["class"]) ? $bb_button["class"] : "btn-success"). '">' .$bb_button["text"]. '</a>'; ?>
					<?php if(isset($bb_buttondel) && !is_null($bb_buttondel)) echo '<a href="' .base_url().$bb_buttondel["linkhref"]. '" class="btn ' .(isset($bb_buttondel) && !is_null($bb_buttondel) && isset($bb_buttondel["class"]) ? $bb_buttondel["class"] : "btn-danger"). ' ahrefaskconfirm">' .$bb_buttondel["text"]. '</a>'; ?>
				</div>
		</div>
</div>