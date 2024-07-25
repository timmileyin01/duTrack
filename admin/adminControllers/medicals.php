<?php

include(base_app . "adminDatabase/db.php");
include(base_app . "adminHelpers/validateMedical.php");

$errors = array();

$history = "";


$id_number = "";


$table = 'medical_information';

$students = selectAll("users", ['admin' => 'repo_user']);

if (isset($_GET['id'])) {
    $medical = selectOne($table, ['id' => $_GET['id']]);
    $id = $medical['id'];
    $_SESSION['medical_id'] = $id;
    $history = $medical['history'];
    $id_number = $medical['id_number'];
}


if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $count = delete($table, $id);

    if ($count) {


        $_SESSION['message'] = 'Medical Information Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './medical-information.php');
        exit();
    } else {
        $_SESSION['message'] = 'Medical Information not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './medical-information.php');
        exit();
    }
}







if (isset($_POST['add-medical'])) {


    $errors = validateMedical($_POST);









    if (count($errors) === 0) {


        unset($_POST['add-medical']);


        $medical_id = create($table, $_POST);

        $_SESSION['message'] = 'Medical Information Created successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './medical-information.php');
        exit();
    } else {
        
        $history = $_POST['history'];
        

        $id_number = $_POST['id_number'];
    }
}

if (isset($_POST['add-matric'])) {

    $matric = $_POST['id_number'];
    $medical = selectOne($table, ['id_number' => $matric]);
    unset($_POST['add-matric']);

    if (!$matric) {
        array_push($errors, "You need to put a Matric ID");
    } elseif ($medical) {
        array_push($errors, "medical Exists");
    } else {
        $medical_id = create($table, $_POST);

        $_SESSION['message'] = 'Matric Added successfully';
        $_SESSION['type'] = 'success';
    }
}







if (isset($_POST['edit-medical'])) {
    $id = $_SESSION['medical_id'];

    $errors = validateMedicalUpdate($_POST);
    unset($_POST['edit-medical'], $_POST['id']);





    if (count($errors) === 0) {


        $medical_id = update($table, $id, $_POST);

        unset($_SESSION['medical_id']);

        $_SESSION['message'] = 'Medical Information Updated successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './medical-information.php');
        exit();
    } else {
        
        $history = $_POST['history'];

        $id_number = $_POST['id_number'];
    }
}
