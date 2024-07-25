<?php
include "./database/constants.php";
session_start();

unset($_SESSION['id'] );
unset($_SESSION['id_number']);
unset($_SESSION['admin']);
unset($_SESSION['message']);
unset($_SESSION['type']) ;
session_destroy();

header('location: ' . "./index.php");
