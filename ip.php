<?php
//if( $_SERVER["HTTP_X_REAL_IP"]=="99.237.207.238") {
//include_once 'm.php';
$IP = $_SERVER['HTTP_X_REAL_IP'];
$dir = "IPs";
//if(count($_POST)>0) {
$_dir = $dir."/".$IP;
//if(!is_dir($dir."/".$IP)) {
    //mkdir($_dir, 0777);
    //$post = print_r($_POST,true);
    //file_put_contents($dir."/".$IP."/".time().".txt",$post, FILE_APPEND );

    file_put_contents($dir . "/" . "IPs.txt", $IP." | ".date('"Y-m-d H:i:s"') . "\n", FILE_APPEND);
//}
//}
//exit;
//}
?>