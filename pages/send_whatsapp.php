<?php require '../includes/config.php'; ?>
<?php require ROOT_PATH . 'includes/db.php'; ?>
<?php date_default_timezone_set('Asia/Kolkata'); ?>

<?php
//The idInstance and apiTokenInstance values are available in your account, double brackets must be removed
$url = 'https://7105.api.greenapi.com/waInstance7105206644/sendMessage/aca8587084c6411f8ce0ab8bcf994f587b52bcf7b73e4f5eb8';

//chatId is the number to send the message to (@c.us for private chats, @g.us for group chats)
$data = array(
'chatId' => '919164454002@c.us', 
'message' => '*Fee Alert*
Dear Karthik, 👋 
 Greetings from St.Peters School 🏫
 🏫 Tuition fee: Rs. 25000
 📚 Books fee: Rs. 5000
 🚌 Transportation fee: Rs. 2000
 💰 Total Pending Amount: Rs. 32000
 ⏳ Please clear the due in the next 15 days.
 For any queries, feel free to contact 📞 9164454002.
 Thank you! 🙏'
);

$options = array(
    'http' => array(
        'header' => "Content-Type: application/json\r\n",
        'method' => 'POST',
        'content' => json_encode($data)
    )
);

$context = stream_context_create($options);

$response = file_get_contents($url, false, $context);

echo $response;
?>
