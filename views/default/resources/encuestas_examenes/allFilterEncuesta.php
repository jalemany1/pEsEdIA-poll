<?php


$username = elgg_extract('username', $vars);
//echo(var_dump(get_user_by_username($username)->guid));

$enex = elgg_list_entities(array(
	'type' => 'object',
	'subtype' => 'encuesta',
	'owner_guid'=> get_user_by_username($username)->guid,

));

$pagetitle = elgg_echo("encuestas_examenes:user_polls", array($username));

$params = array('title' => $pagetitle, 'content' => $enex);
$params['filter'] = '';


$body = elgg_view_layout('content', $params);

echo elgg_view_page($pagetitle, $body);

