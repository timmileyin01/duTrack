<?php

function validateCourse($course){
    $errors = array();

    if (empty($course['course_title'])) {
        array_push($errors, 'Course title is required');
    }
    if (empty($course['course_code'])) {
        array_push($errors, "Course code is required");
    }
    if (empty($course['dept_id'])) {
        array_push($errors, "Department is required");
    }

    $existingCourse = selectOne('courses', ['course_title' => $course['course_title']]);
    if($existingCourse) {
        array_push($errors, 'Course already exists');
    }
    return $errors;
}


function validateCourseUpdate($course){
    $errors = array();

    if (empty($course['course_title'])) {
        array_push($errors, 'Course title is required');
    }
    if (empty($course['course_code'])) {
        array_push($errors, "Course code is required");
    }
    if (empty($course['dept_id'])) {
        array_push($errors, "Department is required");
    }


    $existingCourse = selectOne('courses', ['course_title' => $course['course_title']]);
    
    
    if($existingCourse && $existingCourse['id'] != $course['id']){
        array_push($errors, 'Course already exists');
        
    }
    return $errors;
}
