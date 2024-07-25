<?php

include "./database/db.php";

include "./helpers/validateUser.php";

$errors = array();
$id_number = "";
$email = "";
$password = "";
$confirmPassword = "";
$table = 'users';


function loginUser($user){
    $_SESSION['id'] = $user['id'];
    $_SESSION['id_number'] = $user['id_number'];
    $_SESSION['admin'] = $user['admin'];
    $_SESSION['message'] = 'You are now logged in';
    $_SESSION['type'] = 'success';

    if($_SESSION['admin']){
        header('location: ' . "./admin/index.php");
    }else{
        header('location: ' . "./index.php");
    }
    exit();
}


if(isset($_POST['login-btn'])){
    $errors = validateLogin($_POST);

    if(count($errors) === 0) {
        $user = selectOne($table, ['id_number' => $_POST['id_number']]);

        if($user && password_verify($_POST['password'], $user['password'])){
           
        loginUser($user);

        }else{
            array_push($errors, 'wrong credentials');
        }
    }

    $id_number = $_POST['id_number'];
    $password = $_POST['password'];
}
