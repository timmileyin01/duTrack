<?php
include "./constants.php";

include "./adminDatabase/db.php";
include './adminIncludes/header.php';


if (isset($_GET['message_id'])) {
    $message = selectOne('messages', ['id' => $_GET['message_id']]);
    


    $id = $message['id'];

    $id_number = $message['id_number'];
    $name = $message['name'];
    $email = $message['email'];


    $user_message = $message['message'];

}


?>




<div class="theme-form">
    <div>
        <a href="./messages.php" class="btn">Home</a>
    </div>
</div>

<div class="single-trip-container">
    <div class="single-trip">
        <div class="main-trip">
            <div class="top">
                <h2>Message</h2>
            </div>
            <div class="bottom">
                <div class="s3">
                    <div class="group-2">
                        <span>Matric No.</span>
                        <p><?= $id_number ?></p>
                    </div>
                    <div class="group-2">
                        <span>Name</span>
                        <p><?= $name ?></p>
                    </div>
                    <div class="group-2">
                        <span>Email</span>
                        <p><?= $email ?></p>
                    </div>
                    <div class="group-3">
                        <span>Message</span>
                        <p><?= $user_message ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</body>

</html>