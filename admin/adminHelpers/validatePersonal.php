<?php



function validatePersonal($personal){

    $errors = array();

    if (empty($personal['date_of_birth'])) {
        array_push($errors, 'Date of Birth is required');
    }

    
    if(empty($personal['mobile_number'])){
        array_push($errors, 'Enter Mobile Number');
    }

    if(empty($personal['id_number'])){
        array_push($errors, 'Select Matric Number');
    }
    if(empty($personal['address'])){
        array_push($errors, 'Enter the address');
    }

    if(empty($personal['program'])){
        array_push($errors, 'Program is required');
    }

    
    $existingpersonal1 = selectOne('personal_data', ['mobile_number' => $personal['mobile_number']]);
    $existingpersonal2 = selectAll('personal_data', ['id_number' => $personal['id_number']]);

    
    

    if($existingpersonal1 || $existingpersonal2){
        array_push($errors, 'The Personal Data for this Student has already been added');
    }

    

    return $errors;
}

function validatepersonalUpdate($personal){

    $errors = array();

    if (empty($personal['date_of_birth'])) {
        array_push($errors, 'Date of Birth is required');
    }

    
    if(empty($personal['mobile_number'])){
        array_push($errors, 'Enter Mobile Number');
    }

    if(empty($personal['id_number'])){
        array_push($errors, 'Select Matric Number');
    }
    if(empty($personal['address'])){
        array_push($errors, 'Enter the address');
    }

    if(empty($personal['program'])){
        array_push($errors, 'Program is required');
    }


    
    $existingPersonal1 = selectOne('personal_data', ['mobile_number' => $personal['mobile_number']]);
    $existingPersonal2 = selectOne('personal_data', ['id_number' => $personal['id_number']]);

    


    if($existingPersonal1 && $existingPersonal1['id'] != $personal['id']){
        array_push($errors, 'Personal Data exists');
    }elseif ($existingPersonal2 && $existingPersonal2['id'] != $personal['id']) {
        array_push($errors, 'Personal Data exists');
    }

    

    return $errors;
}


