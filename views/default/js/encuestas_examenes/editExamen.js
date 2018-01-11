elgg.provide('elgg.encuestas_examenes');

elgg.encuestas_examenes.init_editExamen = function() {
var elgg = require('elgg');

//Añadir los campos marcados de cb y radios Y si hay regex en las preguntas de texto
for($i=0; $i < $('#totalQ').val() ; $i++){
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

}


 $numR = 1;
 $numQ = 0;

//$elggDrag = $('.drag');
//$elggDelete = $('.delete');

$localtime = new Date(); 
$('#nowlocal').attr('value', $localtime);


 $('.questionType').change(function(event){

	//$q es el número de la pregunta
	$q = $(event.target).attr('name').substring(12);
	$type = document.getElementById("questionType"+$q).value;
	$element = $(event.target).parents('.question');
	switch($type){
		case "Checkboxes":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();	
			$element.find('.answ_rec'+$q).hide();
			$element.find('.answ'+$q).hide();	
			$element.find('.answ'+ $q +'.answCB').show();
			break;

		case "Radio":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();
			$element.find('.answ_rec'+$q).hide();
			$element.find('.answ'+$q).hide();	
			$element.find('.answ'+ $q +'.answR').show();

			break;

		case "Text":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();
			$element.find('.answ_rec'+$q).hide();
			$element.find('.answ'+$q).hide();	
			$element.find('.answ'+ $q +'.answT').show();
			break;

		case "Long Text":
			$('#qType'+$q).val($type);
			$('#Qtitle'+$q).show();
			$element.find('.answ_rec'+$q).hide();
			$element.find('.answ'+$q).hide();	
			$element.find('.answ'+ $q +'.answLT').show();
			break;
			
	}

	
 });


 $('.lastR.cb').on('focus', function(event) {

	//$(event.target).css({"color": "red", "border": "2px solid red"});

	if($(event.target).hasClass('lastR')){
		$lastli = $(event.target).parents('li');
		$clone = $lastli.clone(true);
		$lastli.children().children('.lastR').removeClass('lastR');
		$numR = $(event.target).attr('name')[2];
		$numR++;
		$numQ = $(event.target).parents('.question').attr('data-numq');
		$clone.find('.elgg-input-checkbox').attr('name','CB' + $numQ + '[]');
		$clone.find('.elgg-input-checkbox').attr('value','r' + $numQ + $numR + 'CB');
		$clone.find('.elgg-input-text').css('width', '90%');
		$clone.find('.elgg-input-text').attr('name', 'r' + $numQ + $numR + 'CB');
		$clone.find('.elgg-input-text').attr('placeholder', elgg.echo('encuestas_examenes:respuesta') + $numR);
		$clone.find('.elgg-input-text').removeAttr('required');
		$clone.find('.elgg-input-text').val('');
		$clone.addClass('answ');
		if($clone.find('.elgg-input-checkbox').is(':checked')){
			$clone.find('.elgg-input-checkbox').attr('checked', false);
			$lastli.find('.elgg-input-checkbox').attr('checked', true);
		}
		
		$lastli.after($clone);

	}

 });


 $('.lastR.radio').on('focus', function(event) {

	//$(event.target).css({"color": "red", "border": "2px solid red"});

	if($(event.target).hasClass('lastR')){
		$lastli = $(event.target).parents('li');
		$clone = $lastli.clone(true);
		$lastli.children().children('.lastR').removeClass('lastR');
		$numR = $(event.target).attr('name')[2];
		$numR++;
		$numQ = $(event.target).parents('.question').attr('data-numq');

		$clone.find('.elgg-input-radio').attr('name','R' + $numQ);
		$clone.find('.elgg-input-radio').val('r' + $numQ + $numR + 'R');
		$clone.find('.elgg-input-text').css('width', '90%');
		$clone.find('.elgg-input-text').attr('name', 'r' + $numQ + $numR + 'R');
		$clone.find('.elgg-input-text').attr('placeholder', elgg.echo('encuestas_examenes:respuesta') + $numR);
		$clone.find('.elgg-input-text').removeAttr('required');
		$clone.find('.elgg-input-text').val('');
		$clone.addClass('answ');
		if($clone.find('.elgg-input-radio').is(':checked')){
			$clone.find('.elgg-input-radio').attr('checked', false);
			$lastli.find('.elgg-input-radio').attr('checked', true);
		}

		$lastli.after($clone);

	}

 });

 $('.new').on('click', function(event) {;
	$lastdiv = $('.lastQ');
	$clone = $lastdiv.clone(true);
	$lastdiv.removeClass('lastQ');

	$numQ = $(event.target).attr('id').substring(3);
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
	


	//CB
	$clone.find('.answCB').find('.answ').remove();
	$clone.find('.answCB').attr('class', 'hidden answCB elgg-discover answ' + $numQ);
	$clone.find('.answCB input').attr('name', 'CB' + $numQ);
	$clone.find('.answCB li .elgg-input-text').val('');
	$clone.find('.answCB li .elgg-input-checkbox').val("r"+$numQ+'1CB');
	$clone.find('.answCB li .elgg-input-checkbox').attr('name', 'CB' + $numQ + '[]');	
	$clone.find('.answCB li .elgg-input-checkbox').attr('checked', false);		
	$clone.find('.answCB li .elgg-input-text').addClass('lastR');
	$clone.find('.answCB li .elgg-input-text').attr('name', 'r' + $numQ + '1CB');

	//Radio
	$clone.find('.answR').find('.answ').remove();
	$clone.find('.answR').attr('class', 'hidden answR elgg-discover answ' + $numQ);
	$clone.find('.answR li .elgg-input-text').val("");
	$clone.find('.answR li .elgg-input-radio').val("r"+$numQ+'1R');
	$clone.find('.answR li .elgg-input-radio').attr('name', 'R'+$numQ);
	$clone.find('.answR li .elgg-input-radio').attr('checked', false);		
	$clone.find('.answR li .elgg-input-text').addClass('lastR');
	$clone.find('.answR li .elgg-input-text').attr('name', 'r' + $numQ + '1R');

	//Text y longtext
	$clone.find('.answT input').attr('name', 'regexT' + $numQ);
	$clone.find('.regexT').attr('name', 'regexT' + $numQ);
	$clone.find('.regexT').attr('checked', false);
	
	$clone.find('.answLT input').attr('name', 'regexLT' + $numQ);
	$clone.find('.regexLT').attr('name', 'regexLT' + $numQ);
	$clone.find('.regexLT').attr('checked', false);

	$clone.find('.answT').attr('class', 'hidden answT elgg-discover text-regex answ' + $numQ);
	$clone.find('.answLT').attr('class', 'hidden answLT elgg-discover text-regex answ' + $numQ);
	$clone.find('.answT .elgg-input-text').attr('name', 'r' + $numQ + '1T');
	$clone.find('.answT .elgg-input-text').val('');
	$clone.find('.answLT textarea').attr('name', 'r' + $numQ + '1LT');
	$clone.find('.answLT textarea').val('');

	$clone.find('.answCB').hide();
	$clone.find('.answR').hide();
	$clone.find('.answLT').hide();
	$clone.find('.answT').show();


	//Fallos y aciertos
	$clone.find('.acierto').attr('id', 'acierto'+$numQ);
	$clone.find('.acierto').attr('name', 'acierto'+$numQ);
	$clone.find('.acierto').val('');

	$clone.find('.fallo').attr('id', 'fallo'+$numQ);
	$clone.find('.fallo').attr('name', 'fallo'+$numQ);
	$clone.find('.fallo').val('');

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
elgg.register_hook_handler('init', 'system', elgg.encuestas_examenes.init_editExamen);
