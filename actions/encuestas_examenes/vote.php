<?php

//elgg_make_sticky_form('respuesta');

$encuesta = get_input('guid');

//Borramos los votos anteriores en la BD en caso de haberlas
$votos_anteriores = elgg_get_entities_from_metadata(array(
	'types'=>'object',
	'subtypes'=>'voto',
	'metadata_names' =>array('encuesta'),
	'metadata_values' =>array($encuesta),
	'owner_guid'=>elgg_get_logged_in_user_entity()->guid
));

foreach($votos_anteriores as $v){
	$v->delete();
}


//Crear un nuevo objeto con el subtipo "voto"
$voto = new ElggObject();
$voto->subtype = "voto";

$titulo = get_input('encuestaTitle');
$voto->title = $titulo;

$resultadosGUID = get_input('resultadosGUID');
$resultadosEncuesta = get_entity($resultadosGUID);



$voto->encuesta = $encuesta;
$voto->resultados = $resultadosGUID;

$numQ = 1;
$nomQ = 'Pregunta' . $numQ;
$questions = array();
$numQTotal = get_input('numQEncuesta');
while($numQ <= $numQTotal){

	$question = array(
		"type" => get_input('qType'.$numQ),
		"answer" => get_input($nomQ),
	);
	
	array_push($questions, $question);

	$nomQ = 'Pregunta' . ++$numQ;
	$question = array();
}

$voto->questions = serialize($questions);
// for now make all encuestas posts public
$voto->access_id = ACCESS_PUBLIC;

// owner is logged in user
$voto->owner_guid = elgg_get_logged_in_user_guid();

// save tags as metadata
//$blog->tags = $tags;

// save to database and get id of the new encuesta
$voto_guid = $voto->save();


//Create a relationship between voto and resultadosEncuesta: "voto es una parte de un resultadosEncuesta"
add_entity_relationship($resultadosEncuesta->guid, 'parte', $voto ->guid);

// if the encuesta was saved, we want to display the new post
// otherwise, we want to register an error and forward back to the form
if ($voto_guid) {
   system_message(elgg_echo('encuestas_examenes:ok_send_poll'));
   forward($voto->getURL());
} else {
   register_error(elgg_echo('encuestas_examenes:bad_send_poll'));
   forward(REFERER); // REFERER is a global variable that defines the previous page
}
