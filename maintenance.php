<?php
$allowed_ips = explode(",", file_get_contents('IPs/white.txt'));

$HTTP_X_FORWARDED_FOR = explode(",", $_SERVER["HTTP_X_REAL_IP"]);
//$allowed_ips[] = $HTTP_X_FORWARDED_FOR[0];
?>
<?php
if($rest == "rest") return;
//if(!in_array($_SERVER["HTTP_X_REAL_IP"], $allowed_ips)){
    include_once('pub/errors/sportires/503.phtml');
    exit;
//}