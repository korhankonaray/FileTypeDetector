:: http://www.robvanderwoude.com/batchphp.php
:: Usage:   LastDayOfMonth.bat  month  year
:: Where:   month and year are integers
:: Example: LastDayOfMonth.bat 2 2008 will return 29
@IF NOT "%~2"=="" PHP -r "print(strftime(\"%%d\", mktime(0, 0, 0, %~1 + 1, 0, %~2)));"
