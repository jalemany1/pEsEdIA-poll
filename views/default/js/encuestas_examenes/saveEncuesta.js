
elgg.provide('elgg.encuestas_examenes');

elgg.encuestas_examenes.init_edit = function() {
 var elgg = require('elgg');
 $numR = 1;
 $numQ = 0;

 $localtime = new Date(); 
 $('#nowlocal').attr('value', $localtime);

 $('.questionType').change(function(event){
	$q = $(event.target).attr('name')[12];
	$type = document.getElementById("questionType"+$q).value;
	$element = $(event.target).parents('.question');
	switch($type){

		case "Checkboxes":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();	
			$element.find('.answ1').show();
			break;

		case "Radio":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();	
			$element.find('.answ1').show();
			break;

		case "Text":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();
			$element.find('.answ1').hide();
			break;

		case "Long Text":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();
			$element.find('.answ1').hide();
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

 $('.new').on('click', function(event) {

	$lastdiv = $('.lastQ');

	$clone = $lastdiv.clone(true);
	$lastdiv.removeClass('lastQ');

	$numQ = $(event.target).attr('id')[3];
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
	$clone.find('.Qtitle').val("");
	


	$clone.find('.answ').remove();
	$clone.find('.answ1 input').val("");
	$clone.find('.answ1 input').attr('name', 'r'+$numQ+'1');
	$clone.find('.answ1').addClass('lastR');
	$clone.find('.answ1').attr('data-numquestion', $numQ);
	$clone.find('.answ1').hide();

	//Required
	$clone.find('.divReq input').attr('name', 'requiredQ' + $numQ);
	//$clone.find('.divReq input .elgg-input-checkbox').attr('name', 'requiredQ'+$numQ);
	$clone.find('.divReq input').attr('checked', false);
	//$clone.find('.divReq input').val('0');



	//NEW
	$(event.target).attr('id', 'new'+ $numQ);
	$('#numQuestions').val($numQ);
	// /NEW
	
	//$clone.find('.new').attr('id', 'new'+$numQ);
	//$('#new'+$lastdiv.data().numq).hide();

	$lastdiv.after($clone);

 });


//Borrar pregunta
 $('.delete-question').on('click', function(event) {
	if($(event.target).parents('.question').hasClass('lastQ')){
		if($(event.target).parents('.question').prev().hasClass('question')){
			$(event.target).parents('.question').prev().addClass('lastQ');
			$(event.target).parents('.question').remove();
		}else{
			elgg.register_error(elgg.echo('encuestas_examenes:delete_last_q_encuesta'));
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
elgg.register_hook_handler('init', 'system', elgg.encuestas_examenes.init_edit);
