<?php 

global $dateTime;
date_default_timezone_set("America/Mexico_City");
$dateTime = date("Y:m:d-H:i:s");
 
function getDateTime() {
            global $dateTime;
            return $dateTime;
}
 
function createHash($chargetotal, $currency) {
            $storename = "3910017";
            $sharedSecret = "topsecret";
 
            $stringToHash = $storename . getDateTime() . $chargetotal . $currency . $sharedSecret;
 
            $ascii = bin2hex($stringToHash);
 
            return  hash( 'sha256', $ascii );
}
