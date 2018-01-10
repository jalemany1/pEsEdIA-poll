<?php

gatekeeper();

elgg_load_css('mycss');

$guid = elgg_extract('guid', $vars);
$examen = get_entity($guid);

$resultados = get_entity($examen->resultadosguid);

$respuesta_al_examen = elgg_get_entities_from_metadata(array(
	'types'=>'object',
	'subtypes'=>'respuesta',
	'metadata_names' =>array('examen'),
	'metadata_values' =>array($guid),
	'owner_guid'=>elgg_get_logged_in_user_entity()->guid
));

$links = '<div class="elgg-subtext">'.elgg_echo('encuestas_examenes:view_exam_note').'<span class="bold">'.elgg_echo('encuestas_examenes:refresh').'</span></div><br>';
$links .= '<a href="/encuestas_examenes/examen/' . $guid .'" class="elgg-button elgg-button-submit enlace_boton">'.elgg_echo('encuestas_examenes:access_exam').'</a><br>';
if($respuesta_al_examen[0]->guid){
	$links .= '<a href="/encuestas_examenes/myresultExamen/'. $respuesta_al_examen[0]->guid .'" class="elgg-button elgg-button-submit enlace_boton">'.elgg_echo('encuestas_examenes:my_result').'</a><br>';
	if($resultados->seeResults == 'seeMarkCorrection'){
	$links .= '<a href="/encuestas_examenes/correction/'. $respuesta_al_examen[0]->guid .'" class="elgg-button elgg-button-submit enlace_boton">'.elgg_echo('encuestas_examenes:my_correction').'</a><br>';
	}
}


if($examen->owner_guid == elgg_get_logged_in_user_guid()){
	$links .= '<a href="/encuestas_examenes/resultsExamen/'. $examen->resultadosguid .'" class="elgg-button elgg-button-submit enlace_boton">'.elgg_echo('encuestas_examenes:all_results').'</a><br>';
	$links .= '<a href="/examen/edit/'. $guid .'" class="elgg-button elgg-button-submit enlace_boton">'.elgg_echo('encuestas_examenes:edit_exam').'</a><br>';
	$links .= '<a href="/encuestas_examenes/eliminarExamen/'. $guid .'" class="elgg-button elgg-button-submit enlace_boton" data-confirm="'.elgg_echo('encuestas_examenes:delete_exam_confirm').'">'.elgg_echo('encuestas_examenes:delete_exam').'</a><br>';
	$links .= '<a href="/encuestas_examenes/reiniciarExamen/'. $guid .'" class="elgg-button elgg-button-submit enlace_boton" data-confirm="'.elgg_echo('encuestas_examenes:reset_exam_config').'">'.elgg_echo('encuestas_examenes:reset_exam').'</a><br>';

}



$content .= elgg_format_element('div', [], $links) . '<br>'; 


// optionally, add the content for the sidebar
//$sidebar = "";

//cho($ver_examen);

$body = elgg_view_layout('one_sidebar', array(
   'title' => $examen->title,
   'content' => $content,
   //'sidebar' => $sidebar
));

echo elgg_view_page($title, $body);




























