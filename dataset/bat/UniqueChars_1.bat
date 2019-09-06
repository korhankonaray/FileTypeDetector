:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  UniqueChars.bat "the quick brown fox jumps over the lazy dog" returns " abcdefghijklmnopqrstuvwxyz"
@IF NOT "%~1"=="" PHP.EXE -r "print(count_chars(\"%~1\",3));
