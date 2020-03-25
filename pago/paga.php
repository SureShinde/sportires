
<?php include("ipg-util.php"); ?>
<html>
<head><title>IPG Connect Sample for PHP</title></head>
<body>
<p><h1>Order Form </h1>
<form method="post" action="https://test.ipg-online.com/connect/gateway/processing">
<input type="hidden" name="txntype" value="sale">
<input type="hidden" name="timezone" value="America/Mexico_City"/>
<input type="hidden" name="txndatetime" value="<?php echo getDateTime()?>"/>
<input type="hidden" name="hash" value="<?php echo createHash("1","484") ?>"/>
<input type="hidden" name="hash_algorithm" value= "SHA256"/>
<input type="hidden" name="storename" value="3910017"/>
<input type="hidden" name="mode" value="payonly"/>
<input type="text" name="chargetotal" value="1"/>
<input type="text" name="currency" value="484"/>
<input type="hidden" name="responseSuccessURL" value="http://sportires.com.mx"/>
<input type="hidden" name="responseFailURL" value="http://sportires.com.mx"/>
<input type="submit" value="Submit">
</form>
</body>
</html>


