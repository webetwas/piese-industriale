<?php
// var_dump($menus);die();
?>
<!--Header--> 
<div class="header-container">
  <header class="header fixed clearfix transparent-header-on">
    <div class="container">
      <div class="logo" data-sticky-logo="<?=base_url();?>public/upload/img/misc/<?=$owner->image_logo;?>" data-normal-logo="<?=base_url();?>public/assets/img/logo-white.png">
        <a href="<?=SITE_URL?>">
          <img alt="piese industriale" src="<?=base_url();?>public/upload/img/misc/<?=$owner->image_logo;?>" data-logo-height="35">
        </a>
      </div>

      <div class="navbar-collapse nav-main-collapse collapse">
        <nav class="nav-main mega-menu one-page-menu">
          <ul class="nav nav-pills nav-main" id="mainMenu">
						<?php if(!is_null($menus)): ?>
						<?php foreach($menus as $keymenu => $menu): ?>
							<?php
								if($menu->fullpath == "/" || $menu->fullpath == "acasa" || $menu->fullpath == "homepage" || $menu->fullpath == "index" || $menu->fullpath == "index.php") $menu->fullpath = "";
							?>
							
							<?php
								if($menu->item_parent_fake && isset($menus[$keymenu+1]) && $menus[$keymenu+1]->item_parent_fake || $menu == end($menus)) {
									
									$href = $home && !is_null($menu->i_idhtml) ? "#{$menu->i_idhtml}" : base_url().$menu->fullpath;
									echo '<li><a ' .($home && !is_null($menu->i_idhtml) ? 'data-hash' : ""). ' href="' .$href. '">' .(!is_null($menu->i_pictograma) ? $menu->i_pictograma : "") .$menu->item_name. '</a></li>';
								} else {
									
									echo '<li class="dropdown">';
										echo '<a class="dropdown-toggle" href="javascript:void(0)">' .(!is_null($menu->i_pictograma) ? $menu->i_pictograma : "") .$menu->item_name. ' <i class="fa fa-caret-down"></i></a>';
										echo '<ul class="dropdown-menu">';
									foreach($menu->childrens as $child) {
										echo '<li><a href="' .base_url().$child->fullpath. '">' .$child->item_name. (!is_null($child->i_badge) ? ' ' .$child->i_badge : ""). '</a></li>';
									}
										echo '</ul>';
									echo '</li>';
								}
							?>
							
						<?php endforeach; ?>
						<?php endif; ?>
          </ul>
        </nav>
      </div>
      <button class="btn btn-responsive-nav btn-inverse" data-toggle="collapse" data-target=".nav-main-collapse">
        <i class="fa fa-bars"></i>
      </button>
    </div>
  </header>
</div>
<!--End Header-->