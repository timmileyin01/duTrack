<?php if(count($errors) > 0): ?>
    <div class="message-alert error">
        <?php foreach ($errors as $error): ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif ?>   
