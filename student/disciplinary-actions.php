<?php

include "./constants.php";
include 'adminControllers/users.php';
include 'adminIncludes/header.php';


$projects = array();

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

            <a href="./documents.php">
                <i title="Documents" class="fa-solid fa-circle-plus"></i>
                <h3>Documents</h3>
            </a>

            <a href="./disciplinary-actions.php" class="active">
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
               <h2>Disciplinary Actions</h2>
            </div>
        </div>



        <?php $user = selectOne('users', ['id' => $_SESSION['id']]) ?>

        <div class="board">          

            <table width="100%">
                <thead>
                    <tr>
                        <th>Offenses</th>
                        <th>Note</th>
                        <th>Date Posted</th> 
                        <th>Attached File</th>                       
                    </tr>
                </thead>
                <tbody>              
                <?php $disciplines = selectAll('disciplinary', ['id_number' => $_SESSION['id_number']]);
                ?>      
                <?php foreach ($disciplines as $key => $discipline) : ?>
                        <tr>
                            <td><?= $discipline['title'] ?></td>
                            <td><?= $discipline['note'] ?></td>
                            <td><?= $discipline['date'] ?></td>
                            <?php
                            if (!empty($discipline['filename'])) { ?>
                                <td>
                                    <a class="edit" href="<?php

                                                            if (file_exists('./uploads/' . $discipline['filename'])) {
                                                                echo './uploads/' . $discipline['filename'];
                                                            } elseif (file_exists('../admin/uploads/' . $discipline['filename'])) {
                                                                echo '../admin/uploads/' . $discipline['filename'];
                                                            }


                                                            ?>" download>
                                        Download File
                                    </a>
                                </td>
                            <?php } ?>

                             </tr>
                    <?php endforeach; ?>                   
                </tbody>
            </table>            
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