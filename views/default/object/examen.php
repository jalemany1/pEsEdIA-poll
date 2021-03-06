<?php

//elgg_require_js('encuestas_examenes/sendExamen');
elgg_load_css('mycss');

$full = elgg_extract('full_view', $vars, FALSE);
$examen = elgg_extract('entity', $vars, FALSE);

$resultadosGUID = $examen->resultadosguid;
$resultados = get_entity($resultadosGUID);

if (!$examen) {
	return TRUE;
}

$owner = $examen->getOwnerEntity();
$categories = elgg_view('output/categories', $vars);
$excerpt = $examen->excerpt;
if (!$excerpt) {
	$excerpt = elgg_get_excerpt($examen->description);
}

$owner_icon = elgg_view_entity_icon($owner, 'tiny');

$vars['owner_url'] = "examen/owner/$owner->username";
$by_line = elgg_view('page/elements/by_line', $vars); //Imprime por ejemplo "By administrador yesterday"

$subtitle = "$by_line $categories";

$metadata = '';
if (!elgg_in_context('widgets')) {
	$metadata = elgg_view_menu('entity', array(
		'entity' => $vars['entity'],
		'handler' => 'examen',
		'sort_by' => 'priority',
		'class' => 'elgg-menu-hz',
	));
}

$now = time();

$start = $examen->start;
$end = $examen->end;

$diffGTM = $examen->diffGTM;
$publishNow = $examen-> publishNow;

if($diffGTM[28] == "+"){
	$startGTM = $start - ((int)$diffGTM[30]*60*60);
	$finGTM = $end - ((int)$diffGTM[30]*60*60);
}else{
	$startGTM = $start + ((int)$diffGTM[30]*60*60);
	$finGTM = $end + ((int)$diffGTM[30]*60*60);
}


if ($full) {

	$noDuration = $examen-> noDuration;

	$answered = unserialize($resultados->respuestas_enviadas);

	if(!($now <= $startGTM && $publishNow == '0')){
		//Prevención de que los usuarios accedan al examen tantas veces como quieran sin enviar una respuesta.
		$answered[elgg_get_logged_in_user_entity()->guid] = (int) $answered[elgg_get_logged_in_user_entity()->guid] +1;
		$resultados->respuestas_enviadas = serialize($answered);
		$resultados->resultados_totales =  count($answered);
		$resultados->save();
	}
	
	//echo('ENVÍOS: ' . $resultados->resultados_totales);
	//echo('<br>ENVÍOS CON ESTA GUID: ' . $answered[elgg_get_logged_in_user_entity()->guid]);

	//JS automatic send control
	$body .= elgg_view('input/hidden', ['id' => 'noDuration', 'value' => $noDuration]);
	$body .= elgg_view('input/hidden', ['id' => 'automaticSend', 'value' => $examen-> automaticSend]);

	//$noDuration = 'noDuration' significa que noDuration no está checked, por lo que HAY LÍMITE DE TIEMPO
	if($noDuration != 'noDuration'){
		$duration = $examen-> duration;

		$body .= '<span>'.elgg_echo('encuestas_examenes:time_left'). '</span><span name="clock" id="clock">' . $duration . '</span><span>'. elgg_echo('encuestas_examenes:min').'<span>';

		$body .= '<div class="bar-progress"> <div class="bar-progress-filled timeLeft" style="width:100%"></div></div>';

		//Mostrar cuando el contador ha lleado a su fin
		/*$contentNOtime = elgg_echo('encuestas_examenes:time_gone');
		$contentNOtimeConfig['id'] = 'contentNOtime';
		$contentNOtimeConfig['class'] = 'hidden';
		echo elgg_format_element('div', $contentNOtimeConfig, $contentNOtime);


		//echo($answered[elgg_get_logged_in_user_entity()->guid]);*/
	}


	//Obtener la variable para comprobar si ya se ha enviado una respuesta de este examen. '0' = NO ESTÁ RESPONDIDO TODAVÍA

	$resendParams = $examen-> resendParams;
	

	switch($resendParams){
		case 'oneSend':
			$body .= '<div class="resend">'. elgg_echo('encuestas_examenes:num_submits').'1 </div><br>';
			break;
		case 'multipleSend':
			$body .= '<div class="resend">'.elgg_echo('encuestas_examenes:num_submits').elgg_echo('encuestas_examenes:unlimited'). '</div><br>';
			break;
		case 'specialSend':
			$respuestasRestantes = ((int)$resultados->num_respuestas_enviadas - (int)$answered[elgg_get_logged_in_user_entity()->guid]) + 1;

			$body .= '<div class="resend">'. elgg_echo('encuestas_examenes:num_submits') . $resultados->num_respuestas_enviadas . ' <br>'. elgg_echo('encuestas_examenes:remaining') . $respuestasRestantes . '</div>';
			break;
	}

	if($resendParams != 'oneSend' &&  $answered[elgg_get_logged_in_user_entity()->guid] > 1){
		$body .= "<p class='req'>". elgg_echo('encuestas_examenes:already_sent') . '</p>';
	}
	

	$body .= elgg_view('output/longtext', array(
		'value' => $examen->description,
		'class' => 'encuestaexamen',
	));

	$body .= '<br><div class="elgg-subtext">' .elgg_echo('encuestas_examenes:required_1').'<span class="req">*</span>'.elgg_echo('encuestas_examenes:required_2').'</div>';


	$fullbodyParams['class'] = 'fullbody';
	$fullbody .= elgg_format_element('div', $fullbodyParams, $body)  . '<br>';	

	$params = array(
		'entity' => $examen,
		'title' => false,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
	);
	$params = $params + $vars;
	$summary = elgg_view('object/elements/summary', $params);

	echo elgg_view('object/elements/full', array(
		'entity' => $examen,
		'summary' => $summary,
		'icon' => $owner_icon,
		'body' => $fullbody,
	));

} else {
	//vista resumen

	$params = array(
		'entity' => $examen,
		'metadata' => $metadata,
		'subtitle' => $subtitle,
		'content' => $excerpt,
		'icon' => $owner_icon,
	);
	$params = $params + $vars;
	echo elgg_view('object/elements/summary', $params);

}


//echo elgg_view('output/longtext', array('value' => $vars['entity']->title));
//echo elgg_view('output/tags', array('tags' => $vars['entity']->tags));
