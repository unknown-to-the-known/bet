<?php
require '../includes/config.php';
require ROOT_PATH . 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['keyword'])) {
    $keyword = trim($_POST['keyword']);
    $u_class = trim($_POST['u_class']);
    $keyword = mysqli_real_escape_string($connection, $keyword);
    $u_class = mysqli_real_escape_string($connection, $u_class);

    $sql = "SELECT tree_id, rev_student_fname FROM rev_erp_student_details 
            WHERE rev_student_fname LIKE '%$keyword%' AND rev_sts = '1' AND rev_admission_class = '$u_class' LIMIT 10";
    $result = mysqli_query($connection, $sql);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = ['id' => $row['tree_id'], 'name' => $row['rev_student_fname']];
    }

    echo json_encode($data);
    exit();
}
?>
