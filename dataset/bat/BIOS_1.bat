@ECHO OFF
:: WMI query to list all properties and values of the Win32_BIOS class
:: This batch file was generated using the WMI Code Generator, Version 1.30
:: http://www.robvanderwoude.com/updates/wmigen.html

IF "%~1"=="" (
	SET Node=%ComputerName%
) ELSE (
	SET Node=%~1
)

WMIC.EXE /Node:%Node% /Output:STDOUT Path Win32_BIOS Get Name,Version,Manufacturer,SMBIOSBIOSVersion /Format:LIST
