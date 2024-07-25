<?php

include "./constants.php";
include 'adminControllers/users.php';
include 'adminIncludes/header.php';



function prepare_sql($sql)
{
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result();
    return $records;
}


/*
$search_te = "";


//get the total numbers of rows
if (isset($_POST['search-term'])) {
    $search_te = $_POST['search-term'];
    $start = 0;
    $rows_per_page = 100;
    $search_term = $_POST['search-term'];
    $sql = "SELECT * FROM `projects` WHERE `title` LIKE  '$search_term' OR `abstract` LIKE  '$search_term' OR `student_name` LIKE  '$search_term' LIMIT $start, $rows_per_page";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $nr_of_rows = count($records);
} else {
    $start = 0;
    $rows_per_page = 5;
    $sql_row = "SELECT * FROM projects";
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






if (isset($_POST['search-term'])) {


    $search_term = '%' . $_POST['search-term'] . '%';
    $sql = "SELECT * FROM `projects`  WHERE `title` LIKE  '$search_term' OR `abstract` LIKE  '$search_term' OR `student_name` LIKE  '$search_term' LIMIT $start, $rows_per_page";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}




if (isset($_GET['page-nr'])) {
    $id_pagination = $_GET['page-nr'];
} else {
    $id_pagination = 1;
}
*/


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

            <a href="./personal-details.php">
                <i title="Personal Details" class="fa-solid fa-pen-to-square"></i>
                <h3>Personal Details</h3>
            </a>

            <a href="./documents.php" class="active">
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
                <h2>Your Documents</h2>
            </div>
        </div>



        <?php $user = selectOne('users', ['id' => $_SESSION['id']]) ?>

        <div class="board">
            <div class="item-container-main">
                <?php $documents = selectAll('documents', ['id_number' => $_SESSION['id_number']]);
                foreach ($documents as $key => $document) :
                ?>

                <div class="detail-1">
                    <h5><?= $document['title'] ?></h5>
                    <?php if ($document['format'] == 'jpg' || $document['format'] == 'webp' || $document['format'] == 'png' || $document['format'] == 'jpeg') : ?>
                        <img src="<?= '../admin/uploads/' . $document['filename']; ?>" alt="" class="doc">
                    <?php endif; ?>
                    <a class="edit" href="<?php

                                            if (file_exists('../admin/uploads/' . $document['filename'])) {
                                                echo '../admin/uploads/' . $document['filename'];
                                            } elseif (file_exists('./uploads/' . $document['filename'])) {
                                                echo '../uploads/' . $document['filename'];
                                            }


                                            ?>" download>
                        Download File
                    </a>
                </div>
            <?php endforeach; ?>
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