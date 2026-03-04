<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>
    <form method="POST" action="https://api.razorpay.com/v1/checkout/embedded">
      <input type="hidden" name="key_id" value="rzp_live_PbMi519dT6bQYC">
      <input type="hidden" name="amount" value=1001>
      <input type="hidden" name="order_id" value="OID_<?php echo rand(10,100); ?>">
      <input type="hidden" name="name" value="Acme Corp">
      <input type="hidden" name="description" value="A Wild Sheep Chase">
      <input type="hidden" name="image" value="https://cdn.razorpay.com/logos/BUVwvgaqVByGp2_large.jpg">
      <input type="hidden" name="name" value="Gaurav Kumar">
      <input type="hidden" name="contact" value="9123456780">
      <input type="hidden" name="email" value="gaurav.kumar@example.com">
      <input type="hidden" name="shipping address" value="L-16, The Business Centre, 61 Wellfield Road, New Delhi - 110001">
      <input type="hidden" name="callback_url" value="https://example.com/payment-callback">
      <input type="hidden" name="cancel_url" value="https://example.com/payment-cancel">
      <button>Submit</button>
    </form>

</body>
</html>