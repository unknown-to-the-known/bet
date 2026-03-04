<?Php 
	if (isset($_POST['submit'])) {
		$amount = htmlspecialchars($_POST['amount'], ENT_QUOTES, 'UTF-8');

		if ($amount == "") {
			$error_message = "Please enter valid amount";
		}

		if (!isset($error_message)) {
			$merchantId = 'AKSHARAPUONLINE'; // sandbox or test merchantId
			$apiKey = "b55377be-9465-4610-acca-1bd0b6b61253"; // sandbox or test APIKEY
			$redirectUrl = 'phonepe.php';
			 
			// Set transaction details
			$order_id = uniqid(); 
			$name="Tutorials Website";
			$email="info@tutorialswebsite.com";
			$mobile=7829103781;
			$amount = $amount; // amount in INR
			$description = 'Payment for Product/Service';
			 
			 
			$paymentData = array(
			   'merchantId' => $merchantId,
			    'merchantTransactionId' => $order_id, // test transactionID
			    "merchantUserId"=>"MUID123",
			    'amount' => $amount*100,
			    'redirectUrl'=>"https://aksharapublicschool.com/phonepe",
			    'redirectMode'=>"POST",
			    'callbackUrl'=>"https://aksharapublicschool.com/phonepe",    
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
			  CURLOPT_URL => "https://api.phonepe.com/apis/hermes/pg/v1/pay",
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

			// print_r($response);
			 
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
		}
	}

	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<form action="" method="post">
		<input type="text" name="amount">
		<input type="submit" name="submit" value="submit">
	</form>
</body>
</html>