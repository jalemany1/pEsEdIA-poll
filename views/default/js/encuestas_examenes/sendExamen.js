elgg.provide('elgg.encuestas_examenes');

elgg.encuestas_examenes.init_sendExamen = function() {
	var elgg = require('elgg');
	
	$examen_guid = $('input[name=guid]').val();

	if($('#hideFullbody').val() == 'YES'){
	//alert($('#hideFullbody').val());
		 $('.fullbody').hide();
	}

	$duration = $('#clock').text();

	//Check if there is a timeoff
	if (typeof $duration !== 'undefined') {
		//CAMBIAR A 60000 CUANDO SE TERMINEN LAS PRUEBAS
  		var stop = setInterval(countdown, 60000);	
		$rest = -1;
		function countdown(){
		
			if($rest == -1){
				$rest = $('#clock').text()-1;
			}else{
				$rest = $rest-1;
			}

			$bar = ($rest*100) / $duration;
			$('.timeLeft').css("width", $bar + '%');

			if($rest == 0){
				clearInterval(stop);
				//$('#contentNOtime').show();
				//$('.fullbody').hide();
				//Automatic send when time is off
				if($('#noDuration').val() == '0'){
					if($('#automaticSend').val() == 'YES'){
						$('form.elgg-form').submit();
					}					
   					elgg.forward('encuestas_examenes/all?tab=examen');
				}
			}else{
				if($('.fullbody').is(":visible")){
					//$rest = $rest-1;
					$('#clock').text($rest);
				}		
			}		
		}
	}


	$(".elgg-form-encuestas-examenes-send").on('submit', function(e){
		$empty = 0;
		$required = false;
		for($i=1;$i<=$('#numQExamen').val();$i++){
			$nomQ = 'Pregunta'+$i;
			$qType = $("[name=qType"+$i+"]").val();

			switch($qType){
				case "Text":
					if($('#'+$nomQ).val() == ''){
						$empty++;
						if($('#'+$nomQ).hasClass('requiredQ')){
							$required = true;
						}	
					}
					break;
				case "Long Text":
					if($('#'+$nomQ).val() == ''){
						$empty++;

						if($('#'+$nomQ).hasClass('requiredQ')){
							$required = true;
						}					
					}
					break;
				case "Checkboxes":
					if($('.elgg-input-checkboxes :checkbox:checked').length <= 0){
						$empty++;

						if($('#'+$nomQ).hasClass('requiredQ')){
							$required = true;
						}				
					}
					break;
				case "Radio":
					if($('.elgg-input-radios :radio:checked').length <= 0){
						$empty++;

						if($('#'+$nomQ).hasClass('requiredQ')){
							$required = true;
						}				
					}
					break;
			
				default:
					$empty++;
					break;

				}

			//alert($empty + '----' +$required);
		
		}
		if($('#emptyResults').val() != 'NO' && $empty == $('#numQExamen').val() && $('.timeLeft').width() != 0){
			//alert($('.timeLeft').width());
			e.preventDefault();
			elgg.register_error(elgg.echo('encuestas_examenes:quiz_empty'));
		}
		if($required && $empty){
			e.preventDefault();
			elgg.register_error(elgg.echo('encuestas_examenes:required_necessary'));
		}


	});
		
		//For any reason, if we invoke the elgg_view_form and any content inside the <fieldset> of the form has a width bigger than the
		//form itself the text overflow the form container, with this we can control that. Note: It only happens with text with no spaces
		if($('fieldset').width() > $('fieldset').parent().width()){
			//alert($('fieldset').parent().width());
			$('fieldset').css("width", $('fieldset').parent().width());
		}

};

//register init hook
elgg.register_hook_handler('init', 'system', elgg.encuestas_examenes.init_sendExamen);
