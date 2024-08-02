<?php
include("../db.php");
if(isset($_POST['paymentbtn'])){	
$product_name = 'Student Fee';
$price = $_POST['amount'];
$stuid = $_POST['stuid'];
$email_address = $_POST['email_address'];
$mobile = $_POST['mobile'];
// $name = 'sanjiv';

include 'folderpay/src/Instamojo.php';
$api = new Instamojo\Instamojo('test_55d2c173b633b635fc4e8286466', 'test_0c45e4cb11723442c7a272c719b','https://test.instamojo.com/api/1.1/');

try {
    $response = $api->paymentRequestCreate(array(
        "purpose" => $product_name,
        "amount" => $price,
        // "buyer_name" => $name,
        "phone" => $mobile,
        "send_email" => false,
        "send_sms" => false,
        "email" => $email_address,
        'allow_repeated_payments' => false,
        "redirect_url" => "http://essglobal.online/aol/application/thankyou.php?sno=$stuid",
        // "webhook" => "http://makemestudyabroad.com/insta/Webhook.php"
        ));    
    $pay_ulr = $response['longurl'];
    
    //Redirect($response['longurl'],302); //Go to Payment page
    header("Location: $pay_ulr");
    exit();
}
catch (Exception $e) {
	$msg = $e->getMessage();
	header("Location: ../application?payError=$msg");
    // print('Error: ' . $e->getMessage());
} 
}    
  ?>