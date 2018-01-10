<?php

return [
        'encuestas_examenes' => "Polls and quizzes",
	'encuestas_examenes:encuestas' => "Polls",
	'encuestas_examenes:examenes' => "Quizzes",
	//All
	'encuestas_examenes:add_encuesta'=> "Add poll",
	'encuestas_examenes:add_examen'=> "Add quiz",
	'encuestas_examenes:list' => "All ",
	'encuestas_examenes:encuesta' => "Polls",
	'encuestas_examenes:examen' => "Quizzes",
	//addExamen
	'encuestas_examenes:crear_examen' => "Create new quiz",
	//addEncuesta
	'encuestas_examenes:crear_encuesta' => "Create new poll",
	//forms/saveExamen
	'encuestas_examenes:titulo'=> 'Title',
	'encuestas_examenes:descripcion_examen'=> 'Description (optional)',
	'encuestas_examenes:duration_config' => 'Date and time configuration:',
	'encuestas_examenes:publishNow'=>'Publish now',
	'encuestas_examenes:start_date'=>'Start date: ',
	'encuestas_examenes:start_time'=>'Start time:',
	'encuestas_examenes:noEndDate'=>'Without deadline',
	'encuestas_examenes:end_date'=>'Deadline (date):',
	'encuestas_examenes:end_time'=>'Deadline (time):',
	'encuestas_examenes:noDuration'=>'Without timeout',
	'encuestas_examenes:duration'=>'Maximum response time',
	'encuestas_examenes:min'=>' min',
	'encuestas_examenes:automaticSend'=>'Send answers automatically when the time is out',
	'encuestas_examenes:resend'=>'Submit configuration:',
	'encuestas_examenes:oneSend'=>'Allow single send',
	'encuestas_examenes:multipleSend'=>'Allow unlimited sends',
	'encuestas_examenes:specialSend'=>'Allow a limit number of sends',
	'encuestas_examenes:customResend'=>'Number of sends:',
	'encuestas_examenes:seeResults'=>'See results configuration:',
	'encuestas_examenes:seeMark'=>'Allow users to see their mark after the quiz delivery',
	'encuestas_examenes:seeMarkCorrection'=>'Allow users to see their mark and the quiz correction after the quiz delivery',
	'encuestas_examenes:seeNothing'=>"Don't allow users to see their mark or the quiz correction after the quiz delivery",
	'encuestas_examenes:score_params'=>'Quiz score: ',
	'encuestas_examenes:score_notes'=> 'Note: The total score of a quiz is the sum of all the question individual scores scaled to 10, so 10 always will be the maximum score of a quiz. If there is a minimum mark to pass the exam, there will be a note next to the quiz score indicating if the quiz has been passed or not. Is because of that the minimum mark to pass the exam must be a number between 0 and 10.',
	'encuestas_examenes:passScore'=>'Minimum mark to pass the quiz (Optional): ',
	'encuestas_examenes:emptyResults'=>'Allow to submit empty answers',
	'encuestas_examenes:access'=>'Quiz access: ',
	'encuestas_examenes:privado'=>'Private',
	'encuestas_examenes:amigos'=>'Friends',
	'encuestas_examenes:ausuarios_autenticados'=>'Autenticated users',
	'encuestas_examenes:publico'=>'Public',
	'encuestas_examenes:qType_label'=>'Select the question type: ',
	'encuestas_examenes:checkboxes'=>'Multiple answer',
	'encuestas_examenes:radio'=>'Single answer',
	'encuestas_examenes:text'=>'Text',
	'encuestas_examenes:long_text'=>'Long text',
	'encuestas_examenes:pregunta'=>'Question title',
	'encuestas_examenes:pregunta_nota_aclaratoria'=>'Note: If no answer is selected as correct, the question will be considered as valid no matters what will be the user response.',
	'encuestas_examenes:respuesta'=>'Answer ',
	'encuestas_examenes:regex'=>'Regular expression',
	'encuestas_examenes:right_answer_text'=>'Right answer (optional)',
	'encuestas_examenes:question_mark_note'=>'Note: All marks (success and fail) will be scaled to 10',
	'encuestas_examenes:success'=>'Success mark: ',
	'encuestas_examenes:fail'=>'Fail mark (optional) : - ',
	'encuestas_examenes:required'=>'Required question',
	'encuestas_examenes:new'=>'New question',
	'encuestas_examenes:save'=>'Submit',
	//js/saveExamen.js
	'encuestas_examenes:delete_last_q'=>"The only question of the quiz cannot be deleted!",
	//js/saveEncuesta.js
	'encuestas_examenes:delete_last_q_encuesta' => "The only question of the poll cannot be deleted!",
	//actions/saveExamen.php
	'encuestas_examenes:exam_saved' => 'The quiz have been saved',
	'encuestas_examenes:exam_not_saved'=>'The quiz could not be saved',
	//actions/saveEncuesta.php
	'encuestas_encuestaes:encuesta_saved'=> 'The poll have been saved',
	'encuestas_encuestaes:encuesta_not_saved' => 'The poll could not be saved',
	//resources/viewExamen
	'encuestas_examenes:view_exam_note'=>"Note: When you access to the quiz the sumbmit counter will be increased by one if the quiz is finally send or no. So, if the quiz only allows one submit, it won't be possible to access it again. If there is a limit number of submits, access the quiz will discount one to the rest access counter.",
	'encuestas_examenes:refresh'=>'Refreshing the page will discount also one submit to the quiz.',
	'encuestas_examenes:access_exam'=>'Access quiz',
	'encuestas_examenes:my_result'=>'See my result',
	'encuestas_examenes:my_correction'=>'See quiz correction',
	'encuestas_examenes:all_results'=>'See all results',
	'encuestas_examenes:edit_exam'=>'Edit quiz',
	'encuestas_examenes:delete_exam_confirm'=>"Are you sure you want to delete the quiz?",
	'encuestas_examenes:delete_exam'=>'Delete quiz',
	'encuestas_examenes:reset_exam_config'=>'Are you sure you want to reset the quiz? All answers will be lost.',
	'encuestas_examenes:reset_exam'=>'Reset quiz',
	//resources/viewEncuesta 
	'encuestas_examenes:view_encuesta_note'=>"Note: When you access to the poll the sumbmit counter will be increased by one if the poll is finally send or no. So, if the poll only allows one submit, it won't be possible to access it again. If there is a limit number of submits, access the poll will discount one to the rest access counter.",
	'encuestas_examenes:refresh_encuesta'=>'Refreshing the page will discount also one submit to the poll.',
	'encuestas_examenes:access_encuesta'=>'Access poll',
	'encuestas_examenes:edit_encuesta'=>'Edit poll',
	'encuestas_examenes:delete_encuesta_confirm'=>"Are you sure you want to delete the poll?",
	'encuestas_examenes:delete_encuesta'=>'Delete poll',
	'encuestas_examenes:reset_encuesta_config'=>'Are you sure you want to reset the poll? All answers will be lost.',
	'encuestas_examenes:reset_encuesta'=>'Reset poll',
	//forms/send.php
	'encuestas_examenes:early_date'=>"The quiz is not avaliable yet",
	'encuestas_examenes:late_date'=>"The quiz is no longer avaliable",
	'encuestas_examenes:submit_num_exceded'=>"This quiz cannot be displayed because the maximum number of submits have been reached",
 	'encuestas_examenes:question'=>'Question ',
	'encuestas_examenes:question_success'=>'Success: +',
	'encuestas_examenes:question_fail'=>'/ Fail: -',
	'encuestas_examenes:points'=>' points',
	'encuestas_examenes:send'=>'Send',
	//forms/vote.php
	'encuestas_examenes:early_date_encuesta'=>"The poll is not avaliable yet",
	'encuestas_examenes:late_date_encuesta'=>"The poll is no longer avaliable",
	'encuestas_examenes:submit_num_exceded_encuesta'=>"This poll cannot be displayed because the maximum number of submits have been reached",
	'encuestas_examenes:one_sent_encuesta'=>"The poll has been already submited once!",
	//objects/examen.php and /object/encuesta.php
	'encuestas_examenes:time_left'=>'Time left: ',
	'encuestas_examenes:time_gone'=>'The time is out!',
	'encuestas_examenes:num_submits'=>'Max submits: ',
	'encuestas_examenes:unlimited'=>'No limit',
	'encuestas_examenes:remaining'=>'Remaining submits: ',
	'encuestas_examenes:already_sent'=>"Warning: This quiz has been already submited with this user account, if you resend the quiz, results will be updated.",
	'encuestas_examenes:already_sent_encuesta'=>"Warning: This poll has been already submited with this user account, if you resend the poll, results will be updated.",
	'encuestas_examenes:required_1'=>'Note: Questions with the symbol ',
	'encuestas_examenes:required_2'=> ' must be answered in order to send the quiz.',
	//actions/send.php
	'encuestas_examenes:ok_send'=>'Your quiz have been sent',
	'encuestas_examenes:bad_send'=> 'The quiz could not be send',
	//actions/vote.php
	'encuestas_examenes:ok_send_poll'=>'Your poll have been sent',
	'encuestas_examenes:bad_send_poll'=> 'The poll could not be send',
	//resources/correctionExamen.php
	'encuestas_examenes:no_answer'=>'No answer',
	'encuestas_examenes:ok_answer_regex'=>'Right answer (regular expression): ',
	'encuestas_examenes:ok_answer'=>'Right answer: ',
	'encuestas_examenes:one_sent'=>"The quiz has been already submited once!",
	'encuestas_examenes:correction_title'=> 'Correction: ',
	//resources/myresultExamen.php
	'encuestas_examenes:my_score'=>  'Score: ',
	'encuestas_examenes:not_passed'=>' (Fail)',
	'encuestas_examenes:passed'=>' (Pass)',
	'encuestas_examenes:see_correction'=> 'See quiz correction',
	//resources/resultsExamen.php
	'encuestas_examenes:no_answers_yet'=> 'There are no answers yet',
	//resources/editExamen.php
	'encuestas_examenes:edit_quiz'=>"Edit quiz",
	//resources/editEncuesta.php
	'encuestas_examenes:edit_poll'=>"Edit poll",
	//forms/editExamen.php
	'encuestas_examenes:edit_restart_note'=>"Note: Please, remember that only modifying this option the quiz won't be restarted, so if the number of answers the user has sent is higher that the maximum number of submits, this user won't be able to anwer the quiz.",
	'encuestas_examenes:modify_answers_note'=>'If the answer of any question is modified: addin knew answers options, deleting answer options, editing answer options or changing right answers, the results of the quiz will be restarted.',
	//forms/editEncuesta.php
	'encuestas_examenes:edit_restart_note_encuesta'=>"Note: Please, remember that only modifying this option the poll won't be restarted, so if the number of answers the user has sent is higher that the maximum number of submits, this user won't be able to anwer the poll.",
	'encuestas_examenes:modify_answers_note_encuesta'=>'If the answer of any question is modified: addin knew answers options, deleting answer options, editing answer options or changing right answers, the results of the poll will be restarted.',
	//actions/editExamen.php
	'encuestas_examenes:ok_edit'=>"The quiz has been edited",
	'encuestas_examenes:problem_edit'=>"The quiz cannot be edited",
	//actions/editEncuesta.php
	'encuestas_examenes:ok_edit_encuesta'=>"The poll has been edited",
	'encuestas_examenes:problem_edit_encuesta'=>"The poll cannot be edited",
	//resources/eliminarExamen.php
	'encuestas_examenes:quiz_deleted'=>"The quiz has been deleted",
	'encuestas_examenes:quiz_not_delated'=>"The quiz cannot be deleted",
	//resources/eliminarEncuesta.php
	'encuestas_examenes:poll_deleted'=>"The poll has been deleted",
	'encuestas_examenes:poll_not_delated'=>"The poll cannot be deleted",
	//resources/reiniciarExamen.php
	'encuestas_examenes:quiz_restarted'=>"The quiz has been restarted",
	'encuestas_examenes:quiz_not_restarted'=>"The quiz cannot be restarted",
	//resources/reiniciarEncuesta.php
	'encuestas_examenes:poll_restarted'=>"The poll has been restarted",
	'encuestas_examenes:poll_not_restarted'=>"The poll cannot be restarted",
	'encuestas_examenes:quiz_empty'=>"The exam cannot be submited empty!",
	'encuestas_examenes:poll_empty'=>"The poll cannot be submited empty!",
	'encuestas_examenes:required_necessary'=>"All required questions must be filled",
	//river create
	'river:create:object:examen' => '%s created a quiz %s',
	//river create
	'river:create:object:encuesta' => '%s created a poll %s',
	//allFilterExamen
	'encuestas_examenes:user_quizs' => "%s - Quizzes ",
	//allFilterEncuesta
	'encuestas_examenes:user_polls' => "%s - Polls ",
	//resources/fillExamen
     	'encuestas_examenes:csv' => 'Download in .csv format'


 





];
