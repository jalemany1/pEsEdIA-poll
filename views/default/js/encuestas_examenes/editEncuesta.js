elgg.provide('elgg.encuestas_examenes');

elgg.encuestas_examenes.init_editEncuesta = function() {
var elgg = require('elgg');

//Añadir los campos marcados de cb y radios Y si hay regex en las preguntas de texto
/*for($i=0; $i < $('#totalQ').val() ; $i++){
	$q_num = $i+1;

	$list = $('.answ_rec'+$q_num +' li .cb').length;

	$r_num = 1;
	for($j=0; $j < $list; $j++){
		if( $('.answ_rec'+$q_num +' li .resp_rec'+$r_num).hasClass('ck')){
			$('.answ_rec'+$q_num +' li .resp_rec'+$r_num).siblings().attr('checked','true');
		}

	$r_num++;
	}

	$r_num_r = 1;
	$list_r = $('.answ_rec'+$q_num +' li .radio').length;
	for($j=0; $j < $list_r; $j++){
		if( $('.answ_rec'+$q_num +' li .resp_rec'+$r_num_r).hasClass('ck')){
			$('.answ_rec'+$q_num +' li .resp_rec'+$r_num_r).siblings().attr('checked','true');
		}

	$r_num_r++;
	}

	if( $('.answ_rec'+$q_num +' .regexT').hasClass('ck')){
		$('.answ_rec'+$q_num +' .regexT').attr('checked','true');
	}

}*/


 $numR = 1;
 $numQ = 0;

//$elggDrag = $('.drag');
//$elggDelete = $('.delete');

$localtime = new Date(); 
$('#nowlocal').attr('value', $localtime);


 $('.questionType').change(function(event){

	//$q es el número de la pregunta
	$q = $(event.target).attr('name')[12];
	$type = document.getElementById("questionType"+$q).value;
	$element = $(event.target).parents('.question');
	switch($type){
		case "Checkboxes":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();	
			$element.find('.answ_rec'+$q).hide();
			$element.find('.answ'+$q).hide();	
			$element.find('.answ'+ $q +'.answRes').show();
			break;

		case "Radio":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();
			$element.find('.answ_rec'+$q).hide();
			$element.find('.answ'+$q).hide();	
			$element.find('.answ'+ $q +'.answRes').show();

			break;

		case "Text":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();
			$element.find('.answ_rec'+$q).hide();
			$element.find('.answ'+$q).hide();	
			//$element.find('.answ'+ $q +'.answT').show();
			break;

		case "Long Text":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();
			$element.find('.answ_rec'+$q).hide();
			$element.find('.answ'+$q).hide();	
			//$element.find('.answ'+ $q +'.answLT').show();
			break;
			
	}

	
 });

 $('.lastR input').focus(function(event) {
	$lastli = $(event.target).parents('.lastR');
	$clone = $lastli.clone(true);
	$lastli.removeClass('lastR');
	$numR = $(event.target).attr('name')[2];
	$numR++;
	$numQ = $(event.target).attr('name')[1];
	$clone.attr('data-index', $numR);
	$clone.find('input').attr('name', 'r' + $numQ + $numR);
	$clone.find('input').attr('placeholder', elgg.echo('encuestas_examenes:respuesta') + $numR);
	$clone.find('input').val('');
	$clone.addClass('answ');
	//$prev = $numR-1;
	//$clone.removeClass('answ'+$prev).addClass('answ'+$numR);
	$lastli.after($clone);
 });

 $('.new').on('click', function(event) {;
	$lastdiv = $('.lastQ');
	$clone = $lastdiv.clone(true);
	$lastdiv.removeClass('lastQ');

	$numQ = $(event.target).attr('id')[3];
	$numQ++;
	$clone.attr('data-numQ', $numQ);

	$clone.find('.rec').remove();
	
	$clone.find('.labelTitulo').attr('for', 'questionType' + $numQ);
	$clone.find('.labelTitulo').html(elgg.echo('encuestas_examenes:qType_label'));

	$clone.find('.questionType').attr('id', 'questionType' + $numQ);
	$clone.find('.questionType').attr('name', 'questionType' + $numQ);
	$clone.find('.questionType').val('Text');

	$clone.find('.qType').attr('name', 'qType' + $numQ);
	$clone.find('.qType').attr('id', 'qType' + $numQ);
	$clone.find('.qType').val("Text");

	$clone.find('.Qtitle').attr('id', 'Qtitle' + $numQ);
	$clone.find('.Qtitle').attr('name', 'Pregunta' + $numQ);
	$clone.find('.Qtitle').attr('placeholder', elgg.echo('encuestas_examenes:pregunta'));
	$clone.find('.Qtitle').val("");
	
	//Respuestas
	//$clone.find('.answCB').find('.answ').remove();
	$clone.find('.answRes').attr('class', 'hidden lastR answRes answ' + $numQ);
	$clone.find('.answRes input').attr('name', 'r' + $numQ + '1');
	$clone.find('.answRes input').val('');
	//$clone.find('.answRes input').val("r"+$numQ+'1');
	//$clone.find('.answCB li .elgg-input-checkbox').attr('name', 'CB' + $numQ + '[]');	
	//$clone.find('.answCB li .elgg-input-checkbox').attr('checked', false);		
	//$clone.find('.answRes input').addClass('lastR');
	//$clone.find('.answCB li .elgg-input-text').attr('name', 'r' + $numQ + '1CB');


	//Required
	$clone.find('.divReq input').attr('name', 'requiredQ' + $numQ);
	$clone.find('.divReq input').attr('checked', false);

	$(event.target).attr('id', 'new'+ $numQ);
	$('#numQuestions').val($numQ);	

	$lastdiv.after($clone);

 });

//Borrar pregunta
 $('.delete-question').on('click', function(event) {
	if($(event.target).parents('.question').hasClass('lastQ')){
		if($(event.target).parents('.question').prev().hasClass('question')){
			$(event.target).parents('.question').prev().addClass('lastQ');
			$(event.target).parents('.question').remove();
		}else{
			elgg.register_error(elgg.echo('encuestas_examenes:delete_last_q'));
		}

	}else{
		$(event.target).parents('.question').remove();
	}
 });

 //Formulario en dos fases

 $('.next').on('click', function(event) {
	$('#configuracion').hide();
	$('#preguntas').show();
 });

 $('.back').on('click', function(event) {
	$('#configuracion').show();
	$('#preguntas').hide();
 });


 //CAMPOS OBLIGATORIOS
 //Parámetros de duración del examen

 $('#publishExamNow').on('click', function(event) {
	if(this.checked == false){
		$('#dateInicio').attr("required", "");
		$('#dateInicioHora').attr("required", "");
		$('#dateInicioMin').attr("required", "");
	}else{
		$('#dateInicio').removeAttr('required');
		$('#dateInicioHora').removeAttr('required');
		$('#dateInicioMin').removeAttr('required');
	}	


 });

 $('#noEndDate').on('click', function(event) {
	if(this.checked == false){
		$('#dateFin').attr("required", "");
		$('#timeFinHora').attr("required", "");
		$('#timeFinMin').attr("required", "");
	}else{
		$('#dateFin').removeAttr('required');
		$('#timeFinHora').removeAttr('required');
		$('#timeFinMin').removeAttr('required');
	}	


 });

 $('#noDuration').on('click', function(event) {
	if(this.checked == false){
		$('#duration').attr("required", "");

	}else{
		$('#duration').removeAttr('required');

	}	


 });

 $('#resendParams').on('click', function(event) {
	if($('input[name="resendParams"]:checked').val() == 'specialSend'){
		$('#customResend').show();
		$('#customResendLabel').show();

	}else{
		$('#customResend').hide();
		$('#customResendLabel').hide();

	}	


 });


};

//register init hook
elgg.register_hook_handler('init', 'system', elgg.encuestas_examenes.init_editEncuesta);
