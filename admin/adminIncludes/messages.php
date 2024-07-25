<?php if(isset($_SESSION['message'])): ?>
    <div class="message-alert <?php echo $_SESSION['type']; ?>">
        <p>
            <?= $_SESSION['message'];
            unset($_SESSION['message']);
            unset($_SESSION['type']);
            ?>
        </p>
    </div>
<?php endif; ?>

