<?php




include (base_app . "adminDatabase/db.php");
include (base_app . "adminHelpers/validateProject.php");


$table = 'projects';
$departments = selectAll('departments');
$projects = selectAll($table);




$errors = array();

$id = "";
$title = "";
$student_name = "";
$supervisor_name = "";
$matric_no = "";
$department_id = "";
$abstract = "";
$info = "";
$published = "";




if (isset($_POST['add-project'])) {
    if ($_POST['department_id']) {
        $department_id = $_POST['department_id'];
        $department = selectOne('departments', ['id' => $department_id]);
        $department_name = $department['name'];
        $_POST['department'] = $department_name;
    }

    
    

    $errors = validateProject($_POST);
    
    $formIndex1 = 'project_file';
    $formIndex2 = 'impl_file';

    $filetype1 = ['pdf', 'doc', 'docx'];
    $filetype2 = ['zip', 'rar', 'iso'];


    $file_s = selectOne('settings', ['id' => 1]);
        $filesize = $file_s['max_upload'];

    $filesize1 = $filesize;
    $filesize2 = $filesize;

    $thumbnail_name_check = $_FILES['impl_file']['name'];
    $extension_check = explode('.', $thumbnail_name_check);
    
    $extension_check = end($extension_check);
    $_POST['format'] = $extension_check;




        if (!empty($_FILES['project_file']['name'])) {
            $file_name = time() . '_' . $_FILES['project_file']['name'];
            $destination ="../admin/uploads/" . $file_name;
            $errors = validateProjectFile($_FILES, $formIndex1, $filetype1, $filesize1);
            if (count($errors) == 0){
            $result = move_uploaded_file($_FILES['project_file']['tmp_name'], $destination);

            if ($result) {
                $_POST['project_file'] = $file_name;
            } else {
                array_push($errors, "Failed to Upload Project File");
            }
        }
            
        } else {
            array_push($errors, "Project File Required");
        }

        if (!empty($_FILES['impl_file']['name'])) {
            $file_name1 = time() . '_' . $_FILES['impl_file']['name'];
            $destination1 = "../admin/uploads/" . $file_name1;
            $errors = validateProjectFile($_FILES, $formIndex2, $filetype2, $filesize2);
            if (count($errors) == 0){
            $result1 = move_uploaded_file($_FILES['impl_file']['tmp_name'], $destination1);

            if ($result1) {
                $_POST['impl_file'] = $file_name1;
                $_POST['filename'] = $_FILES['impl_file']['name'];
                $_POST['size'] = $_FILES['impl_file']['size'];
            } else {
                array_push($errors, "Failed to Upload Project File");
            }
        }
            
        }
    

    if (count($errors) == 0 && $result) {
        unset($_POST['add-project']);
        $_POST['user_id'] = $_SESSION['id'];

        $_POST['abstract'] = htmlentities($_POST['abstract']);
        $_POST['info'] = htmlentities($_POST['info']);

        $existingProject = selectOne('projects', ['user_id' => $_SESSION['id']]);


    
   
    if($existingProject['user_id'] == $_SESSION['id']) {
        $path1 = "../admin/uploads/" . $file_name;
        $path2 = "../admin/uploads/" . $file_name1;

        if (file_exists($path1) && file_exists($path2)) {
            unlink($path1);
            unlink($path2);
         }elseif (file_exists($path2)) {
             unlink($path2);
        }elseif (file_exists($path1)) {
            unlink($path1);
            
        }

        array_push($errors, 'You can only add one project');
    }else{
        
        $department_id = create($table, $_POST);
        $_SESSION['message'] = 'Project created successfully';
        $_SESSION['type'] = 'success';
        header("location: " . "./manage-projects.php");
        exit();
    }


        

        
        
        
    }else{
        $title = $_POST['title'];
        $student_name = $_POST['student_name'];
        $supervisor_name = $_POST['supervisor_name'];
        $matric_no = $_POST['matric_no'];
        $department_id = $_POST['department_id'];
        $abstract = $_POST['abstract'];
        $info = $_POST['info'];
    }

    
}













if (isset($_POST['update-project'])){
    if ($_POST['department_id']) {
        $department_id = $_POST['department_id'];
        $department = selectOne('departments', ['id' => $department_id]);
        $department_name = $department['name'];
        $_POST['department'] = $department_name;
    }

    $errors = validateProjectUpdate($_POST);
    
    $formIndex1 = 'project_file';
    $formIndex2 = 'impl_file';

    $filetype1 = ['pdf', 'doc', 'docx'];
    $filetype2 = ['zip', 'rar', 'iso'];

    $file_s = selectOne('settings', ['id' => 1]);
        $filesize = $file_s['max_upload'];

    $filesize1 = $filesize;
    $filesize2 = $filesize;

    $thumbnail_name_check = $_FILES['impl_file']['name'];
    $extension_check = explode('.', $thumbnail_name_check);
    
    $extension_check = end($extension_check);
    $_POST['format'] = $extension_check;


    if (!empty($_FILES['project_file']['name'])) {
        $file_name = time() . '_' . $_FILES['project_file']['name'];
        $destination = "../admin/uploads/" . $file_name;
        $errors = validateProjectFile($_FILES, $formIndex1, $filetype1, $filesize1);
        if (count($errors) == 0){
        $result = move_uploaded_file($_FILES['project_file']['tmp_name'], $destination);

        if ($result) {
            $_POST['project_file'] = $file_name;
        } else {
            array_push($errors, "Failed to Upload Project File");
        }
    }
        
    } else {
        array_push($errors, "Project File Required");
    }

    if (!empty($_FILES['impl_file']['name'])) {
        $file_name1 = time() . '_' . $_FILES['impl_file']['name'];
        $destination1 = "../admin/uploads/" . $file_name1;
        $errors = validateProjectFile($_FILES, $formIndex2, $filetype2, $filesize2);
        if (count($errors) == 0){
        $result1 = move_uploaded_file($_FILES['impl_file']['tmp_name'], $destination1);

        if ($result1) {
            $_POST['impl_file'] = $file_name1;
            $_POST['filename'] = $_FILES['impl_file']['name'];
            $_POST['size'] = $_FILES['impl_file']['size'];
        } else {
            array_push($errors, "Failed to Upload Project File");
        }
    }
        
    }

    if (count($errors) == 0) {
        $id = $_SESSION['pro_id'];




       
    

        $post = selectOne($table, ['id' => $id]);
        
        $file1 = $post['project_file'];
        $file2 = $post['impl_file'];
        $path1 = ('../admin/uploads/') . $file1;
        $path2 = ('../admin/uploads/') . $file2;
       
    
        







        unset($_POST['update-project'], $_POST['id']);
        $_POST['user_id'] = $_SESSION['id'];

        $_POST['abstract'] = htmlentities($_POST['abstract']);
        $_POST['info'] = htmlentities($_POST['info']);

        if (file_exists($path1) && file_exists($path2)) {
            unlink($path1);
            unlink($path2);
         }elseif (file_exists($path2)) {
             unlink($path2);
        }elseif (file_exists($path1)) {
            unlink($path1);
            
        }

        

        $department_id = update($table, $id, $_POST);
        unset($_SESSION['pro_id']);
        $_SESSION['message'] = 'Project Updated successfully';
        $_SESSION['type'] = 'success';
        header("location: " . "./manage-projects.php");
        exit();
    }else{
        $title = $_POST['title'];
        $student_name = $_POST['student_name'];
        $supervisor_name = $_POST['supervisor_name'];
        $matric_no = $_POST['matric_no'];
        $department_id = $_POST['department_id'];
        $abstract = $_POST['abstract'];
        $info = $_POST['info'];
        
    }
}









if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];



        $post = selectOne($table, ['id' => $id]);

        
        
        $file1 = $post['project_file'];
        $file2 = $post['impl_file'];
        $path1 = (base_app . 'uploads/') . $file1;
        $path2 = (base_app . 'uploads/') . $file2;

    $count = delete($table, $id);

    if (file_exists($path1) && file_exists($path2)) {
        unlink($path1);
        unlink($path2);

        $_SESSION['message'] = 'Project Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './manage-projects.php');
        exit();
    }elseif (file_exists($path2)) {
       
        unlink($path2);

        $_SESSION['message'] = 'Project Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './manage-projects.php');
        exit();
    }elseif (file_exists($path1)) {
        unlink($path1);
        

        $_SESSION['message'] = 'Project Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './manage-projects.php');
        exit();
    } else {
        $_SESSION['message'] = 'Project not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './manage-projects.php');
        exit();
    }
}





if (isset($_GET['published']) && isset($_GET['p_id'])) {
    $published = $_GET['published'];
  
    $p_id = $_GET['p_id'];


    // update

    $count = update($table, $p_id, ['published' => $published]);



    $_SESSION['message'] = 'Project Published state changed successfully!';
        $_SESSION['type'] = 'success';


        header("location: " . './manage-projects.php');
        exit();

}