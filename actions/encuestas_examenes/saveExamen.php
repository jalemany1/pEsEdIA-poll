<?php
$titulo = get_input('title');
$desc = get_input('description');
//$tags = string_to_tag_array(get_input('tags'));

//Obtener el instate en el cual se guarda el examen

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

// create a new examen object
$examen = new ElggObject();
$examen->subtype = "examen";
$examen->title = $titulo;
$examen->description = $desc;

//Exam config
$examen-> passScore = get_input('passScore');
$examen-> start = $inicioTMS;
$examen-> end = $finTMS;
$examen-> diffGTM = $diffGTM;
$examen-> duration = get_input('duration');
$examen-> noDuration = get_input('noDuration');
$examen-> automaticSend = get_input('automaticSend');

$examen-> resendParams = get_input('resendParams');

$examen-> publishNow = get_input('publishExamNow');
$examen-> noEndDate = get_input('noEndDate');

$examen-> emptyResults = get_input('emptyResults');

//Create a new resultados emty object
$resultadosExamen = new ElggObject();
$resultadosExamen->subtype = "resultadosExamen";
$resultadosExamen->title = $titulo;

//Exam config en resultados
$resultadosExamen-> seeResults = get_input('seeResultsParams');


$scoreSum = 0;
$numQ = 1;
$nomQ = 'Pregunta' . $numQ;
$questions = array();
$questionsResults = array();
$q = get_input($nomQ);

$numQuestions = get_input('numQuestions');

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

$numQ = 1;
$nomQ = 'Pregunta' . $numQ;
$q = get_input($nomQ);
for($i=1; $i<=$numQuestions;$i++){

$tmp .= ' - ';
$tmp .= empty($q);
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

					//$ra = array();

					//array_push($rAnswers, $ra);

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
			//"okanswers" => $okanswers,
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

	}
	$nomQ = 'Pregunta' . ++$numQ;
	$q = get_input($nomQ);
	$question = array();

}

 
$examen->questions = serialize($questions);
$examen->scoreSum = $scoreSum;

$resultadosExamen->questions_examen =  serialize($questionsResults);
$resultadosExamen->resultados_totales = 0;
$resultadosExamen->respuestas_enviadas = serialize(array());
$resultadosExamen->num_respuestas_enviadas = get_input('customResend');


//Añadir permisos de acceso
$examen->access_id = get_input('access');
$resultadosExamen->access_id = get_input('access');

//El creador del examen es el usuario que haya registrado
$examen->owner_guid = elgg_get_logged_in_user_guid();
$resultadosExamen->owner_guid = elgg_get_logged_in_user_guid();

//Guardar en la BD una nueva entidad del subtipo resultadosExamen y obtener su guid
$resultadosExamen_guid = $resultadosExamen->save();

// save tags as metadata
//$blog->tags = $tags;

$examen->resultadosguid = $resultadosExamen_guid;
//Guardar en la BD una nueva entidad del subtipo examen
$examen_guid = $examen->save();

//Create a relationship between examen and resultadosExamen: "resultadosExamen es una coleccion_de_respuestas de un examen"
//add_entity_relationship($resultadosExamen->guid, 'coleccion_de_respuestas', $examen->guid);

//elgg_clear_sticky_form('examen');

//Si no hay problema al guardar el examen, acceder a él directamente
// si no, registrar error
if ($examen_guid) {

	elgg_create_river_item([
		'view' => 'river/object/examen/create',
		'action_type' => 'create',
		'subject_guid' => elgg_get_logged_in_user_guid(),
		'object_guid' => $examen->getGUID(),
	]);

   system_message(elgg_echo('encuestas_examenes:exam_saved'));
   forward($examen->getURL());
} else {
   register_error(elgg_echo('encuestas_examenes:exam_not_saved'));
   forward(REFERER); // REFERER hace referencia a la página previa
}
