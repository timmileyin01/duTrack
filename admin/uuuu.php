<?php

include './constants.php';
include(base_app . "adminDatabase/db.php");


$existingGuardian2 = selectAll('student_guardian', ['id_number' => 'DU0071']);

    
    $nr_of_rows = count($existingGuardian2);
    
    if($nr_of_rows > 2){
        echo'You can only add two guardians per student' . $nr_of_rows;
    }else{
        echo $nr_of_rows;
    }