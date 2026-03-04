<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php
// Replace these with your actual PhonePe API credentials
if (isset($_GET['order_id'])) {
  if ($_GET['order_id'] != "") {
    $order_id = htmlspecialchars($_GET['order_id'], ENT_QUOTES, 'UTF-8');
  }  
}


$fetch_details = mysqli_query($connection,"SELECT * FROM erp_payment_details WHERE rev_order_id = '$order_id' AND rev_sts = '2'");
if (mysqli_num_rows($fetch_details) > 0) {
  while($fdr = mysqli_fetch_assoc($fetch_details)) {
   $amount = $fdr['rev_payment_amount'];
   $dicount_amount = $fdr['rev_discount'];
  }
}

 $final_amount = $amount - $dicount_amount;

 if ($final_amount == '0') {
   echo "Looks like fees is paid off, please select the other student";
 }

$merchantId = 'PGTESTPAYUAT105'; // sandbox or test merchantId
$apiKey = "c45b52fe-f2c5-4ef6-a6b5-131aa89ed133"; // sandbox or test APIKEY
$redirectUrl = 'https://erp.revisewell.com/pages/payment-success.php';
 
// Set transaction details
$order_id = $order_id; 
$name="Tutorials Website";
$email="info@tutorialswebsite.com";
$mobile=9999999999;
$amount = $final_amount; // amount in INR
$description = 'fknmsdkfmkdsmf';
 
 
$paymentData = array(
    'merchantId' => $merchantId,
    'merchantTransactionId' => $order_id, // test transactionID
    "merchantUserId"=>"MUID123",
    'amount' => $amount*100,
    'redirectUrl'=>$redirectUrl,
    'redirectMode'=>"POST",
    'callbackUrl'=>$redirectUrl,    
   "mobileNumber"=>$mobile,   
   "paymentInstrument"=> array(    
    "type"=> "PAY_PAGE",
  )
);
 
 
 $jsonencode = json_encode($paymentData);
 $payloadMain = base64_encode($jsonencode);
 $salt_index = 1; //key index 1
 $payload = $payloadMain . "/pg/v1/pay" . $apiKey;
 $sha256 = hash("sha256", $payload);
 $final_x_header = $sha256 . '###' . $salt_index;
 $request = json_encode(array('request'=>$payloadMain));
                
$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL => "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $request,
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
     "X-VERIFY: " . $final_x_header,
     "accept: application/json"
  ],
]);
 
$response = curl_exec($curl);
$err = curl_error($curl);
 
curl_close($curl);
 
if ($err) {
  echo "cURL Error #:" . $err;
} else {
   $res = json_decode($response);
 
if(isset($res->success) && $res->success=='1'){
$paymentCode=$res->code;
$paymentMsg=$res->message;
$payUrl=$res->data->instrumentResponse->redirectInfo->url;
 
header('Location:'.$payUrl) ;
}
}
?>