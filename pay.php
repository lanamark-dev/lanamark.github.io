<?php
//ini_set('display_errors',0);
//error_reporting(0);
//echo("<script>console.log('PHP: ');</script>");
function cors() {//http://stackoverflow.com/questions/8719276/cors-with-php-headers

    // Allow from any origin
    if (isset($_SERVER['https://github.com'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['https://github.com']}"); //change {$_SERVER['HTTP_ORIGIN']} to 'http://www.yoursitehere.com'
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    }
}

cors();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://ecom.payfirma.com/sale');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, true);

$data = array(
	'merchant_id'=>'merchant_id',//Merchant ID
	'key'=>'api_key', //API Key
	'amount'=>'1.00', //change your static amount for your product here
	'card_number'=>$_REQUEST['card_number'],
	'token'=>$_REQUEST['token'],
	'first_name'=>$_REQUEST['first_name'],
	'last_name'=>$_REQUEST['last_name'],
    'address'=>$_REQUEST['address'],
	'card_expiry_month'=>$_REQUEST['card_expiry_month'],
	'card_expiry_year'=>$_REQUEST['card_expiry_year'],
	'test_mode'=>'true' //Remove this after you're done configuring! Don't forget the comma on the above line.
	);

curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$output = curl_exec($ch);
curl_close($ch);
if(curl_errno($ch))
{
    echo 'curl error: ' . curl_error($ch);
}
echo $output;

?>
