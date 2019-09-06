@ECHO OFF
:: Country.bat,  Version 4.00
:: Read the country name from the registry and store
:: the value in an environment variable "Country"
::
:: Usage:  COUNTRY
::
:: Written by Rob van der Woude
:: http://www.robvanderwoude.com

:: Command for ancient versions of REG.EXE
FOR /F "tokens=2*" %%A IN ('REG QUERY "HKCU\Control Panel\International\sCountry"    2^>NUL') DO SET Country=%%B
:: Command for more recent versions of REG.EXE
FOR /F "tokens=2*" %%A IN ('REG QUERY "HKCU\Control Panel\International" /v sCountry 2^>NUL') DO SET Country=%%B
ECHO Country=%Country%
