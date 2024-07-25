<?php


$settings = selectOne('settings', ['id' => 1]);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $settings['title'] ?></title>

    <link rel="icon" type="image/x-icon" href="./admin/uploads/<?= $settings['image'] ?>">

    <!--link to css-->
    <link rel="stylesheet" href="./css/style.css">

    <!--material icons-->
    <script src="https://kit.fontawesome.com/c003743f81.js" crossorigin="anonymous"></script>
</head>
<body>

<!--navigation-->
<nav>
        <div class="container nav-container max-width">
            <a href="./index.php" class="nav-logo">
                <img src="<?= './admin/uploads/' . $settings['image']; ?>">
                <h3><?= $settings['title'] ?></h3>
            </a>
            <div class="theme-toggler">
                <i class="fa-solid fa-sun active"></i>
                <i class="fa-solid fa-moon"></i>
            </div>
            <ul class="nav-items">                
                <li><a href="./about.php">About</a></li>
                <li><a href="./faq.php">FAQs</a></li>
                <li><a href="#contact">Contact</a></li>
                
                <?php if (isset($_SESSION['id'])): ?>
                    
                <li class="nav-profile">
                    <div class="avatar">
                        <?php $image = selectOne('users', ['id' => $_SESSION['id']]) ?>
                        <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == 'repo_user'){ ?>
                        <img src="<?= './admin/uploads/' . $image['avatar'] ?>" alt="">
                        <?php }else{ ?>
                            <img src="<?= './admin/uploads/' . $image['avatar'] ?>" alt="">
                            <?php } ?>
                    </div>
                    <ul>

                        <?php if($_SESSION['admin']): ?>
                            <?php if($_SESSION['admin'] == 'repo_user'): ?>
                        <li><a href="./student/">Dashboard</a></li>
                        <?php else: ?>
                            <li><a href="./admin/">Dashboard</a></li>
                        <?php endif; ?>

                        <?php endif; ?>

                        <li><a href="./logout.php">Logout</a></li>
                    </ul>
                </li>

                <?php else: ?>
                    <li><a href="signin.php">Signin</a></li>
                <?php endif; ?>

                <!---->

                
            </ul>
            <button id="open_nav-btn"><i class="fa-solid fa-bars"></i></button>
            <button id="close_nav-btn"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </nav>
    <!--end of navigation bar-->