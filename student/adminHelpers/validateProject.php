<?php

function validateProject($project){
    $errors = array();

    if (empty($project['title'])) {
        array_push($errors, 'Title is required');
    }

    if (empty($project['student_name'])) {
        array_push($errors, 'Provide name of the student');
    }
    if (empty($project['supervisor_name'])) {
        array_push($errors, 'Provide name of the supervisor');
    }

    if (empty($project['matric_no'])) {
        array_push($errors, 'Matric number of the student is required');
    }

    if (empty($project['department_id'])) {
        array_push($errors, 'Select the department');
    }

    if (empty($project['abstract'])) {
        array_push($errors, 'Abstract is required');
    }

    if (empty($project['info'])) {
        array_push($errors, 'Info is required');
    }


    
    return $errors;
}

function validateProjectUpdate($project){
    $errors = array();

    if (empty($project['title'])) {
        array_push($errors, 'Title is required');
    }

    if (empty($project['student_name'])) {
        array_push($errors, 'Provide name of the student');
    }
    if (empty($project['supervisor_name'])) {
        array_push($errors, 'Provide name of the supervisor');
    }

    if (empty($project['matric_no'])) {
        array_push($errors, 'Matric number of the student is required');
    }

    if (empty($project['department_id'])) {
        array_push($errors, 'Select the department');
    }

    if (empty($project['abstract'])) {
        array_push($errors, 'Abstract is required');
    }

    if (empty($project['info'])) {
        array_push($errors, 'Info is required');
    }

    return $errors;
}

function validateProjectFile($file, $formIndex, $filetype, $filesize){
    $errors = array();

    $thumbnail = $file[$formIndex];
    
    $time = time(); //to make each image name unique
    $thumbnail_name = $time . $thumbnail['name'];
    $thumbnail_tmp_name = $thumbnail['tmp_name'];
    
    

    $allowed_files = $filetype;
    $extension = explode('.', $thumbnail_name);
    
    $extension = end($extension);

    if(!in_array($extension, $allowed_files)) {
        array_push($errors, 'Only pdf, doc, docx files allowed');
    }

    if ($thumbnail['size'] > $filesize) {
        array_push($errors, 'file is too large');
    }

    return $errors;
}








