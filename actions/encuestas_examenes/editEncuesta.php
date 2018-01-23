<?php

//Obtenemos la guid del examen que se acaba de editar
$guid = get_input('guid_encuesta');
$encuesta = get_entity($guid);

$guid_resultados = $encuesta->resultadosguid;
$resultados = get_entity($guid_resultados);

$encuesta->title = get_input('title');
$encuesta->description = get_input('description');

//Obtener el instate en el cual se edita el examen
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

$resultados->num_respuestas_enviadas = get_input('customResend');

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

$questions_old = unserialize($encuesta->questions);
if($questions != $questions_old){

	//Recuperamos y borramos las respuestas anteriores del examen
	$votos_anteriores = elgg_get_entities_from_metadata(array(
		'types'=>'object',
		'subtypes'=>'voto',
		'metadata_names' => array('encuesta'),
		'metadata_values' => array($guid),
	));

	foreach($votos_anteriores as $r){
		$r->delete();
	}

	$resultados->respuestas_enviadas = serialize(array());
	$resultados->resultados_totales = 0;
}

$encuesta->questions = serialize($questions);
$resultados->questions_encuesta = serialize($questionsResults);
 
//Acceso a la encuesta
$encuesta->access_id = get_input('access');
$resultados->access_id = get_input('access');

$encuesta_guid = $encuesta->save();
$resultados->save();

if ($encuesta_guid) {
   system_message(elgg_echo('encuestas_examenes:ok_edit_encuesta'));
   forward($encuesta->getURL());
} else {
   register_error(elgg_echo('encuestas_examenes:problem_edit_encuesta'));
   forward(REFERER);
}