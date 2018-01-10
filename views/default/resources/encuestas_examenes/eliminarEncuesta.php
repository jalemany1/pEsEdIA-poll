<?php

$guid = elgg_extract('guid', $vars);
$encuesta = get_entity($guid);


//Recuperamos y borramos las respuestas anteriores la encuesta
$respuestas_anteriores = elgg_get_entities_from_metadata(array(
	'types'=>'object',
	'subtypes'=>'voto',
	'metadata_names' =>array('encuesta'),
	'metadata_values' =>array($guid),
));

foreach($respuestas_anteriores as $r){
	$r->delete();
}

$resultados_guid = $encuesta->resultadosguid;
$resultados = get_entity($resultados_guid);
//echo(var_dump($resultados));
if($resultados->delete()){
	if($encuesta->delete()){
		system_message(elgg_echo('encuestas_examenes:poll_deleted'));
	}else{
   		reister_error(elgg_echo('encuestas_examenes:poll_not_delated'));
	}
}else{
	system_error(elgg_echo('encuestas_examenes:poll_not_delated'));
}


forward("encuestas_examenes/all");

