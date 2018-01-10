<?php

elgg_register_menu_item('title', array(
	'name' => 'addEncuesta',
	'href' => 'encuestas_examenes/addEncuesta',
	'text' => elgg_echo('encuestas_examenes:add_encuesta'),
	'link_class' => 'elgg-button elgg-button-action',
));

elgg_register_menu_item('title', array(
	'name' => 'addExamen',
	'href' => 'encuestas_examenes/addExamen',
	'text' => elgg_echo('encuestas_examenes:add_examen'),
	'link_class' => 'elgg-button elgg-button-action',
));


if(get_input('tab') == 'examen'){
	$title_tmp = elgg_echo('encuestas_examenes:examenes');
	$enex = elgg_list_entities(array(
	    'type' => 'object',
	    'subtype' => 'examen',

	));

	$params['filter'] = elgg_view('filters/encuestas_examenes/menu', [
		    'filter_context' => 'examen',
	]);

}else{
	$title_tmp = elgg_echo('encuestas_examenes:encuestas');
	$enex = elgg_list_entities(array(
	    'type' => 'object',
	    'subtype' => 'encuesta',
	));

	$params['filter'] = elgg_view('filters/encuestas_examenes/menu', [
		   'filter_context' => 'encuesta',
	]);

}

$pagetitle = elgg_echo("encuestas_examenes:list") . $title_tmp;

$params = array('title' => $pagetitle, 'content' => $enex);

if(get_input('tab') == 'examen'){

	$params['filter'] = elgg_view('filters/encuestas_examenes/menu', [
		    'filter_context' => 'examen',
	]);

}else{

	$params['filter'] = elgg_view('filters/encuestas_examenes/menu', [
		    'filter_context' => 'encuesta',
	]);

}

$body = elgg_view_layout('content', $params);

echo elgg_view_page($pagetitle, $body);

