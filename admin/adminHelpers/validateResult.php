<?php

function validateResult($result){
    $errors = array();

    if (empty($result['matric_id'])) {
        array_push($errors, 'Select Student');
    }
    if (empty($result['session_id'])) {
        array_push($errors, "Select Session");
    }
    if (empty($result['semester'])) {
        array_push($errors, "Select Semester");
    }
    if (empty($result['level'])) {
        array_push($errors, "Select Level");
    }
    if (empty($result['course_id'])) {
        array_push($errors, "Select Course");
    }
    if (empty($result['score'])) {
        array_push($errors, "Enter Score");
    }
    if (empty($result['course_unit'])) {
        array_push($errors, "Enter Course Unit");
    }
    if (empty($result['remark'])) {
        array_push($errors, "Input Remark");
    }
    
    $course = selectOne('courses', ['id' => $result['course_id']]);

    $session = selectOne('sessions', ['id' => $result['session_id']]);

    $unique = $result['matric_id'] . $course['course_code'] . $session['session'];

    $existingResult = selectOne('results', ['unique_id' => $result['unique_id']]);
    if($existingResult) {
        array_push($errors, 'Result already exists');
    }
    return $errors;
}


function validateResultUpdate($result){
    $errors = array();

    if (empty($result['matric_id'])) {
        array_push($errors, 'Select Student');
    }
    if (empty($result['session_id'])) {
        array_push($errors, "Select Session");
    }
    if (empty($result['semester'])) {
        array_push($errors, "Select Semester");
    }
    if (empty($result['level'])) {
        array_push($errors, "Select Level");
    }
    if (empty($result['course_id'])) {
        array_push($errors, "Select Course");
    }
    if (empty($result['score'])) {
        array_push($errors, "Enter Score");
    }
    if (empty($result['remark'])) {
        array_push($errors, "Input Remark");
    }
    $course = selectOne('courses', ['id' => $result['course_id']]);
    $session = selectOne('sessions', ['id' => $result['session_id']]);

    $unique = $result['matric_id'] . $course['course_code'] . $session['session'];

    $existingResult = selectOne('results', ['unique_id' => $result['unique_id']]);
    if($existingResult && $existingResult['id'] != $result['id']) {
        array_push($errors, 'Result already exists');
    }
    return $errors;
}
