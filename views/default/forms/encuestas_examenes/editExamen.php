<?php
elgg_require_js('encuestas_examenes/editExamen');

// get the entity
$guid = elgg_extract('guid', $vars);
$examen = get_entity($guid);

$resultados_guid = $examen->resultadosguid;
$resultados = get_entity($resultados_guid);


//CONFIGURACIÓN

echo elgg_view('input/hidden', ['name' => 'guid_examen', 'value'=>$guid]);

$title = elgg_format_element('label', ['for' => 'title'], elgg_echo('encuestas_examenes:titulo'));
$title .= elgg_view('input/text', ['name' => 'title', 'id' => 'title', 'required'=>'required', 'class'=>'container-margin', 'value' => $examen->title]);
$conf = elgg_format_element('div', [], $title)  . '<br>';

$description = elgg_format_element('label', ['for' => 'description'], elgg_echo('encuestas_examenes:descripcion_examen'));
$description .= elgg_view('input/longtext', ['name' => 'description', 'id' => 'description', 'class'=>'container-margin', 'value'=>$examen->description]);
$conf .= elgg_format_element('div', [], $description) . '<br>'; 


$time = elgg_view('input/hidden', ['name' => 'nowlocal', 'id' => 'nowlocal']);

$cecked_publishNow = false;
if($examen->publishNow == 'publishNow'){
	$cecked_publishNow = true; 
}

$time .= elgg_format_element('label', ['for' => 'time'], elgg_echo('encuestas_examenes:duration_config')) . '<br>';
$time .= elgg_view('input/checkbox', ['name' => 'publishExamNow', 'value' => 'publishNow','label' => elgg_echo('encuestas_examenes:publishNow'), 'id' => 'publishExamNow', 'checked' => $cecked_publishNow]) . '<br>';

$start_date = "";
$start_h ="";
$start_m="";
if(!$cecked_publishNow){
	$start_date = date('Y-m-d', $examen->start);
	$start_h = date('H', $examen->start);
	$start_m = date('i', $examen->start); //El resultado se ve con un solo 0, podría arreglarse
}
//echo(date('Y-m-d', $examen->start));
$time .= elgg_format_element('label', ['for' => 'dateInicio', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:start_date'));
$time .= elgg_view('input/date', array('name' => 'dateInicio[]', 'class'=>'parameters-box', 'id'=>'dateInicio', 'value'=>$start_date)) . '<br>';

$time .= elgg_format_element('label', ['for' => 'timeInicioHora', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:start_time'));
	$time .= elgg_view('input/text', array('name' => 'timeInicioHora', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '23', 'id'=>'dateInicioHora', 'value'=>$start_h)) . ':';
	$time .= elgg_view('input/text', array('name' => 'timeInicioMin', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '60', 'id'=>'dateInicioMin', 'value'=>$start_m)) . '<br>';

$cecked_noEndDate = false;
if($examen->noEndDate == 'noEndDate'){
	$cecked_noEndDate = true; 
}
$time .= elgg_view('input/checkbox', ['name' => 'noEndDate', 'value' => 'noEndDate','label' => elgg_echo('encuestas_examenes:noEndDate'), 'id' => 'noEndDate', 'checked'=>$cecked_noEndDate]) . '<br>';

$end_date = "";
$end_h ="";
$end_m="";
if(!$cecked_noEndDate){
	$end_date = date('Y-m-d', $examen->end);
	$end_h = date('H', $examen->end);
	$end_m = date('i', $examen->end); //El resultado se ve con un solo 0, podría arreglarse
}
$time .= elgg_format_element('label', ['for' => 'dateFin', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:end_date'));
	$time .= elgg_view('input/date', array('name' => 'dateFin[]', 'class'=>'parameters-box', 'id' => 'dateFin', 'value'=> $end_date)) . '<br>';

$time .= elgg_format_element('label', ['for' => 'timeFinHora', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:end_time'));
	$time .= elgg_view('input/text', array('name' => 'timeFinHora', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '23', 'id' => 'timeFinHora', 'value'=> $end_h)) . ':';
	$time .= elgg_view('input/text', array('name' => 'timeFinMin', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'max' => '60', 'id' => 'timeFinMin', 'value'=> $end_m)) . '<br>';

$cecked_noDuration = false;
if($examen->noDuration == 'noDuration'){
	$cecked_noDuration = true; 
}
	$time .= elgg_view('input/checkbox', ['name' => 'noDuration', 'value' => 'noDuration','label' => elgg_echo('encuestas_examenes:noDuration'), 'id' => 'noDuration', 'checked'=>$cecked_noDuration]) . '<br>';

$duration = "";
if(!$cecked_noDuration){
	$duration = $examen->duration; 
}

$time .= elgg_format_element('label', ['for' => 'duration', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:duration'));
$time .= elgg_view('input/text', array('name' => 'duration', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '0', 'id' => 'duration', 'value'=>$duration)) . elgg_echo('encuestas_examenes:min') .'<br>';

$cecked_automaticSend = false;
if($examen->automaticSend == 'YES'){
	$cecked_automaticSend = true; 
}
$time .= elgg_view('input/checkbox', ['name' => 'automaticSend', 'value' => 'YES','label' => elgg_echo('encuestas_examenes:automaticSend'), 'id' => 'automaticSend', 'checked'=>$cecked_automaticSend]) . '<br>';


$confTime['name'] = 'time';
$conf .= elgg_format_element('div', $confTime, $time) . '<br>'; 

$numResend = $examen->resendParams;

$resend .= elgg_format_element('label', ['for' => 'resend'], elgg_echo('encuestas_examenes:resend')) . '<br>';

$resend .= '<br><p class="elgg-subtext">'.elgg_echo('encuestas_examenes:edit_restart_note').'</p>';

$resend .= elgg_view('input/radio', ['name' => 'resendParams', 'id' => 'resendParams', 'options' => array(elgg_echo('encuestas_examenes:oneSend') => 'oneSend', elgg_echo('encuestas_examenes:multipleSend') => 'multipleSend', elgg_echo('encuestas_examenes:specialSend') => 'specialSend'), 'value' => $numResend, 'class'=>'parameters-label']);

$resend .= elgg_format_element('label', ['for' => 'customResend', 'class'=>'parameters-label', 'id'=> 'customResendLabel'], elgg_echo('encuestas_examenes:customResend'));
$resend .= elgg_view('input/text', array('name' => 'customResend', 'class'=>'parameters-box-time', 'type' => 'number', 'min' => '1', 'id' => 'customResend', 'value'=> $resultados->num_respuestas_enviadas));

$confResend['name'] = 'resend';
$conf .= elgg_format_element('div', $confResend, $resend)  . '<br>';


$seeResults = elgg_format_element('label', ['for' => 'seeResults'], elgg_echo('encuestas_examenes:seeResults')) . '<br>';
$seeResults .= elgg_view('input/radio', ['name' => 'seeResultsParams', 'id' => 'seeResultsParams', 'options' => array(elgg_echo('encuestas_examenes:seeMark') => 'seeMark', elgg_echo('encuestas_examenes:seeMarkCorrection') => 'seeMarkCorrection', elgg_echo('encuestas_examenes:seeNothing') => 'seeNothing'), 'value' => $resultados->seeResults, 'class'=>'parameters-label']);

$seeResultsConf['name'] = 'seeResults';
$conf .= elgg_format_element('div', $seeResultsConf, $seeResults)  . '<br>'; 

$score =  elgg_format_element('label', ['for' => 'score'], elgg_echo('encuestas_examenes:score_params'));
$score .= '<p class="elgg-subtext">'. elgg_echo('encuestas_examenes:score_notes').'</p>';

$score .= elgg_format_element('label', ['for' => 'passScore', 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:passScore'));
$score .= elgg_view('input/text', ['name' => 'passScore', 'id' => 'passScore', 'type' => 'number', 'min' => '0', 'max'=>'10', 'placeholder'=>'0', 'style'=>'width:10%', 'step' =>'0.01', 'value'=> $examen->passScore]);

$conf .= elgg_format_element('div', [], $score) . '<br>';

$cecked_emptyResults = false;
if($examen->emptyResults == 'NO'){
	$cecked_emptyResults = true; 
}

$emptyResults .= elgg_view('input/checkbox', ['name' => 'emptyResults', 'value' => 'NO','label' => elgg_echo('encuestas_examenes:emptyResults'), 'id' => 'emptyResults', 'checked'=>$cecked_emptyResults]) . '<br>';
$conf .= elgg_format_element('div', [], $emptyResults). '<br>'; 


$access = elgg_format_element('label', ['for' => 'access'], elgg_echo('encuestas_examenes:access'));
$access .= elgg_view('input/access', ['name' => 'access', 'options_values' => array('0'=>elgg_echo('encuestas_examenes:privado'), '-2'=>elgg_echo('encuestas_examenes:amigos'),'1'=>elgg_echo('encuestas_examenes:ausuarios_autenticados'),'2'=>elgg_echo('encuestas_examenes:publico')), 'value'=>$examen->access_id]);
$conf .= elgg_format_element('div', [], $access) ; 


$next = elgg_view_icon('arrow-right', ['class' => 'next']);
$conf .= elgg_format_element('div', [], $next);

$optConf['id'] = 'configuracion';

echo elgg_format_element('div', $optConf, $conf); 

//FIN CONFIGURACIÓN

//PREGUNTAS - RECUPERACIÓN DE DATOS DEL EXAMEN

$numQ = 1;
$nomQ = 'q' . $numQ;

$numR = 1;
$nomR = 'r' . $numQ . $numR;

$examen_questions = unserialize($resultados->questions_examen);
$examen_obtain_required = unserialize($examen->questions);

$questionType = elgg_view('input/hidden', ['id' => 'totalQ', 'value' => sizeof($examen_questions), 'name'=>'totalQ']);
$questionType .= '<br><p class="elgg-subtext req">'.elgg_echo('encuestas_examenes:modify_answers_note').'</p>';

$numItems_q = count($examen_questions);
$cont_q = 0;
$lastQ = '';
foreach($examen_questions as $q_key=>$q){

	if(++$cont_q === $numItems_q) {
	    $lastQ = 'lastQ';
	}
	$questionIndividual = elgg_view_icon('delete', ['class' => 'elgg-discoverable delete-question']) . '<br>';
	$questionIndividual .= elgg_format_element('label', ['for' => 'questionType'.$numQ, 'class' => 'labelTitulo'], elgg_echo('encuestas_examenes:qType_label'));
	$questionIndividual .= elgg_view('input/dropdown', ['name' => 'questionType'.$numQ, 'options_values' => array('Checkboxes'=>elgg_echo('encuestas_examenes:checkboxes'), 'Radio'=>elgg_echo('encuestas_examenes:radio'), 'Text'=>elgg_echo('encuestas_examenes:text'), 'Long Text'=>elgg_echo('encuestas_examenes:long_text')), 'id' => 'questionType'.$numQ, 'class' => 'questionType parameters-box', 'value' => $q['type']]);
	$questionIndividual .= elgg_view('input/hidden', ['name' => 'qType'.$numQ, 'value' => $q['type'], 'class' => 'qType', 'id' => 'qType'.$numQ]);
	$questionIndividual .= elgg_view('input/text', ['name' => 'Pregunta' . $numQ, 'id' => 'Qtitle'.$numQ, 'class' => 'Qtitle container-margin', 'placeholder' => 'Pregunta' . $numQ, 'required'=>'required', 'value'=>$q['qTittle']]);
	$questionIndividual .= '<br><p class="elgg-subtext">'.elgg_echo('encuestas_examenes:pregunta_nota_aclaratoria').'</p>';


	$answer_fieldsCB = elgg_view('input/checkboxes', [
		'name' => 'CB'.$numQ, 
		'options' => array( elgg_view('input/text', [
				'name' => $nomR.'CB',
				'placeholder' => elgg_echo('encuestas_examenes:respuesta') . elgg_echo($numR),
				'class' => 'lastR cb resp1 answ-css',
			]) => $nomR.'CB'), 
	]);


	//$li_optionsCB = ['data-index' => $numR];
	//$li_optionsCB += ['data-numQuestion' => $numQ];
	$li_optionsCB = ['data-type' => 'checkboxes'];
	$li_optionsCB['class'] = ['answ'.$numQ, 'answCB', 'hidden' ,'elgg-discover'];	
	$questionIndividual .= elgg_format_element('div', $li_optionsCB, $answer_fieldsCB);

	//Respuestas radio
	//TODO: Añadir el delete y el drag

	$answer_fieldsR = elgg_view('input/radio', [
		'name' => 'R'.$numQ, 
		'options' => array( elgg_view('input/text', [
				'name' => $nomR.'R',
				'placeholder' => elgg_echo('encuestas_examenes:respuesta') . elgg_echo($numR),
				'class' => 'lastR radio answ-css',
			]) => $nomR.'R'), 
	]);


	$li_optionsR = ['data-type' => 'radio'];
	$li_optionsR['class'] = ['hidden', 'answ'.$numQ, 'answR', 'elgg-discover'];	
	$questionIndividual .= elgg_format_element('div', $li_optionsR, $answer_fieldsR);

	//Respuesta Text

	$answer_fieldsT = elgg_view('input/checkbox', ['name' => 'regexT'.$numQ, 'class'=>'regexT', 'label' =>elgg_echo('encuestas_examenes:regex'), 'value'=>'SI']);

	$answer_fieldsT .= elgg_view('input/text', [
		'name' => $nomR.'T',
		'placeholder' => elgg_echo('encuestas_examenes:right_answer_text'),
	]);

	$li_optionsT = ['data-type' => 'text'];
	$li_optionsT['class'] = ['hidden', 'answ'.$numQ, 'answT', 'elgg-discover', 'text-regex'];	
	$questionIndividual .= elgg_format_element('div', $li_optionsT, $answer_fieldsT);

	//Respuesta LongText

	$answer_fieldsLT = elgg_view('input/longtext', [
		'name' => $nomR.'LT',
		'placeholder' => elgg_echo('encuestas_examenes:right_answer_text'),
	]);

	$li_optionsLT = ['data-type' => 'longtext'];
	$li_optionsLT['class'] = ['hidden', 'answ'.$numQ, 'answLT', 'text-regex', 'elgg-discover' ];	
	$questionIndividual .= elgg_format_element('div', $li_optionsLT, $answer_fieldsLT) . '<br>';
  

	//FIN PREGUNTAS - FORMULARIO DINÁMICO

	$answers = $q['answers'];

	$numR = 1;
	$nomR = 'r' . $numQ . $numR;
	
	switch($q['type']){

		case "Checkboxes":
			
			$cb = array();

			$numItems = count($answers);
			$cuenta = 0;
			$lastR = '';
			foreach($answers as $key => $a){
				//Comprobamos si la respuseta es la última para añadirle la clase .lastR
				if(++$cuenta === $numItems) {
				    	$lastR = 'lastR';
				}  
				$ck = '';

				if(in_array($a['answer'], $q['okanswers'])) $ck = 'ck';
				
				$field = elgg_view('input/text', [
					'name' => $nomR.'CB',
					//La clase ck se utiliza para poder marcar las respuestas que están
					//puestas como válidas a través de JS
					'class' => 'cb resp_rec'.$numR.' answ-css ' . $ck . ' ' . $lastR,
					'value' => $a['answer'],
				]);
				
				$cb[$field] = $nomR.'CB';

				$numR++;
				$nomR = 'r' . $numQ . $numR;
			}

			$answer_fieldsCB_rec = elgg_view('input/checkboxes', [
				'name' => 'CB'.$numQ, 
				'options' => $cb,
			]);

			//echo($answer_fieldsCB);
			$li_optionsCB_rec = ['data-type' => 'checkboxes'];
			$li_optionsCB_rec['class'] = ['answ_rec'.$numQ, 'answCB','elgg-discover', 'rec'];	
			$questionIndividual .= elgg_format_element('div', $li_optionsCB_rec, $answer_fieldsCB_rec);
			$questionIndividual .= '<br>';
			break;


		case "Radio":
			$r = array();
			$numItems = count($answers);
			$cuenta = 0;
			$lastR = '';
			foreach($answers as $key => $a){

				if(++$cuenta === $numItems) {
				    	$lastR = 'lastR';
				} 
				$ck = '';

				if(in_array($a['answer'], $q['okanswers'])) $ck = 'ck';
				
				$field = elgg_view('input/text', [
					'name' => $nomR.'R',
					//La clase ck se utiliza para poder marcar las respuestas que están
					//puestas como válidas a través de JS
					'class' => 'radio resp_rec'.$numR.' answ-css ' . $ck. ' ' . $lastR,
					'value' => $a['answer'],
				]);

				
				$r[$field] = $nomR.'R';

				$numR++;
				$nomR = 'r' . $numQ . $numR;
			}

			$answer_fieldsR_rec = elgg_view('input/radio', [
				'name' => 'R'.$numQ, 
				'options' => $r, 
			]);


			$li_optionsR_rec = ['data-type' => 'radio'];
			$li_optionsR_rec['class'] = ['answ_rec'.$numQ, 'answR', 'elgg-discover', 'rec'];	
			$questionIndividual .= elgg_format_element('div', $li_optionsR_rec, $answer_fieldsR_rec);
			break;

		case "Text":
			
			//Se comprueba si está marcado el campo de expresión regular
			$ck = '';

			if($q['regex'] == 'SI') $ck = 'ck';

			$answer_fieldsT_rec = elgg_view('input/checkbox', ['name' => 'regexT'.$numQ, 'class'=>'regexT '  . $ck, 'label' =>elgg_echo('encuestas_examenes:regex'), 'value'=>'SI']);


			$answer_fieldsT_rec .= elgg_view('input/text', [
				'name' => $nomR.'T',
				'placeholder' => elgg_echo('encuestas_examenes:right_answer_text'),
				'value' => $q['okanswers'][0],
			]);

			$li_optionsT_rec = ['data-type' => 'text'];
			$li_optionsT_rec['class'] = ['answ_rec'.$numQ, 'answT', 'elgg-discover', 'text-regex', 'rec'];	
			$questionIndividual .= elgg_format_element('div', $li_optionsT_rec, $answer_fieldsT_rec) . '<br>';


			break;

		case "Long Text":

			$answer_fieldsLT_rec = elgg_view('input/longtext', [
				'name' => $nomR.'LT',
				'placeholder' => elgg_echo('encuestas_examenes:right_answer_text'),
				'value' => $q["okanswers"][0],
			]);


			$li_optionsLT_rec = ['data-type' => 'longtext'];
			$li_optionsLT_rec['class'] = ['answ_rec'.$numQ, 'answLT', 'text-regex', 'elgg-discover', 'rec'];	
			$questionIndividual .= elgg_format_element('div', $li_optionsLT_rec, $answer_fieldsLT_rec) . '<br>';
			
			break;

	}

	//Puntuaciones por pregunta
	$scoreQuestions = '<p class="elgg-subtext">'. elgg_echo('encuestas_examenes:question_mark_note').'</p>';
	$questionIndividual .= elgg_format_element('div', [], $scoreQuestions); 

	$acierto = elgg_format_element('label', ['for' => 'acierto'.$numQ, 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:success'));
	$acierto .= elgg_view('input/text', ['name' => 'acierto'.$numQ, 'id' => 'acierto'.$numQ, 'type' => 'number', 'min' => '0', 'placeholder'=>'0', 'style'=>'width:10%', 'class'=>'acierto parameters-box-time', 'step' =>'0.01', 'value'=>$q['success'], 'required'=>'required']);
	$questionIndividual .= elgg_format_element('div', [], $acierto); 

	$fallo = elgg_format_element('label', ['for' => 'fallo'.$numQ, 'class'=>'parameters-label'], elgg_echo('encuestas_examenes:fail'));
	$fallo .= elgg_view('input/text', ['name' => 'fallo'.$numQ, 'id' => 'fallo'.$numQ, 'type' => 'number', 'min' => '0', 'placeholder'=>'0', 'style'=>'width:10%', 'class'=>'fallo parameters-box-time', 'step' =>'0.01', 'value'=>$q['fail']]);
	$questionIndividual .= elgg_format_element('div', [], $fallo);

	$req = false;
	if($examen_obtain_required[$q_key]["required"] == 'NO') $req = true;	

	$required = elgg_view('input/checkbox', ['name' => 'requiredQ'.$numQ, 'value' => 'NO','label' => elgg_echo('encuestas_examenes:required'), 'checked' => $req]) . '<br>';
	$div_req = ['class' => 'divReq'];
	$questionIndividual .= elgg_format_element('div', $div_req, $required) . '<br>';

	$div_options = ['data-numQ' => $numQ];
	$div_options['class'] = [$lastQ, 'question', 'elgg-discover'];

	$questionType .= elgg_format_element('div', $div_options, $questionIndividual);


	$numQ++;

	$numR = 1;
	$nomR = 'r' . $numQ . $numR;
	
}

//FIN PREGUNTAS - RECUPERACIÓN DE DATOS DEL EXAMEN



//Puntuaciones por pregunta




$preguntas = elgg_format_element('div', [] , $questionType);

//NEW
$preguntas .= elgg_view('input/button', ['name' => 'newQ', 'value' => elgg_echo('encuestas_examenes:new'), 'class' => 'new elgg-button-submit', 'id' => 'new'.($numQ-1)]);
$preguntas .= elgg_view('input/hidden', ['name' => 'numQuestions', 'value' => '1', 'id' => 'numQuestions']);

$submit =  elgg_view('input/submit', ['value' => elgg_echo('encuestas_examenes:save'), 'class' => 'submitSave']);
$preguntas .= elgg_format_element('div', [], $submit) . '<br>';

$back = elgg_view_icon('arrow-left', ['class' => 'back']);
$preguntas .= elgg_format_element('div', [], $back);  
	 



$optConf['id'] = 'preguntas';
$optConf['class'] = 'hidden';
echo elgg_format_element('div', $optConf, $preguntas);

//FIN PREGUNTAS



