<?php
include "./constants.php";

include "./adminControllers/users.php";
include './adminIncludes/header.php';

if(isset($_SESSION['admin']) && $_SESSION['admin'] != 'repo_super_admin') {
    header('location: ' . './index.php');
 }


?>




    <div class="theme-form">
        <div>
            <a href="./manage-users.php" class="btn">Home</a>
        </div>
        <div class="theme-toggler margin-top">
            <i class="fa-solid fa-sun active"></i>
            <i class="fa-solid fa-moon"></i>
        </div>
    </div>
    <div class="container form-pages">
        <div class="form">
            <h2>Add User</h2>
            <div class="question" style="display: flex; flex-direction: row; gap: 1rem; align-items: center; justify-content: center;">
                    <span class="text-muted">Click to add Bulk Data</span><a href="add-bulk-user.php" class="btn" style="background: blue;">Add Bulk</a>
                </div>
            
            <?php include (base_app . "adminHelpers/formErrors.php"); ?>

            <form action="add-user.php" enctype="multipart/form-data" method="post">
                <input type="text" name="surname" value="<?= $surname ?>" placeholder="Surname">
                <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="Firstname">
                <input type="text" name="othernames" value="<?= $othernames ?>" placeholder="Other Names">
                <select name="gender" id="sort-item">
                <?php if ($gender == 'Male') : ?>
                    <option value="">Select gender...</option>
                    <option selected value="Male">Male</option>
                    <option value="Female">Female</option>
                <?php elseif ($gender == 'Female') : ?>
                    <option value="">Select gender...</option>
                    <option value="Male">Male</option>
                    <option selected value="Female">Female</option>
                <?php else : ?>
                    <option value="">Select gender...</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                <?php endif; ?>
                </select>
                <select name="admin" id="sort-item2">
                <?php if ($admin == 'repo_user') : ?>
                    <option selected value="1">User</option>
                    <option value="2">Admin</option>
                    <option value="3">Super Admin</option>
                <?php elseif ($admin == 'repo_admin') : ?>
                    <option value="1">User</option>
                    <option selected value="2">Admin</option>
                    <option value="3">Super Admin</option>
                <?php elseif ($admin == 'repo_super_admin') : ?>
                    <option value="1">User</option>
                    <option value="2">Admin</option>
                    <option selected value="3">Super Admin</option>
                <?php else : ?>
                    <option value="1">User</option>
                    <option value="2">Admin</option>
                    <option value="3">Super Admin</option>
                <?php endif; ?>
                </select>
                <!--<input type="text" name="department" placeholder="Department">-->
                <input type="text" name="id_number" value="<?= $id_number ?>" placeholder="Matric No. or Staff ID">
                <input type="text" name="email" value="<?= $email ?>" placeholder="Email Address">
                <input type="password" id="password" value="<?= $password ?>" name="password" placeholder="Password">
                <input type="password" id="confirmpassword" value="<?= $passwordConf ?>" name="passwordConf" placeholder="Confirm Password">
                <div id="message"></div>
                <div class="form-control">
                    <h3>Add Avatar</h3>
                    <input type="file" name="avatar">
                </div>
                <div>
                    <button type="submit" name="add-user" class="btn">Add User</button>
                </div>
            </form>
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