<?php

elgg_require_js('encuestas_examenes/saveExamen');
elgg_load_css('mycss');


//CONFIGURACIÓN

$title = elgg_format_element('label', ['for' => 'title'], elgg_echo('encuestas_examenes:titulo'));
$title .= elgg_view('input/text', ['name' => 'title', 'id' => 'title', 'required'=>'required', 'class'=>'container-margin']);
$conf = elgg_format_element('div', [], $title)  . '<br>';

$description = elgg_format_element('label', ['for' => 'description'], elgg_echo('encuestas_examenes:descripcion_examen'));
$description .= elgg_view('input/longtext', ['name' => 'description', 'id' => 'description', 'class'=>'container-margin']);
$conf .= elgg_format_element('div', [], $description) . '<br>'; 


$time = elgg_view('input/hidden', ['name' => 'nowlocal', 'id' => 'nowlocal']);
	$time .= elgg_format_element('label', ['for' => 'time'], elgg_echo('encuestas_examenes:duration_config')) . '<br>';
	$time .= elgg_view('input/checkbox', ['name' => 'publishExamNow', 'value' => 'publishNow','label' => elgg_echo('encuestas_examenes:publishNow'), 'id' => 'publishExamNow', 'checked'=>'true']) . '<br>';
	$time .= elgg_format_element('label', ['for' => 'dateInicio', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:start_date'));
	$time .= elgg_view('input/date', array('name' => 'dateInicio[]', 'class'=>'parameters-box', 'id'=>'dateInicio')) . '<br>';

	$time .= elgg_format_element('label', ['for' => 'timeInicioHora', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:start_time'));
	$time .= elgg_view('input/text', array('name' => 'timeInicioHora', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '23', 'id'=>'dateInicioHora')) . ':';
	$time .= elgg_view('input/text', array('name' => 'timeInicioMin', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '60', 'id'=>'dateInicioMin')) . '<br>';


	$time .= elgg_view('input/checkbox', ['name' => 'noEndDate', 'value' => 'noEndDate','label' => elgg_echo('encuestas_examenes:noEndDate'), 'id' => 'noEndDate', 'checked'=>'true']) . '<br>';
	$time .= elgg_format_element('label', ['for' => 'dateFin', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:end_date'));
	$time .= elgg_view('input/date', array('name' => 'dateFin[]', 'class'=>'parameters-box', 'id' => 'dateFin')) . '<br>';

	$time .= elgg_format_element('label', ['for' => 'timeFinHora', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:end_time'));
	$time .= elgg_view('input/text', array('name' => 'timeFinHora', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '23', 'id' => 'timeFinHora')) . ':';
	$time .= elgg_view('input/text', array('name' => 'timeFinMin', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '60', 'id' => 'timeFinMin')) . '<br>';

	$time .= elgg_view('input/checkbox', ['name' => 'noDuration', 'value' => 'noDuration','label' => elgg_echo('encuestas_examenes:noDuration'), 'id' => 'noDuration', 'checked'=>'true']) . '<br>';
	$time .= elgg_format_element('label', ['for' => 'duration', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:duration'));
	$time .= elgg_view('input/text', array('name' => 'duration', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'id' => 'duration')) . elgg_echo('encuestas_examenes:min') .'<br>';
	$time .= elgg_view('input/checkbox', ['name' => 'automaticSend', 'value' => 'YES','label' => elgg_echo('encuestas_examenes:automaticSend'), 'id' => 'automaticSend', 'checked'=>'true']) . '<br>';


$confTime['name'] = 'time';
$conf .= elgg_format_element('div', $confTime, $time) . '<br>'; 

$resend .= elgg_format_element('label', ['for' => 'resend'], elgg_echo('encuestas_examenes:resend')) . '<br>';

$resend .= elgg_view('input/radio', ['name' => 'resendParams', 'id' => 'resendParams', 'options' => array(elgg_echo('encuestas_examenes:oneSend') => 'oneSend', elgg_echo('encuestas_examenes:multipleSend') => 'multipleSend', elgg_echo('encuestas_examenes:specialSend') => 'specialSend'), 'value' => 'oneSend', 'class'=>'parameters-label']);

$resend .= elgg_format_element('label', ['for' => 'customResend', 'class'=>'parameters-label hidden', 'id'=> 'customResendLabel'], elgg_echo('encuestas_examenes:customResend'));
$resend .= elgg_view('input/text', array('name' => 'customResend', 'class'=>'parameters-box-time hidden', 'type' => 'number', 'min' => '1', 'id' => 'customResend'));

$confResend['name'] = 'resend';
$conf .= elgg_format_element('div', $confResend, $resend)  . '<br>';

$seeResults = elgg_format_element('label', ['for' => 'seeResults'], elgg_echo('encuestas_examenes:seeResults')) . '<br>';
$seeResults .= elgg_view('input/radio', ['name' => 'seeResultsParams', 'id' => 'seeResultsParams', 'options' => array(elgg_echo('encuestas_examenes:seeMark') => 'seeMark', elgg_echo('encuestas_examenes:seeMarkCorrection') => 'seeMarkCorrection', elgg_echo('encuestas_examenes:seeNothing') => 'seeNothing'), 'value' => 'seeMark', 'class'=>'parameters-label']);

$seeResultsConf['name'] = 'seeResults';
$conf .= elgg_format_element('div', $seeResultsConf, $seeResults)  . '<br>'; 

$score =  elgg_format_element('label', ['for' => 'score'], elgg_echo('encuestas_examenes:score_params'));
$score .= '<p class="elgg-subtext">'. elgg_echo('encuestas_examenes:score_notes') .'</p>';

$score .= elgg_format_element('label', ['for' => 'passScore', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:passScore'));
$score .= elgg_view('input/text', ['name' => 'passScore', 'id' => 'passScore', 'type' => 'number', 'min' => '0', 'max'=>'10', 'placeholder'=>'0', 'style'=>'width:10%', 'step' =>'0.01']);

$conf .= elgg_format_element('div', [], $score) . '<br>';

$emptyResults .= elgg_view('input/checkbox', ['name' => 'emptyResults', 'value' => 'NO','label' => elgg_echo('encuestas_examenes:emptyResults'), 'id' => 'emptyResults']) . '<br>';
$conf .= elgg_format_element('div', [], $emptyResults). '<br>'; 


$access = elgg_format_element('label', ['for' => 'access'], elgg_echo('encuestas_examenes:access'));
$access .= elgg_view('input/access', ['name' => 'access', 'options_values' => array('0'=>elgg_echo('encuestas_examenes:privado'), '-2'=>elgg_echo('encuestas_examenes:amigos'),'1'=>elgg_echo('encuestas_examenes:ausuarios_autenticados'),'2'=>elgg_echo('encuestas_examenes:publico')), 'value'=>'2']);
$conf .= elgg_format_element('div', [], $access) ; 


$next = elgg_view_icon('arrow-right', ['class' => 'next']);
$conf .= elgg_format_element('div', [], $next); 

$optConf['id'] = 'configuracion';

echo elgg_format_element('div', $optConf, $conf); 

//FIN CONFIGURACIÓN

//PREGUNTAS

$numQ = 1;
$nomQ = 'q' . $numQ;

$numR = 1;
$nomR = 'r' . $numQ . $numR;

$questionType = elgg_view_icon('delete', ['class' => 'elgg-discoverable delete-question']) . '<br>';
$questionType .= elgg_format_element('label', ['for' => 'questionType'.$numQ, 'class' => 'labelTitulo'], elgg_echo('encuestas_examenes:qType_label'));
$questionType .= elgg_view('input/dropdown', ['name' => 'questionType'.$numQ, 'options_values' => array('Checkboxes'=>elgg_echo('encuestas_examenes:checkboxes'), 'Radio'=>elgg_echo('encuestas_examenes:radio'), 'Text'=>elgg_echo('encuestas_examenes:text'), 'Long Text'=>elgg_echo('encuestas_examenes:long_text')), 'id' => 'questionType'.$numQ, 'class' => 'questionType parameters-box', 'value' => 'Text']);
$questionType .= elgg_view('input/hidden', ['name' => 'qType'.$numQ, 'value' => 'Text', 'class' => 'qType', 'id' => 'qType'.$numQ]);
$questionType .= elgg_view('input/text', ['name' => 'Pregunta' . $numQ, 'id' => 'Qtitle'.$numQ, 'class' => 'Qtitle container-margin', 'placeholder' => elgg_echo('encuestas_examenes:pregunta'), 'required'=>'required']);
$questionType .= '<br><p class="elgg-subtext">'.elgg_echo('encuestas_examenes:pregunta_nota_aclaratoria').'</p>';

//Respuestas checkboxes

$answer_fieldsCB = '<br>' . elgg_view('input/checkboxes', [
	'name' => 'CB'.$numQ, 
	'options' => array( elgg_view('input/text', [
			'name' => $nomR.'CB',
			'placeholder' => elgg_echo('encuestas_examenes:respuesta').$numR,
			'class' => 'lastR cb resp1 answ-css',
		]) => $nomR.'CB'), 
]);


$li_optionsCB = ['data-type' => 'checkboxes'];
$li_optionsCB['class'] = ['answ'.$numQ, 'answCB', 'hidden' ,'elgg-discover'];	
$questionType .= elgg_format_element('div', $li_optionsCB, $answer_fieldsCB);
$questionType .= '<br>';

//Respuestas radio

$answer_fieldsR = '<br>' . elgg_view('input/radio', [
	'name' => 'R'.$numQ, 
	'options' => array( elgg_view('input/text', [
			'name' => $nomR.'R',
			'placeholder' => elgg_echo('encuestas_examenes:respuesta').$numR,
			'class' => 'lastR radio answ-css',
		]) => $nomR.'R'), 
]);

$li_optionsR = ['data-type' => 'radio'];
$li_optionsR['class'] = ['hidden', 'answ'.$numQ, 'answR', 'elgg-discover'];	
$questionType .= elgg_format_element('div', $li_optionsR, $answer_fieldsR);

//Respuesta Text

$answer_fieldsT = elgg_view('input/checkbox', ['name' => 'regexT'.$numQ, 'class'=>'regexT', 'label' =>elgg_echo('encuestas_examenes:regex'), 'value'=>'SI']);

$answer_fieldsT .= elgg_view('input/text', [
	'name' => $nomR.'T',
	'placeholder' => elgg_echo('encuestas_examenes:right_answer_text'),
]);


$li_optionsT = ['data-type' => 'text'];
$li_optionsT['class'] = ['answ'.$numQ, 'answT', 'elgg-discover', 'text-regex'];	
$questionType .= elgg_format_element('div', $li_optionsT, $answer_fieldsT) . '<br>';

//Respuesta LongText

$answer_fieldsLT .= elgg_view('input/longtext', [
	'name' => $nomR.'LT',
	'placeholder' => elgg_echo('encuestas_examenes:right_answer_text'),
]);


$li_optionsLT = ['data-type' => 'longtext'];
$li_optionsLT['class'] = ['hidden', 'answ'.$numQ, 'answLT', 'elgg-discover', 'text-regex'];	
$questionType .= elgg_format_element('div', $li_optionsLT, $answer_fieldsLT) . '<br>';
  


//Puntuaciones por pregunta
$scoreQuestions .= '<p class="elgg-subtext">'. elgg_echo('encuestas_examenes:question_mark_note').'</p>';
$questionType .= elgg_format_element('div', [], $scoreQuestions); 

$acierto = elgg_format_element('label', ['for' => 'acierto'.$numQ, 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:success'));
$acierto .= elgg_view('input/text', ['name' => 'acierto'.$numQ, 'id' => 'acierto'.$numQ, 'type' => 'number', 'min' => '0', 'placeholder'=>'0', 'style'=>'width:10%', 'class'=>'acierto parameters-box-time', 'step' =>'0.01', 'required'=>'required']);
$questionType .= elgg_format_element('div', [], $acierto); 

$fallo = elgg_format_element('label', ['for' => 'fallo'.$numQ, 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:fail'));
$fallo .= elgg_view('input/text', ['name' => 'fallo'.$numQ, 'id' => 'fallo'.$numQ, 'type' => 'number', 'min' => '0', 'placeholder'=>'0', 'style'=>'width:10%', 'class'=>'fallo parameters-box-time', 'step' =>'0.01']);
$questionType .= elgg_format_element('div', [], $fallo);

$required .= elgg_view('input/checkbox', ['name' => 'requiredQ1', 'value' => 'NO','label' => elgg_echo('encuestas_examenes:required')]) . '<br>';
$div_req = ['class' => 'divReq'];
$questionType .= elgg_format_element('div', $div_req, $required) . '<br>';

$div_options = ['data-numQ' => $numQ];
$div_options['class'] = ['lastQ', 'question', 'elgg-discover'];

$preguntas = elgg_format_element('div', $div_options, $questionType);

//NEW
$preguntas .= elgg_view('input/button', ['name' => 'newQ', 'value' => elgg_echo('encuestas_examenes:new'), 'class' => 'new elgg-button-submit', 'id' => 'new'.$numQ]);
$preguntas .= elgg_view('input/hidden', ['name' => 'numQuestions', 'value' => '1', 'id' => 'numQuestions']);

$submit =  elgg_view('input/submit', ['value' => elgg_echo('encuestas_examenes:save'), 'class' => 'submitSave']);
$preguntas .= elgg_format_element('div', [], $submit) . '<br>';

$back = elgg_view_icon('arrow-left', ['class' => 'back']);
$preguntas .= elgg_format_element('div', [], $back); 
	 



$optConf['id'] = 'preguntas';
$optConf['class'] = 'hidden';
echo elgg_format_element('div', $optConf, $preguntas);

//FIN PREGUNTAS


