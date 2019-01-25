<?php
// var_dump($p_acasa);die();
// var_dump($texte_diverse_prima_pagina);
?>
<style>
.row {margin:0;}
</style>
<?php if(!empty($p_acasa->p->content_ro)): ?>
	<div class="row">
        <h3 class="productblock-title"><?=(!is_null($p_acasa->p->title_content_ro) ? '<h2>' .$p_acasa->p->title_content_ro. '</h2>': "")?></h3>
        <h4 class="title-subline"><?=(!is_null($p_acasa->p->content_ro) ? '<p>' .$p_acasa->p->content_ro. '</p>' : "")?></h4>
	</div>
<?php endif; ?>