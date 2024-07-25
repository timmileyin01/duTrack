<?php

include(base_app . "adminDatabase/db.php");
include(base_app . "adminHelpers/validateGuardian.php");

$errors = array();

$surname = "";
$firstname = "";
$email = "";
$middlename = "";
$mobile_number = "";
$address = "";
$relationship = "";

$id_number = "";


$table = 'student_guardian';

$students = selectAll("users", ['admin' => 'repo_user']);

if (isset($_GET['id'])) {
    $guardian = selectOne($table, ['id' => $_GET['id']]);
    $id = $guardian['id'];
    $_SESSION['guardian_id'] = $id;
    $surname = $guardian['surname'];
    $firstname = $guardian['firstname'];
    $email = $guardian['email'];
    $middlename = $guardian['middlename'];
    $mobile_number = $guardian['mobile_number'];
    $address = $guardian['address'];
    $relationship = $guardian['relationship'];

    $id_number = $guardian['id_number'];
}


if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $guardian = selectOne($table, ['id' => $id]);

    $image = $guardian['avatar'];
    $path = (base_app . 'uploads/') . $image;

    $count = delete($table, $id);

    if (file_exists($path)) {
        unlink($path);

        $_SESSION['message'] = 'guardian Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './guardian-data.php');
        exit();
    } else {
        $_SESSION['message'] = 'guardian not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './guardian-data.php');
        exit();
    }
}







if (isset($_POST['add-guardian'])) {


    $errors = validateGuardian($_POST);

    $formIndex = 'avatar';


    $filetype = ['jpg', 'png', 'webp', 'jpeg'];


    $file_s = selectOne('settings', ['id' => 1]);
    $filesize = $file_s['max_upload'];










    if (count($errors) === 0) {


        unset($_POST['add-guardian']);

        if (!empty($_FILES['avatar']['name'])) {
            $file_name = time() . '_' . $_FILES['avatar']['name'];
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);

                if ($result) {
                    $_POST['avatar'] = $file_name;
                    $guardian_id = create($table, $_POST);

                    $_SESSION['message'] = 'guardian Created successfully';
                    $_SESSION['type'] = 'success';


                    header("location: " . './guardian-data.php');
                    exit();
                } else {
                    array_push($errors, "Failed to Upload Image");
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
        } else {
            array_push($errors, "Image Required");
            $surname = $_POST['surname'];
            $firstname = $_POST['firstname'];
            $email = $_POST['email'];
            $middlename = $_POST['middlename'];
            $relationship = $_POST['relationship'];

            $address = $_POST['address'];
            $mobile_number = $_POST['mobile_number'];

            $id_number = $_POST['id_number'];
        }
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
    $guardian = selectOne($table, ['id_number' => $matric]);
    unset($_POST['add-matric']);

    if (!$matric) {
        array_push($errors, "You need to put a Matric ID");
    } elseif ($guardian) {
        array_push($errors, "guardian Exists");
    } else {
        $guardian_id = create($table, $_POST);

        $_SESSION['message'] = 'Matric Added successfully';
        $_SESSION['type'] = 'success';
    }
}







if (isset($_POST['edit-guardian'])) {
    $id = $_SESSION['guardian_id'];

    $errors = validateGuardianUpdate($_POST);
    unset($_POST['edit-guardian'], $_POST['id']);


    $formIndex = 'avatar';


    $filetype = ['jpg', 'png', 'webp', 'jpeg'];


    $file_s = selectOne('settings', ['id' => 1]);
    $filesize = $file_s['max_upload'];





    if (count($errors) === 0) {


        if (!empty($_FILES['avatar']['name'])) {
            $file_name = time() . '_' . $_FILES['avatar']['name'];
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);

                if ($result) {
                    $_POST['avatar'] = $file_name;
                    $post = selectOne($table, ['id' => $id]);

                    $file1 = $post['avatar'];
                    $path1 = (base_app . 'uploads/') . $file1;


                    if (file_exists($path1)) {
                        unlink($path1);
                    }

                    $guardian_id = update($table, $id, $_POST);

                    unset($_SESSION['guardian_id']);

                    $_SESSION['message'] = 'guardian Updated successfully';
                    $_SESSION['type'] = 'success';


                    header("location: " . './guardian-data.php');
                    exit();
                } else {
                    array_push($errors, "Failed to Upload Image");
                }
            }
        } else {
           

            $guardian_id = update($table, $id, $_POST);

            unset($_SESSION['guardian_id']);

            $_SESSION['message'] = 'guardian Updated successfully';
            $_SESSION['type'] = 'success';


            header("location: " . './guardian-data.php');
            exit();
        }
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
