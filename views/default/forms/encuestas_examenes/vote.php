<?php

elgg_require_js('encuestas_examenes/sendEncuesta');
elgg_load_css('mycss');

// get the entity
$guid = elgg_extract('guid', $vars);
$encuesta = get_entity($guid);

$resultadosGUID = $encuesta->resultadosguid;
$r = get_entity($resultadosGUID);

$now = time();

$start = $encuesta->start;
$end = $encuesta->end;

$diffGTM = $encuesta->diffGTM;


if($diffGTM[28] == "+"){
	$startGTM = $start - ((int)$diffGTM[30]*60*60);
	$finGTM = $end - ((int)$diffGTM[30]*60*60);
}else{
	$startGTM = $start + ((int)$diffGTM[30]*60*60);
	$finGTM = $end + ((int)$diffGTM[30]*60*60);
}

$publishNow = $encuesta-> publishNow;
$noEndDate = $encuesta-> noEndDate;

$content = elgg_view_entity($encuesta, array('full_view' => true));
$hidefullbody = 'NO';


//Obtener la variable para comprobar si ya se ha enviado una respuesta de esta encuesta. '0' = NO ESTÁ RESPONDIDO TODAVÍA
$answered = unserialize($r->respuestas_enviadas);
$resend = $encuesta-> resendParams;

//Si la encuesta ya se ha enviado una vez con este usuario y está configurado para envío único
if($resend == 'oneSend' && $answered[elgg_get_logged_in_user_entity()->guid] > 1){
	$hidefullbody = 'YES';
	$content .= elgg_echo('encuestas_examenes:one_sent_encuesta')."<br>";
	
	/*if($r-> seeResults == "seeMarkCorrection"){
		$respuesta_al_examen = elgg_get_entities_from_metadata(array(
			'types'=>'object',
			'subtypes'=>'respuesta',
			'metadata_names' =>array('encuesta'),
			'metadata_values' =>array($guid),
			'owner_guid'=>elgg_get_logged_in_user_entity()->guid
		));

		$content .= '<a href="/encuestas_examenes/correction/'. $respuesta_al_examen[0]->guid  .'">'.elgg_echo('encuestas_examenes:my_result').'</a>';
	}*/


}else{
	if($now <= $startGTM && $publishNow == '0'){
		$hidefullbody = 'YES';
		$content .= elgg_echo('encuestas_examenes:early_date_encuesta');
	}else{
		if($now > $finGTM && $noEndDate == '0'){
			$hidefullbody = 'YES';
			$content .= elgg_echo('encuestas_examenes:late_date_encuesta');

		}else{

			//Se comprueba si hay envíos limitados o no
			if($resend == 'specialSend' && $answered[elgg_get_logged_in_user_entity()->guid] > $r->num_respuestas_enviadas){
				$hidefullbody = 'YES';
				$content .= elgg_echo('encuestas_examenes:submit_num_exceded_encuesta') . '<br>';
			}else{
		
				$contentEncuesta = elgg_view('input/hidden', ['name' => 'guid', 'value' => $guid]);

				$contentEncuesta .= elgg_view('input/hidden', ['name' => 'resultadosGUID', 'value' => $resultadosGUID]);

				$contentEncuesta .= elgg_view('input/hidden', ['name' => 'encuestaTitle', 'value' => $encuesta->title]);

				$questions = unserialize($encuesta->questions);

				for($i = 0; $i < sizeof($questions); $i++){
					$numQ = $i+1;
					$nomQ = 'Pregunta'.$numQ;
					$question = $questions[$i];
					$qType = $question["type"];
					$answers = array();

					//$acierto = $question["success"];
					//$fallo = $question["fail"];
	
					//Add red * if the question is required
					$requiredMark = "";
					$requiredQ = "";
						
					//echo($question["required"]);
					if($question["required"] != '0'){
						$requiredMark = '<span class="req">*</span>';
						$requiredQ='requiredQ';
					}
					$contentEncuesta .= '<div>';

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
							$contentEncuesta .= elgg_view('input/hidden', ['name' => 'qType'.$numQ, 'value' => $qType]);
							$contentEncuesta .= elgg_echo('<label class=""for=' . $nomQ . '>'. elgg_echo('encuestas_examenes:question') . $numQ . ': ' .$question["qTittle"] . $requiredMark . '</label><br>');
							/*if($acierto != ''){
								$contentEncuesta .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_success').$acierto. elgg_echo('encuestas_examenes:points') .'</span>');
							}

							if($fallo != ''){
								$contentEncuesta .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_fail').$fallo. elgg_echo('encuestas_examenes:points') .'</span>');
							}*/

							$contentEncuesta .= elgg_view('input/checkboxes', ['name' => $nomQ, 'options' => $answers, 'id' => $nomQ, 'class' => $requiredQ]);

	
							break;

						case "Radio":
							for($j = 0; $j < sizeof($question["answers"]); $j++){				
								$nomR = 'r'.$numQ.$j.'R';
								$answers[$question["answers"][$j]] = $question["answers"][$j];
								//$answersVL[$question["answers"][$j]] = $question["answers"][$j];			
							}
							$contentEncuesta .= elgg_view('input/hidden', ['name' => 'qType'.$numQ, 'value' => $qType]);
							$contentEncuesta .= elgg_echo('<label for=' . $nomQ . '>'. elgg_echo('encuestas_examenes:question') . $numQ . ': ' . $question["qTittle"] . $requiredMark . '</label><br>');

							/*if($acierto != ''){
								$contentEncuesta .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_success').$acierto. elgg_echo('encuestas_examenes:points') .'</span>');
							}

							if($fallo != ''){
								$contentEncuesta .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_fail').$fallo. elgg_echo('encuestas_examenes:points') .'</span>');
							}*/

							$contentEncuesta .= elgg_view('input/radio', ['name' => $nomQ, 'options' => $answers, 'id' => $nomQ, 'class'=>$requiredQ]);

							break;

						case "Text":
							$contentEncuesta .= elgg_view('input/hidden', ['name' => 'qType'.$numQ, 'value' => $qType]);
							$contentEncuesta .= elgg_echo('<label for=' . $nomQ . '>	'. elgg_echo('encuestas_examenes:question')  . $numQ . ': ' . $question["qTittle"] . $requiredMark . '</label><br>');

							/*if($acierto != ''){
								$contentEncuesta .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_success').$acierto. elgg_echo('encuestas_examenes:points') .'</span>');
							}

							if($fallo != ''){
								$contentEncuesta .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_fail').$fallo. elgg_echo('encuestas_examenes:points') .'</span>');
							}*/

							$contentEncuesta .= elgg_view('input/text', ['name' => $nomQ, 'id' => $nomQ, 'class'=>$requiredQ]);

							break;

						case "Long Text":
							$contentEncuesta .= elgg_view('input/hidden', ['name' => 'qType'.$numQ, 'value' => $qType]);
							$contentEncuesta .= elgg_echo('<label for=' . $nomQ . '>'. elgg_echo('encuestas_examenes:question')  . $numQ . ': ' . $question["qTittle"] . $requiredMark . '</label><br>');

							/*if($acierto != ''){
								$contentEncuesta .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_success').$acierto. elgg_echo('encuestas_examenes:points') .'</span>');
							}

							if($fallo != ''){
								$contentEncuesta .= elgg_echo('<span class = "elgg-subtext">'.elgg_echo('encuestas_examenes:question_fail').$fallo. elgg_echo('encuestas_examenes:points') .'	</span>');
							}*/

							$contentEncuesta .= elgg_view('input/longtext', ['name' => $nomQ, 'id' => $nomQ, 'class'=>$requiredQ]);

							break;


					}

					$contentEncuesta .= '</div><br><br>';

				}

				$contentEncuesta .= elgg_view('input/hidden', ['name' => 'numQEncuesta', 'id'=>'numQEncuesta', 'value' => $numQ]);
				$contentEncuesta .= elgg_view('input/hidden', ['name' => 'emptyResults', 'id'=>'emptyResults', 'value' => $encuesta->emptyResults]);

				$submit =  elgg_view('input/submit', ['value' => elgg_echo('encuestas_examenes:send')]);
		
				$contentEncuesta .= elgg_format_element('div', [], $submit);


				//Es la que se muestra por defecto
				$contentEncuestaConfig['id'] = 'contentEncuesta';		
				$content .= elgg_format_element('div', $contentEncuestaConfig, $contentEncuesta);

			}		
		}

	}

}

echo elgg_view('input/hidden', ['id' => 'hideFullbody', 'value' => $hidefullbody]);

echo $content;

