<?php

include (base_app . "adminDatabase/db.php");
include (base_app . "adminHelpers/validateDepartment.php");



$table = 'departments';

$errors = array();
$id = '';
$name = '';
$hod = '';
$fac_id = '';


$departments = selectAll($table);

$faculties = selectAll('faculties');







if (isset($_POST['add-department'])) {
    $errors = validateDepartment($_POST);
   
    $oneFaculty = selectOne('faculties', ['id' => $_POST['fac_id']]);

    $_POST['faculty'] = $oneFaculty['name'];


    $formIndex = 'hod_sig';


    $filetype = ['jpg', 'png', 'webp', 'jpeg'];


    $file_s = selectOne('settings', ['id' => 1]);
    $filesize = $file_s['max_upload'];

    if (count($errors) === 0) {

        if (!empty($_FILES['hod_sig']['name'])) {
            $file_name = time() . '_' . $_FILES['hod_sig']['name'];
            
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['hod_sig']['tmp_name'], $destination);

                if ($result) {
                    $_POST['hod_sig'] = $file_name;
                } else {
                    array_push($errors, "Failed to Upload Image");
                }
            }
        } else {
            array_push($errors, "Image Required");
        }



    if (count($errors) === 0) {
        unset($_POST['add-department']);
        $department_id = create($table, $_POST);
        $_SESSION['message'] = 'Department created successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . './manage-departments.php');
        exit();
    }else {
        $name = $_POST['name'];
        $hod = $_POST['hod'];
        $faculty = $_POST['fac_id'];
    }
}
    
}



if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $department = selectOne($table, ['id' => $id]);

    $id = $department['id'];
    $name = $department['name'];
    $hod = $department['hod'];
    $fac_id = $department['fac_id'];
}




if (isset($_POST['update-btn'])) {
    $errors = validateDepartmentUpdate($_POST);
    

    $formIndex = 'hod_sig';


    $filetype = ['jpg', 'png', 'webp', 'jpeg'];


    $file_s = selectOne('settings', ['id' => 1]);
    $filesize = $file_s['max_upload'];

    if (count($errors) === 0) {

        if (!empty($_FILES['hod_sig']['name'])) {
            $file_name = time() . '_' . $_FILES['hod_sig']['name'];
            
            $destination = base_app . "uploads/" . $file_name;
            $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
            if (count($errors) == 0) {
                $result = move_uploaded_file($_FILES['hod_sig']['tmp_name'], $destination);

                if ($result) {
                    $_POST['hod_sig'] = $file_name;
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

        $file1 = $post['hod_sig'];
        $path1 = (base_app . 'uploads/') . $file1;


        if (file_exists($path1)) {
            unlink($path1);
        }
        

        update($table, $id, $_POST);
        
        $_SESSION['message'] = 'Department Updated successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . './manage-departments.php');
        exit();
    }else {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $hod = $_POST['hod'];
        $fac_id = $_POST['fac_id'];
    }
}
   
}

if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];

    $user = selectOne($table, ['id' => $id]);

    $image = $user['hod_sig'];
    $path = (base_app . 'uploads/') . $image;


    $count = delete($table, $id);

    if (file_exists($path)) {
        unlink($path);

        $_SESSION['message'] = 'Department Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './manage-departments.php');
        exit();
    } else {
        $_SESSION['message'] = 'Department not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './manage-departments.php');
        exit();
    }
}