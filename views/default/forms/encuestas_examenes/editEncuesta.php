<?php

elgg_require_js('encuestas_examenes/editEncuesta');

// get the entity
$guid = elgg_extract('guid', $vars);
$encuesta = get_entity($guid);

$resultados_guid = $encuesta->resultadosguid;
$resultados = get_entity($resultados_guid);


//CONFIGURACIÓN

echo elgg_view('input/hidden', ['name' => 'guid_encuesta', 'value'=>$guid]);

$title = elgg_format_element('label', ['for' => 'title'], elgg_echo('encuestas_examenes:titulo'));
$title .= elgg_view('input/text', ['name' => 'title', 'id' => 'title', 'required'=>'required', 'class'=>'container-margin', 'value' => $encuesta->title]);
$conf = elgg_format_element('div', [], $title)  . '<br>';

$description = elgg_format_element('label', ['for' => 'description'], elgg_echo('encuestas_examenes:descripcion_examen'));
$description .= elgg_view('input/longtext', ['name' => 'description', 'id' => 'description', 'class'=>'container-margin', 'value'=>$encuesta->description]);
$conf .= elgg_format_element('div', [], $description) . '<br>'; 


$time = elgg_view('input/hidden', ['name' => 'nowlocal', 'id' => 'nowlocal']);

$cecked_publishNow = false;
if($encuesta->publishNow == 'publishNow'){
	$cecked_publishNow = true; 
}

$time .= elgg_format_element('label', ['for' => 'time'], elgg_echo('encuestas_examenes:duration_config')) . '<br>';
$time .= elgg_view('input/checkbox', ['name' => 'publishExamNow', 'value' => 'publishNow','label' => elgg_echo('encuestas_examenes:publishNow'), 'id' => 'publishExamNow', 'checked' => $cecked_publishNow]) . '<br>';

$start_date = "";
$start_h ="";
$start_m="";
if(!$cecked_publishNow){
	$start_date = date('Y-m-d', $encuesta->start);
	$start_h = date('H', $encuesta->start);
	$start_m = date('i', $encuesta->start); //El resultado se ve con un solo 0, podría arreglarse
}
//echo(date('Y-m-d', $encuesta->start));
$time .= elgg_format_element('label', ['for' => 'dateInicio', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:start_date'));
$time .= elgg_view('input/date', array('name' => 'dateInicio[]', 'class'=>'parameters-box', 'id'=>'dateInicio', 'value'=>$start_date)) . '<br>';

$time .= elgg_format_element('label', ['for' => 'timeInicioHora', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:start_time'));
	$time .= elgg_view('input/text', array('name' => 'timeInicioHora', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '23', 'id'=>'dateInicioHora', 'value'=>$start_h)) . ':';
	$time .= elgg_view('input/text', array('name' => 'timeInicioMin', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '60', 'id'=>'dateInicioMin', 'value'=>$start_m)) . '<br>';

$cecked_noEndDate = false;
if($encuesta->noEndDate == 'noEndDate'){
	$cecked_noEndDate = true; 
}
$time .= elgg_view('input/checkbox', ['name' => 'noEndDate', 'value' => 'noEndDate','label' => elgg_echo('encuestas_examenes:noEndDate'), 'id' => 'noEndDate', 'checked'=>$cecked_noEndDate]) . '<br>';

$end_date = "";
$end_h ="";
$end_m="";
if(!$cecked_noEndDate){
	$end_date = date('Y-m-d', $encuesta->end);
	$end_h = date('H', $encuesta->end);
	$end_m = date('i', $encuesta->end); //El resultado se ve con un solo 0, podría arreglarse
}
$time .= elgg_format_element('label', ['for' => 'dateFin', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:end_date'));
	$time .= elgg_view('input/date', array('name' => 'dateFin[]', 'class'=>'parameters-box', 'id' => 'dateFin', 'value'=> $end_date)) . '<br>';

$time .= elgg_format_element('label', ['for' => 'timeFinHora', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:end_time'));
	$time .= elgg_view('input/text', array('name' => 'timeFinHora', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '23', 'id' => 'timeFinHora', 'value'=> $end_h)) . ':';
	$time .= elgg_view('input/text', array('name' => 'timeFinMin', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '60', 'id' => 'timeFinMin', 'value'=> $end_m)) . '<br>';

$cecked_noDuration = false;
if($encuesta->noDuration == 'noDuration'){
	$cecked_noDuration = true; 
}
	$time .= elgg_view('input/checkbox', ['name' => 'noDuration', 'value' => 'noDuration','label' => elgg_echo('encuestas_examenes:noDuration'), 'id' => 'noDuration', 'checked'=>$cecked_noDuration]) . '<br>';

$duration = "";
if(!$cecked_noDuration){
	$duration = $encuesta->duration; 
}

$time .= elgg_format_element('label', ['for' => 'duration', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:duration'));
$time .= elgg_view('input/text', array('name' => 'duration', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'id' => 'duration', 'value'=>$duration)) . elgg_echo('encuestas_examenes:min') .'<br>';

$cecked_automaticSend = false;
if($encuesta->automaticSend == 'YES'){
	$cecked_automaticSend = true; 
}
$time .= elgg_view('input/checkbox', ['name' => 'automaticSend', 'value' => 'YES','label' => elgg_echo('encuestas_examenes:automaticSend'), 'id' => 'automaticSend', 'checked'=>$cecked_automaticSend]) . '<br>';


$confTime['name'] = 'time';
$conf .= elgg_format_element('div', $confTime, $time) . '<br>'; 

$numResend = $encuesta->resendParams;

$resend .= elgg_format_element('label', ['for' => 'resend'], elgg_echo('encuestas_examenes:resend')) . '<br>';

$resend .= '<br><p class="elgg-subtext">'.elgg_echo('encuestas_examenes:edit_restart_note_encuesta').'</p>';

$resend .= elgg_view('input/radio', ['name' => 'resendParams', 'id' => 'resendParams', 'options' => array(elgg_echo('encuestas_examenes:oneSend') => 'oneSend', elgg_echo('encuestas_examenes:multipleSend') => 'multipleSend', elgg_echo('encuestas_examenes:specialSend') => 'specialSend'), 'value' => $numResend, 'class'=>'parameters-label']);

$resend .= elgg_format_element('label', ['for' => 'customResend', 'class'=>'parameters-label', 'id'=> 'customResendLabel'], elgg_echo('encuestas_examenes:customResend'));
$resend .= elgg_view('input/text', array('name' => 'customResend', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '1', 'id' => 'customResend', 'value'=> $resultados->num_respuestas_enviadas));

$confResend['name'] = 'resend';
$conf .= elgg_format_element('div', $confResend, $resend)  . '<br>';


/*$seeResults = elgg_format_element('label', ['for' => 'seeResults'], elgg_echo('encuestas_examenes:seeResults')) . '<br>';
$seeResults .= elgg_view('input/radio', ['name' => 'seeResultsParams', 'id' => 'seeResultsParams', 'options' => array(elgg_echo('encuestas_examenes:seeMark') => 'seeMark', elgg_echo('encuestas_examenes:seeMarkCorrection') => 'seeMarkCorrection', elgg_echo('encuestas_examenes:seeNothing') => 'seeNothing'), 'value' => $resultados->seeResults, 'class'=>'parameters-label']);

$seeResultsConf['name'] = 'seeResults';
$conf .= elgg_format_element('div', $seeResultsConf, $seeResults)  . '<br>'; 

$score =  elgg_format_element('label', ['for' => 'score'], elgg_echo('encuestas_examenes:score_params'));
$score .= '<p class="elgg-subtext">'. elgg_echo('encuestas_examenes:score_notes').'</p>';

$score .= elgg_format_element('label', ['for' => 'passScore', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:passScore'));
$score .= elgg_view('input/text', ['name' => 'passScore', 'id' => 'passScore', 'type' => 'number', 'min' => '0', 'max'=>'10', 'placeholder'=>'0', 'style'=>'width:10%', 'step' =>'0.01', 'value'=> $encuesta->passScore]);

$conf .= elgg_format_element('div', [], $score) . '<br>';*/

$cecked_emptyResults = false;
if($encuesta->emptyResults == 'NO'){
	$cecked_emptyResults = true; 
}

$emptyResults .= elgg_view('input/checkbox', ['name' => 'emptyResults', 'value' => 'NO','label' => elgg_echo('encuestas_examenes:emptyResults'), 'id' => 'emptyResults', 'checked'=>$cecked_emptyResults]) . '<br>';
$conf .= elgg_format_element('div', [], $emptyResults). '<br>'; 


$access = elgg_format_element('label', ['for' => 'access'], elgg_echo('encuestas_examenes:access'));
$access .= elgg_view('input/access', ['name' => 'access', 'options_values' => array('0'=>elgg_echo('encuestas_examenes:privado'), '-2'=>elgg_echo('encuestas_examenes:amigos'),'1'=>elgg_echo('encuestas_examenes:ausuarios_autenticados'),'2'=>elgg_echo('encuestas_examenes:publico')), 'value'=>$encuesta->access_id]);
$conf .= elgg_format_element('div', [], $access) ; 


$next = elgg_view_icon('arrow-right', ['class' => 'next']);
$conf .= elgg_format_element('div', [], $next);

$optConf['id'] = 'configuracion';

echo elgg_format_element('div', $optConf, $conf); 

//FIN CONFIGURACIÓN

//PREGUNTAS - RECUPERACIÓN DE DATOS DEL EXAMEN
$encuesta_questions = unserialize($resultados->questions_encuesta);
$encuesta_obtain_required = unserialize($encuesta->questions);

$qnumber = count($encuesta_questions);
$questionType .= '<br><p class="elgg-subtext req">'.elgg_echo('encuestas_examenes:modify_answers_note_encuesta').'</p>';

$nq = 1;
foreach($encuesta_questions as $q_key=>$q){

	// Question
	$questionIndividual = elgg_view_icon('delete', ['class' => 'elgg-discoverable delete-question']) . '<br>';
	$questionIndividual .= elgg_format_element('label', ['for' => 'questionType'.$nq, 'class' => 'labelTitulo'], elgg_echo('encuestas_examenes:qType_label'));
	$questionIndividual .= elgg_view('input/dropdown', ['name' => 'questionType'.$nq, 'options_values' => array('Checkboxes'=>elgg_echo('encuestas_examenes:checkboxes'), 'Radio'=>elgg_echo('encuestas_examenes:radio'), 'Text'=>elgg_echo('encuestas_examenes:text'), 'Long Text'=>elgg_echo('encuestas_examenes:long_text')), 'id' => 'questionType'.$nq, 'class' => 'questionType parameters-box', 'value' => $q['type']]);
	$questionIndividual .= elgg_view('input/hidden', ['name' => 'qType'.$nq, 'value' => $q['type'], 'class' => 'qType', 'id' => 'qType'.$nq]);
	$questionIndividual .= elgg_view('input/text', ['name' => 'Pregunta' . $nq, 'id' => 'Qtitle'.$nq, 'class' => 'Qtitle container-margin', 'placeholder' => 'Pregunta' . $nq, 'required'=>'required', 'value'=>$q['qTittle']]);

	// Answers
	$nr = 1;
	$qIndividual = '';
	if($q['type'] == "Radio" || $q['type'] == "Checkboxes") {
		$answers = $q['answers'];
		$nanswers = count($answers);
		
		foreach($answers as $key => $a){
			$rname = 'q' . $nq . 'r' . $nr;  
			
			$answer_fields = '<br>' . elgg_view('input/text', [
				'name' => $rname,
				'class' => ['resp_rec' . $nr, 'answ-css'],
				'value' => $a['answer'],
			]); 

			$lastR = ($nr == $nanswers) ? 'lastR' : 'answ';
			$li_options = ['data-index' => $nr];
			$li_options += ['data-numQuestion' => $nq];
			$li_options['class'] = $lastR;
			$qIndividual .= elgg_format_element('li', $li_options, $answer_fields);
			
			$nr++;
		}
	}
	if($qIndividual == '') {
		$rname = 'q' . $nq . 'r' . $nr;
		$answer_fields = '<br>' . elgg_view('input/text', [
			'name' => $rname,
			'placeholder' => elgg_echo('encuestas_examenes:respuesta') . $nr,
			'class' => 'answ-css',
		]); 

		$li_options = ['data-index' => $nr];
		$li_options += ['data-numQuestion' => $nq];
		$li_options['class'] = ['lastR', 'hidden'];
		$questionIndividual .= elgg_format_element('li', $li_options, $answer_fields);
	} else {
		$questionIndividual .= $qIndividual;
	}

	$req = ($encuesta_obtain_required[$q_key]["required"] == 'NO') ? true : false;	
	$required = elgg_view('input/checkbox', ['name' => 'requiredQ' . $nq, 'value' => 'NO','label' => elgg_echo('encuestas_examenes:required'), 'checked' => $req]) . '<br>';
	$questionIndividual .= elgg_format_element('div', ['class' => 'divReq'], $required) . '<br>';

	
	$lastQ = ($nq == $qnumber) ? 'lastQ' : '';
	$div_options = ['data-numQ' => $nq];
	$div_options['class'] = [$lastQ, 'question', 'elgg-discover'];

	$questionType .= elgg_format_element('div', $div_options, $questionIndividual);

	$nq++;
}
//FIN PREGUNTAS - RECUPERACIÓN DE DATOS DEL EXAMEN

$preguntas = elgg_format_element('div', [] , $questionType);

//NEW
$preguntas .= elgg_view('input/button', ['name' => 'newQ', 'value' => elgg_echo('encuestas_examenes:new'), 'class' => 'new elgg-button-submit', 'id' => 'new'.($nq-1)]);
$preguntas .= elgg_view('input/hidden', ['name' => 'numQuestions', 'value' => $qnumber, 'id' => 'numQuestions']);

$submit =  elgg_view('input/submit', ['value' => elgg_echo('encuestas_examenes:save'), 'class' => 'submitSave']);
$preguntas .= elgg_format_element('div', [], $submit) . '<br>';

$back = elgg_view_icon('arrow-left', ['class' => 'back']);
$preguntas .= elgg_format_element('div', [], $back);  
	 
$optConf['id'] = 'preguntas';
$optConf['class'] = 'hidden';
echo elgg_format_element('div', $optConf, $preguntas);