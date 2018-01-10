<?php

$results_guid = elgg_extract('guid', $vars);
$resultsEncuesta = get_entity($results_guid);

$body = elgg_list_entities(array(
    'type' => 'object',
    'subtype' => 'resultsEncuesta',
));

$resTotal = $resultsEncuesta->resultados_totales;

if(isset($resultsEncuesta) && $resTotal != 0){

$questions = unserialize($resultsEncuesta->questions_encuesta);


//echo(var_dump($resTotal)); 

for($i = 0; $i < sizeof($questions); $i++){
	$numQ = $i+1;
	$nomQ = 'Pregunta'.$numQ;
	$question = $questions[$i];
	$qType = $question["type"];

	switch($qType){
		case "Checkboxes":

			$content .= '<div><h3>'.$question["qTittle"].'</h3>';

			for($j = 0; $j < sizeof($question["answers"]); $j++){
				$res = $question["answers"][$j]['votes']['value'];
				//echo($res);
				$per = ($res * 100)/$resTotal;
				$per=round($per*100);
				$per=$per/100; 	
				$content.= $question["answers"][$j]['answer']. '(' . $res .'-'. $per .'%)'.'</br>';
				$content .= '<div class="poll-progress"> <div class="poll-progress-filled" style="width:'.$per.'%"></div></div>';	
			}

			$content .= '</div>';
			break;

		case "Radio":
			
			
			
			$content .= '<div><h3>'.$question["qTittle"].'</h3>';

			for($j = 0; $j < sizeof($question["answers"]); $j++){
				$res = $question["answers"][$j]['votes']['value'];
				$per = ($res * 100)/$resTotal;
				$per=round($per*100);
				$per=$per/100; 	
				$content.= $question["answers"][$j]['answer']. '(' . $res .'-'. $per .'%)'.'</br>';
				$content .= '<div class="poll-progress"> <div class="poll-progress-filled" style="width:'.$per.'%"></div></div>';			
			}

			$content .= '</div>';
			break;

		case "Text":
			$content .= '<div><h3>'.$question["qTittle"].'</h3>';
			if(sizeof($question['answers'])  == 0){
				$content.= elgg_echo('encuestas_examenes:no_answer').'</br>';	
			}else{
				for($j = 0; $j < sizeof($question['answers']); $j++){
					$content .= '<li> - '. $question['answers'][$j]['answerT'] .'</li><br>';
				}
			}


			$content .= '</div>';
			break;

		case "Long Text":
			$content .= '<div><h3>'.$question["qTittle"].'</h3>';
			if(sizeof($question['answers'])  == 0){
				$content.= elgg_echo('encuestas_examenes:no_answer').'</br>';	
			}else{
				for($j = 0; $j < sizeof($question['answers']); $j++){
					$content .= '<li> - '. $question['answers'][$j]['answerLT'] .'</li><br>';
				}
			}


			$content .= '</div>';
			break;


	}

	$content .= '<br>';
}

//Crear fichero .csv

// arbitrary file on the filestore
$file = new ElggFile();
$file->owner_guid = 7777;
$file->setFilename('encuestas/encuesta.csv');

$file->open('write');

$header = "usuario;";
foreach($questions as $q){
	$header .= $q['qTittle'] .";";
}
$header .= "\n";

$file->write($header);
$csv_body = '';
$respuestas_enviadas = unserialize($resultsEncuesta->respuestas_enviadas);
foreach($respuestas_enviadas as $key=>$r){
	$csv_body .= get_user($key)->username . ';';
	//Recuperamos las respuestas anteriores del examen
	$respuestas_anteriores = elgg_get_entities_from_metadata(array(
		'types'=>'object',
		'subtypes'=>'voto',
		'metadata_names' =>array('resultados'),
		'metadata_values' =>array($results_guid),
		'owner_guid'=> $key,
	));
	$answers_anteriores = unserialize($respuestas_anteriores[0]->questions);
	//echo(var_dump($respuestas_anteriores).'<br><br>');
	foreach($answers_anteriores as $a_a){

		if(is_array($a_a['answer'])){
			$csv_body .= implode(",",$a_a['answer']) . ';';
		}else{
			$csv_body .= $a_a['answer']. ';';
		}

	}
	$csv_body .= "\n";
}
$file->write($csv_body);

$file->close();


elgg_register_menu_item('title', array(
	'name' => 'csvEncuesta',
	'href' => elgg_get_download_url($file),
	'text' => elgg_echo('encuestas_examenes:csv'),
	'link_class' => 'elgg-menu-content',
));


}else{
	$content.= elgg_echo('encuestas_examenes:no_answers_yet');
	//echo(var_dump($resTotal));	
}

$params = array(
    'title' => $resultsEncuesta->title . '(' . $resTotal. ')',
    'content' => $content,
    'filter' => '',
);


$body .= elgg_view_layout('content', $params);

echo elgg_view_page($titlebar, $body);
