<?php



function validateGuardian($guardian){

    $errors = array();

    if (empty($guardian['surname'])) {
        array_push($errors, 'Surname is required');
    }

    if(empty($guardian['firstname'])){
        array_push($errors, 'Firstname is required');
    }

    if(empty($guardian['mobile_number'])){
        array_push($errors, 'Enter Mobile Number');
    }

    if(empty($guardian['id_number'])){
        array_push($errors, 'Select Matric Number');
    }
    if(empty($guardian['address'])){
        array_push($errors, 'Enter the address');
    }

    if(empty($guardian['email'])){
        array_push($errors, 'Email is required');
    }

    if(empty($guardian['relationship'])){
        array_push($errors, 'Relationship is required');
    }

    if(!preg_match("/^[\w\-]+@[\w\-]+.[\w\-]+$/", $guardian['email'])){
        array_push($errors, 'Invalid Email');
    }

    $existingGuardian = selectOne('student_guardian', ['email' => $guardian['email']]);
    $existingGuardian1 = selectOne('student_guardian', ['mobile_number' => $guardian['mobile_number']]);
    $existingGuardian2 = selectAll('student_guardian', ['id_number' => $guardian['id_number']]);

    
    $nr_of_rows = count($existingGuardian2);
    
    if($nr_of_rows >= 2){
        array_push($errors, 'You can no longer add guardian for this student');
    }

    if($existingGuardian || $existingGuardian1){
        array_push($errors, 'guardian exists');
    }

    

    return $errors;
}

function validateGuardianUpdate($guardian){

    $errors = array();

    if (empty($guardian['surname'])) {
        array_push($errors, 'Surname is required');
    }

    if(empty($guardian['firstname'])){
        array_push($errors, 'Firstname is required');
    }

    if(empty($guardian['id_number'])){
        array_push($errors, 'Select Matric Number');
    }

    if(empty($guardian['mobile_number'])){
        array_push($errors, 'Enter Mobile Number');
    }
    if(empty($guardian['address'])){
        array_push($errors, 'Enter the address');
    }

    if(empty($guardian['email'])){
        array_push($errors, 'Email is required');
    }
    if(empty($guardian['relationship'])){
        array_push($errors, 'Relationship is required');
    }


    if(!preg_match("/^[\w\-]+@[\w\-]+.[\w\-]+$/", $guardian['email'])){
        array_push($errors, 'Invalid Email');
    }



    
    $existingGuardian = selectOne('student_guardian', ['email' => $guardian['email']]);
    $existingGuardian1 = selectOne('student_guardian', ['mobile_number' => $guardian['mobile_number']]);
    $existingGuardian2 = selectAll('student_guardian', ['id_number' => $guardian['id_number']]);

    
    $nr_of_rows = count($existingGuardian2);
    
    if($nr_of_rows >= 3){
        array_push($errors, 'You can no longer add guardian for this student');
    }


    if($existingGuardian && $existingGuardian['id'] != $guardian['id']){
        array_push($errors, 'guardian exists');
    }elseif ($existingGuardian1 && $existingGuardian1['id'] != $guardian['id']) {
        array_push($errors, 'guardian exists');
    }

    

    return $errors;
}







function validateFile($file, $formIndex, $filetype, $filesize){
    $errors = array();

    $thumbnail = $file[$formIndex];
    
    $time = time(); //to make each image name unique
    $thumbnail_name = $time . $thumbnail['name'];
    $thumbnail_tmp_name = $thumbnail['tmp_name'];
    
    

    $allowed_files = $filetype;
    $extension = explode('.', $thumbnail_name);
    
    $extension = end($extension);

    if(!in_array($extension, $allowed_files)) {
        array_push($errors, 'Only jpg, jpeg, webp, png files allowed');
    }

    if ($thumbnail['size'] > $filesize) {
        array_push($errors, 'file is too large');
    }

    return $errors;
}