<?php

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

include "./constants.php";

include "./adminControllers/guardians.php";
include './adminIncludes/header.php';

$errors = array();

if (isset($_REQUEST['import-excel'])) {
    $file = $_FILES['excel']['tmp_name'];
    $extension = pathinfo($_FILES['excel']['name'], PATHINFO_EXTENSION);
    if ($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') {
        $obj = PhpOffice\PhpSpreadsheet\IOFactory::load($file);
        $data = $obj->getActiveSheet()->toArray();
        $error = 0;
        $error1 = 0;
        $success = 0;
        foreach ($data as $row) {
            $id_number = $row['0'];
            $firstname = $row['1'];
            $middlename = $row['2'];
            $surname = $row['3'];
            $mobile_number = $row['4'];
            $email = $row['5'];
            $address = $row['6'];
            $relationship = $row['7'];

            $existingGuardian = selectOne('student_guardian', ['email' => $email]);
            $existingGuardian1 = selectOne('student_guardian', ['mobile_number' => $mobile_number]);
            $existingGuardian2 = selectAll('student_guardian', ['id_number' => $id_number]);




            if ($existingGuardian || $existingGuardian1) {
                $error += 1;
                continue;
            } else {
                $nr_of_rows = count($existingGuardian2);

                if ($nr_of_rows >= 2) {
                    $error1 += 1;
                    continue;
                }else {
                    $query = mysqli_query($conn, "INSERT INTO student_guardian SET id_number='$id_number', firstname='$firstname', middlename='$middlename', surname='$surname', mobile_number='$mobile_number', email='$email', address='$address', relationship='$relationship'");
                if ($query) {
                    $success += 1;
                } else {
                    $error3 += 1;
                }
                }
            }
        }


        if ($error == count($data)) {
            array_push($errors, "All the Data were not imported because they exist already");
        } elseif ($error !== count($data) && $error > 0) {
            $_SESSION['message'] = 'Some Data were imported successfully, some were not imported because they exist already';
            $_SESSION['type'] = 'success';

            //header("location: " . './personal-data.php');
        }

        

        if ($success == count($data)) {
            $_SESSION['message'] = 'All the Data were imported successfully';
            $_SESSION['type'] = 'success';


            //header("location: " . './personal-data.php');
        } elseif ($success !== count($data) && $success > 0) {
            $_SESSION['message'] = 'Some Data were imported successfully, There was a problem importing some';
            $_SESSION['type'] = 'success';


            //header("location: " . './personal-data.php');
        } else {
            array_push($errors, "There was a problem importing the Data");
        }
    } else {
        array_push($errors, "Invalid File!");
    }
}

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
    <?php include("./adminIncludes/messages.php"); ?>
    <div class="form">
        <h2>Add Bulk Data</h2>
        <div class="question" style="display: flex; flex-direction: row; gap: 1rem; align-items: center; justify-content: center;">
            <span class="text-muted">Click to add Single Guardian Data</span><a href="./add-guardian-data.php" class="btn" style="background: blue;">Add Guardian Data</a>
        </div>
        <div class="question" style="display: flex; flex-direction: row; gap: 1rem; align-items: center; justify-content: center; margin-top: 1rem;">
            <span class="text-muted">Click to Download Sample File</span><a href="./bulk_sample/guardian/sample.xlsx" class="btn" style="background: peach;">Download</a>
        </div>

        <?php include(base_app . "adminHelpers/formErrors.php"); ?>

        <form action="add-bulk-guardian.php" method="post" enctype="multipart/form-data">
            <input type="file" name="excel">
            <div>
                <button type="submit" name="import-excel" class="btn">Add Data</button>
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