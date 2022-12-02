<?php
require('connect.php');
require('template/navbar.php');
require('session/session_auth.php');

// request to soap server
if(isset($_POST['subscribe'])){
    $idpenyanyi = $_POST['subscribe'];
    $idpengguna = $_SESSION['userid'];
    $opts = array(
        'http' => array(
            'user_agent' => 'PHPSoapClient'
        )
    );
    $context = stream_context_create($opts);
    $soapClientOptions = array(
        'stream_context' => $context,
        'cache_wsdl' => WSDL_CACHE_NONE
    );

    $client = new SoapClient("http://localhost:8000/subscription?wsdl", $soapClientOptions);
    $request = array(
        'creator_id' => $idpengguna,
        'subscriber_id' => $idpenyanyi
    );
    try{
        $response = $client->createSub($request);
        echo "<script>alert('Berhasil subscribe" . $response->subscription->creator_id . " Sebagai " . $response->subscription->subscriber_id . "')</script>";
    }catch (Exception $e){
        echo $e->getMessage();
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/penyanyiPremium.css"/>
    <link rel="stylesheet" href="css/globals.css"/>
    <script src="js/getPenyanyiPremium.js" defer></script>
    <title>List Penyanyi Premium</title>
</head>
<body>
    <div class="top-container">
        <?php navbar(); ?>
        <div class="main" id="main">
        </div>
    </div>

</body>
</html>