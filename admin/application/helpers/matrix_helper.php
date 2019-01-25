<?php

/**
 * buildMatrix
 * 
 * @param type $flat
 * @param type $pidKey
 * @param type $idKey
 * @return Array @tree
 */
function buildMatrix($flat, $pidKey, $idKey = null, $group_initialize = 0)
{
  // var_dump($flat);
  // var_dump($pidKey);
  // var_dump($idKey);
  // die();
  $grouped = array();
  foreach ($flat as $sub){
    
    $grouped[$sub[$pidKey]][] = $sub;
  }
  // var_dump($grouped);
  // die();

  $fnBuilder = function($siblings) use (&$fnBuilder, $grouped, $idKey) {
    foreach ($siblings as $k => $sibling) {
      
      $id = $sibling[$idKey];
      if(isset($grouped[$id])) {
        
        $sibling['_nodes'] = $fnBuilder($grouped[$id]);
      } else {
				$sibling['_nodes'] = array();
			}
      $siblings[$k] = $sibling;
    }

    return $siblings;
  };
  $tree = $fnBuilder($grouped[$group_initialize]);

  return $tree;
}