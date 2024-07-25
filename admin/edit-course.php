<?php 
include './constants.php';
include './adminControllers/courses.php';
include './adminIncludes/header.php';

?>

<div class="theme-form">
    <div>
        <a href="./manage-courses.php" class="btn">Home</a>
    </div>
    <div class="theme-toggler margin-top">
        <i class="fa-solid fa-sun active"></i>
        <i class="fa-solid fa-moon"></i>
    </div>
</div>
<div class="container form-pages">

    <div class="form">
        <?php include(base_app . "adminHelpers/formErrors.php"); ?>
            <form action="edit-course.php" method="post">
                <h2>Edit Course</h2>
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="text" name="course_code" value="<?= $course_code ?>" placeholder="Enter Course Code">
                <input type="text" name="course_title" value="<?= $course_title ?>" placeholder="Enter Course Title">
                <select name="dept_id">
                    <option value="">Select Department...</option>
                    <?php foreach ($departments as $key => $department): ?>
                        <?php if (!empty($dept_id) && $dept_id == $department['id']): ?>
                            <option selected value="<?= $department['id']; ?>"><?= $department['name']; ?></option>
                        <?php else: ?>
                            <option value="<?= $department['id']; ?>"><?= $department['name']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </select>            
                <div>
                    <button type="submit" name="update-btn" class="btn">Update Course</button>
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