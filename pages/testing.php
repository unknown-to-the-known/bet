<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>HTML to PDF Conversion</title>
</head>
<body>

    <div id="content">
        <h1>Hello, this is a PDF test</h1>
        <p>You can convert this div and the table below to a single PDF using the button below.</p>

        <table border="1">
            <tr>
                <td>Column 1</td>
                <td>Column 2</td>
            </tr>
            <tr>
                <td>Data 1</td>
                <td>Data 2</td>
            </tr>
            <!-- Add more rows as needed -->
        </table>
    </div>

    <button id="downloadButton">Download PDF</button>

    <script defer>
        document.getElementById('downloadButton').addEventListener('click', function () {
            var element = document.getElementById('content');
            html2pdf(element);
        });
    </script>

</body>
</html>
