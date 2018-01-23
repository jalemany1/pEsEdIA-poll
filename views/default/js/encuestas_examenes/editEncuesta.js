elgg.provide('elgg.encuestas_examenes');

elgg.encuestas_examenes.init_editEncuesta = function() {
	var elgg = require('elgg');

$localtime = new Date(); 
$('#nowlocal').attr('value', $localtime);


 $('.questionType').change(function(event){
	$type = event.target.value;
	$element = $(event.target).parents('.question');
	switch($type){
		case "Radio":
		case "Checkboxes":
			$element.find('.qType').val($type);
			$element.find('.Qtitle').show();
            $element.find('.answ').show();
            $element.find('.lastR').show();
			break;
		case "Text":
		case "Long Text":
			$element.find('.qType').val($type);
			$element.find('.Qtitle').show();
            $element.find('.answ').hide();
            $element.find('.lastR').hide();
			break;			
	}
 });

 $('.lastR input').focus(function(event) {
	$lastli = $(event.target).parents('.lastR');
	$clone = $lastli.clone(true);
	$lastli.addClass('answ').removeClass('lastR');

	$numQ = $lastli.attr('data-numquestion');
	$numR = $lastli.attr('data-index');
	$numR++;

	$clone.attr('data-index', $numR);
	$clone.find('input').attr('name', 'q' + $numQ + 'r' + $numR);
	$clone.find('input').attr('placeholder', elgg.echo('encuestas_examenes:respuesta') + $numR);
	$clone.find('input').attr('value', '');
	$clone.removeClass('answ');
	$lastli.after($clone);
 });

 $('.new').on('click', function(event) {;
	$lastdiv = $('.lastQ');

	$clone = $lastdiv.clone(true);
	$lastdiv.removeClass('lastQ');

	$numQ = $(event.target).attr('id').substring(3);
	$numQ++;
	$clone.attr('data-numQ', $numQ);

	$clone.find('.labelTitulo').attr('for', 'questionType' + $numQ);
	$clone.find('.labelTitulo').html(elgg.echo('encuestas_examenes:qType_label'));

	$clone.find('.questionType').attr('id', 'questionType' + $numQ);
	$clone.find('.questionType').attr('name', 'questionType' + $numQ);

	$clone.find('.qType').attr('name', 'qType' + $numQ);
	$clone.find('.qType').attr('id', 'qType' + $numQ);
	$clone.find('.qType').val("Text");

	$clone.find('.Qtitle').attr('id', 'Qtitle' + $numQ);
	$clone.find('.Qtitle').attr('name', 'Pregunta' + $numQ);
	$clone.find('.Qtitle').attr('placeholder', elgg.echo('encuestas_examenes:pregunta'));
	$clone.find('.Qtitle').attr('value', '');

	//Respuestas
	$answ = $clone.find('.lastR');
	$answ_input = $answ.find('input'); 
	$clone.find('.answ').remove();
	$answ_input.attr('value', '');
	$answ_input.attr('name', 'q'+$numQ+'r1');
	$answ_input.attr('placeholder', elgg.echo('encuestas_examenes:respuesta') + 1);
	$answ.attr('data-index', 1);
	$answ.attr('data-numquestion', $numQ);
	$answ.hide();

    //Required
    $clone.find('.divReq input').attr('name', 'requiredQ' + $numQ);
    $clone.find('.divReq input').attr('checked', false);

    //NEW
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
