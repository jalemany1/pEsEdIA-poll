<?php

return [
        'encuestas_examenes' => "Encuestas y Exámenes",
	'encuestas_examenes:encuestas' => "Encuestas",
	'encuestas_examenes:examenes' => "Exámenes",
	//All
	'encuestas_examenes:add_encuesta'=> "Añadir encuesta",
	'encuestas_examenes:add_examen'=> "Añadir examen",
	'encuestas_examenes:list' => "Listado de ",
	'encuestas_examenes:encuesta' => "Encuestas",
	'encuestas_examenes:examen' => "Exámenes",
	//addExamen
	'encuestas_examenes:crear_examen' => "Crear nuevo examen",
	//addEncuesta
	'encuestas_examenes:crear_encuesta' => "Crear nueva encuesta",
	//forms/saveExamen
	'encuestas_examenes:titulo'=> 'Título',
	'encuestas_examenes:descripcion_examen'=> 'Descripción (opcional)',
	'encuestas_examenes:duration_config' => 'Fechas y tiempo límite de respuesta:',
	'encuestas_examenes:publishNow'=>'Publicar directamente',
	'encuestas_examenes:start_date'=>'Fecha de inicio: ',
	'encuestas_examenes:start_time'=>'Hora de inicio:',
	'encuestas_examenes:noEndDate'=>'Sin fecha de entrega',
	'encuestas_examenes:end_date'=>'Fecha de entrega:',
	'encuestas_examenes:end_time'=>'Hora de entrega:',
	'encuestas_examenes:noDuration'=>'Sin límite de tiempo',
	'encuestas_examenes:duration'=>'Tiempo de respuesta máximo:',
	'encuestas_examenes:min'=>' min',
	'encuestas_examenes:automaticSend'=>'Enviar respuestas automáticamente cuando el tiempo se agote.',
	'encuestas_examenes:resend'=>'Número de envíos permitidos:',
	'encuestas_examenes:oneSend'=>'Permitir el envío de una única respuesta',
	'encuestas_examenes:multipleSend'=>'Permitir el envío ilimitado de respuestas',
	'encuestas_examenes:specialSend'=>'Permitir el envío de un número limitado de respeustas',
	'encuestas_examenes:customResend'=>'Envíos permitidos:',
	'encuestas_examenes:seeResults'=>'Visualización de resultados:',
	'encuestas_examenes:seeMark'=>'Permitir que el usuario vea su nota una vez haya enviado el examen.',
	'encuestas_examenes:seeMarkCorrection'=>'Permitir que el usuario vea su nota y los resultados correctos una vez haya enviado el examen.',
	'encuestas_examenes:seeNothing'=>'No permitir que el usuario vea su nota ni los resultados correctos una vez haya enviado el examen.',
	'encuestas_examenes:score_params'=>'Puntuación del examen: ',
	'encuestas_examenes:score_notes'=> 'La puntuación total del examen será la suma de las notas individuales de las preguntas escalado a 10, por lo que 10 siempre será la nota máxima. En caso de establecer una nota mínima para aprobar el examen, se mostrará junto a la nota del usuario si el examen está aprobado o suspenso. Para ello, la nota mínima para aprobar debe ser un valor que vaya del 0 al 10.',
	'encuestas_examenes:passScore'=>'Puntuación mínima con la que se aprobará el examen (Opcional): ',
	'encuestas_examenes:emptyResults'=>'Permitir el envío de un examen vacío.',
	'encuestas_examenes:access'=>'Acceso al examen: ',
	'encuestas_examenes:privado'=>'Privado',
	'encuestas_examenes:amigos'=>'Amigos',
	'encuestas_examenes:ausuarios_autenticados'=>'Usuarios registrados',
	'encuestas_examenes:publico'=>'Público',
	'encuestas_examenes:qType_label'=>'Seleccione el tipo de pregunta que desee añadir: ',
	'encuestas_examenes:checkboxes'=>'Respuesta múltiple',
	'encuestas_examenes:radio'=>'Respuesta única',
	'encuestas_examenes:text'=>'Texto',
	'encuestas_examenes:long_text'=>'Texto largo',
	'encuestas_examenes:pregunta'=>'Títlo de la pregunta',
	'encuestas_examenes:pregunta_nota_aclaratoria'=>'Nota: en caso de que no se señale ninguna respuesta como correcta la pregunta será considerada de respuesta libre, y cualquier respuesta introducida por el usuario que realice el examen será válida.',
	'encuestas_examenes:respuesta'=>'Respuesta ',
	'encuestas_examenes:regex'=>'Expresión regular',
	'encuestas_examenes:right_answer_text'=>'Respuesta Correcta (opcional)',
	'encuestas_examenes:question_mark_note'=>'Nota: Todas las puntuaciones, tanto aciertos como fallos, serán escaladas a 10.',
	'encuestas_examenes:success'=>'Puntuación acierto: ',
	'encuestas_examenes:fail'=>'Puntuación fallo (opcional) : - ',
	'encuestas_examenes:required'=>'Pregunta obligatoria',
	'encuestas_examenes:new'=>'Nueva pregunta',
	'encuestas_examenes:save'=>'Publicar',
	//js/saveExamen.js
	'encuestas_examenes:delete_last_q'=>"¡No se puede borrar la única pregunta del examen!",
	//js/saveEncuesta.js
	'encuestas_examenes:delete_last_q_encuesta' => "¡No se puede borrar la única pregunta de la encuesta!",
	//actions/saveExamen.php
	'encuestas_examenes:exam_saved' => 'El examen se ha guardado correctamente',
	'encuestas_examenes:exam_not_saved'=>'El examen no se ha podido guardar',
	//actions/saveEncuesta.php
	'encuestas_encuestaes:encuesta_saved'=> 'La encuesta se ha guardado correctamente',
	'encuestas_encuestaes:encuesta_not_saved' => 'La encuesta no se ha podido guardar',
	//resources/viewExamen
	'encuestas_examenes:view_exam_note'=>'Nota: Al acceder al examen el contador de envíos se activará, se envíe o no una respuesta, por lo que en caso de que el examen se pueda enviar una única vez no se podrá volver a acceder a él. En caso de envíos limitados, el contador de envios se reducirá en uno. En caso de envíos ilimitados, se podrá acceder al examen tantas veces como el usuario desee.',
	'encuestas_examenes:refresh'=>'Refrescar la página del examen también descontará un envío del examen.',
	'encuestas_examenes:access_exam'=>'Acceder al examen',
	'encuestas_examenes:my_result'=>'Ver mi resultado',
	'encuestas_examenes:my_correction'=>'Ver la corrección del examen',
	'encuestas_examenes:all_results'=>'Ver todos los resultados',
	'encuestas_examenes:edit_exam'=>'Editar examen',
	'encuestas_examenes:delete_exam_confirm'=>"¿Está seguro de que desea eliminar el examen?",
	'encuestas_examenes:delete_exam'=>'Eliminar examen',
	'encuestas_examenes:reset_exam_config'=>'¿Está seguro de que desea reiniciar el examen? Todas las respuestas se perderán.',
	'encuestas_examenes:reset_exam'=>'Reiniciar examen',
	//resources/viewEncuesta
	'encuestas_examenes:view_encuesta_note'=>'Nota: Al acceder a la encusta el contador de envíos se activará, se envíe o no una respuesta, por lo que en caso de que la encuesta se pueda enviar una única vez no se podrá volver a acceder a ella. En caso de envíos limitados, el contador de envios se reducirá en uno. En caso de envíos ilimitados, se podrá acceder a la encuesta tantas veces como el usuario desee.',
	'encuestas_examenes:refresh_encuesta'=>'Refrescar la página de la encuesta también descontará un envío de la misma.',
	'encuestas_examenes:access_encuesta'=>'Acceder a la encuesta',
	'encuestas_examenes:edit_encuesta'=>'Editar encuesta',
	'encuestas_examenes:delete_encuesta_confirm'=>"¿Está seguro de que desea eliminar la encuesta?",
	'encuestas_examenes:delete_encuesta'=>'Eliminar encuesta',
	'encuestas_examenes:reset_encuesta_config'=>'¿Está seguro de que desea reiniciar la encuesta? Todas las respuestas se perderán.',
	'encuestas_examenes:reset_encuesta'=>'Reiniciar encuesta',
	//forms/send.php
	'encuestas_examenes:early_date'=>"¡El examen todavía no se encuentra activo!",
	'encuestas_examenes:late_date'=>"¡El examen ya no se encuentra activo!",
	'encuestas_examenes:submit_num_exceded'=>"¡El examen ya se ha enviado el máximo de número de veces permitidas!",
 	'encuestas_examenes:question'=>'Pregunta ',
	'encuestas_examenes:question_success'=>'Acierto: +',
	'encuestas_examenes:question_fail'=>'/ Fallo: -',
	'encuestas_examenes:points'=>' puntos',
	'encuestas_examenes:send'=>'Enviar',
	'encuestas_examenes:one_sent'=>"¡El examen ya se ha enviado una vez!",
	//forms/vote.php
	'encuestas_examenes:early_date_encuesta'=>"¡La encuesta todavía no se encuentra activa!",
	'encuestas_examenes:late_date_encuesta'=>"¡La encuesta ya no se encuentra activa!",
	'encuestas_examenes:submit_num_exceded_encuesta'=>"¡La encuesta ya se ha enviado el máximo de número de veces permitidas!",
	'encuestas_examenes:one_sent_encuesta'=>"¡La encuesta ya se ha enviado una vez!",
	//objects/examen.php y /object/encuesta.php
	'encuestas_examenes:time_left'=>'Tiempo restante: ',
	'encuestas_examenes:time_gone'=>'¡El tiempo para realizar el examen se ha agotado!',
	'encuestas_examenes:num_submits'=>'Envíos permitidos: ',
	'encuestas_examenes:unlimited'=>'Ilimitados',
	'encuestas_examenes:remaining'=>'Envíos restantes: ',
	'encuestas_examenes:already_sent'=>"Aviso: El examen ya se ha enviado con esta cuenta de usuario, si lo envía de nuevo, los resutlados se sustuirán.",
	'encuestas_examenes:already_sent_encuesta'=>"Aviso: La encuesta ya se ha enviado con esta cuenta de usuario, si la envía de nuevo, los resutlados se sustuirán.",
	'encuestas_examenes:required_1'=>'Nota: Las preguntas que contengan un ',
	'encuestas_examenes:required_2'=> ' deberán ser respondidas obligatoriamente.',
	//actions/send.php
	'encuestas_examenes:ok_send'=>'Su examen se ha enviado correctamente',
	'encuestas_examenes:bad_send'=> 'No se ha podido enviar el examen',
	//actions/vote.php
	'encuestas_examenes:ok_send_poll'=>'Su encuesta se ha enviado correctamente',
	'encuestas_examenes:bad_send_poll'=> 'No se ha podido enviar la encuesta',
	//resources/correctionExamen.php
	'encuestas_examenes:no_answer'=>'No hay respuesta',
	'encuestas_examenes:ok_answer_regex'=>'Respuesta correcta (expresión regular): ',
	'encuestas_examenes:ok_answer'=>'Respuesta correcta: ',
	'encuestas_examenes:correction_title'=> 'Corrección: ',
	//resources/myresultExamen.php
	'encuestas_examenes:my_score'=>  'Nota: ',
	'encuestas_examenes:not_passed'=>' (Suspenso)',
	'encuestas_examenes:passed'=>' (Aprobado)',
	'encuestas_examenes:see_correction'=> 'Ver corrección',
	//resources/resultsExamen.php
	'encuestas_examenes:no_answers_yet'=> 'Todavía no hay ninguna respuesta',
	//resources/editExamen.php
	'encuestas_examenes:edit_quiz'=>"Editar examen",
	//resources/editEncuesta.php
	'encuestas_examenes:edit_poll'=>"Editar encuesta",
	//forms/editExamen.php
	'encuestas_examenes:edit_restart_note'=>'Nota: Por favor, recuerde que al editar solo esta opción el examen no se reiniciará, por lo que si el número de respuestas que ya ha enviado un usuario es mayor al nuevo número de respuestas permitidas, dicho usuario no podrá volver a realizar el examen.',
	'encuestas_examenes:modify_answers_note'=>'En caso de modificar alguna de las respuestas a cualquiera de las preguntas del examen, eliminar o añadir una nueva pregunta, los resultados del examen se reiniciarán.',
	//forms/editEncuesta.php
	'encuestas_examenes:edit_restart_note_encuesta'=>'Nota: Por favor, recuerde que al editar solo esta opción la encuesta no se reiniciará, por lo que si el número de respuestas que ya ha enviado un usuario es mayor al nuevo número de respuestas permitidas, dicho usuario no podrá volver a realizar la encuesta.',
	'encuestas_examenes:modify_answers_note_encuesta'=>'En caso de modificar alguna de las respuestas a cualquiera de las preguntas de la encuesta, eliminar o añadir una nueva pregunta, los resultados de la encuesta se reiniciarán.',
	//actions/editExamen.php
	'encuestas_examenes:ok_edit'=>"El examen ha sido editado",
	'encuestas_examenes:problem_edit'=>"El examen no se ha editado correctamente",
	//actions/editEncuesta.php
	'encuestas_examenes:ok_edit_encuesta'=>"La encuesta ha sido editada",
	'encuestas_examenes:problem_edit_encuesta'=>"La encuesta no se ha editado correctamente",
	//resources/eliminarExamen.php
	'encuestas_examenes:quiz_deleted'=>"El examen ha sido eliminado",
	'encuestas_examenes:quiz_not_delated'=>"El examen no se ha podido eliminar correctamente",
	//resources/eliminarEncuesta.php
	'encuestas_examenes:poll_deleted'=>"La encuesta ha sido eliminada",
	'encuestas_examenes:poll_not_delated'=>"La encuesta no se ha podido eliminar correctamente",
	//resources/reiniciarExamen.php
	'encuestas_examenes:quiz_restarted'=>"Los resultados del examen han sido reiniciados ",
	'encuestas_examenes:quiz_not_restarted'=>"El examen no se ha podido reiniciar correctamente",
	//resources/reiniciarEncuesta.php
	'encuestas_examenes:poll_restarted'=>"Los resultados de la encuesta han sido reiniciados ",
	'encuestas_examenes:poll_not_restarted'=>"La encuesta no se ha podido reiniciar correctamente",
	'encuestas_examenes:quiz_empty'=>"¡No se puede enviar el examen vacío!",
	'encuestas_examenes:poll_empty'=>"¡No se puede enviar la encuesta vacía!",
	'encuestas_examenes:required_necessary'=>"¡Es necesario responder todas las preguntas obligatorias!",
	//river create
	'river:create:object:examen' => '%s ha creado un nuevo examen:  %s',
	//river create
	'river:create:object:encuesta' => '%s ha creado una nueva encuesta:  %s',
	//allFilterExamen
	'encuestas_examenes:user_quizs' => 'Examenes de %s',
	//allFilterEncuesta
	'encuestas_examenes:user_polls' => 'Encuestas de %s',
	//resources/fillExamen
     	'encuestas_examenes:csv' => 'Descargar los resultados en .csv'




















];
