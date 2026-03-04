<?php
require 'includes/config.php'; 
require ROOT_PATH . 'includes/db.php'; 
date_default_timezone_set('Asia/Kolkata');

if (isset($_GET['id'])) {
    if ($_GET['id'] != "") {
        $user_id = htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8');
    } else {
        header("Location: " . BASE_URL . 'pages/cg');
    }
} else {
    header("Location: " . BASE_URL . 'pages/cg');
}

$fetch_details = mysqli_query($connection, "SELECT * FROM rev_erp_student_details WHERE tree_id = '$user_id' AND rev_sts = '1'");

if (mysqli_num_rows($fetch_details) > 0) {
    while($ds = mysqli_fetch_assoc($fetch_details)) {
        $student_name = $ds['rev_student_fname'] . " " . $ds['rev_student_mname'] . " " . $ds['rev_student_lname'];
        $father_name = $ds['rev_father_fname'] . " " . $ds['rev_father_mname'] . " " . $ds['rev_father_lname'];
        $district = $ds['rev_student_district'];
        $taluk = $ds['rev_student_taluk'];
        $school_name = $ds['rev_school_name'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HK Certificate</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Kannada:wght@100..900&display=swap');
        body { font-family: "Noto Sans Kannada", sans-serif; background: #f8f9fa; }
        .certificate { background: white; padding: 20px; border-radius: 10px; margin-top: 150px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        .header img { width: 120px; height: 120px; }
        @media print {
          .no-print {
            display: none !important;
          }
        }
    </style>
</head>
<body>
    <section id="content">
        <div class="container-fluid" >
            <div class="row">
                <div class="col-md-12 text-center" style="margin-top: 15px; line-height: 10px;">
                    <img src="kar_logo.png" alt="kar_gov_logo" class="img-fluid " width="120px" height="120px">
                    <h4 class="fw-bold">ಅನುಬಂಧ - ಸಿ</h4>
                    <h2 class="fw-normal">ವ್ಯಾಸಂಗ ಪ್ರಮಾಣಪತ್ರ</h2>
                    <h4>(ಅನುಚ್ಛೇದ 371 (ಜೆ) ಮೇರೆಗೆ)</h4>
                    <h4>(ನಿಯಮ 4 (ಸಿ) (2) (ii) ನೋಡಿ)</h4>
                    <h5 class="fw-medium">(ಪ್ರಮಾಣಪತ್ರಗಳ ನೀಡಿಕೆಗಾಗಿ ಕರ್ನಾಟಕ ಸಾರ್ವಜನಿಕ ಉದ್ಯೋಗ (ಹೈದರಾಬಾದ್-ಕರ್ನಾಟಕ ಪ್ರದೇಶಕ್ಕೆ ನೇಮಕಾತಿಯಲ್ಲಿ ಮೀಸಲಾತಿ) ನಿಯಮಗಳು, 2013)</h5>
                    <p class="mt-4" style="text-align: justify;line-height: 32px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ಶ್ರೀ/ ಶ್ರೀಮತಿ <b style="text-decoration: underline;"><?php echo $student_name; ?></b> ರವರು <b style="text-decoration: underline;"><?php echo $father_name; ?></b> ರವರ ಮಗ/ಮಗಳು/ಹೆಂಡತಿಯಾಗಿದ್ದು, ಇವರು <b style="text-decoration: underline;"><?php echo $district; ?></b> ಜಿಲ್ಲೆಯ <b style="text-decoration: underline;"><?php echo $taluk; ?></b> ತಾಲ್ಲೂಕಿನ <b style="text-decoration: underline;"><?php echo $school_name; ?></b> ಕಾಲೇಜು/ ಶಾಲೆಯಲ್ಲಿ ಈ ಕೆಳಗೆ ಸೂಚಿಸಲಾದ ಅವಧಿಯಲ್ಲಿ ವ್ಯಾಸಂಗ ಮಾಡಿರುತ್ತಾರೆಂದು ಪ್ರಮಾಣೀಕರಿಸಲಾಗಿದೆ.</p>
                </div>

                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">ಕ್ರ. ಸಂ.</th>
                            <th scope="col">ತರಗತಿ / ಹಂತ</th>
                            <th scope="col">ಯಾವ ದಿನಾಂಕದಿಂದ ಯಾವ<br> ದಿನಾಂಕದ ವರೆಗೆ</th>
                            <th scope="col">ದಾಖಲೆಯ ಉಲ್ಲೇಖ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        </tbody>
                      </table>

                      <p>&nbsp;&nbsp;&nbsp;ಇವನು ಈ ಕೆಳಕಂಡ ವರ್ಷಗಳಲ್ಲಿ ಈ ಕೆಳಕಂಡ ಪರೀಕ್ಷೆಗಳಲ್ಲಿ ಉತ್ತೀರ್ಣನಾಗಿದ್ದಾನೆ/ ಅನುತ್ತೀರ್ಣನಾಗಿದ್ದಾನೆ.</p>

                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">ಕ್ರ. ಸಂ.</th>
                            <th scope="col">ತರಗತಿ/ ಪರೀಕ್ಷೆ/ ಹಂತದ ಹೆಸರು</th>
                            <th scope="col">ವರ್ಷ</th>
                            <th scope="col">ಅನುತ್ತೀರ್ಣ/ <br>ಉತ್ತೀರ್ಣ</th>
                            <th scope="col">ದಾಖಲೆಯ ಉಲ್ಲೇಖ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        </tbody>
                      </table>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="col-md-12 d-flex mt-3 justify-content-between" style="line-height: 10px;">
                <div>
                    <p>ಸ್ಥಳ : <?php echo $taluk; ?></p>
                    <p>ದಿನಾಂಕ : <?php echo date('d-M-Y'); ?></p>
                </div>
                <div>
                    <p>ಹೆಸರು :______________</p>
                    <p>ಸಂಸ್ಥೆಯ ಮುಖ್ಯಸ್ಥರು :______________</p>
                </div>
            </div>

            <div class="col-md-12">
                 <p class="text-center fw-bold"><u>ಪ್ರಮಾಣಪತ್ರ</u></p>
                 <p style="text-align: justify;">&nbsp; &nbsp; &nbsp; ಮೇಲೆ ನೀಡಲಾದ ಪ್ರಮಾಣ ಪತ್ರವು ಲಭ್ಯವಿರುವ ದಾಖಲೆಯ ಪ್ರಕಾರ ಸತ್ಯವಾಗಿದೆ ಎಂಬುದನ್ನು ನಾನು ಸ್ವತಃ ಮನವರಿಕೆ ಮಾಡಿಕೊಂಡಿದ್ದೇನೆಂದು ಪ್ರಮಾಣೀಕರಿಸುತ್ತೇನೆ.</p>
            </div>

            <div class="col-md-12 mt-4 d-flex justify-content-between" style="line-height: 10px;">
                <div>
                    <p>ಸ್ಥಳ : <?php echo $taluk; ?></p>
                    <p>ದಿನಾಂಕ : <?php echo date('d-M-Y'); ?></p>
                </div>
                <div>
                    <p>ಹೆಸರು :______________</p>
                    <p>ಕ್ಷೇತ್ರ ಶಿಕ್ಷಣಾಧಿಕಾರಿ :______________</p>
                    <p class="text-right">_____________________ ತಾಲ್ಲೂಕು</p>
                    <p class="text-right">_____________________ ಜಿಲ್ಲೆ</p>
                </div>
            </div>
        </div>
    </section>
    
</body>
</html>
<script type="text/javascript">
     class PDFGenerator {
            constructor(elementId) {
                this.elementId = elementId;
            }

            generateAndDownloadPDF(filename = "document.pdf") {
                const element = document.getElementById(this.elementId);
                if (element) {
                    html2pdf().from(element).save(filename);
                } else {
                    console.error("Element not found: " + this.elementId);
                }
            }
        }

        window.onload = function () {
            const pdfGen = new PDFGenerator("content");
            setTimeout(() => pdfGen.generateAndDownloadPDF(), 1000); // Delay ensures full page load
        };
    
</script>

