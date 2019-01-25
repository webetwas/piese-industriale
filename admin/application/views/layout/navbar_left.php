<?php
// var_dump($application->owner);die();
// var_dump($listpages);die();
?>

<?php
$ctrl = "admin";
$ctrl2 = false;

// var_dump($this->uri);
// var_dump($this->uri->segment());
if(!empty($this->uri->segment(1, 0))) $ctrl = $this->uri->segment(1, 0);
if(!empty($this->uri->segment(2, 0))) $ctrl2 = $this->uri->segment(2, 0);
?>

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                      <span style="color:white;font-size:20px;">
                        <img alt="image" class="img-circle" style="border-radius:0;" src="<?=(isset($application->owner->image_logo) && !is_null($application->owner->image_logo) ? SITE_URL.PATH_IMG_MISC. '/' .$application->owner->image_logo : 'public/assets/img/logo/default-logo.png');?>" />
                      </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
													<span class="text-muted text-xs block"><?=($application->user->privilege ? "SUPERADMIN" : $application->user->user_name)?> <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a href="<?=base_url();?>platforma/setari/companie/item/u/id/<?=$application->owner->id;?>">Contul meu</a></li>
                            <li class="divider"></li>
                            <li><a class="swloader" href="<?=base_url();?>platforma/setari/utilizator/item/u/id/<?=$application->user->id;?>"><?=$application->user->user_name;?></a></li>
                            <li><a href="<?=base_url();?>login/getout">Iesi din cont</a></li>
                        </ul>
                    </div>
                    <div class="logo-element">
                      WEW
                    </div>
                </li>
                <li <?=($ctrl == "admin" || $ctrl == "platforma" ? 'class="active"' : "");?>>
                   <a href="<?=base_url()?>"><i class="fa fa-home" style="color:#fff;"></i> <span class="nav-label">Administrare</span></a>
                </li>
				
                <li <?=($ctrl == "catalog_produse" || strstr($this->uri->uri_string, 'air_id/4') ? 'class="active"' : "");?>>
                   <a href="javascript:void(0);"><i class="fa fa-tags" style="color:#22A7F0;font-size:18px;"></i> <span class="nav-label">Catalog Produse</span></a>
					<ul class="nav nav-second-level collapse">
						<li><a class="swloader" href="<?=base_url()?>catalog_produse"><i class="fa fa-angle-double-right" style="color:#22A7F0;"></i> Catalog</a></li>
						<li><a class="swloader" href="<?=base_url()?>catalog_produse/categorii_speciale"><i class="fa fa-angle-double-right" style="color:#22A7F0;"></i> Categorii speciale</a></li>
					</ul>                
				
				</li>
				
                <li <?=($ctrl == "cereri_produse" ? 'class="active"' : "");?>>
                   <a href="<?=base_url()?>cereri_produse"><span class="nav-label">Cereri produse</span> <?=($cereri_produse > 0 ? '&nbsp;&nbsp;<span class="badge">' .$cereri_produse. '</span>' : '')?></a>
                </li>
				
                <li <?=($ctrl == "pagini" ? 'class="active"' : "");?>>
				<a href="#"><i class="fa fa-files-o" style="color:#fff;"></i> <span class="nav-label">Pagini site</span><span class="fa arrow"></span></a>
				<ul class="nav nav-second-level collapse">
					<li><a class="swloader" href="<?=base_url()?>pagini/item/i"><i class="fa fa-plus-circle" style="color:#fff;"></i> Creaza pagina</a></li>
					<?php
						if(!$listpages)
							echo '<li><a href="javascript:void(0);">Nu exista pagini</a></li>';
						else {
							foreach($listpages as $lp) {
								if($lp->is_page)
								echo '<li><a class="swloader" href="' .base_url(). 'pagini/item/u/id/' .$lp->id. "/" .$lp->id_page. '">' .$lp->title. '</a></li>';
							}
						}
					?>
				</ul>
                </li>
				
                <li <?=($ctrl == "programul_nostru" ? 'class="active"' : "");?>>
                   <a href="<?=base_url()?>programul_nostru/item/u/id/1"><i class="fa fa-calendar" style="color:#fff;"></i> <span class="nav-label">Programul nostru</span></a>
                </li>
                <li <?=($ctrl == "texte_diverse" ? 'class="active"' : "");?>>
                   <a href="<?=base_url()?>texte_diverse"><i class="fa fa-paragraph" style="color:#fff;"></i> <span class="nav-label">Texte diverse</span></a>
                </li>
                <?php if($application->user->privilege): ?>
                <li <?=($ctrl == "meniuri" ? 'class="active"' : "");?>>
                   <a href="<?=base_url()?>meniuri"><i class="fa fa-list-ul" style="color:#fff;"></i> <span class="nav-label">Meniuri</span></a>
                </li>
				<?php endif; ?>
                <li <?=($ctrl == "echipa" ? 'class="active"' : "");?>>
                   <a href="<?=base_url()?>echipa"><i class="fa fa-handshake-o" style="color:#fff;"></i> <span class="nav-label">Echipa</span></a>
                </li>
				<!--
                <li <?=($ctrl == "branduri" ? 'class="active"' : "");?>>
                   <a href="<?=base_url()?>branduri"><i class="fa fa-suitcase" style="color:#fff;"></i> <span class="nav-label">Branduri</span></a>
                </li>
                <li <?=($ctrl == "newsletter" ? 'class="active"' : "");?>>
                   <a href="<?=base_url()?>newsletter"><i class="fa fa-envelope-open-o"></i> <span class="nav-label">Newsletter</span></a>
                </li>
				-->
				<!--
                <li <?=($ctrl == "aranjarea_elementelor_in_pagina" ? 'class="active special_link"' : 'class="special_link"');?>>
                   <a href="<?=base_url()?>aranjarea_elementelor_in_pagina"><i class="fa fa-heart-o"></i> <span class="nav-label">Aranjare elemente</span></a>
                </li>
				-->
            </ul>

        </div>
    </nav>