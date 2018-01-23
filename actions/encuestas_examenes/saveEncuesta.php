<?php

$titulo = get_input('title');
$desc = get_input('description');

//Obtener el instate en el cual se guarda el encuesta
$now = time();

$diffGTM = get_input('nowlocal');

$dateInicio = get_input('dateInicio');
$timeInicioHora = get_input('timeInicioHora');
$timeInicioMin = get_input('timeInicioMin');

$inicio = $dateInicio[0] . "T" . $timeInicioHora . ":" . $timeInicioMin . ":00";

$inicioTMS = strtotime($inicio);

$dateFin = get_input('dateFin');
$timeFinHora = get_input('timeFinHora');
$timeFinMin = get_input('timeFinMin');

$fin = $dateFin[0] . "T" . $timeFinHora . ":" . $timeFinMin . ":00";

$finTMS = strtotime($fin);

// create a new encuesta object
$encuesta = new ElggObject();
$encuesta->subtype = "encuesta";
$encuesta->title = $titulo;
$encuesta->description = $desc;

// Settings
$encuesta->start = $inicioTMS;
$encuesta->end = $finTMS;
$encuesta->diffGTM = $diffGTM;
$encuesta->duration = get_input('duration');
$encuesta->noDuration = get_input('noDuration');
$encuesta->automaticSend = get_input('automaticSend');
$encuesta->resendParams = get_input('resendParams');
$encuesta->publishNow = get_input('publishExamNow');
$encuesta->noEndDate = get_input('noEndDate');
$encuesta->emptyResults = get_input('emptyResults');

//Create a new resultados empty object
$resultadosEncuesta = new ElggObject();
$resultadosEncuesta->subtype = "resultadosEncuesta";
$resultadosEncuesta->title = $titulo;


$questions = array();
$questionsResults = array();

$qnumber = get_input('numQuestions');
for($i=1; $i<=$qnumber; $i++){ //questions number
	
	$qname = 'Pregunta' . $i;
	$q = get_input($qname);

	if(!empty($q)) {
		$answers = array();
		$answersResults = array();

		$numR = 1;
		$rname = 'q' . $i . 'r' . $numR;
		$r = get_input($rname);
		while (!empty($r)) {
			$ra = array(
				"answer" => $r,
				"votes" => array(
					'guidVotes' => array(),
					'value' => 0)
			);
			array_push($answersResults, $ra);
			array_push($answers, $r);

			$rname = 'q' . $i . 'r' . ++$numR;
			$r = get_input($rname);
		}

		$question = array(
			"type" => get_input('qType'.$i),
			"qTittle" => $q,
			"answers" => $answers,
			"required" => get_input('requiredQ'.$i),
		);

		$questionResults = array(
			"type" => get_input('qType'.$i),
			"qTittle" => $q,
			"answers" => $answersResults,
		);

		array_push($questionsResults, $questionResults);	
		array_push($questions, $question);
	}
}

$encuesta->questions = serialize($questions);

$resultadosEncuesta->questions_encuesta = serialize($questionsResults);
$resultadosEncuesta->resultados_totales = 0;
$resultadosEncuesta->respuestas_enviadas = serialize(array());
$resultadosEncuesta->num_respuestas_enviadas = get_input('customResend');


//Añadir permisos de acceso
$encuesta->access_id = get_input('access');
$resultadosEncuesta->access_id = get_input('access');

//El creador del encuesta es el usuario que haya registrado
$encuesta->owner_guid = elgg_get_logged_in_user_guid();
$resultadosEncuesta->owner_guid = elgg_get_logged_in_user_guid();

//Guardar en la BD una nueva entidad del subtipo resultadosEncuesta y obtener su guid
$resultadosEncuesta_guid = $resultadosEncuesta->save();

$encuesta->resultadosguid = $resultadosEncuesta_guid;

//Guardar en la BD una nueva entidad del subtipo encuesta
$encuesta_guid = $encuesta->save();

//Si no hay problema al guardar el encuesta, acceder a él directamente
// si no, registrar error
if ($encuesta_guid) {

	elgg_create_river_item([
		'view' => 'river/object/encuesta/create',
		'action_type' => 'create',
		'subject_guid' => elgg_get_logged_in_user_guid(),
		'object_guid' => $encuesta->getGUID(),
	]);

   system_message(elgg_echo('encuestas_encuestaes:encuesta_saved'));
   forward($encuesta->getURL());
} else {
   register_error(elgg_echo('encuestas_encuestaes:encuesta_not_saved'));
   forward(REFERER);
}
