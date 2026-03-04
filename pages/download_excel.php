<?php
// Include database connection
require '../includes/config.php';
require ROOT_PATH . 'includes/db.php';

if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];

    // Fetch total working days
    $total_working_query = mysqli_query($connection, "SELECT DISTINCT st_date FROM attendance WHERE class_id = '$class_id'");
    $tw = mysqli_num_rows($total_working_query); // Total working days

    // Fetch student attendance data
    $query = "SELECT student_id, student_name, 
                     COUNT(CASE WHEN status = 'present' THEN 1 END) AS present_days, 
                     MAX(st_date) AS last_date 
              FROM attendance 
              WHERE class_id = '$class_id' 
              GROUP BY student_id, student_name 
              ORDER BY last_date DESC";

    $fetch_attendance = mysqli_query($connection, $query);

    // Set headers for Excel download
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=attendance_report.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Print Excel column headers
    echo "S.No\tStudent Name\tClass\tNo. of Working Days\tPresent Days\tAbsent Days\n";

    if (mysqli_num_rows($fetch_attendance) > 0) {
        $i = 1;
        while ($dse = mysqli_fetch_assoc($fetch_attendance)) {
            $absent_days = $tw - $dse['present_days'];

            echo "$i\t" . ucfirst($dse['student_name']) . "\t$class_id\t$tw\t{$dse['present_days']}\t$absent_days\n";
            $i++;
        }
    } else {
        echo "No records found\n";
    }
} else {
    echo "Class ID is missing.";
}
?>
