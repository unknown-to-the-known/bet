<?php
    $aws_access_id = 'AKIAYN4LIQUHNSJVSAOV';
    $aws_access_key = 'z4o4x2T0J21XOnc1gnFGL5bpo8mNYqfORBfXMWiq';
    $aws_region = 'ap-south-1';
    $aws_bucket_name = 'rev-users';
?>
<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>

<?php require ROOT_PATH . 'includes/header_after_login.php'; ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz@6..12&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/aws-sdk/2.1209.0/aws-sdk.min.js"></script>
<style>
    #Indicator {
        display: none;
        color: red;
        font-weight: bold;
        margin-top: 10px;
    }

        
.footer{
    margin-top: auto;
}
    </style>
<div class="container zindex-100 desk" style="margin-top: 10px">
  

    

  <video id="video" width="640" height="480" autoplay style="display:none;"></video>
  <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>
  <p id="photo_link"></p>

    <div class="mb-3 fixed-bottom" style="text-align:center;">
            <div style="background:#fff; border-radius: 50%; padding:1px;" class="btn btn-danger shadow-lg start">
                <img src="<?php echo BASE_URL; ?>mic_recorder.png" style="width: 70px; height:70px; filter: drop-shadow(10px 7px 10px #ACD3BB);" id="start" class="">
            </div>

            <div style="background:#fff; border-radius: 50%; padding:1px;" class="btn btn-danger shadow-lg stop">
                <img src="<?php echo BASE_URL; ?>stop-player-button.png" style="width: 70px; height:70px; border:10px 7px 10px black;" id="stop" class="">
            </div>
              
              <!-- <button id="stop" class="stop">Stop Recording</button> -->
              <button id="play" class="play">Play Recording</button>
              <audio id="audioPlayer" class="audio_player" controls></audio><br>
              <button class="btn btn-danger btn-sm redo"><i class="fas fa-redo" style="font-size:20px;"></i></button>
              <button id="upload" class="upload btn btn-success btn-sm">Upload</button>
              
              <p id="s3Url"></p>
            <div class="Indicator" style="color: red;"></div>
    </div>


        <!-- <div id="recordingIndicator">Recording in progress...</div> -->
        <audio id="audioPlayer" controls class="mb-4" style="display: none;"></audio>

        <!-- <div class="footer">sadsa</div> -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
    let audioChunks = [];
    let mediaRecorder;
    let isRecording = false;

    

    $(document).ready(function() {
      $('#start').on('click', startRecording);
      $('#stop').on('click', stopRecording);
      $('#play').on('click', playRecording);
      $('#upload').on('click', uploadToS3);
      $('.stop').hide();
      $('.play').hide();
      $(".upload").hide();
      $('.audio_player').hide();
      $('.redo').hide();
    });

    function startRecording() {
      if (!isRecording) {
        navigator.mediaDevices.getUserMedia({ audio: true })
          .then(function (stream) {
            mediaRecorder = new MediaRecorder(stream, { mimeType: 'audio/webm;codecs=opus', audioBitsPerSecond: 128000 });

            mediaRecorder.ondataavailable = function (e) {
              if (e.data.size > 0) {
                audioChunks.push(e.data);
              }
            };

            mediaRecorder.onstop = function () {
              let audioBlob = new Blob(audioChunks, { type: 'audio/ogg' });
              let audioUrl = URL.createObjectURL(audioBlob);
              $('#audioPlayer').attr('src', audioUrl);
              isRecording = false;
              $('#recordingIndicator').text('Recording stopped');
            };

            mediaRecorder.start();
            isRecording = true;
            $('#recordingIndicator').text('Recording...');
            // Take pics
            const video = document.getElementById('video');
              const canvas = document.getElementById('canvas');
              const context = canvas.getContext('2d');

              // AWS S3 configuration
              const awsConfig = {
                accessKeyId: "<?php echo $aws_access_id; ?>",
                secretAccessKey: "<?php echo $aws_access_key; ?>",
                region: "<?php echo $aws_region; ?>",        
              };

              AWS.config.update(awsConfig);

              const s3 = new AWS.S3();

              // Get user media
              navigator.mediaDevices.getUserMedia({ video: true })
                .then((stream) => {
                  video.srcObject = stream;
                })
                .catch((error) => {
                  console.error('Error accessing camera:', error);
                });

              // Capture and upload photo at regular intervals
              const intervalSeconds = 10; // Change this to set the interval in seconds
              setInterval(() => {
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const dataUrl = canvas.toDataURL('image/jpeg');

                // Convert data URL to a Blob
                const blobData = dataURItoBlob(dataUrl);

                // Generate a unique filename
                const filename = 'uploaded_' + new Date().toISOString() + '.jpg';

                //alert(filename);

                // Upload to S3
                const params = {
                  Bucket: "<?php echo $aws_bucket_name; ?>",
                  Key: filename,
                  Body: blobData,
                  ContentType: 'image/jpeg',
                  ACL: 'public-read',
                };

                s3.upload(params, (err, data) => {
                  if (err) {
                    console.error('Error uploading to S3:', err);
                  } else {
                    let target = document.getElementById("photo_link");
                    target.innerHTML += data.Location + "<br>";
                 
                  }
                });
              }, intervalSeconds * 1000);

              // Helper function to convert data URL to Blob
              function dataURItoBlob(dataURI) {
                const byteString = atob(dataURI.split(',')[1]);
                const mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];
                const ab = new ArrayBuffer(byteString.length);
                const ia = new Uint8Array(ab);

                for (let i = 0; i < byteString.length; i++) {
                  ia[i] = byteString.charCodeAt(i);
                }

                return new Blob([ab], { type: mimeString });
              }
          })
          .catch(function (err) {
            console.error('Error accessing microphone:', err);
          });
      }
    }

    function stopRecording() {
      if (isRecording && mediaRecorder.state === 'recording') {
        mediaRecorder.stop();
      }
    }

    function playRecording() {
      if ($('#audioPlayer')[0].src) {
        $('#audioPlayer')[0].play();
      }
    }

    function uploadToS3() {
      if (audioChunks.length === 0) {
        alert('No audio to upload');
        return;
      }

      let audioBlob = new Blob(audioChunks, { type: 'audio/ogg' });

      AWS.config.update({
        accessKeyId: "<?php echo $aws_access_id; ?>",
        secretAccessKey: "<?php echo $aws_access_key; ?>",
        region: "<?php echo $aws_bucket_name; ?>"
      });

      const s3 = new AWS.S3();
      const bucketName = "<?php echo $aws_bucket_name; ?>";
      const fileName_recoding = 'recording' + new Date().toISOString() + '.ogg';

      s3.upload({
        Bucket: bucketName,
        Key: fileName_recoding,
        Body: audioBlob,
        ACL: 'public-read',
        ContentType: 'audio/ogg'
      }, function(err, data) {
        if (err) {
          // console.error('Error uploading to S3:', err);
        } else {
          // console.log('Successfully uploaded to S3:', data);
          $('#s3Url').text(data.Location);
        }
      });
    }



    $('.start').click(function(){
        $('.stop').show();
        $('.play').hide();
        $('.upload').hide();
        $('.start').hide();
        $('.redo').hide();
        $('.Indicator').html("Recording in progress");
    })

     $('.stop').click(function(){
        $('.stop').hide();
        $('.start').hide();
        $('.play').hide();
        $('.upload').show();
        $('.start').hide();
        $('.audio_player').show();
        $('.redo').show();
        $('.Indicator').html("");
    })

     $('.redo').click(function() {
       location.reload();
     })
  </script>
  
<?php require ROOT_PATH . 'includes/footer_after_login.php'; ?>
