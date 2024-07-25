<?php 
include './constants.php';
include './adminControllers/sessions.php';
include './adminIncludes/header.php';

?>


<div class="theme-form">
    <div>
        <a href="./academic-record.php" class="btn">Home</a>
    </div>
    <div class="theme-toggler margin-top">
        <i class="fa-solid fa-sun active"></i>
        <i class="fa-solid fa-moon"></i>
    </div>
</div>
<div class="container form-pages">

    <div class="form">
        <?php include(base_app . "adminHelpers/formErrors.php"); ?>
        <?php include(base_app . "adminIncludes/messages.php"); ?>
    
 

            <form action="add-session.php" method="post">
                <h2>Add Session</h2>
                <input type="text" name="session" value="<?= $session ?>" placeholder="Enter Session">
                <div>
                    <button type="submit" name="add-session" class="btn">Add Session</button>
                </div>
            </form>
        </div>
        <div class="form margin-top">
            <h2>Recently Addedd Sessions</h2>
            <table>
             <thead>
                <tr>
                    <th>ID</th>
                    <th>SESSION</th>
                </tr>
             </thead>
             <tbody>
                <?php $sql = "SELECT * FROM `sessions` ORDER BY `id` DESC LIMIT 3;"; 
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $sessions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
                
                foreach ($sessions as $key => $row) {
                ?>

                
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $row['session'] ?></td>
                </tr>
                <?php } ?>
             </tbody>
            </table>
        </div>
    </div>


<!--links to js-->

<!--links to js-->
<script src="./assets/js/main.js"></script>
<script src="./assets/js/theme-toggler.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</body>

</html>