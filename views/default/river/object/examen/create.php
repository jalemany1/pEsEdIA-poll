<?php

$item = elgg_extract('item', $vars);

//$vars['item'] contiene los parámetros:
// - $vars['item']->subject_guid (Usuario que crea el river - que crea el examen en este caso-)
// -$vars['item']->object_guid (GUID del examen)

$entity = $item->getObjectEntity();
if (!($entity->getSubtype() == "examen")) {	
	return;
}


$excerpt = elgg_get_excerpt($entity->description);

echo elgg_view('river/elements/layout',array(
	'item'=>$vars['item'],
	'message' => $excerpt,

));


