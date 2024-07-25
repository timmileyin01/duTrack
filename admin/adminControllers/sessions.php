<?php


include (base_app . "adminDatabase/db.php");
include (base_app . "adminHelpers/validateSession.php");



$table = 'sessions';

$errors = array();
$id = '';
$session = '';




$sessions = selectAll($table);



if (isset($_POST['add-session'])) {
    $errors = validateSession($_POST);

    if (count($errors) === 0) {
        unset($_POST['add-session']);
        $session_id = create($table, $_POST);
        $_SESSION['message'] = 'Session created successfully';
        $_SESSION['type'] = 'success';
       
    }else {
        $session = $_POST['session'];
    }
    
}



if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $session1 = selectOne($table, ['id' => $id]);

    $id = $session1['id'];
    $session = $session1['name'];
}

if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $count = delete($table, $id);

    if ($count) {
      

        $_SESSION['message'] = 'Session Deleted successfully';
        $_SESSION['type'] = 'success';


    } else {
        $_SESSION['message'] = 'Session not Deleted';
        $_SESSION['type'] = 'error';

    }
}




if (isset($_POST['update-btn'])) {
    $errors = validateSessionUpdate($_POST);

    if (count($errors) === 0) {
        $id = $_POST['id'];
        unset($_POST['update-btn'], $_POST['id']);
        update($table, $id, $_POST);
        
        $_SESSION['message'] = 'Session Updated successfully';
        $_SESSION['type'] = 'success';
    }else {
        $id = $_POST['id'];
        $session = $_POST['session'];
        $session_id = $_POST['sess_id'];
    }
   
}

