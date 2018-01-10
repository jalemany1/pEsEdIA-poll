<?php

elgg_register_event_handler('init', 'system', 'encuestas_examenes_init');

function encuestas_examenes_init() {

	//Añadir al menú principal el botón que accede al plugin
	elgg_register_menu_item('site', array(
		'name' => 'encuestas_examenes',
		'text' => elgg_echo('encuestas_examenes'),
		'href' => 'encuestas_examenes/all?tab=encuesta',	
	));

	//Registrar la librería chartsjs -> No utilizada de momento
	//elgg_define_js('chartjs', [
	//	'src' => '/mod/encuestas_examenes/libs/Chart.min.js',
	//]);
	
    	elgg_register_page_handler('encuestas_examenes', 'encuestas_examenes_page_handler');
	//Al editar, la url es examen/...
    	elgg_register_page_handler('examen', 'examen_page_handler');

	//Al editar, la url es encuesta/...
    	elgg_register_page_handler('encuesta', 'encuesta_page_handler');

	elgg_register_action("encuestas_examenes/saveEncuesta", __DIR__ . "/actions/encuestas_examenes/saveEncuesta.php");

	elgg_register_action("encuestas_examenes/vote", __DIR__ . "/actions/encuestas_examenes/vote.php");

	elgg_register_action("encuestas_examenes/saveExamen", __DIR__ . "/actions/encuestas_examenes/saveExamen.php");

	elgg_register_action("encuestas_examenes/send", __DIR__ . "/actions/encuestas_examenes/send.php");

	elgg_register_action("encuestas_examenes/editExamen", __DIR__ . "/actions/encuestas_examenes/editExamen.php");

	elgg_register_action("encuestas_examenes/editEncuesta", __DIR__ . "/actions/encuestas_examenes/editEncuesta.php");

	elgg_register_css('mycss', elgg_get_simplecache_url('mycss.css'));

	//Hook handler para sobrescribir las URL's
    	elgg_register_plugin_hook_handler('entity:url', 'object', 'encuestas_examenes_set_url');

}

function encuestas_examenes_page_handler($segments) {
	
	switch ($segments[0]) {
		case 'addEncuesta':
			echo elgg_view_resource('encuestas_examenes/addEncuesta');
			break;

		case 'addExamen':
			echo elgg_view_resource('encuestas_examenes/addExamen');
			break;

		case 'viewEncuesta':
		    $resource_vars['guid'] = elgg_extract(1, $segments);
		    echo elgg_view_resource('encuestas_examenes/viewEncuesta', $resource_vars);
		    break;

		case 'viewExamen':
		    $resource_vars['guid'] = elgg_extract(1, $segments);
		    echo elgg_view_resource('encuestas_examenes/viewExamen', $resource_vars);
		    break;

		case 'examen':
		    $resource_vars['guid'] = elgg_extract(1, $segments);
		    echo elgg_view_resource('encuestas_examenes/fillExamen', $resource_vars);
		    break;

		case 'encuesta':
		    $resource_vars['guid'] = elgg_extract(1, $segments);
		    echo elgg_view_resource('encuestas_examenes/fillEncuesta', $resource_vars);
		    break;

		case 'myresultEncuesta':
			$resource_vars['guid'] = elgg_extract(1, $segments);
			echo elgg_view_resource('encuestas_examenes/myresultEncuesta', $resource_vars);
			break;

		case 'myresultExamen':
			$resource_vars['guid'] = elgg_extract(1, $segments);
			echo elgg_view_resource('encuestas_examenes/myresultExamen', $resource_vars);
			break;

		case 'resultsEncuesta':
			$resource_vars['guid'] = elgg_extract(1, $segments);
			echo elgg_view_resource('encuestas_examenes/resultsEncuesta', $resource_vars);
			break;

		case 'resultsExamen':
			$resource_vars['guid'] = elgg_extract(1, $segments);
			echo elgg_view_resource('encuestas_examenes/resultsExamen', $resource_vars);
			break;


		case 'correction':
			$resource_vars['guid'] = elgg_extract(1, $segments);
			echo elgg_view_resource('encuestas_examenes/correctionExamen', $resource_vars);
			break;

		case 'eliminarExamen':
			$resource_vars['guid'] = elgg_extract(1, $segments);
			echo elgg_view_resource('encuestas_examenes/eliminarExamen', $resource_vars);
			break;

		case 'eliminarEncuesta':
			$resource_vars['guid'] = elgg_extract(1, $segments);
			echo elgg_view_resource('encuestas_examenes/eliminarEncuesta', $resource_vars);
			break;

		case 'reiniciarExamen':
			$resource_vars['guid'] = elgg_extract(1, $segments);
			echo elgg_view_resource('encuestas_examenes/reiniciarExamen', $resource_vars);
			break;

		case 'reiniciarEncuesta':
			$resource_vars['guid'] = elgg_extract(1, $segments);
			echo elgg_view_resource('encuestas_examenes/reiniciarEncuesta', $resource_vars);
			break;

		case 'csvExamen':
			$resource_vars['guid'] = elgg_extract(1, $segments);
			echo elgg_view_resource('encuestas_examenes/csvExamen', $resource_vars);
			break;

		case 'csvEncuesta':
			$resource_vars['guid'] = elgg_extract(1, $segments);
			echo elgg_view_resource('encuestas_examenes/csvEncuesta', $resource_vars);
			break;

		case 'all':
			default:
		  	echo elgg_view_resource('encuestas_examenes/all');
		   	break;

	    }

    	return true;
}

function examen_page_handler($segments) {
	
	switch ($segments[0]) {
		case 'edit':
			$resource_vars['guid'] = elgg_extract(1, $segments);
		  	//echo elgg_view_resource('encuestas_examenes/all');
			$encuesta_examen = get_entity($resource_vars['guid']);
			if(elgg_instanceof($encuesta_examen, 'object', 'examen')){
				echo elgg_view_resource('encuestas_examenes/editExamen', $resource_vars);
			}

			break;
		case 'owner':
			$resource_vars['username'] = elgg_extract(1, $segments);
 			//return "encuestas_examenes/all";
			echo elgg_view_resource('encuestas_examenes/allFilterExamen', $resource_vars);
	}
	
}

function encuesta_page_handler($segments) {
	
	switch ($segments[0]) {
		case 'edit':
			$resource_vars['guid'] = elgg_extract(1, $segments);
		  	//echo elgg_view_resource('encuestas_examenes/all');
			$encuesta_examen = get_entity($resource_vars['guid']);
			if(elgg_instanceof($encuesta_examen, 'object', 'encuesta')){
				echo elgg_view_resource('encuestas_examenes/editEncuesta', $resource_vars);
			}

			break;
		case 'owner':
			$resource_vars['username'] = elgg_extract(1, $segments);
 			//return "encuestas_examenes/all";
			echo elgg_view_resource('encuestas_examenes/allFilterEncuesta', $resource_vars);
	}
	
}

function encuestas_examenes_set_url($hook, $type, $url, $params) {
    $entity = $params['entity'];
    if (elgg_instanceof($entity, 'object', 'encuesta')) {
        return "encuestas_examenes/viewEncuesta/{$entity->guid}";
    }

    if (elgg_instanceof($entity, 'object', 'voto')) {
        return "encuestas_examenes/myresultEncuesta/{$entity->guid}";
    }

    if (elgg_instanceof($entity, 'object', 'resultados')) {
        return "encuestas_examenes/resultsEncuesta/{$entity->guid}";
    }

    if (elgg_instanceof($entity, 'object', 'resultadosExamen')) {
        return "encuestas_examenes/resultsExamen/{$entity->guid}";
    }

    if (elgg_instanceof($entity, 'object', 'examen')) {
        return "encuestas_examenes/viewExamen/{$entity->guid}";
    }

    if (elgg_instanceof($entity, 'object', 'respuesta')) {
        return "encuestas_examenes/myresultExamen/{$entity->guid}";
    }

}


