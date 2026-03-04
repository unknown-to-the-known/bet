<!DOCTYPE html>
<html>
<head>
  <title>Print Test Landscape</title>
  <style>
    @media print {
      @page {
        size: A4 landscape;
        margin: 10mm;
      }

      body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
      }

      .no-print {
        display: none !important;
      }

      .print-area {
        font-size: 24px;
        width: 100%;
        text-align: center;
        padding-top: 50px;
      }
    }

    .print-area {
      font-size: 24px;
      width: 100%;
      text-align: center;
      padding-top: 50px;
    }
  </style>
</head>
<body>

  <div class="no-print">This won't print.</div>

  <div class="print-area">
    This is a test page for landscape printing.
  </div>

</body>
</html>
