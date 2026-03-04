<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>

<?php 
     if (isset($_SESSION['teach_details'])) {
            session_destroy();
             header("Location: " . BASE_URL . 'index');
        } else {
             if (isset($_SESSION['parent'])) {
            session_destroy();
             header("Location: " . BASE_URL . 'parents/');
             } else {
                  header("Location: " . BASE_URL . 'parents/');
             }
        }




     
?>

