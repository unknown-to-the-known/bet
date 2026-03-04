<html>
    <head>
        <title>Certificate</title>
        <!-- Favicons -->
    <link href="../assets/images/favicon.svg" rel="icon">
    <link href="../assets/images/favicon.svg" rel="icon"> 

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>

        <style type='text/css'>
            body, html {
                margin: 0 auto;
                padding: 0 auto;
            }
            body {
                color: black;
                display: table;
                font-family: Georgia, serif; 
                font-size: 24px;
                text-align: center;
            }
            .share-button {
                border: 20px solid #536976;
                width: 750px;
                height: 563px;
              display: table-cell;
                vertical-align: middle;
                /*horizontal-align: middle;*/
            }
            .logo {
                color: tan;
            }
            .marquee {
            /*  color: tan;*/
                font-size: 44px;
                margin: 20px;
                color: #536976;
            }
            .assignment {
                margin: 20px;
            }
            .person {
                border-bottom: 2px solid black;
                font-size: 32px;
                font-style: italic;
                margin: 20px auto;
                width: 400px;
            }
            .reason {
                margin: 20px;
            }

        .share-button1 {
          position:fixed;
          width:60px;
          height:60px;
          bottom:40px;
          right:80px;
          background-color:#fff;
          color:#FFF;
          border-radius:50px;
          text-align:center;
                font-size:30px;
          box-shadow: 2px 2px 3px #999;
                z-index:100;
          cursor: pointer;
        }

        
        /*@media screen and (max-width: 767px){
            .share-button {
                width: 40px;
                height: 40px;
                bottom: 18px;
                font-size: 22px;
                right: 10px;
            }
        }*/
      </style>
    </head>

    <body>
        
        <section style="margin-top: 50px">
            
            <div class="container share-button" id="html-content-holder" style="background-image: url('../assets/images/cert_bg.jpg'); background-repeat: no-repeat; background-size: 750px 523px;">

                <a id="btn-Convert-Html2Image" href="#"><img class="share-button1" src="../assets/images/share_1.svg" alt="share"/></a>

                <div style="display: inline-block;">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12">                
                            <div class="logo">
                                <span style="display: inline-flex;"><img src="https://rev-user.s3.ap-south-1.amazonaws.com/Revisewell_logo.svg" alt="logo_revisewell" height="100px" width="100px;">
                                    <span style="font-size:32px; color: #000; margin-top:15px; font-family: 'Nunito', sans-serif;">Revisewell</span>
                                </span>
                            </div>

                            <div class="marquee" style="display: inline-flex;">
                               <img src="../assets/images/medal.svg" alt="certificate_medal" height="50px" width="50px;">
                               <span>Certificate</span>
                               <img src="../assets/images/medal.svg" alt="certificate_medal" height="50px" width="50px;" style="float: left;">
                            </div>

                            <div class="assignment">
                                This certificate is presented to
                            </div>

                            <div class="person">
                                Rakhee Jain
                            </div>

                            <div class="reason">
                                For scoring 98% in Revisewell MCQs<br/>
                                Hearty Congratulations!
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    <script type="text/javascript">
        const shareButton = document.querySelector('.share-button1');
        const shareDialog = document.querySelector('.share-dialog');
        const closeButton = document.querySelector('.close-button');

        shareButton.addEventListener('click', event => {
          if (navigator.share) { 
           navigator.share({
              title: 'Presenting certificate for Revisewell MCQs',
              url: 'https://codepen.io/ayoisaiah/pen/YbNazJ'
            }).then(() => {
              console.log('Thanks for sharing!');
            })
            .catch(console.error);
            } else {
                shareDialog.classList.add('is-open');
            }
        });

        closeButton.addEventListener('click', event => {
          shareDialog.classList.remove('is-open');
        });
    </script>

    <script>
        $(document).ready(function () {
            var element = $("#html-content-holder"); // global variable
            var getCanvas; // global variable

            html2canvas(element, {
                onrendered: function (canvas) {
                    $("#previewImage").append(canvas);
                    getCanvas = canvas;
                }
            });

            $("#btn-Convert-Html2Image").on('click', function () {
                var imgageData = getCanvas.toDataURL();
                
                // Now browser starts downloading it instead of just showing it
                var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                console.log(newData);
                // $("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);
            });
        });
    </script>
</html>