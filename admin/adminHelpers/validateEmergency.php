<?php



function validateEmergency($emergency){

    $errors = array();

    if (empty($emergency['surname'])) {
        array_push($errors, 'Surname is required');
    }

    if(empty($emergency['firstname'])){
        array_push($errors, 'Firstname is required');
    }

    if(empty($emergency['mobile_number'])){
        array_push($errors, 'Enter Mobile Number');
    }

    if(empty($emergency['id_number'])){
        array_push($errors, 'Select Matric Number');
    }
    if(empty($emergency['address'])){
        array_push($errors, 'Enter the address');
    }

    if(empty($emergency['email'])){
        array_push($errors, 'Email is required');
    }

    if(empty($emergency['relationship'])){
        array_push($errors, 'Relationship is required');
    }

    if(!preg_match("/^[\w\-]+@[\w\-]+.[\w\-]+$/", $emergency['email'])){
        array_push($errors, 'Invalid Email');
    }

    $existingEmergency = selectOne('emergency_contacts', ['email' => $emergency['email']]);
    $existingEmergency1 = selectOne('emergency_contacts', ['mobile_number' => $emergency['mobile_number']]);
    $existingEmergency2 = selectAll('emergency_contacts', ['id_number' => $emergency['id_number']]);

    
    $nr_of_rows = count($existingEmergency2);
    
    if($nr_of_rows >= 2){
        array_push($errors, 'You can no longer add emergency contact for this student');
    }

    if($existingEmergency || $existingEmergency1){
        array_push($errors, 'Emergency Contact exists');
    }

    

    return $errors;
}

function validateEmergencyUpdate($emergency){

    $errors = array();

    if (empty($emergency['surname'])) {
        array_push($errors, 'Surname is required');
    }

    if(empty($emergency['firstname'])){
        array_push($errors, 'Firstname is required');
    }

    if(empty($emergency['id_number'])){
        array_push($errors, 'Select Matric Number');
    }

    if(empty($emergency['mobile_number'])){
        array_push($errors, 'Enter Mobile Number');
    }
    if(empty($emergency['address'])){
        array_push($errors, 'Enter the address');
    }

    if(empty($emergency['email'])){
        array_push($errors, 'Email is required');
    }
    if(empty($emergency['relationship'])){
        array_push($errors, 'Relationship is required');
    }


    if(!preg_match("/^[\w\-]+@[\w\-]+.[\w\-]+$/", $emergency['email'])){
        array_push($errors, 'Invalid Email');
    }



    
    $existingEmergency = selectOne('emergency_contacts', ['email' => $emergency['email']]);
    $existingEmergency1 = selectOne('emergency_contacts', ['mobile_number' => $emergency['mobile_number']]);
    $existingEmergency2 = selectAll('emergency_contacts', ['id_number' => $emergency['id_number']]);

    
    $nr_of_rows = count($existingEmergency2);
    
    if($nr_of_rows >= 3){
        array_push($errors, 'You can no longer add Emergency Contact for this student');
    }


    if($existingEmergency && $existingEmergency['id'] != $emergency['id']){
        array_push($errors, 'Emergency Contact exists');
    }elseif ($existingEmergency1 && $existingEmergency1['id'] != $emergency['id']) {
        array_push($errors, 'Emergency Contact exists');
    }

    

    return $errors;
}



