<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['b_i'])) {
    echo "Form was submitted.<br>";

    if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {
        echo "File uploaded successfully.<br>";
        
        // Optional: print file info
        print_r($_FILES['file']);
    } else {
        echo "File upload error. Code: " . $_FILES['file']['error'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CSV Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="formFile" class="form-label fw-semibold text-secondary">Select CSV File</label>
            <div class="file-upload-wrapper">
                <input class="form-control" type="file" id="formFile" name="file" accept=".csv" style="background-color: #f8f9fa; border: 2px dashed #bbdefb; padding: 20px; border-radius: 10px;">
            </div>
        </div>

        <button type="submit" name="b_i" class="btn btn-primary">Upload</button>
    </form>
</body>
</html>
