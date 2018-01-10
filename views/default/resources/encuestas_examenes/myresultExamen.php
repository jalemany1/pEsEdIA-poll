<?php


$guid = elgg_extract('guid', $vars);
$respuesta = get_entity($guid);

$examen = get_entity($respuesta->examen);
$resultados = get_entity($respuesta->resultados);

$pagetitle = $examen->tittle;

$body .= elgg_view_title($pagetitle); 

$questions = unserialize($respuesta->questions);
$questionsExamen = unserialize($examen->questions);

$questionsResultados = unserialize($resultados->questions_examen);

$mark = 0;

//Obtener la variable para comprobar si ya se ha enviado una respuesta de este examen. '0' = NO ESTÁ RESPONDIDO TODAVÍA
$resend = $examen-> resendParams; //oneSend, multipleSend o specialSend
$respuestasEnviadas = unserialize($resultados->respuestas_enviadas); //Pares [guid] => númeroDeEnvíosDeEsteGuid

	//Si se permiten varias respuestas del mismo usuario, en primer lugar se borran los resultados anteriores del objeto resultadosExamen
	if($resend != 'oneSend' && array_key_exists(elgg_get_logged_in_user_entity()->guid, $respuestasEnviadas)){
		for($i = 0; $i < sizeof($questions); $i++){
			$question = $questions[$i];
			$qType = $question["type"];
			switch($qType){
				case "Checkboxes":
					foreach($questionsResultados[$i]["answers"] as $akey => $a){	
						foreach($a["votes"]["guidVotes"] as $key => $id){
							if($id == elgg_get_logged_in_user_entity()->guid){
								unset($questionsResultados[$i]["answers"][$akey]["votes"]["guidVotes"][$key]);
								$questionsResultados[$i]["answers"][$akey]["votes"]["value"]--;
							}			
						}
					}
					
					break;

				case "Radio":
					foreach($questionsResultados[$i]["answers"] as $akey => $a){	
						foreach($a["votes"]["guidVotes"] as $key => $id){
							if($id == elgg_get_logged_in_user_entity()->guid){
								unset($questionsResultados[$i]["answers"][$akey]["votes"]["guidVotes"][$key]);
								$questionsResultados[$i]["answers"][$akey]["votes"]["value"]--;	
							}			
						}
					}
					
					break;

				case "Text":
					foreach($questionsResultados[$i]["answers"] as $key => $a){
	
						if($a["guidVote"] == elgg_get_logged_in_user_entity()->guid){
							unset($questionsResultados[$i]["answers"][$key]);				
						}
					}
					
					break;

				case "Long Text":
					foreach($questionsResultados[$i]["answers"] as $key => $a){
	
						if($a["guidVote"] == elgg_get_logged_in_user_entity()->guid){
							unset($questionsResultados[$i]["answers"][$key]);				
						}
					}
					
					break;
			}
		}

	}

	for($i = 0; $i < sizeof($questions); $i++){
		$numQ = $i+1;
		$question = $questions[$i];
		$qType = $question["type"];
		$answer = $question["answer"];

		$title = $questionsExamen[$i]['qTittle'];

		$markFail = false;

		switch($qType){
			case "Checkboxes":
				$content .= '<div> <h3>'.$title.'</h3>';
			
				if($question["answer"] == "0"){
					$content.= elgg_echo('encuestas_examenes:no_answer').'<br>';
					$markFail = true;	//EN CASO DE AÑADIR LA OPCION DE QUE RESPUESTAS VACÍAS NO RESTAN NOTAS, QUITAR
				}else{
					//Parte que muestra el resultado al usuario
					for($k = 0; $k < sizeof($questionsResultados[$i]['answers']); $k++){
						//Comprobamos si la respuesta $k de la pregunta $i está entre las respuestas del usuario
						if(in_array($questionsResultados[$i]['answers'][$k]['answer'], $answer)){
							//La respuesta marcada por el usuario es correcta
							if(in_array($questionsResultados[$i]['answers'][$k]['answer'], $questionsResultados[$i]['okanswers'])){
								$content .= $questionsResultados[$i]['answers'][$k]['answer']. '<br>'; //ELIMINAR ?
							}else{
								$content .= $questionsResultados[$i]['answers'][$k]['answer']. '<br>'; //ELIMINAR ?
								$markFail = true;
							}

						}else{
							//$content .= $questionsResultados[$i]['answers'][$k]['answer']. '<br>';
							//La respuesta era correcta pero el usuario no la había seleccionado
							if(in_array($questionsResultados[$i]['answers'][$k]['answer'], $questionsResultados[$i]['okanswers'])){
								$markFail = true;
							}

						}

						if($questionsResultados[$i]['okanswers'] == array()){$markFail = false;}					
					
					}

					//parte que añade los resultados a resultadosExamen

					for($j = 0; $j < sizeof($question["answer"]); $j++){
				
						for($k = 0; $k < sizeof($questionsResultados[$i]['answers']); $k++){

							if($questionsResultados[$i]['answers'][$k]['answer'] == $answer[$j]){
								//Obtain how many answers has the response
								$sizeCB = sizeof($questionsResultados[$i]['answers'][$k]['votes']['guidVotes']);
								$questionsResultados[$i]['answers'][$k]['votes']['guidVotes'][$sizeCB] = $respuesta->owner_guid;
								$questionsResultados[$i]['answers'][$k]['votes']['value']++;
							}				
						} 
					}
				}
				
				//echo("Valor de markFail " . $numQ . "---" . $markFail);
				//Añadir la nota
				if($markFail){
					$mark -= (double)$questionsResultados[$i]['fail'];
				}else{
					$mark += (double)$questionsResultados[$i]['success'];
				}

				//echo("Nota en la pregunta " . $numQ . "---" . $mark);

				$content .= '</div>';

				break;

			case "Radio":
				$content .= '<div> <h3>'.$title.'</h3>';

				if($answer == "" || $answer == NULL){
					$content.=  elgg_echo('encuestas_examenes:no_answer').'<br>';
					$markFail = true; //EN CASO DE AÑADIR LA OPCION DE QUE RESPUESTAS VACÍAS NO RESTAN NOTAS, QUITAR
				}else{
					//Parte que muestra el resultado al usuario
					for($k = 0; $k < sizeof($questionsResultados[$i]['answers']); $k++){
						//Comprobamos si la respuesta $k de la pregunta $i es la respuesta del usuario
						if($questionsResultados[$i]['answers'][$k]['answer'] == $answer){
							//Comprobamos si la respuesta seleccionada es correcta
							if(in_array($questionsResultados[$i]['answers'][$k]['answer'], $questionsResultados[$i]['okanswers'])){
								$content .= $questionsResultados[$i]['answers'][$k]['answer']. '<br>'; //ELIMINAR ?
							}else{
								$content .= $questionsResultados[$i]['answers'][$k]['answer']. '<br>'; //ELIMINAR ?
								$markFail = true;
							}

						}else{
							//$content .= $questionsResultados[$i]['answers'][$k]['answer']. '<br>'; //ELIMINAR ?
							//La respuesta era correcta pero el usuario no la había seleccionado
							if(in_array($questionsResultados[$i]['answers'][$k]['answer'], $questionsResultados[$i]['okanswers'])){
								$markFail = true;
							}

						}					
					
					}

					if($questionsResultados[$i]['okanswers'] == array()){$markFail = false;}	

					for($k = 0; $k < sizeof($questionsResultados[$i]['answers']); $k++){
						//echo(var_dump($questionsResultados[$i]['answers'][$k]['answer']));
						if($questionsResultados[$i]['answers'][$k]['answer'] == $answer){
							//Obtain how many answers has the response
							$sizeR = sizeof($questionsResultados[$i]['answers'][$k]['votes']['guidVotes']);
							$questionsResultados[$i]['answers'][$k]['votes']['guidVotes'][$sizeR] = $respuesta->owner_guid;
							$questionsResultados[$i]['answers'][$k]['votes']['value']++;
						
						}				
					} 

				}
				//echo("Valor de markFail " . $numQ . "---" . $markFail);

				//Añadir la nota
				if($markFail){
					$mark -= (double)$questionsResultados[$i]['fail'];
				}else{
					$mark += (double)$questionsResultados[$i]['success'];
				}
				//echo("Nota en la pregunta " . $numQ . "---" . $mark);

				$content .= '</div>';
				break;

			case "Text":
			
				$content.= '<div> <h3>'.$title.'</h3>';			

				if($answer == ""){
					$content.= elgg_echo('encuestas_examenes:no_answer').'<br>';
					$markFail = true; //EN CASO DE AÑADIR LA OPCION DE QUE RESPUESTAS VACÍAS NO RESTAN NOTAS, QUITAR	
				}else{
					$content .=	$answer;
				
					if($questionsResultados[$i]['okanswers'][0] != ""){
						$regex = $questionsResultados[$i]['regex'];

						if($regex == 'SI'){
							if(!preg_match('/'. $questionsResultados[$i]['okanswers'][0] .'/i', $answer)){
								$markFail = true;
							}
						}else{
							if($questionsResultados[$i]['okanswers'][0] != $answer){
								$markFail = true;
							}
						}
					}

					//Obtain how many answers has the question
					$qSize = sizeof($questionsResultados[$i]['answers']);

					$questionsResultados[$i]['answers'][$qSize] = array(
						"answerT" => $answer,
						"guidVote" => $respuesta->owner_guid,
					);
			
				}	

				//Añadir la nota
				if($markFail){
					$mark -= (double)$questionsResultados[$i]['fail'];
				}else{
					$mark += (double)$questionsResultados[$i]['success'];
				}
				$content .= '</div>';

				break;

			case "Long Text":

				$content.= '<div> <h3>'.$title.'</h3>';			

				if($answer == ""){
					$content.= elgg_echo('encuestas_examenes:no_answer').'<br>';
					$markFail = true; //EN CASO DE AÑADIR LA OPCION DE QUE RESPUESTAS VACÍAS NO RESTAN NOTAS, QUITAR		
				}else{
					$content .=	$answer;
				
					if($questionsResultados[$i]['okanswers'][0] != ""){
						//$regex = $questionsResultados[$i]['regex'];

						//if($regex == 'SI'){
						//	if(!preg_match('/'. $questionsResultados[$i]['okanswers'][0] .'/i', $answer)){
								//$markFail = true;
						//	}
						//}else{
							if($questionsResultados[$i]['okanswers'][0] != $answer){
								$markFail = true;
							}
						//}
					}

					//Obtain how many answers has the question
					$qSize = sizeof($questionsResultados[$i]['answers']);
					$questionsResultados[$i]['answers'][$qSize] = array(
						"answerLT" => $answer,
						"guidVote" => $respuesta->owner_guid,
					);
				}

				//Añadir la nota
				if($markFail){
					$mark -= (double)$questionsResultados[$i]['fail'];
				}else{
					$mark += (double)$questionsResultados[$i]['success'];
				}
				$content .= '</div>';
				break;


		}

		$content .= '<br>';

	} 

	//$resultados->resultados_totales++; 
	$resultados->questions_examen = serialize($questionsResultados);
	$resultados->save();

	$respuesta->nota = $mark;
	$respuesta->save();

if($resultados-> seeResults != "seeNothing"){
	if($examen->passScore != ""){
		if($mark < (double)$examen->passScore){
			if($mark < 0) $mark = 0;
			$content.= '<br><div> <h3>'.elgg_echo('encuestas_examenes:my_score').$mark. elgg_echo('encuestas_examenes:not_passed').'</h3></div>';			
		}else{
			//if($mark > 10) $mark = (double)$examen->maxScore;
			$content.= '<br><div> <h3>'.elgg_echo('encuestas_examenes:my_score').$mark.elgg_echo('encuestas_examenes:passed').'</h3></div>';
		}	
	}else{
		$content.= '<br><div> <h3>'.elgg_echo('encuestas_examenes:my_score').$mark.'</h3></div>';
	}
	if($resultados-> seeResults == "seeMarkCorrection"){
				$content .= '<br><a href="/encuestas_examenes/correction/'. $guid .'">'.elgg_echo('encuestas_examenes:see_correction').'</a>';
	}
}

//}

$params = array(
   'title' => $respuesta->title,
   'content' => $content,
   'filter' => '',
);


$body .= elgg_view_layout('content', $params);

echo elgg_view_page($titlebar, $body);


