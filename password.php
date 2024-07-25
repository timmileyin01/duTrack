<?php
include './admin/constants.php';
include(base_app . "adminControllers/users.php");



$settings = selectOne('settings', ['id' => 1]);




if (isset($_POST['reset-btn'])) {
    $errors = passwordReset($_POST);


    if (count($errors) === 0) {
        $confirmCode = selectOne('reset', ['id_number' => $_SESSION['reset_id_number']]);
        $confirm_id = $confirmCode['id'];
        if ($confirmCode) {
            $codedata = $confirmCode['code'];
            if (password_verify($_POST['code'], $codedata)) {
                unset($_POST['reset-btn'], $_POST['confirmpassword'], $_POST['code']);
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $get_id = selectOne('users', ['id_number' => $_SESSION['reset_id_number']]);

                $id = $get_id['id'];



                $user_id = update('users', $id, $_POST);
                $delete_reset = delete('reset', $confirm_id);

                unset($_SESSION['reset_id_number']);

                $_SESSION['message'] = 'Password Updated successfully';
                $_SESSION['type'] = 'success';


                header("location: " . './signin.php');
                exit();
            } else {
                array_push($errors, 'Invalid reset code');
                $code = $_POST['code'];
                $password = $_POST['password'];
                $confirmpassword = $_POST['confirmpassword'];
            }
        } else {
            array_push($errors, 'Kindly request for reset code');
            $code = $_POST['code'];
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];
        }
    } else {
        $code = $_POST['code'];
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $settings['title'] ?></title>

    <link rel="icon" type="image/x-icon" href="./admin/uploads/<?= $settings['image'] ?>">

    <!--link to css-->
    <link rel="stylesheet" href="./admin/assets/css/style.css">

    <!--material icons-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" />
</head>

<body>




    <div class="theme-form">
        <div>
            <a href="./index.php" class="btn">Home</a>
        </div>
        <div class="theme-toggler margin-top">
            <i class="material-icons-sharp active">light_mode</i>
            <i class="material-icons-sharp">dark_mode</i>
        </div>
    </div>
    <div class="container form-pages">
        <div class="form">

            <h2>Change Password</h2>

            <?php include "helpers/formErrors.php"; ?>
            <?php include("./includes/messages.php"); ?>

            <form action="password.php" method="post">
                <input type="text" name="code" value="<?= $code; ?>" placeholder="Enter Reset Code">
                <input type="password" name="password" value="<?= $password; ?>" placeholder="Password">
                <input type="password" name="confirmpassword" value="<?= $confirmpassword; ?>" placeholder="Confirm Password">
                <div>
                    <button type="submit" name="reset-btn" class="btn">Submit</button>
                </div>
            </form>
        </div>
    </div>





    <!--links to js-->
    <script src="./admin/assets/js/main.js"></script>
    <script src="./admin/assets/js/theme-toggler.js"></script>

    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>