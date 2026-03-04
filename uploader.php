<?php   
     // error_reporting(0);
    defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost');
    defined('DB_USER')   ? null : define('DB_USER', 'NkAvGCEubF'); //u538764663_karth 
    defined('DB_PASS')   ? null : define('DB_PASS', '387ep#fS6'); //3Pj6LD#5IKo9U1CwX~
    defined('DB_NAME')   ? null : define('DB_NAME', 'xNqmMjoh0I'); //u538764663_video
    

    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if (!$connection) {
        die("There is a problem to connect the database, Please try after some time");
    } 
      
   session_start();
   
?>
<?php   
     // error_reporting(0);
   //  defined('DB_SERVER') ? null : define('DB_SERVER', 'localhost');
   //  defined('DB_USER')   ? null : define('DB_USER', 'karthik'); //u538764663_karth 
   //  defined('DB_PASS')   ? null : define('DB_PASS', '#Uk9zv45'); //3Pj6LD#5IKo9U1CwX~
   //  defined('DB_NAME')   ? null : define('DB_NAME', 'test_data'); //u538764663_video
    

   //  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
   //  if (!$connection) {
   //      die("There is a problem to connect the database, Please try after some time");
   //  } 
      
   // session_start();

   // $path = "up/rakhee.webp";
   // $image = "";

   // $status = file_put_contents($path, file_get_contents($image));
   

// require 'vendor/autoload.php';
// use Aws\S3\S3Client;

// $client = new Aws\S3\S3Client([
//         'version' => 'latest',
//         'region'  => 'ap-south-1',
//         'endpoint' => 'revisewell.s3-accelerate.amazonaws.com',
//         'credentials' => [
//                 'key'    => getenv('AKIAYN4LIQUHGQLEZX56'),
//                 'secret' => getenv('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'),
//             ],
// ]);

//     $client->createBucket([
//         'Bucket' => 'jmk',
//     ]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image resize</title>
    <style>
        #old{
            max-width: 90%;
            height: auto;
            /*border: solid thick red;*/
        }
        #new{
            /*border: solid thick red;*/
        }
    </style>
</head>
<body>
    <input id="file" accept="image/*" type="file" onchange="preview_image()" capture="environment">
    <br>


    <!-- <video width="320" height="240" controls >
          <source src="" id="new">
        </video> -->
    
    <img src="" id="new" width="100%" height="50%">
    <br>
    <img src="" id="old" style="display:none;">
    <button class="add_more">Add More</button>
    <?php 
        $fetch_img = mysqli_query($connection, "SELECT * FROM rev_base64 ORDER BY tree_id DESC");
        if (mysqli_num_rows($fetch_img) > 0) {
            while($lk = mysqli_fetch_assoc($fetch_img)) { 
                ?>
                <a href="https://d349p3fjrxa3i.cloudfront.net/<?php echo $lk['uniq_url'];?>" target="_blank"><img src="https://d349p3fjrxa3i.cloudfront.net/<?php echo htmlspecialchars($lk['uniq_url'], ENT_QUOTES, ENT_QUOTES); ?>" width="100px"></a> 
             <?php }
        }
    ?>
    <script>
        /**
 * Resize a base 64 Image
 * @param {String} base64Str - The base64 string (must include MIME type)
 * @param {Number} MAX_WIDTH - The width of the image in pixels
 * @param {Number} MAX_HEIGHT - The height of the image in pixels
 */
async function reduce_image_file_size(base64Str, MAX_WIDTH = 1224, MAX_HEIGHT = 1224) {
    let resized_base64 = await new Promise((resolve) => {
        let img = new Image()
        img.src = base64Str
        img.onload = () => {
            let canvas = document.createElement('canvas')
            let width = img.width
            let height = img.height

            if (width > height) {
                if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width
                    width = MAX_WIDTH
                }
            } else {
                if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height
                    height = MAX_HEIGHT
                }
            }
            canvas.width = width
            canvas.height = height
            let ctx = canvas.getContext('2d')
            ctx.drawImage(img, 0, 0, width, height)
            resolve(canvas.toDataURL()) // this will return base64 image results after resize
            var k = canvas.toDataURL();           

            // setTimeout(function()  {
                // $.post( "imag_up.php", { name: k}, function(){
                //     console.log()
                // } );

                $.post( "imag_up.php", { name: k, })
                  .done(function( data ) {
                    var b = $.trim(data);
                    if (b != "") {
                        alert(b);
                    }
                  });
              // }, 3000);
        }
    });
    return resized_base64;
}

async function image_to_base64(file) {
    let result_base64 = await new Promise((resolve) => {
        let fileReader = new FileReader();
        fileReader.onload = (e) => resolve(fileReader.result);
        fileReader.onerror = (error) => {
            console.log(error)
            alert('An Error occurred please try again, File might be corrupt');
        };
        fileReader.readAsDataURL(file);
    });
    return result_base64;
}

async function process_image(file, min_image_size = 300) {
    const res = await image_to_base64(file);
    if (res) {
        const old_size = calc_image_size(res);
        if (old_size > min_image_size) {
            const resized = await reduce_image_file_size(res);
            const new_size = calc_image_size(resized)
            console.log('new_size=> ', new_size, 'KB');
            console.log('old_size=> ', old_size, 'KB');
            return resized;
        } else {
            console.log('image already small enough')
            return res;
        }

    } else {
        console.log('return err')
        return null;
    }
}

/*- NOTE: USE THIS JUST TO GET PROCESSED RESULTS -*/
async function preview_image() {
    const file = document.getElementById('file');
    const image = await process_image(file.files[0]);
    console.log(image)
}

/*- NOTE: USE THIS TO PREVIEW IMAGE IN HTML -*/
async function preview_image() {
    const file = document.getElementById('file');
    const res = await image_to_base64(file.files[0])
    if (res) {
        document.getElementById("old").src = res;

        const olds = calc_image_size(res)
        console.log('Old size => ', olds, 'KB')

        const resized = await reduce_image_file_size(res);
        const news = calc_image_size(resized)
        console.log('new size => ', news, 'KB')

        document.getElementById("new").src = resized;
    } else {
        console.log('return err')
    }    
}

function calc_image_size(image) {
    let y = 1;
    if (image.endsWith('==')) {
        y = 2
    }
    const x_size = (image.length * (3 / 4)) - y
    return Math.round(x_size / 1024)
}

// credit to: https://gist.github.com/ORESoftware/ba5d03f3e1826dc15d5ad2bcec37f7bf 

    </script>
</body>
</html>


 <!-- credit to: https://gist.github.com/ORESoftware/ba5d03f3e1826dc15d5ad2bcec37f7bf -->