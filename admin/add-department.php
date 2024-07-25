<?php 
include './constants.php';
include './adminControllers/departments.php';
include './adminIncludes/header.php';


?>

<div class="theme-form">
    <div>
        <a href="./manage-departments.php" class="btn">Home</a>
    </div>
    <div class="theme-toggler margin-top">
        <i class="fa-solid fa-sun active"></i>
        <i class="fa-solid fa-moon"></i>
    </div>
</div>
<div class="container form-pages">

    <div class="form">
        <?php include(base_app . "adminHelpers/formErrors.php"); ?>
            <form action="add-department.php" enctype="multipart/form-data" method="post">
                <h2>Add Department</h2>
                <input type="text" name="name" value="<?= $name ?>" placeholder="Enter Department Name">
                <input type="text" name="hod" value="<?= $hod ?>" placeholder="Enter Name of HOD">
                <div class="form-control">
                    <h3>HOD's Signature</h3>
                    <input type="file" name="hod_sig" id="">     
                    
                </div>
                <select name="fac_id">
                    <option value="">Select Faculty...</option>
                    <?php foreach ($faculties as $key => $faculty): ?>
                        <?php if (!empty($fac_id) && $fac_id == $faculty['id']): ?>
                            <option selected value="<?= $faculty['id']; ?>"><?= $faculty['name']; ?></option>
                        <?php else: ?>
                            <option value="<?= $faculty['id']; ?>"><?= $faculty['name']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </select>          
                <div>
                    <button type="submit" name="add-department" class="btn">Add Department</button>
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