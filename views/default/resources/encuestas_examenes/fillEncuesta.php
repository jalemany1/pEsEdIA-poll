<?php
// get the entity
$guid = elgg_extract('guid', $vars);
$encuesta = get_entity($guid);

/*elgg_register_menu_item('title', array(
	'name' => 'resultsEncuesta',
	'href' => 'encuestas_examenes/resultsEncuesta/'. $encuesta->resultadosguid,
	'text' => elgg_echo('encuestas_examenes:all_results'),
	'link_class' => 'elgg-menu-content',
));*/

$param['guid'] = $guid;

$content = elgg_view_form("encuestas_examenes/vote", null, $param);


// optionally, add the content for the sidebar
//$sidebar = "";

// layout the page
$body = elgg_view_layout('one_sidebar', array(
   'title' => $encuesta->title,
   'content' => $content,
   //'sidebar' => $sidebar
));

// draw the page, including the HTML wrapper and basic page layout
echo elgg_view_page($title, $body);
