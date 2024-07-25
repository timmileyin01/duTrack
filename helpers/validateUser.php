<?php

function validateUser($user){
    $errors = array();

    if (empty($user['surname'])) {
        array_push($errors, 'Surname is required');
    }
    return $errors;
}


function validateLogin($user){
    $errors = array();

    if (empty($user['id_number'])) {
        array_push($errors, 'Matric no. or Staff id. is required');
    }

    if (empty($user['password'])) {
        array_push($errors, 'Password required');
    }
    return $errors;
}