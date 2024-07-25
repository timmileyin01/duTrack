<?php
include "./constants.php";
include './adminDatabase/db.php';
include './adminIncludes/header.php';

$table = 'settings';

function validateFile($file, $formIndex, $filetype, $filesize)
{
    $errors = array();

    $thumbnail = $file[$formIndex];

    $time = time(); //to make each image name unique
    $thumbnail_name = $time . $thumbnail['name'];
    $thumbnail_tmp_name = $thumbnail['tmp_name'];



    $allowed_files = $filetype;
    $extension = explode('.', $thumbnail_name);

    $extension = end($extension);

    if (!in_array($extension, $allowed_files)) {
        array_push($errors, 'Only jpg, jpeg, webp, png files allowed');
    }

    if ($thumbnail['size'] > $filesize) {
        array_push($errors, 'file is too large');
    }

    return $errors;
}

$errors = array();

if (isset($_POST['update'])) {

    $id = 1;


    if (empty($_POST['title'])) {
        array_push($errors, 'Title is required');
    } elseif (empty($_POST['description'])) {
        array_push($errors, 'Description is required');
    }else {

        unset($_POST['update']);

        $formIndex = 'image';


        $filetype = ['jpg', 'png', 'webp', 'jpeg'];
        


        $file_s = selectOne($table, ['id' => $id]);
        $filesize = $file_s['max_upload'];

        





       
        if (count($errors) === 0) {


            if (!empty($_FILES['image']['name'])) {
                $file_name = time() . '_' . $_FILES['image']['name'];
                $destination = base_app . "uploads/" . $file_name;
                $errors = validateFile($_FILES, $formIndex, $filetype, $filesize);
                
                if (count($errors) == 0) {
                    $result = move_uploaded_file($_FILES['image']['tmp_name'], $destination);
    
                    if ($result) {
                        $_POST['image'] = $file_name;
                    } else {
                        array_push($errors, "Failed to Upload Site Logo");
                    }
                }
            } else {
                array_push($errors, "Logo Required");
            }
    

            if (empty($_POST['max_upload'])) {
                $_POST['max_upload'] = $filesize;
            }
            
            $post = selectOne($table, ['id' => 1]);
            
        
            
            $image = $post['image'];
            $path = (base_app . 'uploads/') . $image;

            

            
            
            if ($path && !empty($_POST['image'])) {
                unlink($path);
                
                $user_id = update($table, $id, $_POST);
                $_SESSION['message'] = 'Settings Updated successfully';
                $_SESSION['type'] = 'success';
                header('location: ' . './index.php');
                exit();
            }elseif ($path && empty($_POST['image'])) {
                $user_id = update($table, $id, $_POST);
                $_SESSION['message'] = 'Settings Updated successfully';
                $_SESSION['type'] = 'success';
                header('location: ' . './index.php');
                exit();
            } else {
                $name = $_POST['title'];
                $description = $_POST['description'];
                $max_upload = $_POST['max_upload'];
                $image = $file_name;

            }
        }
    }
}


$settings = selectOne($table, ['id' => 1]);

?>



    <div class="theme-form">
        <div>
            <a href="./index.php" class="btn">Home</a>
        </div>
        <div class="theme-toggler margin-top">
            <i class="fa-solid fa-sun active"></i>
            <i class="fa-solid fa-moon"></i>
        </div>
    </div>
    <div class="container form-pages">
        <div class="form">
            <h2>Settings</h2>
            <?php include (base_app . "adminHelpers/formErrors.php"); ?>
            <form action="settings.php" method="post" enctype="multipart/form-data">
                <div class="form-control">
                    <h3>Change site title</h3>
                    <input name="title" value="<?= $settings['title'] ?>" type="text">
                </div>
                <div class="form-control">
                    <h3>Change site logo</h3>
                    <input name="image" type="file">
                </div>
                <div class="form-control">
                <h3>Change site description</h3>
                    <textarea name="description" rows="5" placeholder="site description"><?= $settings['description'] ?></textarea>
                </div>
                <div class="form-control">
                    <h3>Change max-upload size</h3>
                    <select name="max_upload">
                        <option value="">Max upload size</option>
                        <option value="5000000">5mb</option>
                        <option value="10000000">10mb</option>
                        <option value="15000000">15mb</option>
                        <option value="20000000">20mb</option>
                        <option value="25000000">25mb</option>
                        <option value="30000000">30mb</option>
                    </select>
                </div>
                <div>
                    <button type="submit" name="update" class="btn">Update</button>
                </div>
            </form>
        </div>
    </div>
   
              



    <!--links to js-->
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/theme-toggler.js"></script>


    <script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>


</body>
</html>