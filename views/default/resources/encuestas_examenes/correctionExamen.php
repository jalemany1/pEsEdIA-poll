<?php 

$guid = elgg_extract('guid', $vars);
$respuesta = get_entity($guid);
$resultados = get_entity($respuesta->resultados);

$questions = unserialize($respuesta->questions);
$questionsResultados = unserialize($resultados->questions_examen);

if($resultados-> seeResults == "seeMarkCorrection"){
	for($i = 0; $i < sizeof($questions); $i++){
		$numQ = $i+1;
		$question = $questions[$i];
		$qType = $question["type"];
		$answer = $question["answer"];

		$title = $questionsResultados[$i]['qTittle'];

		//$markFail = false;

		switch($qType){
			case "Checkboxes":
				$content .= '<div> <h3>'.$title.'</h3>';
			
				if($question["answer"] == "0"){
						$content.= elgg_echo('encuestas_examenes:no_answer') .'<br>';	
				}else{
					//Parte que muestra el resultado al usuario
					for($k = 0; $k < sizeof($questionsResultados[$i]['answers']); $k++){

						if(in_array($questionsResultados[$i]['answers'][$k]['answer'], $answer)){
							if(in_array($questionsResultados[$i]['answers'][$k]['answer'], $questionsResultados[$i]['okanswers']) || $questionsResultados[$i]['okanswers'] == array()){
								$content .= $questionsResultados[$i]['answers'][$k]['answer'];
								$content .= elgg_view_icon('checkmark-hover') . '<br>';
								//echo('Estoy en no correcta y mi respuesta no es la respuesta actual');
							}else{
								$content .= $questionsResultados[$i]['answers'][$k]['answer'];
								$content .= elgg_view_icon('delete-hover') . '<br>';
							}


						}else{
							$content .= $questionsResultados[$i]['answers'][$k]['answer'];
							if(in_array($questionsResultados[$i]['answers'][$k]['answer'], $questionsResultados[$i]['okanswers']) || $questionsResultados[$i]['okanswers'] == array()){
								$content .= elgg_view_icon('checkmark-hover') . '<br>';
							}
						}					
					
					}
				}
				$content .= '</div>';

				break;

			case "Radio":
				$content .= '<div> <h3>'.$title.'</h3>';

				if($question["answer"] == "0"  || $answer == NULL){
						$content.= elgg_echo('encuestas_examenes:no_answer') .'<br>';	
				}else{
					//Parte que muestra el resultado al usuario
					for($k = 0; $k < sizeof($questionsResultados[$i]['answers']); $k++){

						if($questionsResultados[$i]['answers'][$k]['answer'] == $answer){
							if(in_array($questionsResultados[$i]['answers'][$k]['answer'], $questionsResultados[$i]['okanswers'])  || $questionsResultados[$i]['okanswers'] == array()){
								$content .= $questionsResultados[$i]['answers'][$k]['answer'];
								$content .= elgg_view_icon('checkmark-hover') . '<br>';
								//echo('Estoy en no correcta y mi respuesta no es la respuesta actual');
							}else{
								$content .= $questionsResultados[$i]['answers'][$k]['answer'];
								$content .= elgg_view_icon('delete-hover') . '<br>';
							}


						}else{
							$content .= $questionsResultados[$i]['answers'][$k]['answer'];
							if(in_array($questionsResultados[$i]['answers'][$k]['answer'], $questionsResultados[$i]['okanswers'])  || $questionsResultados[$i]['okanswers'] == array()){
								$content .= elgg_view_icon('checkmark-hover') . '<br>';
							}
						}					
					
					}
				}
				$content .= '</div>';
			
				break;

			case "Text":
			
				$content.= '<div> <h3>'.$title.'</h3>';			

				if($answer == ""){
					$content.= elgg_echo('encuestas_examenes:no_answer') .'<br>';	
				}else{
					$content .=	$answer;
				
					if($questionsResultados[$i]['okanswers'][0] == ""){
						$content .= elgg_view_icon('checkmark-hover') . '<br>';
					}else{
						$regex = $questionsResultados[$i]['regex'];

						if($regex == 'SI'){
							if(preg_match('/'. $questionsResultados[$i]['okanswers'][0] .'/i', $answer)){
								$content .= elgg_view_icon('checkmark-hover') . '<br>';
							}else{
								$content .= elgg_view_icon('delete-hover') . '<br>';
								$content .= elgg_echo('encuestas_examenes:ok_answer_regex') . $questionsResultados[$i]['okanswers'][0];
							}
						}else{
							if($questionsResultados[$i]['okanswers'][0] == $answer){
								$content .= elgg_view_icon('checkmark-hover') . '<br>';	
							}else{
								$content .= elgg_view_icon('delete-hover') . '<br>';
								$content .= elgg_echo('encuestas_examenes:ok_answer'). $questionsResultados[$i]['okanswers'][0];	
							}
						}
					}
				}

				$content .= '</div>';

				break;

			case "Long Text":

				$content.= '<div> <h3>'.$title.'</h3>';			

				if($answer == ""){
					$content.= elgg_echo('encuestas_examenes:no_answer') .'<br>';	
				}else{
					$content .=	$answer;
				
					if($questionsResultados[$i]['okanswers'][0] == ""){
						$content .= elgg_view_icon('checkmark-hover') . '<br>';
					}else{
						//$regex = $questionsResultados[$i]['regex'];

						//if($regex == 'SI'){
							//if(preg_match('/'. $questionsResultados[$i]['okanswers'][0] .'/i', $answer)){
								//$content .= elgg_view_icon('checkmark-hover') . '<br>';
							//}else{
								//$content .= elgg_view_icon('delete-hover') . '<br>';
								//$content .= 'Respuesta correcta (expresión regular): ' . $questionsResultados[$i]['okanswers'][0];
							//}
						//}else{
							if($questionsResultados[$i]['okanswers'][0] == $answer){
								$content .= elgg_view_icon('checkmark-hover') . '<br>';	
							}else{
								$content .= elgg_view_icon('delete-hover') . '<br>';
								$content .= elgg_echo('encuestas_examenes:ok_answer') . $questionsResultados[$i]['okanswers'][0];	
							}
						//}
					}
				}

				$content .= '</div>';
				break;

		}
				$content .= '<br>';

	}
}


$examen = get_entity($respuesta->examen);
$mark = $respuesta->nota; 

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
}
$params = array(
    'title' => elgg_echo('encuestas_examenes:correction_title').$respuesta->title,
    'content' => $content,
    'filter' => '',
);


$body .= elgg_view_layout('content', $params);

echo elgg_view_page($titlebar, $body);

	
//echo(var_dump($questions));
//echo('<br><br>');	
//echo(var_dump($questionsResultados));
