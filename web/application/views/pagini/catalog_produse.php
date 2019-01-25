<?php
// var_dump($categories);
// var_dump($products);die();
// var_dump($filters);
?>

<div class="col-md-9 right-side-p">
	<?php
	if(is_null($categories_cp) && is_null($products))
	{
		if($site_lang == "en")
		{
			echo '<h4 style="margin:100px;">No results were found.<br />Go to <a href="' .base_url(). 'catalog_produse"> Our products</a></h4>';
		}
		else {
			echo '<h4 style="margin:100px;">Nu s-au gasit produse in urma cautarilor tale.<br />Mergi la <a href="' .base_url(). 'catalog_produse">Catalog produse</a></h4>';
		}
		
	}
	?>	
	<!-- Categories -->
    <div class="row">
		
		<?php if(!is_null($categories_cp)): ?>
		<?php $row_ctg = 0; foreach($categories_cp as $ctg): $row_ctg++;?>
		<?php
			if(strstr($ctg["images"], ','))
			{
				$ctgimages = explode(',', $ctg["images"]);
			}
			else
			{
				$ctgimages = array($ctg["images"]);
			}
		?>		
			<?php if($row_ctg == 1) echo '<div class="row"><div class="col-sm-12">'; ?>
			<div class="single-product-items">
				<div class="single-items">
					<a href="<?=base_url()?>catalog_produse/categorie/<?=$ctg["slug"]?>">
						<?php if(!is_null($ctg["images"])): ?>
						<img class="primary-img" src="<?=base_url()?>public/upload/img/nodes/m/<?=$ctgimages[0]?>" alt="piese industriale, industrial parts">
						<?=(!is_null($ctg["images"]) && is_array($ctgimages) && count($ctgimages) > 1 ? '<img class="secondary-img" src="' .base_url(). 'public/upload/img/nodes/m/' .$ctgimages[1]. '" alt="piese industriale, industrial parts">' : '')?>
						<?php else: ?>
						<img class="primary-img" src="<?=base_url()?>public/assets/img/product/blank_product.jpg" alt="piese industriale, industrial parts">
						<?php endif; ?>
					</a>
					<div class="p-bottom-cart">
						<a href="<?=base_url()?>catalog_produse/categorie/<?=$ctg["slug"]?>" class="hover-cart">Vezi <br /><span>Produse</span></a>
					</div>
				</div>
				<div class="product-info">
					<h4 style="font-size:16px;"><a href="<?=base_url()?>catalog_produse/categorie/<?=$ctg["slug"]?>"><?=$ctg["denumire_" . $site_lang]?></a></h4>
				</div>
			</div>
			<?php if($row_ctg == 4) { echo '</div></div>'; $row_ctg = 0; } ?>
		<?php endforeach; ?>
		<?php endif; ?>
		
		
  
    </div>
	<!-- Categories -->		
		
		<?php if(!is_null($products)): ?>
		
		
			<div class="row">
				<div class="shop-item-filter">
					<div class="filter-text">
						<p style="color:#597999;"><?=($site_lang == "en" ? 'Category products:' : 'Produse din categoria:')?> <?=($site_lang == "en" ? $node->denumire_en : $node->denumire_ro)?></p>
					</div>
					<div class="filter-by">
						<h4><?=($site_lang == "en" ? 'Sort' : 'Ordoneaza:')?></h4>
						<form action="#">
							<div class="select-filter-opt">
								<select id="select-filter-opt">
									<?php
										$filter_order_by = null;
										if(!is_null($filters->order_by))
										{
											$filter_order_by = str_replace('"', '', $filters->order_by);
										}
									?>
								  <option value="">- <?=($site_lang == "en" ? 'Filter' : 'Filtreaza:')?> -</option>
								  <option value="order_by_pret_asc" <?=(!is_null($filter_order_by) && $filter_order_by == "order_by_pret_asc" ? 'selected="selected"' : '')?>><?=($site_lang == "en" ? 'Ascendent price' : 'Pret crescator')?></option>
								  <option value="order_by_pret_desc" <?=(!is_null($filter_order_by) && $filter_order_by == "order_by_pret_desc" ? 'selected="selected"' : '')?>><?=($site_lang == "en" ? 'Descendent price' : 'Pret descrescator')?></option>
								</select> 
							</div>
						</form>								
					</div>
					<div class="filter-by">
						<h4><?=($site_lang == "en" ? 'Show:' : 'Arata:')?> </h4>
						<form action="#">
							<div class="select-filter">
								<select id="select-filter-pg">
								  <option value="8" <?=(!is_null($filters->perpage) && $filters->perpage == "8" ? 'selected="selected"' : '')?>><?=($site_lang == "en" ? '8 per page' : '8 pe pagina')?></option>
								  <option value="16" <?=(!is_null($filters->perpage) && $filters->perpage == "16" ? 'selected="selected"' : '')?>><?=($site_lang == "en" ? '16 per page' : '16 pe pagina')?></option>
								  <option value="32" <?=(!is_null($filters->perpage) && $filters->perpage == "32" ? 'selected="selected"' : '')?>><?=($site_lang == "en" ? '32 per page' : '32 pe pagina')?></option>
								</select> 
							</div>
						</form>							
					</div>
					<!-- <div class="shop-view">
					   <h4>View</h4>
						<a href="#" class="active"><i class="fa fa-th-large"></i></a>
						<a href="#" class=""><i class="fa fa-th-list"></i></a>
					</div> -->
				</div>
			</div>		
			
			<?php $rproduct = 0; ?>
			<?php foreach($products as $product): $rproduct++; ?>
			<?php
				if(strstr($product->images, ','))
				{
					$pimages = explode(',', $product->images);
				}
				else
				{
					$pimages = array($product->images);
				}
			?>
			<?php if($rproduct == 1) echo '<div class="row">'; ?>
			<div class="single-product-items">
				<div class="single-items">
					<a href="<?=base_url()?>catalog_produse/produs/<?=$product->slug?>">

						<?php if(!is_null($product->images)): ?>
						<img class="primary-img" src="<?=base_url()?>public/upload/img/catalog_produse/m/<?=$pimages[0]?>" alt="piese industriale, industrial parts">
						<?=(!is_null($product->images) && is_array($pimages) && count($pimages) > 1 ? '<img class="secondary-img" src="' .base_url(). 'public/upload/img/catalog_produse/m/' .$pimages[1]. '" alt="' . $product->{'atom_name_' . $site_lang} . '">' : '')?>
						<?php else: ?>
						<img class="primary-img" src="<?=base_url()?>public/assets/img/product/blank_product.jpg" alt="<?=$product->{'atom_name_' . $site_lang}?>">
						<?php endif; ?>
					</a>
					<div class="p-bottom-cart">
						<a href="<?=base_url()?>catalog_produse/produs/<?=$product->slug?>" class="hover-cart"><?=($site_lang == "en" ? 'View <span>Product</span>' : 'VEZI <span>PRODUS</span>')?></a>
					</div>
				</div>
				<div class="product-info">
					<h4><a href="<?=base_url()?>catalog_produse/produs/<?=$product->slug?>"><?=$product->{'atom_name_' . $site_lang}?></a>
					<br />
					<?php if($product->pret !== "0.00") : ?>
					<?=($product->pret_nou == '0.00' ? '<span>' .$product->pret. ' RON </span>' : '<span class="line">' .$product->pret. ' RON</span>')?>
					<?=($product->pret_nou != '0.00' ? '<span>' .$product->pret_nou. ' RON</span>' : '') ?>
					<?php endif; ?>
					</h4>
				</div>
			</div>
			<?php if($rproduct == 4) { echo '</div>';$rproduct = 0; } ?>
			<?php endforeach;?>
			
		<?php endif; ?>
		
	<?php if(!is_null($pagination)): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="pagination">
                <ul id="ulpagination">
					<?php echo $pagination; ?>
                </ul>
            </div>
        </div>
    </div>
	<?php endif; ?>
</div>