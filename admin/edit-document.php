<?php
include "./constants.php";

include "./adminControllers/documents.php";
include './adminIncludes/header.php';


?>




<div class="theme-form">
    <div>
        <a href="./documents.php" class="btn">Home</a>
    </div>
    <div class="theme-toggler margin-top">
        <i class="fa-solid fa-sun active"></i>
        <i class="fa-solid fa-moon"></i>
    </div>
</div>
<div class="container form-pages">
    <div class="form">
        <h2>Edit Document</h2>
        <div class="question" style="display: flex; flex-direction: row; gap: 1rem; align-items: center; justify-content: center;">
            <span class="text-muted">Click to add Matric Number Only</span><a href="add-matric.php" class="btn" style="background: blue;">Add Matric ID</a>
        </div>

        <?php include(base_app . "adminHelpers/formErrors.php"); ?>

        <form action="edit-document.php" enctype="multipart/form-data" method="post">
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
            
            <input type="text" name="title" value="<?= $title ?>" placeholder="Tilte of the File">
            <textarea name="note" id="editor" placeholder="Add a Note"><?= $note ?></textarea>
            
            <div class="form-control">
                <h3>Add File</h3>
                <span class="small">Leave empty if you do not wish to change the file</span>
                <input type="file" name="file">
            </div>
            <div>
                <button type="submit" name="edit-document" class="btn">Submit Data</button>
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
        tinymce.init({
          selector: '#editor',
          plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
          toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | align lineheight | tinycomments | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
          tinycomments_mode: 'embedded',
          tinycomments_author: 'Author name',
          mergetags_list: [
            { value: 'First.Name', title: 'First Name' },
            { value: 'Email', title: 'Email' },
          ],
          ai_request: (request, respondWith) => respondWith.string(() => Promise.reject("See docs to implement AI Assistant"))
        });
      </script>


<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

</body>

</html>