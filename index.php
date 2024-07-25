<?php
include './admin/constants.php';
include "admin/adminControllers/users.php";
include 'includes/header.php';

$faculties = array();


function prepare_sql($sql)
{
    global $conn;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $records = $stmt->get_result();
    return $records;
}



function validateMessage($message)
{

    $errors = array();

    if (empty($message['message'])) {
        array_push($errors, 'Message is required');
    }


    return $errors;
}


if (isset($_POST['send'])) {
    $errors = array();
    validateMessage($_POST);

    if (isset($_SESSION['id']) && isset($_SESSION['id_number'])) {
        $_POST['id_number'] = $_SESSION['id_number'];
        $users = selectOne('users', ['id_number' => $_SESSION['id_number']]);
        $_POST['name'] = $users['firstname']. ' ' . $users['othernames'] . ' ' . $users['surname'];
        $_POST['email'] = $users['email'];
    }


    unset($_POST['send']);


    $message_id = create('messages', $_POST);

    $_SESSION['message'] = 'Your Message has been sent successfully';
    $_SESSION['type'] = 'success';
}


$settings = selectOne('settings', ['id' => 1])
?>



<!--welcome section-->
<section id="home">
    <div class="sub-home max-width">
        <?php include("./admin/adminIncludes/messages.php"); ?>
        <h2>Student Information Tracking System</h2>
        <p><?= $settings['description'] ?></p>
        <?php if ($_SESSION['admin']) : ?>
            <?php if ($_SESSION['admin'] == 'repo_user') : ?>
                
                    <a href="./student/" class="btn-special">Explore</a>

                
            <?php elseif ($_SESSION['admin'] == 'repo_admin' || $_SESSION['admin'] == 'repo_super_admin') :?>
                <a href="./admin/" class="btn-special">Explore</a>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</section>
<!--welcome section ends here-->



<?php
include 'includes/footer.php';
?>