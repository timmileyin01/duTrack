<?php

function validateFaculty($faculty){
    $errors = array();

    if (empty($faculty['name'])) {
        array_push($errors, 'Faculty name is required');
    }
    if (empty($faculty['dean'])) {
        array_push($errors, "Dean's name is required");
    }

    $existingFaculty = selectOne('faculties', ['name' => $faculty['name']]);
    if($existingFaculty) {
        array_push($errors, 'Faculty already exists');
    }
    return $errors;
}


function validateFacultyUpdate($faculty){
    $errors = array();

    if (empty($faculty['name'])) {
        array_push($errors, 'Faculty name is required');
    }
    if (empty($faculty['dean'])) {
        array_push($errors, "Dean's name is required");
    }


    $existingFaculty = selectOne('faculties', ['name' => $faculty['name']]);
    
    
    if($existingFaculty && $existingFaculty['id'] != $faculty['id']){
        array_push($errors, 'Faculty already exists');
        
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
