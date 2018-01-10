<?php

$filter_context = elgg_extract('filter_context', $vars, 'all');

$tabs = [
    	'encuesta',
	'examen',
];

foreach ($tabs as $tab) {
    elgg_register_menu_item('filter', [
        'name' => $tab,
        'text' => elgg_echo("encuestas_examenes:$tab"),
        'href' => elgg_http_add_url_query_elements(current_page_url(), ['tab' => $tab]),
        'selected' => $tab == $filter_context,
    ]);
}

echo elgg_view_menu('filter', [
    'sort_by' => 'priority',
]);
