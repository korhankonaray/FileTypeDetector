:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  "SHA1 teststring" returns the SHA-1 checksum for "teststring"
@IF NOT "%~1"=="" perl -MDigest::SHA1=sha1_hex -le "print sha1_hex '%~1'"
