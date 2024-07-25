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

            <a href="./personal-details.php" class="active">
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
                <h2>Student's Details</h2>
            </div>
        </div>



        <?php $user = selectOne('users', ['id' => $_SESSION['id']]);
        $personal = selectOne('personal_data', ['id_number' => $_SESSION['id_number']]);

        ?>

        <div class="board">
            <div class="item-container-main">
                <div class="detail">
                    <h3>Surname</h3>
                    <h4><?= $user['surname'] ?></h4>
                </div>
                <div class="detail">
                    <h3>Firstname</h3>
                    <h4><?= $user['firstname'] ?></h4>
                </div>
                <div class="detail">
                    <h3>Othername</h3>
                    <h4><?= $user['othernames'] ?></h4>
                </div>
                <div class="detail">
                    <h3>Matric Number</h3>
                    <p><?= $user['id_number'] ?></p>
                </div>
                <div class="detail">
                    <h3>Program</h3>
                    <p><?= $personal['program'] ?></p>
                </div>
                <div class="detail">
                    <h3>Gender</h3>
                    <p><?= $user['gender'] ?></p>
                </div>
                <div class="detail">
                    <h3>Date of Birth</h3>
                    <p><?= $personal['date_of_birth'] ?></p>
                </div>
                <div class="detail">
                    <h3>Phone Number</h3>
                    <p><?= $personal['mobile_number'] ?></p>
                </div>
                <div class="detail">
                    <h3>Email</h3>
                    <p><?= $user['email'] ?></p>
                </div>
                <div class="detail">
                    <h3>Home Address</h3>
                    <p><?= $personal['address'] ?></p>
                </div>
                <div class="detail">
                    <h3>Profile Image</h3>
                    <img class="profile" src="<?= '../admin/uploads/' . $user['avatar']; ?>" alt="">
                </div>


            </div>
        </div>


        <div class="search_and_i-name minus_margin-1">
            <div class="search2 minus_margin-2">
                <h2>Guardian's Details</h2>
            </div>
        </div>



        <?php $guardians = selectAll('student_guardian', ['id_number' => $_SESSION['id_number']]); ?>
        <?php foreach ($guardians as $key => $guardian) : ?>
            <div class="board">
            <h3 style="padding: 10px; text-align: center;">Guardian's Detail<?= $key + 1 ?></h3>
                <div class="item-container-main">
                    <div class="detail">
                        <h3>Surname</h3>
                        <h4><?= $guardian['surname'] ?></h4>
                    </div>
                    <div class="detail">
                        <h3>Firstname</h3>
                        <h4><?= $guardian['firstname'] ?></h4>
                    </div>
                    <div class="detail">
                        <h3>Othername</h3>
                        <h4><?= $guardian['middlename'] ?></h4>
                    </div>
                    <div class="detail">
                        <h3>Phone Number</h3>
                        <p><?= $guardian['mobile_number'] ?></p>
                    </div>
                    <div class="detail">
                        <h3>Email</h3>
                        <p><?= $guardian['email'] ?></p>
                    </div>
                    <div class="detail">
                        <h3>Address</h3>
                        <p><?= $guardian['address'] ?></p>
                    </div>
                    <div class="detail">
                        <h3>Profile Image</h3>
                        <img class="profile" src="<?= '../admin/uploads/' . $guardian['avatar']; ?>" alt="">
                    </div>


                </div>
            </div>
        <?php endforeach; ?>


        <div class="search_and_i-name minus_margin-1">
            <div class="search2 minus_margin-2">
                <h2>Emergency Contact</h2>
            </div>
        </div>



        <?php $emergencies = selectAll('emergency_contacts', ['id_number' => $_SESSION['id_number']]) ?>
        <?php foreach ($emergencies as $key => $emergency) : ?>
            <div class="board">
            <h3 style="padding: 10px; text-align: center;">Emergency Contact <?= $key + 1 ?></h3>
                <div class="item-container-main">
                    <div class="detail">
                        <h3>Surname</h3>
                        <h4><?= $emergency['surname'] ?></h4>
                    </div>
                    <div class="detail">
                        <h3>Firstname</h3>
                        <h4><?= $emergency['firstname'] ?></h4>
                    </div>
                    <div class="detail">
                        <h3>Othername</h3>
                        <h4><?= $emergency['middlename'] ?></h4>
                    </div>
                    <div class="detail">
                        <h3>Relationship</h3>
                        <p><?= $emergency['relationship'] ?></p>
                    </div>
                    <div class="detail">
                        <h3>Phone Number</h3>
                        <p><?= $emergency['mobile_number'] ?></p>
                    </div>
                    <div class="detail">
                        <h3>Email</h3>
                        <p><?= $emergency['email'] ?></p>
                    </div>
                    <div class="detail">
                        <h3>Address</h3>
                        <p><?= $emergency['address'] ?></p>
                    </div>



                </div>
            </div>
        <?php endforeach; ?>


        <div class="search_and_i-name minus_margin-1">
            <div class="search2 minus_margin-2">
                <h2>Medical Information</h2>
            </div>
        </div>





        <div class="board">
            <div class="item-container-main">
                <?php $information = selectOne('medical_information', ['id_number' => $_SESSION['id_number']]) ?>

                <div class="detail">
                    <h3>Information</h3>
                    <p><?= $information['history'] ?></p>
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