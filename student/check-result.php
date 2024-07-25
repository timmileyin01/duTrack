<?php
include "./constants.php";
include 'adminControllers/users.php';
include 'adminIncludes/header.php';

$errors = array();


function validateResult($result){
    $errors = array();
    if (empty($result['session_id'])) {
        array_push($errors, "Select Session");
    }
    if (empty($result['semester'])) {
        array_push($errors, "Select Semester");
    }
    
    return $errors;
}

if(isset($_POST['check-result'])){
    $errors = validateResult($_POST);
    if (count($errors) === 0) {
        $_SESSION['session_id'] = $_POST['session_id']; 
        $_SESSION['semester'] = $_POST['semester']; 


        header("location: " . './result.php');
        exit();
    }else {
        $session = $_POST['session_id'];
        $semester = $_POST['semester'];
    }
}

?>
 <div class="theme-form">
        <div>
            <a href="./" class="btn">Home</a>
        </div>
        <div class="theme-toggler margin-top">
            <i class="fa-solid fa-sun active"></i>
            <i class="fa-solid fa-moon"></i>
        </div>
    </div>

    <div class="container form-pages">
        <div class="form">
        <?php include (base_app . "helpers/formErrors.php"); ?>
            <form action="check-result.php" method="post">
                <h2>Check Your Result</h2>
                <select name="session_id">
                    <option value="">Select Session...</option>
                    <?php 
                    $sessions = selectAll('sessions');
                    
                    foreach ($sessions as $key => $row): ?>
                        <?php if (!empty($session) && $session == $row['id']): ?>
                            <option selected value="<?= $row['id']; ?>"><?= $row['session']; ?></option>
                        <?php else: ?>
                            <option value="<?= $row['id']; ?>"><?= $row['session']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </select>

                <select name="semester">
                    <option value="">Select Semeter...</option>
                   <?php if (!empty($semester) && $semester == 1): ?>
                            <option selected value="1">First Semester</option>
                            <option value="2">Second Semester</option>
                        <?php elseif (!empty($semester) && $semester == 2): ?>
                            <option value="1">First Semester</option>
                            <option selected value="2">Second Semester</option>
                        <?php else: ?>
                            <option value="1">First Semester</option>
                            <option value="2">Second Semester</option>
                        <?php endif; ?>

                </select>
                <div>
                    <button type="submit" name="check-result" class="btn">Check Result</button>
                </div>
                <div class="form-down-info">
                    <span>Do you want to check all results?</span><a href="./all-result.php" class="btn">Click Me</a>
                </div>
            </form>
        </div>
    </div>
 

    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</body>
</html>