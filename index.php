<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test store</title>
</head>

<body>
    <?php
    //hide debug errors
    error_reporting(0);
    require_once 'Cloacker.php';

    //retrun ip details
    
    $cloacker = new Cloacker();

    //retrun ip details
    $ip = $cloacker->get_ip();
    //check if is browser header is preview fb/tiktok
    echo $cloacker->is_preview() . '<br>';
    //check if ip is facebook ip or tiktok ip
    echo $cloacker->is_ip() . '<br>';
    //check if is crawler
    echo $cloacker->is_crawler() . '<br>';

    //check if its mobile
    echo $cloacker->is_mobile() . '<br>';
    //check if its proxy
    echo $cloacker->is_proxy() . '<br>';

    //show headers details
    echo $cloacker->show_headers() . '<br>';

    //forwarded website
    echo $cloacker->is_forwarded() . '<br>';
    //cookie
    echo $cloacker->is_cookie() . '<br>';
    ?>


</body>

</html>