<?php

if (!isset($_SESSION['id'])) {
    header('location: ' . '../signin.php');
}elseif (isset($_SESSION['id']) && $_SESSION['admin'] != 'repo_user') {
    header('location: ' . '../admin');
}

$settings = selectOne('settings', ['id' => 1]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $settings['title'] ?></title>

    <link rel="icon" type="image/x-icon" href="../admin/uploads/<?= $settings['image'] ?>">

    <!--link to css-->
    <link rel="stylesheet" href="./assets/css/style.css">

    <!--material icons-->
    <script src="https://kit.fontawesome.com/c003743f81.js" crossorigin="anonymous"></script>
</head>
<body id="<?= $id_pagination ?>">

