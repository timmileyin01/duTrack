<div class="navigation">
    <div class="n1">
        <button id="menu-btn">
            <span class="fa-solid fa-bars"></span>
        </button>


        &nbsp;<?php include("adminIncludes/messages.php"); ?>
    </div>

    <div class="profile">
        <div class="theme-toggler">
            <i class="fa-solid fa-sun active"></i>
            <i class="fa-solid fa-moon"></i>
        </div>
        <a href="./messages.php">
            <i class="fa-solid fa-bell"></i>
        </a>
        <?php
        if (isset($_SESSION['id']) && $_SESSION['admin'] == 'repo_admin' || $_SESSION['admin'] == 'repo_super_admin') {
            $user_avatar = selectOne('users', ['id' => $_SESSION['id']])
        ?>
            <small class="text-muted"><?= $user_avatar['surname'] ?></small>

            <img src="<?= './uploads/' . $user_avatar['avatar'] ?>">

        <?php } ?>
    </div>
</div>