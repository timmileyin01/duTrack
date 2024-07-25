<?php

function validateSession($session){
    $errors = array();

    if (empty($session['session'])) {
        array_push($errors, 'Session is required');
    }

    $existingSession = selectOne('sessions', ['session' => $session['session']]);
    if($existingSession) {
        array_push($errors, 'Session already exists');
    }
    return $errors;
}


function validateSessionUpdate($session){
    $errors = array();

    if (empty($session['session'])) {
        array_push($errors, 'Session is required');
    }


    $existingSession = selectOne('sessions', ['session' => $session['session']]);
    
    
    if($existingSession && $existingSession['id'] != $session['id']){
        array_push($errors, 'Session already exists');
        
    }
    return $errors;
}
