:: http://www.robvanderwoude.com/batchphp.php
:: Usage:  ISODate.bat  year  week  day  format
:: Where:  year, week and day are integers, format is a PHP date format like Ymd or m/d/Y (case sensitive)
@IF NOT "%~4"=="" PHP.EXE -r "$date=date_create();date_isodate_set($date,%~1,%~2,%~3);print(date_format($date,'%~4'));"
