<?php

include './adminDatabase/db.php';

if (isset($_SESSION['semester'])) {

    $semester = $_SESSION['semester'];
    $session_id = $_SESSION['session_id'];
    $matric_id = $_SESSION['id_number'];
}


if (isset($_SESSION['id'])) {
    $student = selectOne('users', ['id' => $_SESSION['id']]);
}

$settings = selectOne('settings', ['id' => 1]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title><?= $settings['title'] ?></title>
</head>

<body>
<script>window.print();</script>


    <div class="container-1">




        <div class="result">
        <?php $sele = selectOne('results', ['session_id' => $session_id, 'semester' => $semester, 'matric_id' => $matric_id]); ?>
            <?php if($sele): ?>
            <div class="result-head">
                <img src="./assets/images/duLogo.png" alt="" class="logo">
                <div class="school-details">
                    <h2>DOMINION UNIVERSITY, IBADAN</h2>
                    <h2>FACULTY OF COMPUTING AND APPLIED SCIENCES</h2>
                    <h2>STATEMENT OF RESULT</h2>
                </div>
            </div>
            <div class="student-particulars">
                <h2>STUDENT PARTICULARS</h2>
                <div class="student">
                    <div class="info">
                        <span>MATRIC NO</span>
                        <p><?= $_SESSION['id_number'] ?></p>
                    </div>
                    <div class="info">
                        <span>STUDENT NAME</span>
                        <p><?= $student['firstname'] . ' ' . $student['othernames'] . ' ' . $student['surname'] ?></p>
                    </div>
                    <div class="info">
                        <span>LEVEL</span>
                        <?php $select = selectOne('results', ['session_id' => $session_id, 'semester' => $semester, 'matric_id' => $matric_id]); ?>
                        <p><?= $select['level'] ?></p>
                    </div>
                    <div class="info">
                        <span>GENDER</span>
                        <p><?= $student['gender'] ?></p>
                    </div>
                    <div class="info">
                    <?php $studentProg = selectOne('personal_data', ['id_number' => $matric_id]); ?>
                        <span>PROGRAMME</span>
                        <p><?= $studentProg['program'] ?></p>
                    </div>
                    <div class="info">
                        <span>SESSION</span>
                        <?php $session = selectOne('sessions', ['id' => $session_id]) ?>
                        <p><?= $session['session'] ?></p>
                    </div>
                </div>
            </div>
            <div class="result-table">
                <?php if ($_SESSION['semester'] == 1) {

                ?>
                    <h2>FIRST SEMESTER RESULT</h2>
                <?php } else { ?>
                    <h2>SECOND SEMESTER RESULT</h2>
                <?php } ?>
                <table width="100%">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>COURSE CODE</th>
                            <th>COURSE TITLE</th>
                            <th>UNIT</th>
                            <th>SCORE</th>
                            <th>GRADE</th>
                            <th>REMARK</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        $sql = "SELECT * FROM `results` WHERE `session_id` = $session_id  AND `semester` = $semester AND `matric_id` = '$matric_id'";
                        $stmt = $conn->prepare($sql);
                        $stmt->execute();
                        $records = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

                        foreach ($records as $key => $row) {
                        ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <?php $course = selectOne('courses', ['id' => $row['course_id']]) ?>
                                <td><?= $course['course_code'] ?></td>
                                <td><?= $course['course_title'] ?></td>
                                <td><?= $row['course_unit'] ?></td>
                                <td><?= $row['score'] ?></td>
                                <?php if ($row['score'] > 69) {

                                ?>
                                    <td>A</td>
                                <?php } elseif ($row['score'] > 59 && $row['score'] < 70) { ?>
                                    <td>B</td>
                                <?php } elseif ($row['score'] > 49 && $row['score'] < 60) { ?>
                                    <td>C</td>
                                <?php } elseif ($row['score'] > 44 && $row['score'] < 50) { ?>
                                    <td>D</td>
                                <?php } else { ?>
                                    <td>F</td>
                                <?php } ?>
                                <td><?= $row['remark'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="semester-performance">
                    <div class="previous">
                        <table>
                            <h3>PREVIOUS</h3>
                            <thead>
                                <tr>
                                    <th>POINTS</th>
                                    <th>UNITS</th>
                                    <th>CGPA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $gpa_exists = selectOne('gpa', ['session_id' => $session_id, 'semester' => $semester, 'matric_no' => $matric_id]);

                                $unique_gpa_id = $gpa_exists['unique_id'];




                                $level = $select['level'];
                                


                                $total_points = "SELECT SUM(`total_points`) AS count FROM `gpa` WHERE `level` <= $level AND  `unique_id` != '$unique_gpa_id'";     
                                $duration = $conn->query($total_points);
                                $record = $duration->fetch_array();
                                $total_point = $record['count'];
                        
                        
                                $course_unit = "SELECT SUM(`total_unit`) AS count1 FROM `gpa` WHERE `level` <= $level AND  `unique_id` != '$unique_gpa_id'";     
                                $course_u = $conn->query($course_unit);
                                $records = $course_u->fetch_array();
                                $total_unit = $records['count1'];
                                $cgpa = "";
                        
                                if ($total_point && $total_unit) {
                                    
                                    $cgpa = number_format(($total_point / $total_unit), 2);
                                }
                                ?>
                                    <tr>
                                        <td><?php
                                        if ($total_point) {
                                            echo $total_point;
                                        }else{
                                            echo "0";
                                        }
                                        
                                        ?></td>
                                        <td><?php
                                        if ($total_unit) {
                                            echo $total_unit;
                                        }else{
                                            echo "0";
                                        }
                                        
                                        ?></td>
                                        <td><?php
                                        if ($total_point && $total_unit) {
                                            echo $cgpa;
                                        }else{
                                            echo "0.00";
                                        }
                                        
                                        ?></td>
                                    </tr>
                               
                            </tbody>
                        </table>
                    </div>
                    <div class="present">
                        <table>
                            <h3>PRESENT</h3>
                            <thead>
                                <tr>
                                    <th>POINTS</th>
                                    <th>UNITS</th>
                                    <th>GPA</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php

                                $gpa_exists = selectOne('gpa', ['session_id' => $session_id, 'semester' => $semester, 'matric_no' => $matric_id]);

                               
                        
                               
                                ?>
                                <tr>
                                    <td><?= $gpa_exists['total_points'] ?></td>
                                    <td><?= $gpa_exists['total_unit'] ?></td>
                                    <td><?= $gpa_exists['gpa'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="cumulative">
                        <table>
                            <h3>CUMULATIVE</h3>
                            <thead>
                                <tr>
                                    <th>POINTS</th>
                                    <th>UNITS</th>
                                    <th>CGPA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $level = $select['level'];
                                


                                $total_points2 = "SELECT SUM(`total_points`) AS count2 FROM `gpa` WHERE `level` <= $level AND  `semester` <= $semester";     
                                $duration2 = $conn->query($total_points2);
                                $record2 = $duration2->fetch_array();
                                $total_point2 = $record2['count2'];
                        
                        
                                $course_unit3 = "SELECT SUM(`total_unit`) AS count3 FROM `gpa` WHERE `level` <= $level AND  `semester` <= $semester";     
                                $course_u3 = $conn->query($course_unit3);
                                $records3 = $course_u3->fetch_array();
                                $total_unit3 = $records3['count3'];
                                $cgpa2 = "";
                        
                                if ($total_point2 && $total_unit3) {
                                    
                                    $cgpa2 = number_format(($total_point2 / $total_unit3), 2);
                                }
                                ?>
                                <tr>
                                        <td><?php
                                        if ($total_point2) {
                                            echo $total_point2;
                                        }else{
                                            echo "0";
                                        }
                                        
                                        ?></td>
                                        <td><?php
                                        if ($total_unit3) {
                                            echo $total_unit3;
                                        }else{
                                            echo "0";
                                        }
                                        
                                        ?></td>
                                        <td><?php
                                        if ($total_point2 && $total_unit3) {
                                            echo $cgpa2;
                                        }else{
                                            echo "0.00";
                                        }
                                        
                                        ?></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="remark">
                    <h3>REMARK:</h3>
                    <p><?= $row['remark'] ?></p>
                </div>
                <div class="hod">
                    <?php





                    $hod = selectOne('departments', ['id' => $course['dept_id']]) ?>

                    <div class="hod-sig">
                        <img src="../admin/uploads/<?= $hod['hod_sig'] ?>" alt="">
                        <hr />
                        <p>HOD'S SIGNATUE</p>
                        <p><?php echo $hod['hod']; ?></p>
                    </div>

                    <?php $dean = selectOne('faculties', ['id' => $course['fac_id']]) ?>
                    <div class="hod-sig">
                        <img src="../admin/uploads/<?= $dean['dean_sig'] ?>" alt="">
                        <hr />
                        <p>DEAN'S SIGNATUE</p>
                        <p><?= $dean['dean']; ?></p>
                    </div>
                </div>
            </div>
            <?php else: ?>
                <p>You do not have a Result for the combinaation you selected</p>
            <?php endif; ?>
        </div>




    </div>


</body>

</html>