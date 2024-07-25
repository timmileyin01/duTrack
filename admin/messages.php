<?php
include './constants.php';
include 'adminDatabase/db.php';
include 'adminIncludes/header.php';


$settings = array();

function prepare_sql($sql)
{
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result();
    return $records;
}

if (isset($_GET['delm_id'])) {
    $id = $_GET['delm_id'];


    $post = selectOne('messages', ['id' => $id]);




    $count = delete('messages', $id);

    if ($count) {

        $_SESSION['message'] = 'Message Deleted successfully';
        $_SESSION['type'] = 'success';


        header("location: " . './messages.php');
        exit();
    } else {
        $_SESSION['message'] = 'Message not Deleted';
        $_SESSION['type'] = 'error';


        header("location: " . './messages.php');
        exit();
    }
}





$sql4_row = "SELECT * FROM users";
$row4_record = prepare_sql($sql4_row);
$nr4_of_rows = $row4_record->num_rows;

$start = 0;
$rows_per_page = 5;

//get the total numbers of rows
$sql_row = "SELECT * FROM messages";
$row_record = prepare_sql($sql_row);
$nr_of_rows = $row_record->num_rows;

//calculating number of pages
$pages = ceil($nr_of_rows / $rows_per_page);

//if the user clicks on the pagination buttons a new stating point is set
if (isset($_GET['page-nr'])) {
    $page = $_GET['page-nr'] - 1;
    $start = $page * $rows_per_page;
}




$sql = "SELECT * FROM messages ORDER BY id DESC LIMIT $start, $rows_per_page";
$records = prepare_sql($sql);


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
                <img src="<?= 'uploads/' . $settings['image']; ?>">
                <h2><?= $settings['title']; ?></h2>
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

        <div class="board">
            <h2>Messages</h2>

            <table width="100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Matric No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $records->fetch_assoc()) { ?>
                        <tr>
                            <td> <a href="single-message.php?message_id=<?= $row['id']; ?>"> <?= $row['id']; ?> </a></td>
                            <td><a href="single-message.php?message_id=<?= $row['id']; ?>"> <?= $row['id_number']; ?> </a></td>
                            <td> <a href="single-message.php?message_id=<?= $row['id']; ?>"> <?= $row['name']; ?> </a></td>
                            <td> <a href="single-message.php?message_id=<?= $row['id']; ?>"> <?= $row['email']; ?> </a></td>
                            <td> <a href="single-message.php?message_id=<?= $row['id']; ?>"> <?= $row['message']; ?> </a></td>
                            <td> <a href="messages.php?delm_id=<?= $row['id']; ?>" class="delete">Delete</a></td>

                        </tr>
                    <?php } ?>
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
</body>

</html>