<?php
// ini_set('xdebug.var_display_max_depth', -1);
// ini_set('xdebug.var_display_max_children', -1);
// ini_set('xdebug.var_display_max_data', -1);
// var_dump($air);
// var_dump($nodes);
?>


<?php
/**
 * 
 * @param type $u
 * @param type $nodes
 * @param type $tree
 * @return string
 */
function nodes($u, $air, $nodes, $tree, $dd_id = null, $dd_prefix = null)
{
	if(!empty($nodes))
	{
		$t = '';
		$t .= '<div class="dd' .$dd_id. ' dd" id="' . $dd_prefix . $dd_id . '">';
		$t .= '<ol class="dd' .$dd_id. '-list dd-list">';

		foreach($nodes as $node)
		{
			$t .= '<li class="dd' .$dd_id. '-item dd-item dd3-item" data-id="' .$node["node_id"]. '">';
			
			//no dragable

			if(count($nodes) === 1)
			{
				$t .= '<div class="dd' .$dd_id. '-nodrag dd3-handle dd-handle"></div>';
			}
			else
			{
				$t .= '<div class="dd' .$dd_id. '-handle dd3-handle dd-handle"></div>';
			}

			$t .= '<div class="dd3-content" ' .(!(bool)$node["is_active"] ? 'style="border-right:3px solid red;border-radius:0;"' : ''). '>';
				$t .= '<span class="lispmn">';
				if(!is_null($node["img"]))
				{
					$t .= '<img src="' .SITE_URL. 'public/upload/img/nodes/s/' .$node["img"]. '" class="img-tree"/>&nbsp;&nbsp;';
				}
				else
				{
					$t .= '<img src="' .SITE_URL. 'public/assets/img/product/blank_product.jpg" class="img-tree"/>&nbsp;&nbsp;';
				}
					$t .= $node["denumire_ro"];

					$t .= ' <span class="sp" style="visibility:hidden;">';
					$t .= '<a href="' .$u. '/item/i/air_id/4/node_id/' .$node["node_id"]. '"> <strong>Adaug&abreve; produs</strong></a>';
					$t .= '<a href="' .base_url().'legaturi/item/i/air_id/4/parent_id/' .$node["node_id"]. '"><i class="fa fa-plus"></i> creeaz&abreve; categorie</a>';
					$t .= '<a href="' .base_url().'legaturi/item/u/air_id/4/id/' .$node["node_id"]. '"><i class="fa fa-pencil"></i> editeaz&abreve;</a>';
					$t .= '<a href="' .base_url().'legaturi/item/d/air_id/4/id/' .$node["node_id"]. '" class="atdel"><i class="fa fa-window-close" style="color:red;"></i> &scedil;terge</a>';
					$t .= '</span>';

				$t .= '</span>';
			$t .= '</div>';

			//nextnodes
			if(!empty($node["_nodes"]))
			{
				$t .= '<ul>';
				$t .= nodes($u, $air, $node["_nodes"], $tree, $node["node_id"], 'nd');
				$t .= '</ul>';//ul
			}
			if(!empty($node["_airdrop"]))
			{
				$create_id = $node["node_id"] . join(array_keys($node["_airs"]));
				$t .= '<ul>';
				$t .= airdrop($u, $air, $node["_airdrop"], $node["_airs"], $create_id, 'ad');
				$t .= '</ul>';//ul
			}
			$t .= '</li>';
		}

		$t .= '</ol>';
		$t .= '</div>';
	}
	return $t;
}

function airdrop($u, $air, $airdrops, $airs, $dd_id = null, $dd_prefix = null)
{
	if(!empty($airdrops))
	{
		$t = '';
		$t .= '<div class="dd' .$dd_id. ' dd" id="' . $dd_prefix . $dd_id . '">';
		$t .= '<ol class="dd' .$dd_id. '-list dd-list">';

		foreach($airdrops as $airdrop)
		{
			$t .= '<li class="dd' .$dd_id. '-item dd-item dd3-item" data-id="' .$airdrop["airdrop_id"]. '">';
			
			//no dragable
			if(count($airdrops) === 1)
			{
				$t .= '<div class="dd' .$dd_id. '-nodrag dd3-handle dd-handle"></div>';
			}
			else
			{
				$t .= '<div class="dd' .$dd_id. '-handle dd3-handle dd-handle"></div>';
			}

			$t .= '<div class="dd3-content" style="background:#f1f1f1;">';
				$t .= '<span class="lispmn">';
				
				if(!is_null($airdrop["images"]))
				{
					$xplode_airdrop_images = explode(',', $airdrop["images"]);
					$t .= '<img src="' .SITE_URL. 'public/upload/img/catalog_produse/s/' .$xplode_airdrop_images[0]. '" class="img-tree"/>&nbsp;&nbsp;';
				}
				else
				{
					$t .= '<img src="' .SITE_URL. 'public/assets/img/product/blank_product.jpg" class="img-tree"/>&nbsp;&nbsp;';
				}				
				
					$t .= '<strong>' . $airdrop["atom_name_ro"] . '</strong>';
					$t .= (!(bool)$airdrop["atom_isactive"] ? '&nbsp;<i class="fa fa-tag" aria-hidden="true" style="color:red;"></i>' : '');
					$t .= (!(bool)$airdrop["atom_instock"] ? '&nbsp;<i class="fa fa-tag" aria-hidden="true" style="color:blue;"></i>' : '');
					$t .= ((bool)$airdrop["atom_newproduct"] ? '&nbsp;<i class="fa fa-tag" aria-hidden="true" style="color:orange;"></i>' : '');
					$t .= ((bool)$airdrop["atom_special"] ? '&nbsp;<i class="fa fa-tag" aria-hidden="true" style="color:green;"></i>' : '');

					$t .= ' <span class="sp" style="visibility:hidden;">';
					$t .= '<a href="' .$u. '/item/u/id/' .$airdrop["atom_id"] . '"><i class="fa fa-pencil"></i> Editeaz&abreve; ' .strtolower($air->air_ident). '</a>';
					$t .= '<a href="' .$u. '/item/d/id/' .$airdrop["atom_id"] . '" class="atdel"><i class="fa fa-window-close" style="color:red;"></i> &scedil;terge produs</a>';
					$t .= '</span>';

				$t .= '</span>';
			$t .= '</div>';
		}

		$t .= '</ol>';
		$t .= '</div>';
	}
	return $t;
}


$controllerurl = base_url().$controller;
if(!empty($nodes))
{
	$dd_id = 0;
	$dd_prefix = 'nd';
	$tree = nodes($controllerurl, $air, $nodes, $tree = '', $dd_id, $dd_prefix);
}
  
?>

<style>
ul#browser-atoms-miss li{
	font-size:15px;
}

img.img-tree {
	max-height: 20px;
}
</style>

<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
		<div class="col-md-12">

			<div class="tabs-container">

				<ul role="tablist" class="nav nav-tabs">
					<li role="presentation" class="active">
						<a href="<?=base_url()?>legaturi/item/i/air_id/4/parent_id/<?=$air->targeted_node_id?>" style="cursor:pointer;"><i class="fa fa-plus-circle"></i> Creeaza categorie noua</a>
					</li>
					<li role="presentation">
						<a href="javascript:void(0);" style="color:grey;"><i class="fa fa-tag" aria-hidden="true" style="color:green;"></i> Produs Special</a>
					</li>
					<li role="presentation">
						<a href="javascript:void(0);" style="color:grey;"><i class="fa fa-tag" aria-hidden="true" style="color:blue;"></i> Fara stoc</a>
					</li>
					<li role="presentation">
						<a href="javascript:void(0);" style="color:grey;"><i class="fa fa-tag" aria-hidden="true" style="color:red;"></i> Inactiv</a>
					</li>
					<li role="presentation">
						<a href="javascript:void(0);" style="color:grey;"><i class="fa fa-tag" aria-hidden="true" style="color:orange;"></i> Nou</a>
					</li>
				</ul>

				<div class="tab-content">
					<!--start#legaturi-->
					<div id="legaturi" class="tab-pane active">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12">
									<?php if(is_null($nodes)): echo "<span>Nu exista date..</span>"; ?>
									<?php elseif(!empty($tree)): ?>
									<div class="float" style="margin-top:15px;">
										<ul id="browser">
											<?php echo trim($tree); ?>
										</ul>
									</div>
									<?php endif; ?>
								</div> <!-- end col-md-12 -->
							</div>
							
						</div>
					</div><!--end#legaturi-->
					
				</div>
				
				<?php if(!is_null($atoms_missing_airdrop_or_node)): ?>
				<div class="row" style="margin-top:20px;">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5 style="color:red;">Produse fara categorie</h5>
							</div>
							<div class="ibox-content">
								<ul id="browser-atoms-miss">
								<?php
									foreach($atoms_missing_airdrop_or_node as $atmissadnd)
									{
										echo '<li><span class="lispmn">' . $atmissadnd["atom_name"]
										. '<span class="sp" style="visibility:hidden;">
										<a href="' .$controllerurl. '/item/u/id/' .$atmissadnd["atom_id"] . '"><i class="fa fa-pencil"></i> Editeaz&abreve;</a>
										<a href="' .$controllerurl. '/item/d/id/' .$atmissadnd["atom_id"] . '" class="atdel"><i class="fa fa-window-close" style="color:red;"></i> &scedil;terge produs</a>
										
										</span></span>'
										
										. '</li>';
									}
								?>
								</ul>
							</div>
						</div>
					</div>
				
				</div>
				<?php endif; ?>
				
			</div>
		</div>
	</div>
</div>