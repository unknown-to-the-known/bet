<?php
// Green API credentials
$instanceId = '7105206644';
$apiToken = 'aca8587084c6411f8ce0ab8bcf994f587b52bcf7b73e4f5eb8';
$url = "https://7105.api.greenapi.com/waInstance{$instanceId}/sendMessage/{$apiToken}";

// Array of phone numbers (without country code prefix '+', and should include country code)
$numbers = ['919164454002', '917829103781', '919008011476', '919380003070', '919060067699', '918660464980', '918088700901']; // Add your numbers here
$message = "asdasd"; // Your message

foreach ($numbers as $number) {
    $data = array(
        'chatId' => $number . '@c.us',
        'message' => $message
    );

    $options = array(
        'http' => array(
            'header'  => "Content-Type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        )
    );

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    echo "Sent to {$number}: " . $response . "\n";
}
?>
