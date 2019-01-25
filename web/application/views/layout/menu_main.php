<?php
// var_dump($menus);die();
// var_dump($categories);die();
?>


<!--Main Menu Area Start-->
<div class="mainmenu-area">
    <div class="container">
        <div class="row">
            <div class="<?=$menu_class?>">
                <div class="menu-area">
                    <div class="mainmenu">
                        <nav>
                            <ul id="nav">
								<?php if(!is_null($menus)): $wasopen = false; ?>
									<?php foreach($menus as $keymenu => $menu): $opened = false;?>
										<?php
											if($menu->fullpath == "/" || $menu->fullpath == "acasa" || $menu->fullpath == "homepage" || $menu->fullpath == "index" || $menu->fullpath == "index.php") $menu->fullpath = "";
										?>
										<?php if($menu->atom_isactive): ?>
											<?php
												if($wasopen && (bool)$menu->parent_fake)
												{
													echo '</ul></li>';
													$wasopen = false;
												}
												
												if($menu != end($menus) && !(bool)$menus[$keymenu+1]->parent_fake && !$wasopen)
												{
													echo '<li><a href="javascript:void(0);">' . $menu->{'atom_name' . '_' . $site_lang} . '</a>';
													echo '<ul class="sub-menu">';
													$wasopen = true;
												} else {
													echo '<li><a href="' .base_url().$menu->fullpath. '">' . $menu->{'atom_name' . '_' . $site_lang} . '</a></li>';
												}
												

											?>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- mobile-menu-area start -->
    <div class="mobile-menu-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="mobile-menu">
                        <nav id="dropdown">
                            <ul>
								<li>
									<a href="javascript:void(0);">
										<?=($site_lang == "en" ? 'Limba : English' : ' Language : Romana')?>
									</a>
									<ul>
										<li><a href="<?=base_url()?>pagini/site_lang/<?=($site_lang == "ro" ? 'en' : 'ro')?>"><?=($site_lang == "ro" ? 'English' : 'Romana')?></a></li>
									</ul>
								</li>
								<?php if(!is_null($menus)): $wasopen = false; ?>
									<?php foreach($menus as $keymenu => $menu): $opened = false;?>
										<?php
											if($menu->fullpath == "/" || $menu->fullpath == "acasa" || $menu->fullpath == "homepage" || $menu->fullpath == "index" || $menu->fullpath == "index.php") $menu->fullpath = "";
										?>
										<?php if($menu->atom_isactive): ?>
											<?php
												if($wasopen && (bool)$menu->parent_fake)
												{
													echo '</ul></li>';
													$wasopen = false;
												}
												
												if($menu != end($menus) && !(bool)$menus[$keymenu+1]->parent_fake && !$wasopen)
												{
													echo '<li><a href="javascript:void(0);">' . $menu->{'atom_name' . '_' . $site_lang} . '</a>';
													echo '<ul>';
													$wasopen = true;
												} else {
													echo '<li><a href="' .base_url().$menu->fullpath. '">' . $menu->{'atom_name' . '_' . $site_lang} . '</a></li>';
												}
												

											?>
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
                            </ul>
                        </nav>
                    </div>					
                </div>
            </div>
        </div>
    </div>
    <!-- mobile-menu-area end -->
</div>
<!--End of Main Menu Area-->