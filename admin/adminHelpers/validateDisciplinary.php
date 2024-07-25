<?php



function validateDisciplinary($disciplinary){

    $errors = array();

    if (empty($disciplinary['title'])) {
        array_push($errors, 'Title is required');
    }
    if (empty($disciplinary['date'])) {
        array_push($errors, 'Date is required');
    }   

    return $errors;
}

function validateDisciplinaryUpdate($disciplinary){

    $errors = array();

    if (empty($disciplinary['title'])) {
        array_push($errors, 'Title is required');
    }
    if (empty($disciplinary['date'])) {
        array_push($errors, 'Date is required');
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
        array_push($errors, 'Only jpg, jpeg, webp, png, pdf, doc, docx files allowed');
    }

    if ($thumbnail['size'] > $filesize) {
        array_push($errors, 'file is too large');
    }

    return $errors;
}