<?php

elgg_require_js('encuestas_examenes/sendExamen');
elgg_load_css('mycss');

// get the entity
$guid = elgg_extract('guid', $vars);
$examen = get_entity($guid);

$resultadosGUID = $examen->resultadosguid;
$r = get_entity($resultadosGUID);

$now = time();

$start = $examen->start;
$end = $examen->end;

$diffGTM = $examen->diffGTM;


if($diffGTM[28] == "+"){
	$startGTM = $start - ((int)$diffGTM[30]*60*60);
	$finGTM = $end - ((int)$diffGTM[30]*60*60);
}else{
	$startGTM = $start + ((int)$diffGTM[30]*60*60);
	$finGTM = $end + ((int)$diffGTM[30]*60*60);
}

$publishNow = $examen-> publishNow;
$noEndDate = $examen-> noEndDate;

$content = elgg_view_entity($examen, array('full_view' => true));
$hidefullbody = 'NO';


//Obtener la variable para comprobar si ya se ha enviado una respuesta de este examen. '0' = NO ESTÁ RESPONDIDO TODAVÍA
$answered = unserialize($r->respuestas_enviadas);
$resend = $examen-> resendParams;

//Si el examen ya se ha enviado una vez con este usuario y está configurado para envío único
if($resend == 'oneSend' && $answered[elgg_get_logged_in_user_entity()->guid] > 1){
	$hidefullbody = 'YES';
	$content .= elgg_echo('encuestas_examenes:one_sent')."<br>";
	
	if($r-> seeResults == "seeMarkCorrection"){
		$respuesta_al_examen = elgg_get_entities_from_metadata(array(
			'types'=>'object',
			'subtypes'=>'respuesta',
			'metadata_names' =>array('examen'),
			'metadata_values' =>array($guid),
			'owner_guid'=>elgg_get_logged_in_user_entity()->guid
		));

		$content .= '<a href="/encuestas_examenes/correction/'. $respuesta_al_examen[0]->guid  .'">'.elgg_echo('encuestas_examenes:my_result').'</a>';
	}


}else{
	if($now <= $startGTM && $publishNow == '0'){
		$hidefullbody = 'YES';
		$content .= elgg_echo('encuestas_examenes:early_date');
	}else{
		if($now > $finGTM && $noEndDate == '0'){
			$hidefullbody = 'YES';
			$content .= elgg_echo('encuestas_examenes:late_date');

		}else{

			//Se comprueba si hay envíos limitados o no
			if($resend == 'specialSend' && $answered[elgg_get_logged_in_user_entity()->guid] > $r->num_respuestas_enviadas){
				$hidefullbody = 'YES';
				$content .= elgg_echo('encuestas_examenes:submit_num_exceded') . '<br>';
			}else{
		
				$contentExam = elgg_view('input/hidden', ['name' => 'guid', 'value' => $guid]);

				$contentExam .= elgg_view('input/hidden', ['name' => 'resultadosGUID', 'value' => $resultadosGUID]);

				$contentExam .= elgg_view('input/hidden', ['name' => 'examenTitle', 'value' => $examen->title]);

				$questions = unserialize($examen->questions);

				for($i = 0; $i < sizeof($questions); $i++){
					$numQ = $i+1;
					$nomQ = 'Pregunta'.$numQ;
					$question = $questions[$i];
					$qType = $question["type"];
					$answers = array();

					$acierto = $question["success"];
					$fallo = $question["fail"];
	
					//Add red * if the question is required
					$requiredMark = "";
					$requiredQ = "";
						
					//echo($question["required"]);
					if($question["required"] != '0'){
						$requiredMark = '<span class="req">*</span>';
						$requiredQ='requiredQ';
					}
					$contentExam .= '<div>';

					switch($qType){
						case "Checkboxes":

							for($j = 0; $j < sizeof($question["answers"]); $j++){				
								$nomR = 'r'.$numQ.$j.'CB';
							
								//Elgg interpreta el 0 como que no se ha envíado ningún resultado al servidor, por lo que para
								//que se muestre el 0 literalmente por pantalla es necesario este arreglo
								if($question["answers"][$j] == '0'){
									$answers["0 "] = $question["answers"][$j];
								}else{
									$answers[$question["answers"][$j]] = $question["answers"][$j];
								}
		
							}
							$contentExam .= elgg_view('input/hidden', ['name' => 'qType'.$numQ, 'value' => $qType]);
							$contentExam .= elgg_echo('<label class=""for=' . $nomQ . '>'. elgg_echo('encuestas_examenes:question') . $numQ . ': ' .$question["qTittle"] . $requiredMark . '</label><br>');
							if($acierto != ''){
								$contentExam .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_success').$acierto. elgg_echo('encuestas_examenes:points') .'</span>');
							}

							if($fallo != ''){
								$contentExam .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_fail').$fallo. elgg_echo('encuestas_examenes:points') .'</span>');
							}

							$contentExam .= elgg_view('input/checkboxes', ['name' => $nomQ, 'options' => $answers, 'id' => $nomQ, 'class' => $requiredQ]);

	
							break;

						case "Radio":
							for($j = 0; $j < sizeof($question["answers"]); $j++){				
								$nomR = 'r'.$numQ.$j.'R';
								$answers[$question["answers"][$j]] = $question["answers"][$j];
								//$answersVL[$question["answers"][$j]] = $question["answers"][$j];			
							}
							$contentExam .= elgg_view('input/hidden', ['name' => 'qType'.$numQ, 'value' => $qType]);
							$contentExam .= elgg_echo('<label for=' . $nomQ . '>'. elgg_echo('encuestas_examenes:question') . $numQ . ': ' . $question["qTittle"] . $requiredMark . '</label><br>');

							if($acierto != ''){
								$contentExam .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_success').$acierto. elgg_echo('encuestas_examenes:points') .'</span>');
							}

							if($fallo != ''){
								$contentExam .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_fail').$fallo. elgg_echo('encuestas_examenes:points') .'</span>');
							}

							$contentExam .= elgg_view('input/radio', ['name' => $nomQ, 'options' => $answers, 'id' => $nomQ, 'class'=>$requiredQ]);

							break;

						case "Text":
							$contentExam .= elgg_view('input/hidden', ['name' => 'qType'.$numQ, 'value' => $qType]);
							$contentExam .= elgg_echo('<label for=' . $nomQ . '>	'. elgg_echo('encuestas_examenes:question')  . $numQ . ': ' . $question["qTittle"] . $requiredMark . '</label><br>');

							if($acierto != ''){
								$contentExam .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_success').$acierto. elgg_echo('encuestas_examenes:points') .'</span>');
							}

							if($fallo != ''){
								$contentExam .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_fail').$fallo. elgg_echo('encuestas_examenes:points') .'</span>');
							}

							$contentExam .= elgg_view('input/text', ['name' => $nomQ, 'id' => $nomQ, 'class'=>$requiredQ]);

							break;

						case "Long Text":
							$contentExam .= elgg_view('input/hidden', ['name' => 'qType'.$numQ, 'value' => $qType]);
							$contentExam .= elgg_echo('<label for=' . $nomQ . '>'. elgg_echo('encuestas_examenes:question')  . $numQ . ': ' . $question["qTittle"] . $requiredMark . '</label><br>');

							if($acierto != ''){
								$contentExam .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_success').$acierto. elgg_echo('encuestas_examenes:points') .'</span>');
							}

							if($fallo != ''){
								$contentExam .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_fail').$fallo. elgg_echo('encuestas_examenes:points') .'	</span>');
							}

							$contentExam .= elgg_view('input/longtext', ['name' => $nomQ, 'id' => $nomQ, 'class'=>$requiredQ]);

							break;


					}

					$contentExam .= '</div><br><br>';

				}

				$contentExam .= elgg_view('input/hidden', ['name' => 'numQExamen', 'id'=>'numQExamen', 'value' => $numQ]);
				$contentExam .= elgg_view('input/hidden', ['name' => 'emptyResults', 'id'=>'emptyResults', 'value' => $examen->emptyResults]);

				$submit =  elgg_view('input/submit', ['value' => elgg_echo('encuestas_examenes:send')]);
		
				$contentExam .= elgg_format_element('div', [], $submit);


				//Es la que se muestra por defecto
				$contentExamConfig['id'] = 'contentExam';		
				$content .= elgg_format_element('div', $contentExamConfig, $contentExam);

			}		
		}

	}

}

echo elgg_view('input/hidden', ['id' => 'hideFullbody', 'value' => $hidefullbody]);

echo $content;


