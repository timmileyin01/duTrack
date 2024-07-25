<?php



function validateMedical($medical){

    $errors = array();

    if (empty($medical['history'])) {
        array_push($errors, 'History is required');
    }

    if(empty($medical['id_number'])){
        array_push($errors, 'Select Matric Number');
    }
   

    $existingMedical2 = selectOne('medical_information', ['id_number' => $medical['id_number']]);

    

    if($existingMedical2){
        array_push($errors, 'Medical Information exists for this Student');
    }

    

    return $errors;
}

function validateMedicalUpdate($medical){

    $errors = array();

    if(empty($medical['id_number'])){
        array_push($errors, 'Select Matric Number');
    }


    if(empty($medical['history'])){
        array_push($errors, 'History is required');
    }
    


    $existingMedical2 = selectOne('medical_information', ['id_number' => $medical['id_number']]);

    


    if($existingMedical2 && $existingMedical2['id'] != $medical['id']){
        array_push($errors, 'Medical Information exists for this Student');
    }

    

    return $errors;
}



