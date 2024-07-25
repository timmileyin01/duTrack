<?php

function validateDepartment($department){
    $errors = array();

    if (empty($department['name'])) {
        array_push($errors, 'Department name is required');
    }
    if (empty($department['hod'])) {
        array_push($errors, 'Department name is required');
    }
    if (empty($department['fac_id'])) {
        array_push($errors, 'Department name is required');
    }

    $existingDepartment = selectOne('departments', ['name' => $department['name']]);
    if($existingDepartment) {
        array_push($errors, 'Department already exists');
    }
    return $errors;
}


function validateDepartmentUpdate($department){
    $errors = array();

    if (empty($department['name'])) {
        array_push($errors, 'Department name is required');
    }
    if (empty($department['hod'])) {
        array_push($errors, 'Department name is required');
    }
    if (empty($department['fac_id'])) {
        array_push($errors, 'Department name is required');
    }

    $existingDepartment = selectOne('departments', ['name' => $department['name']]);
    
    if($existingDepartment && $existingDepartment['id'] != $department['id']) {
        array_push($errors, 'Department already exists');
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