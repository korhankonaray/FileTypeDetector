:: http://www.robvanderwoude.com/batchphp.php
:: %1=regex pattern
:: %2=replacement (use \\n or $n or ${n} for back references, where n is an integer)
:: %3=subject string
:: e.g. RFAR /./ "A" "Test string" returns "AAAAAAAAAAA"
:: e.g. RFAR "/img(_?)(\d{4,5})\.cr2/i" "Foto${2}.cr2" "IMG_8094.CR2" returns "Foto8094.cr2"
:: e.g. RFAR /\d/ "9" "Phone number: 0123456789" returns "Phone number: 9999999999"
@IF NOT "%~3"=="" PHP.EXE -r "print(preg_replace('%~1','%~2','%~3'));"