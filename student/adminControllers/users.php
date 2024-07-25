<?php

include(base_app . "adminDatabase/db.php");
include(base_app . "adminHelpers/validateUser.php");

$errors = array();

$surname = "";
$firstname = "";
$email = "";
$othernames = "";
$admin = "";
$gender = "";

$id_number = "";
$password = "";
$passwordConf = "";

$table = 'users';


if (isset($_POST['edit_id'])) {
    $user = selectOne($table, ['id' => $_POST['edit_id']]);
    $id = $user['id'];
    $_SESSION['use_id'] = $id;
    $surname = $user['surname'];
    $firstname = $user['firstname'];
    $email = $user['email'];
    $othernames = $user['othernames'];
    $admin = $user['admin'];
    $gender = $user['gender'];

    $id_number = $user['id_number'];
}


if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $user = selectOne($table, ['id' => $id]);

    $image = $user['avatar'];
    $path = (base_app . 'uploads/') . $image;

    $count = delete($table, $id);

    if (file_exists($path)) {
        unlink($path);

        $_SESSION['message'] = 'User Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './manage-users.php');
        exit();
    } else {
        $_SESSION['message'] = 'User not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './manage-users.php');
        exit();
    }
}



function loginUser($user)
{
    $_SESSION['id'] = $user['id'];
    $_SESSION['id_number'] = $user['id_number'];

    if ($user['admin'] == 'repo_super_admin') {
        $_SESSION['admin'] = 'repo_super_admin';
        $_SESSION['message'] = 'Welcome, ' . $user['id_number'];
        $_SESSION['type'] = 'success';


        header('location: ' . './admin/');

        exit();
    }elseif ($user['admin'] == 'repo_admin') {
        $_SESSION['admin'] = 'repo_admin';
        $_SESSION['message'] = 'Welcome, ' . $user['id_number'];
        $_SESSION['type'] = 'success';


        header('location: ' . './admin/');

        exit();
    }elseif ($user['admin'] == 'repo_user') {
        $_SESSION['admin'] = 'repo_user';
        $_SESSION['message'] = 'Welcome, ' . $user['id_number'];
        $_SESSION['type'] = 'success';


        header('location: ' . './index.php');

        exit();
    }
}

if (isset($_POST['login-btn'])) {
    $errors = validateLogin($_POST);

    if (count($errors) === 0) {
        $user = selectOne($table, ['id_number' => $_POST['id_number']]);
        

        if ($user && password_verify($_POST['password'], $user['password'])) {
            loginUser($user);
        } else {
            array_push($errors, 'wrong credentials');
        }
    }

    $id_number = $_POST['id_number'];
    $password = $_POST['password'];
}




/*
if (isset($_POST['register-btn'])) {

    $errors = validateUser($_POST);

    $formIndex = 'image';


    $filetype = ['jpg', 'png', 'webp', 'jpeg'];


    $filesize = 1000000;










    if (count($errors) === 0) {

        $password1 = $_POST['password'];
        $passwordConf1 = $_POST['passwordConf'];

        unset($_POST['register-btn'], $_POST['passwordConf']);
        if (!empty($_FILES['image']['name'])) {
            $file_name = time() . '_' . $_FILES['image']['name'];
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);

                if ($result) {
                    $_POST['image'] = $file_name;
                } else {
                    array_push($errors, "Failed to Upload Image");
                }
            }
        } else {
            array_push($errors, "Image Required");
        }

        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);


        $user_id = create($table, $_POST);
        $user = selectOne($table, ['id' => $user_id]);

        //login user in
        loginUser($user);
    } else {
        $name = $_POST['name'];
        $nick = $_POST['username'];
        $email_or_no = $_POST['email'];
        $p_no = $_POST['p_no'];
        $password = $password1;
        $passwordConf = $passwordConf1;
    }
}

*/






if (isset($_POST['add-user'])) {
    $password1 = $_POST['password'];
    $password1_hash = $_POST['passwordConf'];
    $errors = validateUser($_POST);

    $formIndex = 'avatar';


    $filetype = ['jpg', 'png', 'webp', 'jpeg'];


    $file_s = selectOne('settings', ['id' => 1]);
    $filesize = $file_s['max_upload'];










    if (count($errors) === 0) {


        unset($_POST['add-user'], $_POST['passwordConf']);

        if (!empty($_FILES['avatar']['name'])) {
            $file_name = time() . '_' . $_FILES['avatar']['name'];
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);

                if ($result) {
                    $_POST['avatar'] = $file_name;
                } else {
                    array_push($errors, "Failed to Upload Image");
                }
            }
        } else {
            array_push($errors, "Image Required");
        }

        $password_hash = $_POST['password'];
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if ($_POST['admin'] == 1) {
            $_POST['admin'] = 'repo_user';
        } elseif ($_POST['admin'] == 2) {
            $_POST['admin'] = 'repo_admin';
        } elseif ($_POST['admin'] == 3) {
            $_POST['admin'] = 'repo_super_admin';
        }

        $user_id = create($table, $_POST);

        $_SESSION['message'] = 'User Created successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './manage-users.php');
        exit();
    } else {
        $surname = $_POST['surname'];
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $othernames = $_POST['othernames'];
        if ($_POST['admin'] == 1) {
            $_POST['admin'] = 'repo_user';
        } elseif ($_POST['admin'] == 2) {
            $_POST['admin'] = 'repo_admin';
        } elseif ($_POST['admin'] == 3) {
            $_POST['admin'] = 'repo_super_admin';
        }
        $admin = $_POST['admin'];
        $gender = $_POST['gender'];

        $id_number = $_POST['id_number'];
        $password = $password1;
        $passwordConf = $password1_hash;
    }
}







if (isset($_POST['edit-user'])) {
    $password1 = $_POST['password'];
    $password1_hash = $_POST['passwordConf'];
    $id = $_SESSION['use_id'];

    $errors = validateUserUpdate($_POST);
    unset($_POST['update-user'], $_POST['id'], $_POST['passwordConf']);


    $formIndex = 'avatar';


    $filetype = ['jpg', 'png', 'webp', 'jpeg'];


    $file_s = selectOne('settings', ['id' => 1]);
    $filesize = $file_s['max_upload'];


    if (count($errors) === 0) {


        unset($_POST['edit-user'], $_POST['passwordConf']);

        if (!empty($_FILES['avatar']['name'])) {
            $file_name = time() . '_' . $_FILES['avatar']['name'];
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['avatar']['tmp_name'], $destination);

                if ($result) {
                    $_POST['avatar'] = $file_name;
                } else {
                    array_push($errors, "Failed to Upload Image");
                }
            }
        } else {
            array_push($errors, "Image Required");
        }

        $password_hash = $_POST['password'];
        $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

        if ($_POST['admin'] == 1) {
            $_POST['admin'] = 'repo_user';
        } elseif ($_POST['admin'] == 2) {
            $_POST['admin'] = 'repo_admin';
        }

        $post = selectOne($table, ['id' => $id]);

        $file1 = $post['avatar'];
        $path1 = (base_app . 'uploads/') . $file1;


        if (file_exists($path1)) {
            unlink($path1);
        }

        $user_id = update($table, $id, $_POST);

        unset($_SESSION['use_id']);

        $_SESSION['message'] = 'Pofile Updated successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './index.php');
        exit();
    } else {
        $surname = $_POST['surname'];
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $othernames = $_POST['othernames'];
        if ($_POST['admin'] == 1) {
            $_POST['admin'] = 'repo_user';
        } elseif ($_POST['admin'] == 2) {
            $_POST['admin'] = 'repo_admin';
        }
        $admin = $_POST['admin'];
        $gender = $_POST['gender'];

        $id_number = $_POST['id_number'];
        $password = $password1;
        $passwordConf = $password1_hash;
    }
}
