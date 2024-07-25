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


$sql2_row = "SELECT * FROM messages";
$row2_record = prepare_sql($sql2_row);
$nr2_of_rows = $row2_record->num_rows;

$sql4_row = "SELECT * FROM users";
$row4_record = prepare_sql($sql4_row);
$nr4_of_rows = $row4_record->num_rows;

$sql1_row = "SELECT * FROM documents";
$row1_record = prepare_sql($sql1_row);
$nr1_of_rows = $row1_record->num_rows;

$sql3_row = "SELECT * FROM disciplinary";
$row3_record = prepare_sql($sql3_row);
$nr3_of_rows = $row3_record->num_rows;



$settings = selectOne('settings', ['id' => 1]);
?>


<div class="container">

    <section id="menu">
        <div class="top">
            <a href="../index.php" class="logo">
                <img src="<?= './uploads/' . $settings['image']; ?>">
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

            <a href="./manage-details.php">
                <i title="Manage Students" class="fa-solid fa-pen-to-square"></i>
                <h3>Student Data</h3>
            </a>
            <a href="./academic-record.php">
                <i title="Manage Academic" class="fa-solid fa-pen-to-square"></i>
                <h3>Academic Record</h3>
            </a>
            <a href="./documents.php">
                <i title="Manage documents" class="fa-solid fa-pen-to-square"></i>
                <h3>Documents</h3>
            </a>
            <a href="./disciplinary-action.php">
                <i title="Manage Disciplinary" class="fa-solid fa-pen-to-square"></i>
                <h3>Disciplinary</h3>
            </a>


            

            <?php if(isset($_SESSION['id']) && $_SESSION['admin'] == 'repo_super_admin') { ?>
            <a href="./manage-users.php">
                <i title="Manage Users" class="fa-solid fa-pen-to-square"></i>
                <h3>Users</h3>
                <small class="no-count"><?= $nr4_of_rows ?></small>
            </a>            
            <?php } ?>

            <a href="./settings.php">
                <i title="Settings" class="fa-solid fa-gear"></i>
                <h3>Settings</h3>
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
            
        </div>



        <div class="analytics">
        <div class="analytic-box">
                <div class="box">
                    <i class="fa-solid fa-user-plus i4"></i>
                    <div>
                        <h3><?= $nr4_of_rows ?></h3>
                        <small class="small">Total Users</small>
                    </div>
                </div>
                <small class="text-muted">Available</small>

            </div>
            <div class="analytic-box">
                <div class="box">
                    <i class="fa-solid fa-chart-simple i1"></i>
                    <div>
                        <h3><?= $nr1_of_rows ?></h3>
                        <small class="small">Documents</small>
                    </div>
                </div>
                <small class="text-muted">All</small>
            </div>
            <div class="analytic-box">
                <div class="box">
                    <i class="fa-solid fa-upload i2"></i>
                    <div>
                        <h3><?= $nr2_of_rows ?></h3>
                        <small class="small">Messages</small>
                    </div>
                </div>
                <small class="text-muted">All</small>
            </div>
            <div class="analytic-box">
                <div class="box">
                    <i class="fa-solid fa-download i3"></i>
                    <div>
                        <h3><?= $nr3_of_rows ?></h3>
                        <small class="small">Disciplinary Actions</small>
                    </div>
                </div>
                <small class="text-muted">All</small>
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