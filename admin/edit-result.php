<?php 
include './constants.php';
include './adminControllers/results.php';
include './adminIncludes/header.php';


?>
<div class="theme-form">
    <div>
        <a href="./manage-results.php" class="btn">Home</a>
    </div>
    <div class="theme-toggler margin-top">
        <i class="fa-solid fa-sun active"></i>
        <i class="fa-solid fa-moon"></i>
    </div>
</div>
<div class="container form-pages">

    <div class="form">
        <?php include(base_app . "adminHelpers/formErrors.php"); ?>
            <form action="edit-result.php" method="post">
                <h2>Edit Result</h2>
                <?php $student = selectOne('users', ['id_number' => $matric_id]) ?>
                <h3>Edit Result of <span style="color: green;"><?= $student['firstname'] . ' ' . $student['othernames'] . ' ' . $student['surname']; ?> : </span> <span style="color: red;"><?= $matric_id ?></span> </h3>
                <input type="hidden" name="id" value="<?= $_SESSION['re_id'] ?>">
                <input type="hidden" name="matric_id" value="<?= $matric_id ?>">
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
                <select name="level" id="">
                <option value="">Select Level</option>
                <?php if (!empty($level_st) && $level_st == 100): ?>
                    <option selected value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="400">400</option>
                <?php elseif (!empty($level_st) && $level_st == 200): ?>
                    <option  value="100">100</option>
                    <option selected value="200">200</option>
                    <option value="300">300</option>
                    <option value="400">400</option>
                <?php elseif (!empty($level_st) && $level_st == 300): ?>
                    <option  value="100">100</option>
                    <option  value="200">200</option>
                    <option selected value="300">300</option>
                    <option value="400">400</option>
                <?php elseif (!empty($level_st) && $level_st == 400): ?>
                    <option  value="100">100</option>
                    <option  value="200">200</option>
                    <option value="300">300</option>
                    <option  selected value="400">400</option>
                <?php else: ?>
                    <option value="">Select Level</option>
                    <option  value="100">100</option>
                    <option  value="200">200</option>
                    <option value="300">300</option>
                    <option  value="400">400</option>
                <?php endif; ?>

                   
                </select>
                <select name="course_id" id="">
                    <option value="">Select Course</option>
                    <?php 
                    $courses = selectAll('courses');
                    
                    foreach ($courses as $key => $row): ?>
                        <?php if (!empty($course_id) && $course_id == $row['id']): ?>
                            <option selected value="<?= $row['id']; ?>"><?= $row['course_code']; ?></option>
                        <?php else: ?>
                            <option value="<?= $row['id']; ?>"><?= $row['course_code']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    
                </select>
                <input type="number" name="course_unit" value="<?= $course_unit ?>" placeholder="Enter Course Unit">
                <input type="number" name="score" value="<?= $score ?>" placeholder="Enter Score">
                <input type="text" name="remark" value="<?= $remark ?>" placeholder="Remark">
                <div>
                    <button type="submit" name="update-btn" class="btn">Update Result</button>
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