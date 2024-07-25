<?php 
include './constants.php';
include './adminControllers/faculties.php';
include './adminIncludes/header.php';

?>

<div class="theme-form">
    <div>
        <a href="./manage-faculties.php" class="btn">Home</a>
    </div>
    <div class="theme-toggler margin-top">
        <i class="fa-solid fa-sun active"></i>
        <i class="fa-solid fa-moon"></i>
    </div>
</div>
<div class="container form-pages">

    <div class="form">
        <?php include(base_app . "adminHelpers/formErrors.php"); ?>
            <form action="add-faculty.php" enctype="multipart/form-data" method="post">
                <h2>Add Faculty</h2>
                <input type="text" name="name" value="<?= $name ?>" placeholder="Enter Faculty Name">
                <input type="text" name="dean" value="<?= $dean ?>" placeholder="Enter Name of Dean">
                <div class="form-control">
                    <h3>Dean's Signature</h3>
                    <input type="file" name="dean_sig" id="">     
                    
                </div>
                <div class="form-control">
                    <h3>About Faculty</h3>
                    <textarea name="about" id="" rows="6"><?= $about ?></textarea>     

                </div>
                <div>
                    <button type="submit" name="add-faculty" class="btn">Add Faculty</button>
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