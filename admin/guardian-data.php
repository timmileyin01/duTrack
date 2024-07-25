<?php
include './constants.php';
include 'adminControllers/guardians.php';
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


$sql4_row = "SELECT * FROM users";
$row4_record = prepare_sql($sql4_row);
$nr4_of_rows = $row4_record->num_rows;



//get the total numbers of rows
if (isset($_POST['search-term'])) {
    $start = 0;
    $rows_per_page = 100;
    $search_term = $_POST['search-term'];
    $sql = "SELECT * FROM `student_guardian` WHERE `surname` LIKE  '$search_term' OR `firstname` LIKE  '$search_term' OR `middlename` LIKE  '$search_term' OR `id_number` LIKE  '$search_term' LIMIT $start, $rows_per_page";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $nr_of_rows = count($records);
} else {
    $start = 0;
    $rows_per_page = 5;
    $sql_row = "SELECT * FROM student_guardian";
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


$sql = "SELECT * FROM student_guardian LIMIT $start, $rows_per_page";


$stmt = $conn->prepare($sql);
$stmt->execute();
$records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


$search_te = "";

if (isset($_POST['search-term'])) {
    $search_term = '%' . $_POST['search-term'] . '%';
    $sql = "SELECT * FROM `student_guardian` WHERE `surname` LIKE  '$search_term' OR `firstname` LIKE  '$search_term' OR `middlename` LIKE  '$search_term' OR `id_number` LIKE  '$search_term' LIMIT $start, $rows_per_page";
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

            <a href="./manage-details.php"  class="active">
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
            <div class="search2">
                <i class="fa-solid fa-magnifying-glass"></i>
                <form action="guardian-data.php" method="post">
                    <input type="text" value="<?= $search_te ?>" name="search-term" placeholder="Search..">
                </form>
            </div>
        </div>

        <div class="board">
            <h2>Guardians Data</h2>
            <div class="add_faculty-btn">
                <a href="add-guardian-data.php" class="btn">Add Data</a>
            </div>
            <table width="100%">
                <thead>
                    <tr>
                        <th>Student's ID</th>
                        <th>Firstname</th>
                        <th>Othernames</th>
                        <th>Surname</th>
                        <th>Relationship</th>

                        <th>Mobile No.</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $key => $row) : ?>
                        <tr>
                            <td><?= $row['id_number'] ?></td>
                            <td><?= $row['firstname'] ?></td>
                            <td><?= $row['middlename'] ?></td>
                            <td><?= $row['surname'] ?></td>
                            <td><?= $row['relationship'] ?></td>
                            <td><?= $row['mobile_number'] ?></td>
                            <td><a href="edit-guardian.php?id=<?= $row['id']; ?>" class="edit">Edit</a></td>
                            <td><a href="guardian-data.php?del_id=<?= $row['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this?')">Delete</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="page-info">
                <div class="page_num_info">
                    <?php
                    if (!isset($_GET['page-nr'])) {
                        $page = 1;
                    } else {
                        $page = $_GET['page-nr'];
                    }
                    ?>
                    Showing <?= $page ?> of <?= $pages ?> page(s)
                </div>
                <div class="pagination">
                    <a href="?page-nr=1">First</a>

                    <?php
                    if (isset($_GET['page-nr']) && $_GET['page-nr'] > 1) {
                    ?>
                        <a href="?page-nr=<?= $_GET['page-nr'] - 1 ?>">Previous</a>
                    <?php
                    } else {
                    ?>
                        <a>Previous</a>
                    <?php
                    }
                    ?>


                    <div class="page-numbers">
                        <?php
                        for ($counter = 1; $counter <= $pages; $counter++) {
                        ?>
                            <a href="?page-nr=<?= $counter ?>"><?= $counter ?></a>
                        <?php
                        }
                        ?>
                    </div>


                    <?php
                    if (!isset($_GET['page-nr'])) {
                    ?>
                        <a href="?page-nr=2">Next</a>
                        <?php
                    } else {
                        if ($_GET['page-nr'] >= $pages) {
                        ?>
                            <a>Next</a>
                        <?php
                        } else {
                        ?>
                            <a href="?page-nr=<?= $_GET['page-nr'] + 1 ?>">Next</a>
                    <?php
                        }
                    }
                    ?>

                    <a href="?page-nr=<?= $pages ?>">Last</a>
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