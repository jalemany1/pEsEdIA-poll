<?php

$guid = elgg_extract('guid', $vars);
$encuesta = get_entity($guid);


//Recuperamos y borramos las respuestas anteriores del examen
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

$question = unserialize($resultados->questions_encuesta);

for($i=0;$i<count($question);$i++){

	switch($question[$i]['type']){
		case "Text":
			$question[$i]["answers"] = array();
		break;
		case "Long Text":
			$question[$i]["answers"] = array();
		break;
		case "Checkboxes":
		//$tmp = count($question[$i]["answers"]);
			for($j = 0; $j < count($question[$i]["answers"]); $j++){
				$question[$i]["answers"][$j]["votes"]["guidVotes"] = array();
				$question[$i]["answers"][$j]["votes"]["value"] = 0;
			}
		break;

		case "Radio":
		//$tmp = count($question[$i]["answers"]);
			for($j = 0; $j < count($question[$i]["answers"]); $j++){
				$question[$i]["answers"][$j]["votes"]["guidVotes"] = array();
				$question[$i]["answers"][$j]["votes"]["value"] = 0;
			}
		break;
	}
}


$resultados->questions_encuesta = serialize($question);
$resultados->resultados_totales = 0;
$resultados->respuestas_enviadas = serialize(array());


if($resultados->save()){
	system_message(elgg_echo('encuestas_examenes:poll_restarted'));
}else{
   	reister_error(elgg_echo('encuestas_examenes:poll_not_restarted'));
}



forward("encuestas_examenes/all");
