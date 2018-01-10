<?php

//Obtenemos la guid del examen que se acaba de editar
$guid = get_input('guid_examen');
$examen = get_entity($guid);

$guid_resultados = $examen->resultadosguid;
$resultados = get_entity($guid_resultados);



$examen->title = get_input('title');
$examen->description = get_input('description');
$examen-> passScore = get_input('passScore');

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

$examen-> start = $inicioTMS;
$examen-> end = $finTMS;
$examen-> diffGTM = $diffGTM;
$examen-> duration = get_input('duration');
$examen-> noDuration = get_input('noDuration');
$examen-> automaticSend = get_input('automaticSend');
$examen-> resendParams = get_input('resendParams');
$resultados->num_respuestas_enviadas = get_input('customResend'); //REVISAR Y COMPARAR CON respuestas_enviadas
$examen-> publishNow = get_input('publishExamNow');
$examen-> noEndDate = get_input('noEndDate');
$examen-> emptyResults = get_input('emptyResults');

$resultados-> seeResults = get_input('seeResultsParams');

$scoreSum = 0;
$numQ = 1;
$nomQ = 'Pregunta' . $numQ;
$questions = array();
$questionsResults = array();
$q = get_input($nomQ);

$numQuestions = get_input('numQuestions');
$totalQ = get_input('totalQ');
if($totalQ > $numQuestions) $numQuestions = $totalQ;

//Obtiene la nota total para poder escalarla a 10
for($i=1; $i<=$numQuestions;$i++){
	if($q != '' || !isset($q)){
		if(get_input('acierto'.$numQ) != null){
			$scoreSum += (double)get_input('acierto'.$numQ);
		}
	}
	$nomQ = 'Pregunta' . ++$numQ;
	$q = get_input($nomQ);
}

//Para ver si ha habido o no cambios en las respuestas a las preguntas, se harán dos arrays con las respuestas y las respuestas correctas
//anteriores y actuales
$questions_old = unserialize($examen->questions);
$list_answers_old = array();
foreach($questions_old as $q_old){
	array_push($list_answers_old, $q_old['answers']);
}
$list_answers_now = array();

$questions_examen_old = unserialize($resultados->questions_examen);
$list_okanswers_old = array();
foreach($questions_examen_old as $qe_old){
	array_push($list_okanswers_old, $qe_old['okanswers']);
}
$list_okanswers_now = array();




$numQ = 1;
$nomQ = 'Pregunta' . $numQ;
$q = get_input($nomQ);

for($i=1; $i<=$numQuestions;$i++){

	if($q != ''){
		$numR = 1;
		$regex = "0";
		$answers = array();
		$qType = get_input('qType'.$numQ);

		//Resultados
		$rAnswers = array();
		$okanswers = array();
		

		switch($qType){
			case 'Text':
					$regex = get_input('regexT'.$numQ);

					$ok = get_input('r'.$numQ.'1T');
					array_push($okanswers, $ok);
				break;

			case 'Checkboxes':
					$numRCB = 1;
					$nomRCB = 'r'.$numQ.$numRCB.'CB';
					$oks = get_input('CB'.$numQ);
					$rcb = get_input($nomRCB);
					
					while(isset($rcb)){
						if($rcb != ''){
							array_push($answers, $rcb);

							$ra = array(
								"answer" => $rcb,
								"votes" => array(
									'guidVotes' => array(),
									'value' => 0,
								),
							);
							array_push($rAnswers, $ra);

							if(in_array($nomRCB, $oks)){
								array_push($okanswers, $rcb);
							}
						}

						
						$nomRCB = 'r' . $numQ . ++$numRCB . 'CB';
						$rcb = get_input($nomRCB);
					}
						

				break;

			case 'Radio':
					$numRR = 1;
					$nomRR = 'r'.$numQ.$numRR.'R';
					$oks = get_input('R'.$numQ);
					$rr = get_input($nomRR);
					while(isset($rr)){
						if($rr != ''){
							array_push($answers, $rr);

							$ra = array(
								"answer" => $rr,
								"votes" => array(
									'guidVotes' => array(),
									'value' => 0,
								),
							);
							array_push($rAnswers, $ra);

							if($nomRR === $oks){
								array_push($okanswers, $rr);
							}

						}

						$nomRR = 'r' . $numQ . ++$numRR . 'R';
						$rr = get_input($nomRR);
					}
				break;

			case 'Long Text':

					$ok = get_input('r'.$numQ.'1LT');
					array_push($okanswers, $ok);
				break;
	
		}

		$question = array(
			"type" => $qType,
			"qTittle" => $q,
			"regex" => $regex,
			"answers" => $answers,
			"success"=> (round((((double)get_input('acierto'.$numQ)*10)/$scoreSum)*100))/100,
			"fail" => (round((((double)get_input('fallo'.$numQ)*10)/$scoreSum)*100))/100,
			"required" => get_input('requiredQ'.$numQ),
		);

		$qResult = array(
			"type" => $qType,
			"qTittle" => $q,
			"regex" => $regex,
			"answers" => $rAnswers,
			"okanswers" => $okanswers,
			"success"=> (round((((double)get_input('acierto'.$numQ)*10)/$scoreSum)*100))/100,
			"fail" => (round((((double)get_input('fallo'.$numQ)*10)/$scoreSum)*100))/100,
		);
	
		array_push($questions, $question);
		array_push($questionsResults, $qResult);
		array_push($list_answers_now, $question['answers']);
		array_push($list_okanswers_now, $qResult['okanswers']);


	}
	$nomQ = 'Pregunta' . ++$numQ;
	$q = get_input($nomQ);
	$question = array();

}

$tmp = $list_okanswers_now != $list_okanswers_old;

$examen->questions = serialize($questions);
$resultados->questions_examen = serialize($questionsResults);

if($list_answers_now != $list_answers_old || $list_okanswers_now != $list_okanswers_old){

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

$resultados->respuestas_enviadas = serialize(array());
$resultados->resultados_totales = 0;

}
 

$examen->scoreSum = $scoreSum;



//Acceso al examen
$examen->access_id = get_input('access');
$resultados->access_id = get_input('access');


$examen_guid = $examen->save();
$resultados->save();

if ($examen_guid) {

   system_message(elgg_echo('encuestas_examenes:ok_edit'));
   forward($examen->getURL());
} else {
   register_error(elgg_echo('encuestas_examenes:problem_edit'));
   forward(REFERER);
}
