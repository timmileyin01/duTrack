<?php
include "./constants.php";

include "./adminControllers/guardians.php";
include './adminIncludes/header.php';



?>




<div class="theme-form">
    <div>
        <a href="./guardian-data.php" class="btn">Home</a>
    </div>
    <div class="theme-toggler margin-top">
        <i class="fa-solid fa-sun active"></i>
        <i class="fa-solid fa-moon"></i>
    </div>
</div>
<div class="container form-pages">
    <div class="form">
        <h2>Edit Guardian</h2>

        <?php include(base_app . "adminHelpers/formErrors.php"); ?>

        <form action="edit-guardian.php" enctype="multipart/form-data" method="post">
        <select name="id_number">
                <option value="">Select Student's Matric Number...</option>
                <?php foreach ($students as $key => $student) : ?>
                    <?php if (!empty($id_number) && $id_number == $student['id_number']) : ?>
                        <option selected value="<?= $student['id_number']; ?>"><?= $student['id_number']; ?></option>
                    <?php else : ?>
                        <option value="<?= $student['id_number']; ?>"><?= $student['id_number']; ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        <input type="hidden" name="id" value="<?= $id ?>">
            <input type="text" name="surname" value="<?= $surname ?>" placeholder="Surname">
            <input type="text" name="firstname" value="<?= $firstname ?>" placeholder="Firstname">
            <input type="text" name="middlename" value="<?= $middlename ?>" placeholder="Middle Name">
            <input type="text" name="relationship" value="<?= $relationship ?>" placeholder="Relationship">
            <input type="text" name="mobile_number" value="<?= $mobile_number ?>" placeholder="Mobile Number">
            
            <input type="text" name="email" value="<?= $email ?>" placeholder="Email Address">
            <input type="text" name="address" value="<?= $address ?>" placeholder="Contact Address">
            <div class="form-control">
                <h3>Add Image</h3>
                <input type="file" name="avatar">
            </div>
            <div>
                <button type="submit" name="edit-guardian" class="btn">Submit Data</button>
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