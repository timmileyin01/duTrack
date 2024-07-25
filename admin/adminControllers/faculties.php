<?php


include (base_app . "adminDatabase/db.php");
include (base_app . "adminHelpers/validateFaculty.php");



$table = 'faculties';

$errors = array();
$id = '';
$name = '';
$dean = '';
$about = '';



$faculties = selectAll($table);



if (isset($_POST['add-faculty'])) {
    $errors = validateFaculty($_POST);

    $formIndex = 'dean_sig';


    $filetype = ['jpg', 'png', 'webp', 'jpeg'];


    $file_s = selectOne('settings', ['id' => 1]);
    $filesize = $file_s['max_upload'];

    if (count($errors) === 0) {

        if (!empty($_FILES['dean_sig']['name'])) {
            $file_name = time() . '_' . $_FILES['dean_sig']['name'];
            
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['dean_sig']['tmp_name'], $destination);

                if ($result) {
                    $_POST['dean_sig'] = $file_name;
                } else {
                    array_push($errors, "Failed to Upload Image");
                }
            }
        } else {
            array_push($errors, "Image Required");
        }


    if (count($errors) === 0) {
        unset($_POST['add-faculty']);
        $topic_id = create($table, $_POST);
        $_SESSION['message'] = 'Faculty created successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . './manage-faculties.php');
        exit();
    }else {
        $name = $_POST['name'];
        $dean = $_POST['dean'];
        $about = $_POST['about'];
    }
}
    
}



if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $faculty = selectOne($table, ['id' => $id]);

    $id = $faculty['id'];
    $name = $faculty['name'];
    $dean = $faculty['dean'];
    $about = $faculty['about'];
}

if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];

    $user = selectOne($table, ['id' => $id]);

    $image = $user['dean_sig'];
    $path = (base_app . 'uploads/') . $image;

    $count = delete($table, $id);

    if (file_exists($path)) {
        unlink($path);
      

        $_SESSION['message'] = 'Faculty Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './manage-faculties.php');
        exit();
    } else {
        $_SESSION['message'] = 'Faculty not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './manage-faculties.php');
        exit();
    }
}




if (isset($_POST['update-btn'])) {
    $errors = validateFacultyUpdate($_POST);
    $formIndex = 'dean_sig';


    $filetype = ['jpg', 'png', 'webp', 'jpeg'];


    $file_s = selectOne('settings', ['id' => 1]);
    $filesize = $file_s['max_upload'];

    if (count($errors) === 0) {

        if (!empty($_FILES['dean_sig']['name'])) {
            $file_name = time() . '_' . $_FILES['dean_sig']['name'];
            
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['dean_sig']['tmp_name'], $destination);

                if ($result) {
                    $_POST['dean_sig'] = $file_name;
                } else {
                    array_push($errors, "Failed to Upload Image");
                }
            }
        } else {
            array_push($errors, "Image Required");
        }


    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['update-btn'], $_POST['id']);

        $post = selectOne($table, ['id' => $id]);

        $file1 = $post['dean_sig'];
        $path1 = (base_app . 'uploads/') . $file1;


        if (file_exists($path1)) {
            unlink($path1);
        }

        update($table, $id, $_POST);
        
        $_SESSION['message'] = 'Faculty Updated successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . './manage-faculties.php');
        exit();
    }else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $dean = $_POST['dean'];
        $about = $_POST['about'];
    }
}
}

