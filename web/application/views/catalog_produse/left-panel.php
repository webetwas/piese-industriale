<?php
// var_dump($products_opt_values);
// var_dump($products_opt_values);die();
// var_dump($products_opt_values->sizes);
?>

<?php
$categories_to_show = $categories_cp;
if(is_null($categories_to_show))
{
	$categories_to_show = $categories;
}
?>

<style>
.opt_m {
	cursor:pointer;
}
</style>
<div class="col-md-3">
<div class="blog-left-sidebar">
<?php if(!is_null($categories)): ?>
    
				<ul class="l-sidebar blog">
					<li><a href="javascript:void(0);" class="left-sidebar-title"><?=($site_lang == "en" ? 'Categories' : 'Categorii Produse')?> </a></li>
					<?php foreach($categories_to_show as $ctgmain) { ?>
						<li <?=(!empty($ctgmain["_nodes"]) ? 'class="activSub"' : '')?>>

							<?php if(!empty($ctgmain["_nodes"])) { ?>
							<a href="<?=base_url()?>catalog_produse/categorie/<?=$ctgmain["slug"]?>" class="show-submenu"><?=$ctgmain["denumire_" . $site_lang]?>
								<i class="fa fa-plus plus"></i>
								<i class="fa fa-minus minus"></i>							
							</a>					
								<ul class="left-sub-navbar submenu">
									<?php foreach($ctgmain["_nodes"] as $ctg_sub) { ?>
										<li>
											<a href="<?=base_url()?>catalog_produse/categorie/<?=$ctg_sub["slug"]?>"><?=$ctg_sub["denumire_" . $site_lang]?></a>
										</li>
									<?php } ?>
								</ul>
							<?php } else { ?>
							<a href="<?=base_url()?>catalog_produse/categorie/<?=$ctgmain["slug"]?>"><?=$ctgmain["denumire_" . $site_lang]?>
							</a>							
							<?php } ?>
						</li>
					<?php } ?>
					
				</ul>		
<?php endif; ?>
    </div>
</div>