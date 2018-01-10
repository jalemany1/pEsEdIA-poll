<?php

$item = elgg_extract('item', $vars);
$entity = $item->getObjectEntity();
if (!($entity->getSubtype() == "encuesta")) {	
	return;
}


$excerpt = elgg_get_excerpt($entity->description);

echo elgg_view('river/elements/layout',array(
	'item'=>$vars['item'],
	'message' => $excerpt,

));
