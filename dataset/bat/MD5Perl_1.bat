:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "MD5 teststring" returns the MD5 checksum for "teststring"
@IF NOT "%~1"=="" perl -MDigest::MD5=md5_hex -le "print md5_hex '%~1'"
