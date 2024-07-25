<?php



function validateAcademic($academic){

    $errors = array();

    if (empty($academic['session'])) {
        array_push($errors, 'Session is required');
    }

    if(empty($academic['semester'])){
        array_push($errors, 'Semester is required');
    }

    if(empty($academic['gpa'])){
        array_push($errors, 'Enter GPA');
    }

    if(empty($academic['id_number'])){
        array_push($errors, 'Select Matric Number');
    }

    
   
    $existingAcademic = selectOne('academic_record', ['session' => $academic['session'], 'semester' => $academic['semester'], 'id_number' => $academic['id_number']]);


    if($existingAcademic){
        array_push($errors, 'Academic Record exists');
    }

    

    return $errors;
}

function validateAcademicUpdate($academic){

    $errors = array();

    if (empty($academic['session'])) {
        array_push($errors, 'Session is required');
    }

    if(empty($academic['semester'])){
        array_push($errors, 'Semester is required');
    }

    if(empty($academic['gpa'])){
        array_push($errors, 'Enter GPA');
    }

    if(empty($academic['id_number'])){
        array_push($errors, 'Select Matric Number');
    }


    $existingAcademic = selectOne('academic_record', ['session' => $academic['session'], 'semester' => $academic['semester'], 'id_number' => $academic['id_number']]);


    if($existingAcademic && $existingAcademic['id'] != $academic['id']){
        array_push($errors, 'Academic Record exists');
    }

    

    return $errors;
}



