<?php
//Permitir que solo usuarios registrados accedan a la página
gatekeeper();

$title = elgg_echo("encuestas_examenes:crear_encuesta");

$content .= elgg_view_form("encuestas_examenes/saveEncuesta");

// optionally, add the content for the sidebar
//$sidebar = "";

// layout the page
$body = elgg_view_layout('one_sidebar', array(
   'title' => $title,
   'content' => $content,
   //'sidebar' => $sidebar
));

echo elgg_view_page($title, $body);
