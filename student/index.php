<?php

include "./constants.php";
include 'adminControllers/users.php';
include 'adminIncludes/header.php';


$users = array();

function prepare_sql($sql)
{
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result();
    return $records;
}





$settings = selectOne('settings', ['id' => 1]);
?>


<div class="container">

    <section id="menu">
        <div class="top">
            <a href="../index.php" class="logo">
                <img src="<?= '../admin/uploads/' . $settings['image']; ?>">
                <h2><?= $settings['title'] ?></h2>
            </a>
            <div class="close" id="close-btn">
                <span class="fa-solid fa-xmark"></span>
            </div>
        </div>


        <div class="items">
            <a href="./index.php" class="active">
                <i class="fa-solid fa-gauge"></i>
                <h3>Dashboard</h3>
            </a>

            <a href="./personal-details.php">
                <i title="Personal Details" class="fa-solid fa-pen-to-square"></i>
                <h3>Personal Details</h3>
            </a>

            <a href="./documents.php">
                <i title="Documents" class="fa-solid fa-circle-plus"></i>
                <h3>Documents</h3>
            </a>

            <a href="./disciplinary-actions.php">
                <i title="Disciplinary Actions" class="fa-solid fa-pen-to-square"></i>
                <h3>Disciplinary Actions</h3>
            </a>

            <a href="./check-result.php">
                <i title="Results" class="fa-solid fa-pen-to-square"></i>
                <h3>Check Result</h3>
            </a>

            <a href="../logout.php">
                <i title="Logout" class="fa-solid fa-right-from-bracket"></i>
                <h3>Logout</h3>
            </a>

        </div>
    </section>

    <section id="interface" class="interface">
        <?php include "adminIncludes/topNav.php"; ?>
        <div class="search_and_i-name">
            <div class="search2">
               <h2>Your Profile</h2>
            </div>
        </div>



        <?php 
        $user = selectOne('users', ['id' => $_SESSION['id']]);
        ?>

        <div class="board">
        <div class="item-container-main">
            <div class="detail">
                <h3>Name</h3>
                <h4><?= $user['surname']. ' ' . $user['firstname'] . ' ' . $user['othernames']?></h4>
            </div>
            <div class="detail">
                <h3>Matric Number</h3>
                <p><?= $user['id_number'] ?></p>
            </div>
            <div class="detail">
                <h3>Gender</h3>
                <p><?= $user['gender'] ?></p>
            </div>
            <div class="detail">
                <h3>Email</h3>
                <p><?= $user['email'] ?></p>
            </div>
            <div class="detail">
                <h3>Profile Image</h3>
                <img class="profile" src="<?= '../admin/uploads/' . $user['avatar']; ?>" alt="">
            </div>
            
            
        </div>
        </div>
    </section>

</div>



<!--links to js-->
<script src="./assets/js/main.js"></script>
<script src="./assets/js/theme-toggler.js"></script>
<script>
    let links = document.querySelectorAll('.page-numbers > a');
    let bodyId = parseInt(document.body.id);
    links[bodyId].classList.add("active");
</script>
</body>

</html>