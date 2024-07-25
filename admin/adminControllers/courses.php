<?php

include(base_app . "adminDatabase/db.php");
include(base_app . "adminHelpers/validateCourse.php");



$table = 'courses';

$errors = array();
$id = '';
$course_code = '';
$course_title = '';
$dept_id = '';
$fac_id = '';
$faculty = '';


$departments = selectAll('departments');
$courses = selectAll($table);









if (isset($_POST['add-course'])) {
    $errors = validateCourse($_POST);

    if (!empty($_POST['dept_id'])) {
        
    
    $oneDepartment = selectOne('departments', ['id' => $_POST['dept_id']]);
    $oneFaculty = selectOne('faculties', ['id' => $oneDepartment['fac_id']]);

    $_POST['department'] = $oneDepartment['name'];

    $_POST['fac_id'] = $oneFaculty['id'];
    $faculty = $_POST['faculty'] = $oneFaculty['name'];
    }


    if (count($errors) === 0) {
        unset($_POST['add-course']);
        $course_id = create($table, $_POST);
        $_SESSION['message'] = 'Course created successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . './manage-courses.php');
        exit();
    } else {
        $course_code = $_POST['course_code'];
        $course_title = $_POST['course_title'];
        $dept_id = $_POST['dept_id'];
    }
}



if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $course = selectOne($table, ['id' => $id]);

    $id = $course['id'];
    $course_code = $course['course_code'];
    $course_title = $course['course_title'];
    $dept_id = $course['dept_id'];
}




if (isset($_POST['update-btn'])) {
    $errors = validateCourseUpdate($_POST);

    if (!empty($_POST['dept_id'])) {
        
    
        $oneDepartment = selectOne('departments', ['id' => $_POST['dept_id']]);
        $oneFaculty = selectOne('faculties', ['id' => $oneDepartment['fac_id']]);
    
        $_POST['department'] = $oneDepartment['name'];
    
        $_POST['fac_id'] = $oneFaculty['id'];
        $faculty = $_POST['faculty'] = $oneFaculty['name'];
        }


    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['update-btn'], $_POST['id']);
        

        update($table, $id, $_POST);

        $_SESSION['message'] = 'Course Updated successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . './manage-courses.php');
        exit();
    } else {
        $id = $_POST['id'];
        $course_code = $_POST['course_code'];
        $course_title = $_POST['course_title'];
        $dept_id = $_POST['dept_id'];
    }
}

if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $count = delete($table, $id);

    if ($count) {


        $_SESSION['message'] = 'Course Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './manage-courses.php');
        exit();
    } else {
        $_SESSION['message'] = 'Course not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './manage-courses.php');
        exit();
    }
}
