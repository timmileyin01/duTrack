<?php
include './admin/constants.php';
include (base_app . "adminControllers/users.php");



$settings = selectOne('settings', ['id' => 1]);
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp"/>
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
            
            <h2>Login</h2>

            <?php include "helpers/formErrors.php"; ?>
            <?php include("./includes/messages.php"); ?>

            <form action="signin.php" method="post">
                <input type="text" name="id_number" value="<?= $id_number; ?>" placeholder="Matric No. or Staff ID">
                <input type="password" name="password"  value="<?= $password; ?>" placeholder="Password">
                <div>
                    <button type="submit" name="login-btn" class="btn">Login</button>
                </div>
                <div class="question" style="display: flex; flex-direction: row; gap: 1rem; align-items: center; justify-content: center;">
                    <span class="text-muted">Want to Reset Your Password?</span><a href="forgot.php">Forgot Password</a>
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