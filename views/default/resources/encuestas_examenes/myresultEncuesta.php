<?php

$guid = elgg_extract('guid', $vars);
$voto = get_entity($guid);

$encuesta = get_entity($voto->encuesta);
$resultados = get_entity($voto->resultados);

$pagetitle = $encuesta->tittle;

$body .= elgg_view_title($pagetitle); 

$questions = unserialize($voto->questions);
$questionsEncuesta = unserialize($encuesta->questions);

$questionsResultados = unserialize($resultados->questions_encuesta);

//Obtener la variable para comprobar si ya se ha enviado una respuesta de esta encuesta. '0' = NO ESTÁ RESPONDIDO TODAVÍA
$resend = $encuesta-> resendParams; //oneSend, multipleSend o specialSend
$votosEnviadas = unserialize($resultados->respuestas_enviadas); //Pares [guid] => númeroDeEnvíosDeEsteGuid

	//Si se permiten varias respuestas del mismo usuario, en primer lugar se borran los resultados anteriores del objeto resultadosEncuesta
	if($resend != 'oneSend' && array_key_exists(elgg_get_logged_in_user_entity()->guid, $votosEnviadas)){
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

		$title = $questionsEncuesta[$i]['qTittle'];

		switch($qType){
			case "Checkboxes":
				$content .= '<div> <h3>'.$title.'</h3>';
			
				if($question["answer"] == "0"){
					$content.= elgg_echo('encuestas_examenes:no_answer').'<br>';
				}else{
					//Parte que muestra el resultado al usuario
					for($k = 0; $k < sizeof($questionsResultados[$i]['answers']); $k++){
						//Comprobamos si la respuesta $k de la pregunta $i está entre las respuestas del usuario
						if(in_array($questionsResultados[$i]['answers'][$k]['answer'], $answer)){
							$content .= $questionsResultados[$i]['answers'][$k]['answer']. '<br>';
						}

					}

					//parte que añade los resultados a resultadosEncuesta

					for($j = 0; $j < sizeof($question["answer"]); $j++){
				
						for($k = 0; $k < sizeof($questionsResultados[$i]['answers']); $k++){

							if($questionsResultados[$i]['answers'][$k]['answer'] == $answer[$j]){
								//Obtain how many answers has the response
								$sizeCB = sizeof($questionsResultados[$i]['answers'][$k]['votes']['guidVotes']);
								$questionsResultados[$i]['answers'][$k]['votes']['guidVotes'][$sizeCB] = $voto->owner_guid;
								$questionsResultados[$i]['answers'][$k]['votes']['value']++;
							}				
						} 
					}
				}

				$content .= '</div>';

				break;

			case "Radio":
				$content .= '<div> <h3>'.$title.'</h3>';

				if($answer == "" || $answer == NULL){
					$content.=  elgg_echo('encuestas_examenes:no_answer').'<br>';
				}else{
					//Parte que muestra el resultado al usuario
					for($k = 0; $k < sizeof($questionsResultados[$i]['answers']); $k++){
						//Comprobamos si la respuesta $k de la pregunta $i es la respuesta del usuario
						if($questionsResultados[$i]['answers'][$k]['answer'] == $answer){
							$content .= $questionsResultados[$i]['answers'][$k]['answer']. '<br>';
						}					
					}

					for($k = 0; $k < sizeof($questionsResultados[$i]['answers']); $k++){
						//echo(var_dump($questionsResultados[$i]['answers'][$k]['answer']));
						if($questionsResultados[$i]['answers'][$k]['answer'] == $answer){
							//Obtain how many answers has the response
							$sizeR = sizeof($questionsResultados[$i]['answers'][$k]['votes']['guidVotes']);
							$questionsResultados[$i]['answers'][$k]['votes']['guidVotes'][$sizeR] = $voto->owner_guid;
							$questionsResultados[$i]['answers'][$k]['votes']['value']++;
						
						}				
					} 

				}

				$content .= '</div>';
				break;

			case "Text":
			
				$content.= '<div> <h3>'.$title.'</h3>';			

				if($answer == ""){
					$content.= elgg_echo('encuestas_examenes:no_answer').'<br>';	
				}else{
					$content .=	$answer;

					//Obtain how many answers has the question
					$qSize = sizeof($questionsResultados[$i]['answers']);

					$questionsResultados[$i]['answers'][$qSize] = array(
						"answerT" => $answer,
						"guidVote" => $voto->owner_guid,
					);

					//echo(var_dump($qSize));			
				}	

				$content .= '</div>';

				break;

			case "Long Text":

				$content.= '<div> <h3>'.$title.'</h3>';			

				if($answer == ""){
					$content.= elgg_echo('encuestas_examenes:no_answer').'<br>';	
				}else{
					$content .=	$answer;

					//Obtain how many answers has the question
					$qSize = sizeof($questionsResultados[$i]['answers']);
					$questionsResultados[$i]['answers'][$qSize] = array(
						"answerLT" => $answer,
						"guidVote" => $voto->owner_guid,
					);
				}

				$content .= '</div>';
				break;


		}

		$content .= '<br>';

	} 

	$resultados->questions_encuesta = serialize($questionsResultados);
	$resultados->save();


$params = array(
   'title' => $voto->title,
   'content' => $content,
   'filter' => '',
);


$body .= elgg_view_layout('content', $params);

echo elgg_view_page($titlebar, $body);



/*echo('VOTO: <br>');
echo(var_dump($voto->title));
echo('<br>');
echo(var_dump($voto->encuesta));
echo('<br>');
echo(var_dump($voto->resultados));
echo('<br>');
echo(var_dump(unserialize($voto->questions)));
echo('<br>');
echo(var_dump($voto->access_id));
echo('<br>');
echo(var_dump($voto->owner_guid));*/
