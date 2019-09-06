@ECHO OFF
:: This batch file was generated using the WMI Code Generator, Version 2.01
:: http://www.robvanderwoude.com/wmigen.html
:: It has been edited afterwards to show only the CPU load percentage

IF "%~1"=="" (
	SET Node=%ComputerName%
) ELSE (
	SET Node=%~1
)

FOR /F "tokens=2 delims==" %%A IN ('WMIC.EXE /Node:%Node% /Output:STDOUT Path Win32_Processor Get LoadPercentage /Format:LIST') DO SET CPULoad=%%A

SET CPULoad
