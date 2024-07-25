<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include(base_app . "adminDatabase/db.php");
include(base_app . "adminHelpers/validateDisciplinary.php");

$errors = array();

$date = "";
$title = "";
$note = "";
$id_number = "";


$table = 'disciplinary';

$students = selectAll("users", ['admin' => 'repo_user']);

if (isset($_GET['id'])) {
    $disciplinary = selectOne($table, ['id' => $_GET['id']]);
    $id = $disciplinary['id'];
    $_SESSION['disciplinary_id'] = $id;
    $date = $disciplinary['date'];
    $title = $disciplinary['title'];
    $note = $disciplinary['note'];
    $id_number = $disciplinary['id_number'];
}


if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $disciplinary = selectOne($table, ['id' => $id]);

    $image = $disciplinary['filename'];
    $path = (base_app . 'uploads/') . $image;

    $count = delete($table, $id);

    if (file_exists($path)) {
        unlink($path);

        $_SESSION['message'] = 'Disciplinary Action Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './disciplinary-action.php');
        exit();
    } else {
        $_SESSION['message'] = 'Disciplinary Action not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './disciplinary-action.php');
        exit();
    }
}







if (isset($_POST['add-disciplinary'])) {


    $errors = validateDisciplinary($_POST);

    $_POST['date'] = date('Y-m-d', strtotime($_POST['date']));

    $formIndex = 'file';


    $filetype = ['jpg', 'png', 'webp', 'jpeg', 'pdf', 'doc', 'docx'];


    $file_s = selectOne('settings', ['id' => 1]);
    $filesize = $file_s['max_upload'];



    $thumbnail_name_check = $_FILES['file']['name'];
    $extension_check = explode('.', $thumbnail_name_check);

    $extension_check = end($extension_check);
    $_POST['format'] = $extension_check;







    if (count($errors) === 0) {


        unset($_POST['add-disciplinary']);

        if (!empty($_FILES['file']['name'])) {
            $file_name = time() . '_' . $_FILES['file']['name'];
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['file']['tmp_name'], $destination);

                if ($result) {
                    $_POST['filename'] = $file_name;
                    $_POST['size'] = $_FILES['file']['size'];
                    $disciplinary_id = create($table, $_POST);

                    $id_number_email = $_POST['id_number'];
                    $title_email = $_POST['title'];
                    $note_email = $_POST['note'];
                    $date_email = $_POST['date'];

                    $guardian =  selectAll('student_guardian', ['id_number' => $id_number_email]);
                    $student_mail =  selectOne('users', ['id_number' => $id_number_email]);
                    $student_mail_send = $student_mail['email'];
                    $student_name_send = $student_mail['firstname'];
                    //Import PHPMailer classes into the global namespace
                    //These must be at the top of your script, not inside a function
                    require(base_app . "PHPMailer/src/Exception.php");
                    require(base_app . "PHPMailer/src/PHPMailer.php");
                    require(base_app . "PHPMailer/src/SMTP.php");

                    foreach ($guardian as $key => $row) {

                        $guardian_email = $row['email'];
                        $guardian_firstname = $row['firstname'];


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
                            $mail->addAddress($guardian_email, $guardian_firstname);     //Add a recipient
                            $mail->addAddress($student_mail_send, $student_name_send);     //Add a recipient




                            //Content
                            $mail->isHTML(true);                                  //Set email format to HTML


                            $mail->Subject = 'Disciplinary Action against ' . $id_number_email;
                            $mail->Body    = '<p>A Disciplinary Action titled <b style="font-size:30px;">' . $title_email . '</b> has been taking against the student (' . $id_number_email . ') with the following note <br /><br />' . $note_email . '<br /><br /> The Action was taken on ' . $date_email . '</p>';




                            $mail->send();

                            //echo 'Message has been sent';
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }

                    $_SESSION['message'] = 'Disciplinary Action Created successfully';
                    $_SESSION['type'] = 'success';


                    header("location: " . './disciplinary-action.php');
                    exit();
                } else {
                    array_push($errors, "Failed to Upload Image");
                    $title = $_POST['title'];
                    $note = $_POST['note'];
                    $date = $_POST['date'];

                    $id_number = $_POST['id_number'];
                }
            }
        } else {
            array_push($errors, "Image Required");
            $title = $_POST['title'];
            $note = $_POST['note'];
            $date = $_POST['date'];
            $id_number = $_POST['id_number'];
        }
    } else {
        $title = $_POST['title'];
        $note = $_POST['note'];
        $date = $_POST['date'];
        $id_number = $_POST['id_number'];
    }
}

if (isset($_POST['add-matric'])) {

    $matric = $_POST['id_number'];
    $disciplinary = selectOne($table, ['id_number' => $matric]);
    unset($_POST['add-matric']);

    if (!$matric) {
        array_push($errors, "You need to put a Matric ID");
    } elseif ($disciplinary) {
        array_push($errors, "disciplinary Exists");
    } else {
        $disciplinary_id = create($table, $_POST);

        $_SESSION['message'] = 'Matric Added successfully';
        $_SESSION['type'] = 'success';
    }
}







if (isset($_POST['edit-disciplinary'])) {
    $id = $_SESSION['disciplinary_id'];

    $errors = validateDisciplinaryUpdate($_POST);

    $_POST['date'] = date('Y-m-d', strtotime($_POST['date']));
    unset($_POST['edit-disciplinary'], $_POST['id']);


    $formIndex = 'file';


    $filetype = ['jpg', 'png', 'webp', 'jpeg', 'pdf', 'doc', 'docx'];


    $file_s = selectOne('settings', ['id' => 1]);
    $filesize = $file_s['max_upload'];









    if (count($errors) === 0) {


        if (!empty($_FILES['file']['name'])) {
            $file_name = time() . '_' . $_FILES['file']['name'];
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['file']['tmp_name'], $destination);

                if ($result) {
                    $_POST['filename'] = $file_name;
                    $_POST['size'] = $_FILES['file']['size'];
                    $thumbnail_name_check = $_FILES['file']['name'];
                    $extension_check = explode('.', $thumbnail_name_check);

                    $extension_check = end($extension_check);
                    $_POST['format'] = $extension_check;

                    $post = selectOne($table, ['id' => $id]);

                    $file1 = $post['filename'];
                    $path1 = (base_app . 'uploads/') . $file1;


                    if (file_exists($path1)) {
                        unlink($path1);
                    }

                    $disciplinary_id = update($table, $id, $_POST);

                    unset($_SESSION['disciplinary_id']);

                    $_SESSION['message'] = 'Disciplinary Action Updated successfully';
                    $_SESSION['type'] = 'success';


                    header("location: " . './disciplinary-action.php');
                    exit();
                } else {
                    array_push($errors, "Failed to Upload Image");
                    $title = $_POST['title'];
                    $note = $_POST['note'];
                    $date = $_POST['date'];
                    $id_number = $_POST['id_number'];
                }
            }
        } else {
            //dd($_POST);


            $disciplinary_id = update($table, $id, $_POST);

            unset($_SESSION['disciplinary_id']);

            $_SESSION['message'] = 'Disciplinary Action Updated successfully';
            $_SESSION['type'] = 'success';


            header("location: " . './disciplinary-action.php');
            exit();
        }
    } else {
        $title = $_POST['title'];
        $note = $_POST['note'];
        $date = $_POST['date'];
        $id_number = $_POST['id_number'];
    }
}
