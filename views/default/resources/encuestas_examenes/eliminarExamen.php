<?php

$guid = elgg_extract('guid', $vars);
$examen = get_entity($guid);


//Recuperamos y borramos las respuestas anteriores del examen
$respuestas_anteriores = elgg_get_entities_from_metadata(array(
	'types'=>'object',
	'subtypes'=>'respuesta',
	'metadata_names' =>array('examen'),
	'metadata_values' =>array($guid),
));

foreach($respuestas_anteriores as $r){
	$r->delete();
}

$resultados_guid = $examen->resultadosguid;
$resultados = get_entity($resultados_guid);
//echo(var_dump($resultados));
if($resultados->delete()){
	if($examen->delete()){
		system_message(elgg_echo('encuestas_examenes:quiz_deleted'));
	}else{
   		reister_error(elgg_echo('encuestas_examenes:quiz_not_delated'));
	}
}else{
	system_error(elgg_echo('encuestas_examenes:quiz_not_delated'));
}


forward("encuestas_examenes/all");

