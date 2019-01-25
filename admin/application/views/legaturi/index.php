<?php
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
?>
<?php
// var_dump($nodes);die();
?>


<?php

/**
 * 
 * @param type $u
 * @param type $nodes
 * @param type $tree
 * @return string
 */
function nodes($u, $nodes, $tree, $dd_id = null, $dd_prefix = null)
{

	if(!empty($nodes))
	{
		$t = '';
		$t .= '<div class="dd' .$dd_id. ' dd" id="' . $dd_prefix . $dd_id . '">';
		$t .= '<ol class="dd' .$dd_id. '-list dd-list">';

		foreach($nodes as $node)
		{
			$t .= '<li class="dd' .$dd_id. '-item dd-item dd3-item" data-id="' .$node["node_id"]. '">';
			
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
					$t .= $node["denumire_ro"];

					$t .= ' <span class="sp" style="visibility:hidden;">';
					$t .= '<a href="' .$u. '/item/i/parent_id/' .$node["node_id"] . '"><i class="fa fa-plus"></i> adaug&abreve; leg&abreve;tur&abreve;</a>';
					$t .= '<a href="' .$u. '/item/u/id/' .$node["node_id"] . '"><i class="fa fa-pencil"></i> editeaz&abreve;</a>';
					$t .= '<a href="' .$u. '/item/d/id/' .$node["node_id"] . '" class="atdel"><i class="fa fa-window-close" style="color:red;"></i> &scedil;terge</a>';
					$t .= '</span>';

				$t .= '</span>';
			$t .= '</div>';

			//nextnodes
			if(!empty($node["_nodes"]))
			{
				$t .= '<ul>';
				$t .= nodes($u, $node["_nodes"], $tree, $node["node_id"], 'nd');
				$t .= '</ul>';//ul
			}
			if(!empty($node["_airdrop"]))
			{
				$create_id = $node["node_id"] . join(array_keys($node["_airs"]));
				$t .= '<ul>';
				$t .= airdrop($u, $node["_airdrop"], $node["_airs"], $create_id, 'ad');
				$t .= '</ul>';//ul
			}
			$t .= '</li>';
		}

		$t .= '</ol>';
		$t .= '</div>';
	}
	return $t;
}

function airdrop($u, $airdrops, $airs, $dd_id = null, $dd_prefix = null)
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

			$t .= '<div class="dd3-content" ' .(!(bool)$airdrop["atom_isactive"] ? 'style="border-right:3px solid red;border-radius:0;background:#f2fbff;;"' : 'style="background:#f2fbff;"'). '>';
				$t .= '<span class="lispmn">';
					$t .= '<span style="color:orange;font-weight:bold;">' . $airs[$airdrop["air_id"]]["air_ident"] . '</span> ' . $airdrop["atom_name_ro"];

					//$t .= ' <span class="sp" style="visibility:hidden;">';
					//$t .= '<a href="' .$u. '/item/i/parent_id/' .$airdrop["airdrop_id"] . '"><i class="fa fa-plus"></i> adaug&abreve; leg&abreve;tur&abreve;</a>';
					//$t .= '<a href="' .$u. '/item/u/id/' .$airdrop["airdrop_id"] . '"><i class="fa fa-pencil"></i> editeaz&abreve;</a>';
					//$t .= '<a href="' .$u. '/item/d/id/' .$airdrop["airdrop_id"] . '" class="atdel"><i class="fa fa-window-close" style="color:red;"></i> &scedil;terge</a>';
					//$t .= '</span>';

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
	$tree = nodes($controllerurl, $nodes, $tree = '', $dd_id, $dd_prefix);
}
  
?>

<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
		<div class="col-md-12">

			<div class="tabs-container">

				<ul role="tablist" class="nav nav-tabs">
					<li role="presentation">
						<a href="javascript:void(0);"><strong style="color:black;">Structura:</strong></a>
					</li>
					<li role="presentation" class="active">
						<a href="#legaturi" data-toggle="tab">Legaturi</a>
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
			</div>
		</div>
	</div>
</div>