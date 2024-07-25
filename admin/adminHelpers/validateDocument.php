<?php



function validateDocument($document){

    $errors = array();

    if (empty($document['title'])) {
        array_push($errors, 'Title is required');
    }


    $existingDocument = selectOne('documents', ['id_number' => $document['id_number']]);


    if($existingDocument && $existingDocument['title'] == $document['title']){
        array_push($errors, 'Document exists, try and Edit it');
    }

    

    return $errors;
}

function validateDocumentUpdate($document){

    $errors = array();

    if (empty($document['title'])) {
        array_push($errors, 'Title is required');
    }


    $existingDocument = selectOne('documents', ['id_number' => $document['id_number']]);


    if($existingDocument){
        if ($existingDocument['title'] == $document['title'] && $existingDocument['id'] != $document['id']) {
            
            array_push($errors, 'Document exists');
        }
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