<?php

//elgg_make_sticky_form('respuesta');

$examen = get_input('guid');

//Borramos respuestas anteriores en la BD en caso de haberlas
$respuestas_anteriores = elgg_get_entities_from_metadata(array(
	'types'=>'object',
	'subtypes'=>'respuesta',
	'metadata_names' =>array('examen'),
	'metadata_values' =>array($examen),
	'owner_guid'=>elgg_get_logged_in_user_entity()->guid
));

foreach($respuestas_anteriores as $r){
	$r->delete();
}


//Crear un nuevo objeto con el subtipo "respuesta"
$respuesta = new ElggObject();
$respuesta->subtype = "respuesta";

$titulo = get_input('examenTitle');
$respuesta->title = $titulo;
$respuesta->nota = 0;

$resultadosGUID = get_input('resultadosGUID');
$resultadosExamen = get_entity($resultadosGUID);



$respuesta->examen = $examen;
$respuesta->resultados = $resultadosGUID;

$numQ = 1;
$nomQ = 'Pregunta' . $numQ;
$questions = array();
$numQTotal = get_input('numQExamen');
while($numQ <= $numQTotal){

	$question = array(
		"type" => get_input('qType'.$numQ),
		"answer" => get_input($nomQ),
	);
	
	array_push($questions, $question);

	$nomQ = 'Pregunta' . ++$numQ;
	$question = array();
}

$respuesta->questions = serialize($questions);
// for now make all encuestas posts public
$respuesta->access_id = ACCESS_PUBLIC;

// owner is logged in user
$respuesta->owner_guid = elgg_get_logged_in_user_guid();

// save tags as metadata
//$blog->tags = $tags;

// save to database and get id of the new encuesta
$respuesta_guid = $respuesta->save();

elgg_clear_sticky_form('respuesta');

//Create a relationship between respuesta and resultadosExamen: "respuesta es una parte de un resultadosExamen"
add_entity_relationship($resultadosExamen->guid, 'parte', $respuesta ->guid);

// if the encuesta was saved, we want to display the new post
// otherwise, we want to register an error and forward back to the form
if ($respuesta_guid) {
   system_message(elgg_echo('encuestas_examenes:ok_send'));
   forward($respuesta->getURL());
} else {
   register_error(elgg_echo('encuestas_examenes:bad_send'));
   forward(REFERER); // REFERER is a global variable that defines the previous page
}
