<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include(base_app . "adminDatabase/db.php");
include(base_app . "adminHelpers/validateResult.php");




$table = 'results';

$errors = array();
$id = '';
$matric_id = '';
$session = '';
$semester = '';
$course_id = '';
$course_unit = '';
$score = '';
$remark = '';









if (isset($_POST['add-result'])) {

    if (!empty($_POST['course_id']) && !empty($_POST['session_id']) && !empty($_POST['matric_id'])) {
        $course = selectOne('courses', ['id' => $_POST['course_id']]);

        $session = selectOne('sessions', ['id' => $_POST['session_id']]);

        $unique_id = $_POST['matric_id'] . $course['course_code'] . $session['session'];
        $_POST['unique_id'] = $unique_id;
    }


    if (!empty($_POST['matric_id'])) {
        $student = selectOne('users', ['id_number' => $_POST['matric_id']]);
        $_POST['student_name'] = $student['firstname'] . ' ' . $student['othernames'] . ' ' . $student['surname'];
    }

    $matric = $_POST['matric_id'];
    $session_id = $_POST['session_id'];
    $semester_id = $_POST['semester'];

    $errors = validateResult($_POST);


    if ($_POST['score'] >= 70) {
        $grade = 5;
    } elseif ($_POST['score'] > 59 && $_POST['score'] < 70) {
        $grade = 4;
    } elseif ($_POST['score'] > 49 && $_POST['score'] < 60) {
        $grade = 3;
    } elseif ($_POST['score'] > 44 && $_POST['score'] < 50) {
        $grade = 2;
    } else {
        $grade = 0;
    }


    $_POST['total_points'] = $grade * $_POST['course_unit'];

    if (count($errors) === 0) {
        unset($_POST['add-result']);

        $result_id = create($table, $_POST);

        $total_points = "SELECT SUM(`total_points`) AS count FROM `results` WHERE `matric_id` = '$matric' AND `session_id` = $session_id AND `semester` = $semester_id";
        $duration = $conn->query($total_points);
        $record = $duration->fetch_array();
        $total_point = $record['count'];


        $course_unit = "SELECT SUM(`course_unit`) AS count1 FROM `results` WHERE `matric_id` = '$matric' AND `session_id` = $session_id AND `semester` = $semester_id";
        $course_u = $conn->query($course_unit);
        $records = $course_u->fetch_array();
        $total_unit = $records['count1'];


        $gpa = number_format(($total_point / $total_unit), 2);

        $level = $_POST['level'];

        $unique_gpa_id = $matric . $session_id . $semester_id . $level;

        $confirm_gpa = "SELECT * FROM `gpa` WHERE `matric_no` = '$matric' AND `session_id` = $session_id AND `semester` = $semester_id";
        $st = $conn->prepare($confirm_gpa);
        $st->execute();
        $rec = $st->get_result()->fetch_all(MYSQLI_ASSOC);

        if ($rec) {
            $gpa_update = "UPDATE `gpa` SET `total_points`= $total_point,`total_unit`= $total_unit,`gpa`= $gpa WHERE `matric_no` = '$matric' AND `session_id` = $session_id AND `semester` = $semester_id";
            $exec = $conn->query($gpa_update);
        } else {
            $create_gpa = "INSERT INTO `gpa`(`session_id`, `semester`, `level`, `matric_no`, `total_points`, `total_unit`, `gpa`, `unique_id`) VALUES ($session_id, $semester_id, $level, '$matric', $total_point, $total_unit, $gpa, '$unique_gpa_id')";
            $exec = $conn->query($create_gpa);
        }

        





        $_SESSION['message'] = 'Result Added Successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . './manage-results.php');
        exit();
    } else {
        $matric_id = $_POST['matric_id'];
        $session = $_POST['session_id'];
        $semester = $_POST['semester'];
        $course_id = $_POST['course_id'];
        $course_unit = $_POST['course_unit'];
        $score = $_POST['score'];
        $remark = $_POST['remark'];
    }
}



if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $_SESSION['re_id'] = $id;
    $result = selectOne($table, ['id' => $id]);

    $matric_id = $result['matric_id'];
    $session = $result['session_id'];
    $level_st = $result['level'];
    $semester = $result['semester'];
    $course_id = $result['course_id'];
    $course_unit = $result['course_unit'];
    $score = $result['score'];
    $remark = $result['remark'];
}




if (isset($_POST['update-btn'])) {
    if (!empty($_POST['course_id']) && !empty($_POST['session_id']) && !empty($_POST['matric_id'])) {
        $course = selectOne('courses', ['id' => $_POST['course_id']]);

        $session = selectOne('sessions', ['id' => $_POST['session_id']]);

        $unique_id = $_POST['matric_id'] . $course['course_code'] . $session['session'];
        $_POST['unique_id'] = $unique_id;
    }


    if (!empty($_POST['matric_id'])) {
        $student = selectOne('users', ['id_number' => $_POST['matric_id']]);
        $_POST['student_name'] = $student['firstname'] . ' ' . $student['othernames'] . ' ' . $student['surname'];
    }


    $matric = $_POST['matric_id'];
    $session_id = $_POST['session_id'];
    $semester_id = $_POST['semester'];


    $errors = validateResultUpdate($_POST);



    if (count($errors) === 0) {
        $id = $_SESSION['re_id'];
        unset($_POST['update-btn'], $_POST['id']);
        update($table, $id, $_POST);
        unset($_SESSION['re_id']);




        $total_points = "SELECT SUM(`total_points`) AS count FROM `results` WHERE `matric_id` = '$matric' AND `session_id` = $session_id AND `semester` = $semester_id";
        $duration = $conn->query($total_points);
        $record = $duration->fetch_array();
        $total_point = $record['count'];


        $course_unit = "SELECT SUM(`course_unit`) AS count1 FROM `results` WHERE `matric_id` = '$matric' AND `session_id` = $session_id AND `semester` = $semester_id";
        $course_u = $conn->query($course_unit);
        $records = $course_u->fetch_array();
        $total_unit = $records['count1'];


        $gpa = number_format(($total_point / $total_unit), 2);

        $level = $_POST['level'];

        $unique_gpa_id = $matric . $session_id . $semester_id . $level;

        $confirm_gpa = "SELECT * FROM `gpa` WHERE `matric_no` = '$matric' AND `session_id` = $session_id AND `semester` = $semester_id";
        $st = $conn->prepare($confirm_gpa);
        $st->execute();
        $rec = $st->get_result()->fetch_all(MYSQLI_ASSOC);

        if ($rec) {
            $gpa_update = "UPDATE `gpa` SET `total_points`= $total_point,`total_unit`= $total_unit,`gpa`= $gpa, `level` = $level WHERE `matric_no` = '$matric' AND `session_id` = $session_id AND `semester` = $semester_id";
            $exec = $conn->query($gpa_update);
        } else {
            $create_gpa = "INSERT INTO `gpa`(`session_id`, `semester`, `level`, `matric_no`, `total_points`, `total_unit`, `gpa`, `unique_id`) VALUES ($session_id, $semester_id, $level, '$matric', $total_point, $total_unit, $gpa, '$unique_gpa_id')";
            $exec = $conn->query($create_gpa);
        }



        $_SESSION['message'] = 'Result Updated successfully';
        $_SESSION['type'] = 'success';
        header('location: ' . './manage-results.php');
        exit();
    } else {
        $matric_id = $_POST['matric_id'];
        $session = $_POST['session_id'];
        $semester = $_POST['semester'];
        $course_id = $_POST['course_id'];
        $course_unit = $_POST['course_unit'];
        $score = $_POST['score'];
        $remark = $_POST['remark'];
    }
}

if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];


    $count = delete($table, $id);

    if ($count) {


        $_SESSION['message'] = 'Result Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './manage-results.php');
        exit();
    } else {
        $_SESSION['message'] = 'Result not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './manage-results.php');
        exit();
    }
}
