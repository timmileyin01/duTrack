<?php

include(base_app . "adminDatabase/db.php");
include(base_app . "adminHelpers/validateDocument.php");

$errors = array();

$filename = "";
$title = "";
$note = "";
$format = "";
$size = "";


$id_number = "";


$table = 'documents';

$students = selectAll("users", ['admin' => 'repo_user']);

if (isset($_GET['id'])) {
    $document = selectOne($table, ['id' => $_GET['id']]);
    $id = $document['id'];
    $_SESSION['document_id'] = $id;
    $filename = $document['filename'];
    $title = $document['title'];
    $note = $document['note'];
    $size = $document['size'];
    $format = $document['format'];
    $id_number = $document['id_number'];
}


if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $document = selectOne($table, ['id' => $id]);

    $image = $document['filename'];
    $path = (base_app . 'uploads/') . $image;

    $count = delete($table, $id);

    if (file_exists($path)) {
        unlink($path);

        $_SESSION['message'] = 'Document Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './documents.php');
        exit();
    } else {
        $_SESSION['message'] = 'Document not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './documents.php');
        exit();
    }
}







if (isset($_POST['add-document'])) {


    $errors = validateDocument($_POST);

    $formIndex = 'file';


    $filetype = ['jpg', 'png', 'webp', 'jpeg', 'pdf', 'doc', 'docx'];


    $file_s = selectOne('settings', ['id' => 1]);
    $filesize = $file_s['max_upload'];



    $thumbnail_name_check = $_FILES['file']['name'];
    $extension_check = explode('.', $thumbnail_name_check);

    $extension_check = end($extension_check);
    $_POST['format'] = $extension_check;







    if (count($errors) === 0) {


        unset($_POST['add-document']);

        if (!empty($_FILES['file']['name'])) {
            $file_name = time() . '_' . $_FILES['file']['name'];
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['file']['tmp_name'], $destination);

                if ($result) {
                    $_POST['filename'] = $file_name;
                    $_POST['size'] = $_FILES['file']['size'];
                    $document_id = create($table, $_POST);

                    $_SESSION['message'] = 'Document Created successfully';
                    $_SESSION['type'] = 'success';


                    header("location: " . './documents.php');
                    exit();
                } else {
                    array_push($errors, "Failed to Upload Image");
                    $title = $_POST['title'];
                    $note = $_POST['note'];

                    $id_number = $_POST['id_number'];
                }
            }
        } else {
            array_push($errors, "Image Required");
            $title = $_POST['title'];
            $note = $_POST['note'];

            $id_number = $_POST['id_number'];
        }
    } else {
        $title = $_POST['title'];
        $note = $_POST['note'];

        $id_number = $_POST['id_number'];
    }
}

if (isset($_POST['add-matric'])) {

    $matric = $_POST['id_number'];
    $document = selectOne($table, ['id_number' => $matric]);
    unset($_POST['add-matric']);

    if (!$matric) {
        array_push($errors, "You need to put a Matric ID");
    } elseif ($document) {
        array_push($errors, "document Exists");
    } else {
        $document_id = create($table, $_POST);

        $_SESSION['message'] = 'Matric Added successfully';
        $_SESSION['type'] = 'success';
    }
}







if (isset($_POST['edit-document'])) {
    $id = $_SESSION['document_id'];

    $errors = validateDocumentUpdate($_POST);
    unset($_POST['edit-document'], $_POST['id']);


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

                    $document_id = update($table, $id, $_POST);

                    unset($_SESSION['document_id']);

                    $_SESSION['message'] = 'Document Updated successfully';
                    $_SESSION['type'] = 'success';


                    header("location: " . './documents.php');
                    exit();
                } else {
                    array_push($errors, "Failed to Upload Image");
                    $title = $_POST['title'];
                    $note = $_POST['note'];
                    $id_number = $_POST['id_number'];
                }
            }
        } else {


            $document_id = update($table, $id, $_POST);

            unset($_SESSION['document_id']);

            $_SESSION['message'] = 'Document Updated successfully';
            $_SESSION['type'] = 'success';


            header("location: " . './documents.php');
            exit();
        }
    } else {
        $title = $_POST['title'];
        $note = $_POST['note'];

        $id_number = $_POST['id_number'];
    }
}
