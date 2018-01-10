<?php

gatekeeper();

elgg_load_css('mycss');

$guid = elgg_extract('guid', $vars);
$encuesta = get_entity($guid);

$respuesta_encuesta = elgg_get_entities_from_metadata(array(
	'types'=>'object',
	'subtypes'=>'voto',
	'metadata_names' =>array('encuesta'),
	'metadata_values' =>array($guid),
	'owner_guid'=>elgg_get_logged_in_user_entity()->guid
));

$links = '<div class="elgg-subtext">'.elgg_echo('encuestas_examenes:view_encuesta_note').'<span class="bold">'.elgg_echo('encuestas_examenes:refresh_encuesta').'</span></div><br>';
$links .= '<a href="/encuestas_examenes/encuesta/' . $guid .'" class="elgg-button elgg-button-submit enlace_boton">'.elgg_echo('encuestas_examenes:access_encuesta').'</a><br>';

if($respuesta_encuesta[0]->guid){
	$links .= '<a href="/encuestas_examenes/myresultEncuesta/'. $respuesta_encuesta[0]->guid .'" class="elgg-button elgg-button-submit enlace_boton">'.elgg_echo('encuestas_examenes:my_result').'</a><br>';
}


if($encuesta->owner_guid == elgg_get_logged_in_user_guid()){
	$links .= '<a href="/encuestas_examenes/resultsEncuesta/'. $encuesta->resultadosguid .'" class="elgg-button elgg-button-submit enlace_boton">'.elgg_echo('encuestas_examenes:all_results').'</a><br>';
	$links .= '<a href="/encuesta/edit/'. $guid .'" class="elgg-button elgg-button-submit enlace_boton">'.elgg_echo('encuestas_examenes:edit_encuesta').'</a><br>';
	$links .= '<a href="/encuestas_examenes/eliminarEncuesta/'. $guid .'" class="elgg-button elgg-button-submit enlace_boton" data-confirm="'.elgg_echo('encuestas_examenes:delete_encuesta_confirm').'">'.elgg_echo('encuestas_examenes:delete_encuesta').'</a><br>';
	$links .= '<a href="/encuestas_examenes/reiniciarEncuesta/'. $guid .'" class="elgg-button elgg-button-submit enlace_boton" data-confirm="'.elgg_echo('encuestas_examenes:reset_encuesta_config').'">'.elgg_echo('encuestas_examenes:reset_encuesta').'</a><br>';

}


$content .= elgg_format_element('div', [], $links) . '<br>'; 


// optionally, add the content for the sidebar
//$sidebar = "";


$body = elgg_view_layout('one_sidebar', array(
   'title' => $encuesta->title,
   'content' => $content,
   //'sidebar' => $sidebar
));

echo elgg_view_page($title, $body);

/*$res = get_entity($encuesta->resultadosguid);
echo("encuesta: <br>");
echo("title: ".var_dump($encuesta->title));
echo("<br>");
echo("description: ".var_dump($encuesta->description));
echo("<br>");
echo("start: ".var_dump($encuesta->start));
echo("<br>");
echo("end: ".var_dump($encuesta->end));
echo("<br>");
echo("diffGTM: ".var_dump($encuesta->diffGTM));
echo("<br>");
echo("duration: ".var_dump($encuesta->duration));
echo("<br>");
echo("noDuration: ".var_dump($encuesta->noDuration));
echo("<br>");
echo("automaticSend: ".var_dump($encuesta->automaticSend));
echo("<br>");
echo("resendParams: ".var_dump($encuesta->resendParams));
echo("<br>");
echo("publishNow: ".var_dump($encuesta->publishNow));
echo("<br>");
echo("noEndDate: ".var_dump($encuesta->noEndDate));
echo("<br>");
echo("emptyResults: ".var_dump($encuesta->emptyResults));
echo("<br>");
echo("questions: ".var_dump(unserialize($encuesta->questions)));
echo("<br>");
echo("access_id: ".var_dump($encuesta->access_id));
echo("<br>");
echo("owner_id: ".var_dump($encuesta->owner_guid));
echo("<br>");
echo("resultadiosguid: ".var_dump($encuesta->resultadosguid));
echo("<br>_____________________________________<br>resultadosEncuesta: <br>");
echo("title: ".var_dump($res->title));
echo("<br>");
echo("questionsEncuesta: ".var_dump(unserialize($res->questions_encuesta)));
echo("<br>");
echo("resultados_totales: ".var_dump($res->resultados_totales));
echo("<br>");
echo("respuestas_enviadas: ".var_dump(unserialize($res->respuestas_enviadas)));
echo("<br>");
echo("num_respuestas_enviadas: ".var_dump($res->num_respuestas_enviadas));
echo("<br>");
echo("access_id: ".var_dump($res->access_id));
echo("<br>");
echo("owner_id: ".var_dump($res->owner_guid));
echo("<br>");*/

