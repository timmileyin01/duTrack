<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include './admin/constants.php';
include(base_app . "adminControllers/users.php");


function randNo($n)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = "";

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}

$settings = selectOne('settings', ['id' => 1]);
$id_number = "";

if (isset($_POST['reset-btn'])) {
    if (!empty($_POST['id_number'])) {
        $_SESSION['reset_id_number'] = $_POST['id_number'];
        $confirm = selectOne('users', ['id_number' => $_POST['id_number']]);
        if ($confirm) {
            $email_send = $confirm['email'];
            $firstname_send = $confirm['firstname'];
            $id_number_email = $_POST['id_number'];
            unset($_POST['reset-btn']);
            $randomNo = randNo(6);

            $_POST['code'] = password_hash($randomNo, PASSWORD_DEFAULT);

            $existing = selectOne('reset', ['id_number' => $_POST['id_number']]);

            if ($existing) {
                $id = $existing['id'];
                $update_reset = update("reset", $id, $_POST);

                require(base_app . "PHPMailer/src/Exception.php");
                require(base_app . "PHPMailer/src/PHPMailer.php");
                require(base_app . "PHPMailer/src/SMTP.php");



                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'oluwaseyitimm02@gmail.com';                     //SMTP username
                    $mail->Password   = 'jizdzdhkwmvfyvya';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('oluwaseyitimm02@gmail.com', 'DU Information Tracking System');
                    $mail->addAddress($email_send, $firstname_send);     //Add a recipient




                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML


                    $mail->Subject = 'Password Reset for ' . $id_number_email;
                    $mail->Body    = '<p>Your Password Reset Code is : <b style="font-size:30px;">' . $randomNo . '</b> It can only be used once <br /><br /> Ignore if you did not request for a password reset';




                    $mail->send();

                    //echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

                $_SESSION['message'] = 'A Reset code has been sent to your mail';
                $_SESSION['type'] = 'success';


                header("location: " . './password.php');
                exit();
            } else {
                $create_reset = create('reset', $_POST);

                require(base_app . "PHPMailer/src/Exception.php");
                require(base_app . "PHPMailer/src/PHPMailer.php");
                require(base_app . "PHPMailer/src/SMTP.php");



                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);

                try {
                    //Server settings
                    //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'oluwaseyitimm02@gmail.com';                     //SMTP username
                    $mail->Password   = 'jizdzdhkwmvfyvya';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('oluwaseyitimm02@gmail.com', 'DU Information Tracking System');
                    $mail->addAddress($email_send, $firstname_send);     //Add a recipient




                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML


                    $mail->Subject = 'Password Reset for ' . $id_number_email;
                    $mail->Body    = '<p>Your Password Reset Code is : <b style="font-size:30px;">' . $randomNo . '</b> <br /><br /> Ignore if you did not request for a password reset';




                    $mail->send();

                    //echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                $_SESSION['message'] = 'A Reset code has been sent to your mail';
                $_SESSION['type'] = 'success';


                header("location: " . './password.php');
                exit();
            }
        } else {
            array_push($errors, 'No Data Found');
            $id_number = $_POST['id_number'];
        }
    } else {
        array_push($errors, 'You need to enter Matric ID or Staff ID');
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

            <h2>Reset Password</h2>

            <?php include "helpers/formErrors.php"; ?>

            <form action="forgot.php" method="post">
                <input type="text" name="id_number" required value="<?= $id_number; ?>" placeholder="Enter Matric No. or Staff ID to reset">
                <div>
                    <button type="submit" name="reset-btn" class="btn">Reset</button>
                </div>
            </form>
        </div>
    </div>





    <!--links to js-->
    <script src="./admin/assets/js/main.js"></script>
    <script src="./admin/assets/js/theme-toggler.js"></script>

    <script>
        const resetBtn = document.getElementById('forgotPass');


        resetBtn.addEventListener('click', () => {

            setTimeout(() => {
                resetBtn.disabled = true;;
            }, 1000);
            setTimeout(() => {
                resetBtn.disabled = false;
            }, 30 * 100);
        })
    </script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>

</html>