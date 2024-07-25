<?php

include(base_app . "adminDatabase/db.php");
include(base_app . "adminHelpers/validatepersonal.php");

$errors = array();

$program = "";

$mobile_number = "";
$address = "";
$date_of_birth = "";

$id_number = "";


$table = 'personal_data';

$students = selectAll("users", ['admin' => 'repo_user']);

if (isset($_GET['id'])) {
    $personal = selectOne($table, ['id' => $_GET['id']]);
    $id = $personal['id'];
    $_SESSION['personal_id'] = $id;
    $date_of_birth = $personal['date_of_birth'];

    $address = $personal['address'];
    $program = $personal['program'];
    $mobile_number = $personal['mobile_number'];

    $id_number = $personal['id_number'];
}


if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $count = delete($table, $id);

    if ($count) {


        $_SESSION['message'] = 'Personal Data Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './personal-data.php');
        exit();
    } else {
        $_SESSION['message'] = 'Personal Data not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './personal-data.php');
        exit();
    }
}







if (isset($_POST['add-personal'])) {


    $errors = validatePersonal($_POST);

    $_POST['date_of_birth'] = date('Y-m-d', strtotime($_POST['date_of_birth']));


    if (count($errors) === 0) {


        unset($_POST['add-personal']);


        $personal_id = create($table, $_POST);

        $_SESSION['message'] = 'Personal Data Created successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './personal-data.php');
        exit();
    } else {
        $date_of_birth = $_POST['date_of_birth'];
        $program = $_POST['program'];
        $address = $_POST['address'];
        $mobile_number = $_POST['mobile_number'];

        $id_number = $_POST['id_number'];
    }
}

if (isset($_POST['add-matric'])) {

    $matric = $_POST['id_number'];
    $personal = selectOne($table, ['id_number' => $matric]);
    unset($_POST['add-matric']);

    if (!$matric) {
        array_push($errors, "You need to put a Matric ID");
    } elseif ($personal) {
        array_push($errors, "personal Exists");
    } else {
        $personal_id = create($table, $_POST);

        $_SESSION['message'] = 'Matric Added successfully';
        $_SESSION['type'] = 'success';
    }
}







if (isset($_POST['edit-personal'])) {
    $id = $_SESSION['personal_id'];
    

    $errors = validatePersonalUpdate($_POST);
    unset($_POST['edit-personal'], $_POST['id']);


   




    if (count($errors) === 0) {


        
        $personal_id = update($table, $id, $_POST);

        unset($_SESSION['personal_id']);

        $_SESSION['message'] = 'Personal Data Updated successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './personal-data.php');
        exit();
    } else {
        $date_of_birth = $_POST['date_of_birth'];
        $program = $_POST['program'];
        $address = $_POST['address'];
        $mobile_number = $_POST['mobile_number'];

        $id_number = $_POST['id_number'];
    }
}
