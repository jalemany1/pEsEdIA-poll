<?php

// make sure only logged in users can see this page
gatekeeper();

elgg_load_css('mycss');

$guid = elgg_extract('guid', $vars);
$examen = get_entity($guid);

// set the title
$title = elgg_echo('encuestas_examenes:edit_quiz');

// start building the main column of the page

$param['guid'] = $guid;

// add the form to the main column
$content .= elgg_view_form("encuestas_examenes/editExamen", null, $param);

// optionally, add the content for the sidebar
//$sidebar = "";

// layout the page
$body = elgg_view_layout('one_sidebar', array(
   'title' => $title,
   'content' => $content,
   //'sidebar' => $sidebar
));

// draw the page, including the HTML wrapper and basic page layout
echo elgg_view_page($title, $body);
