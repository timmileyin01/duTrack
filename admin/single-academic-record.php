<?php
include './constants.php';
include 'adminControllers/academic-record.php';
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



//get the total numbers of rows
if (isset($_POST['search-term'])) {
    $start = 0;
    $rows_per_page = 100;
    $search_term = $_POST['search-term'];
    $sql = "SELECT * FROM `academic_record` WHERE `id_number` LIKE  '$search_term' LIMIT $start, $rows_per_page";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $nr_of_rows = count($records);
} else {
    $start = 0;
    $rows_per_page = 5;
    $sql_row = "SELECT * FROM academic_record";
    $row_record = prepare_sql($sql_row);
    $nr_of_rows = $row_record->num_rows;
}


//calculating number of pages
$pages = ceil($nr_of_rows / $rows_per_page);

//if the user clicks on the pagination buttons a new stating point is set
if (isset($_GET['page-nr'])) {
    $page = $_GET['page-nr'] - 1;
    $start = $page * $rows_per_page;
}


$sql = "SELECT * FROM academic_record LIMIT $start, $rows_per_page";


$stmt = $conn->prepare($sql);
$stmt->execute();
$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


$search_te = "";

if (isset($_POST['search-term'])) {
    $search_term = '%' . $_POST['search-term'] . '%';
    $sql = "SELECT * FROM `academic_record` WHERE `id_number` LIKE  '$search_term' LIMIT $start, $rows_per_page";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $search_te = $_POST['search-term'];
}




if (isset($_GET['page-nr'])) {
    $id_pagination = $_GET['page-nr'];
} else {
    $id_pagination = 1;
}



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

        <div class="search_and_i-name">

        </div>

        <div class="board">
            <h2>Academic Record for
                <?php if (isset($_POST['check_cgpa']) && !empty($_POST['cgpa_id'])) {
                    echo $_POST['cgpa_id'];
                } ?>
            </h2>
            <div class="add_faculty-btn">
                <a href="add-academic.php" class="btn">Add Data</a>
            </div>
            <table width="100%">
                <thead>
                    <tr>

                        <th>Session</th>
                        <th>Semester</th>
                        <th>GPA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_POST['check_cgpa'])) {
                        $single_academic = selectAll($table, ['id_number' => $_POST['cgpa_id']]);
                    }
                    foreach ($single_academic as $key => $row) : ?>
                        <tr>
                            <td><?= $row['session'] ?></td>
                            <td><?= $row['semester'] ?></td>
                            <td><?= $row['gpa'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
        <div class="board">
            
            <?php
            if (!empty($_POST['cgpa_id'])) {
                
                $check_cgpa = $_POST['cgpa_id'];
                $total_gpa = "SELECT SUM(`gpa`) AS count1 FROM `academic_record` WHERE `id_number` = '$check_cgpa'";
                $total_cgpa = $conn->query($total_gpa);
                $records = $total_cgpa->fetch_array();
                $cgpa = $records['count1'];
    
                $row_cgpa = "SELECT * FROM `academic_record` WHERE `id_number` = '$check_cgpa'";
                $row_cgpa_record = prepare_sql($row_cgpa);
                $no_cgpa = $row_cgpa_record->num_rows;
    
                if ($cgpa) {
    
                    $cgpa_now = number_format(($cgpa / $no_cgpa), 2);
                }
            }


            ?>
            <h2>The CGPA for this student is <span class="danger"><?= $cgpa_now ?></span></h2>

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