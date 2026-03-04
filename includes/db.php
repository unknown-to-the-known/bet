<?php   
    defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost');
    defined('DB_USER')   ? null : define('DB_USER', 'bet'); //u538764663_karth 
    defined('DB_PASS')   ? null : define('DB_PASS', '0?6Ih8q0w'); //3Pj6LD#5IKo9U1CwX~
    defined('DB_NAME')   ? null : define('DB_NAME', 'bet'); //u538764663_video
    

    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if (!$connection) {
        die("There is a problem to connect the database, Please try after some time");
    } 
    session_start();  

    $pdf_reader_for_teacher = '19157e29ac6a4a1ab0758309387f54be';
    $ultra_msg_token = "wq6wqj6ky4or8oy7";
    $instance_id = "instance26587";
    $uploadcare_code = "cbdac181dd6cc9f7ab5b";
    date_default_timezone_set("Asia/Kolkata");
?>