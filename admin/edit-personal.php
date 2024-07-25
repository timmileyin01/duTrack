<?php
include "./constants.php";

include "./adminControllers/personal-data.php";
include './adminIncludes/header.php';



?>




<div class="theme-form">
    <div>
        <a href="./personal-data.php" class="btn">Home</a>
    </div>
    <div class="theme-toggler margin-top">
        <i class="fa-solid fa-sun active"></i>
        <i class="fa-solid fa-moon"></i>
    </div>
</div>
<div class="container form-pages">
    <div class="form">
        <h2>Edit Personal Data</h2>

        <?php include(base_app . "adminHelpers/formErrors.php"); ?>

        <form action="edit-personal.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
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
            
            <input type="text" name="program" value="<?= $program ?>" placeholder="Enter Student's Program">
            <input type="text" name="mobile_number" value="<?= $mobile_number ?>" placeholder="Mobile Number">
            <input type="date" name="date_of_birth" id="" value="<?= $date_of_birth ?>">
            <input type="text" name="address" value="<?= $address ?>" placeholder="Contact Address">
            
            <div>
                <button type="submit" name="edit-personal" class="btn">Submit Data</button>
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