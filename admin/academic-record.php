<?php
include './constants.php';
include 'adminControllers/results.php';
include 'adminIncludes/header.php';


$academics = array();

function prepare_sql($sql)
{
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result();
    return $records;
}


$sql4_row = "SELECT * FROM users";
$row4_record = prepare_sql($sql4_row);
$nr4_of_rows = $row4_record->num_rows;





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
            <a href="./index.php">
                <i class="fa-solid fa-gauge"></i>
                <h3>Dashboard</h3>
            </a>

            <a href="./manage-details.php">
                <i title="Manage Students" class="fa-solid fa-pen-to-square"></i>
                <h3>Student Data</h3>
            </a>
            <a href="./academic-record.php" class="active">
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




            <?php if (isset($_SESSION['id']) && $_SESSION['admin'] == 'repo_super_admin') { ?>
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




        <div class="analytics add-margin">
            <div class="analytic-box">
                <div class="box">

                    <div>

                        <small class="small-unique"><a href="manage-courses.php">Manage Courses</a></small>
                    </div>
                </div>


            </div>
            <div class="analytic-box">
                <div class="box">

                    <div>

                        <small class="small-unique"><a href="manage-departments.php">Manage Departments</a></small>
                    </div>
                </div>

            </div>
            <div class="analytic-box">
                <div class="box">

                    <div>

                        <small class="small-unique"><a href="manage-faculties.php">Manage Faculties</a></small>
                    </div>
                </div>

            </div>
            <div class="analytic-box">
                <div class="box">

                    <div>

                        <small class="small-unique"><a href="manage-results.php">Manage Results</a></small>
                    </div>
                </div>

            </div>

        </div>


        <div class="board">
            <div class="add_faculty-btn">
                <a href="./add-session.php" class="btn">Add Academic Session</a>
            </div>
            
        </div>


    </section>

</div>



<!--links to js-->
<script src="./assets/js/main.js"></script>
<script src="./assets/js/theme-toggler.js"></script>

</body>

</html>