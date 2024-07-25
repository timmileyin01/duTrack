<?php

include(base_app . "adminDatabase/db.php");
include(base_app . "adminHelpers/validateEmergency.php");

$errors = array();

$surname = "";
$firstname = "";
$email = "";
$middlename = "";
$mobile_number = "";
$address = "";
$relationship = "";

$id_number = "";


$table = 'emergency_contacts';

$students = selectAll("users", ['admin' => 'repo_user']);

if (isset($_GET['id'])) {
    $emergency = selectOne($table, ['id' => $_GET['id']]);
    $id = $emergency['id'];
    $_SESSION['emergency_id'] = $id;
    $surname = $emergency['surname'];
    $firstname = $emergency['firstname'];
    $email = $emergency['email'];
    $middlename = $emergency['middlename'];
    $mobile_number = $emergency['mobile_number'];
    $address = $emergency['address'];
    $relationship = $emergency['relationship'];

    $id_number = $emergency['id_number'];
}


if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $count = delete($table, $id);

    if ($count) {


        $_SESSION['message'] = 'Emergency Contact Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './emergency-contact.php');
        exit();
    } else {
        $_SESSION['message'] = 'Emergency Contact not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './emergency-contact.php');
        exit();
    }
}







if (isset($_POST['add-emergency'])) {


    $errors = validateEmergency($_POST);









    if (count($errors) === 0) {


        unset($_POST['add-emergency']);


        $emergency_id = create($table, $_POST);

        $_SESSION['message'] = 'Emergency Contact Created successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './emergency-contact.php');
        exit();
    } else {
        $surname = $_POST['surname'];
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $middlename = $_POST['middlename'];
        $relationship = $_POST['relationship'];

        $address = $_POST['address'];
        $mobile_number = $_POST['mobile_number'];

        $id_number = $_POST['id_number'];
    }
}

if (isset($_POST['add-matric'])) {

    $matric = $_POST['id_number'];
    $emergency = selectOne($table, ['id_number' => $matric]);
    unset($_POST['add-matric']);

    if (!$matric) {
        array_push($errors, "You need to put a Matric ID");
    } elseif ($emergency) {
        array_push($errors, "emergency Exists");
    } else {
        $emergency_id = create($table, $_POST);

        $_SESSION['message'] = 'Matric Added successfully';
        $_SESSION['type'] = 'success';
    }
}







if (isset($_POST['edit-emergency'])) {
    $id = $_SESSION['emergency_id'];

    $errors = validateEmergencyUpdate($_POST);
    unset($_POST['edit-emergency'], $_POST['id']);





    if (count($errors) === 0) {


        $emergency_id = update($table, $id, $_POST);

        unset($_SESSION['emergency_id']);

        $_SESSION['message'] = 'Emergency Contact Updated successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './emergency-contact.php');
        exit();
    } else {
        $surname = $_POST['surname'];
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $middlename = $_POST['middlename'];
        $relationship = $_POST['relationship'];

        $address = $_POST['address'];
        $mobile_number = $_POST['mobile_number'];

        $id_number = $_POST['id_number'];
    }
}
