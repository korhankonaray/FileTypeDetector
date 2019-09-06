@ECHO OFF
:: Windows NT / 2000 / XP only
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: One command line parameter only
IF     "%~1"=="" GOTO Syntax
IF NOT "%~2"=="" GOTO Syntax

:: Display help if requested
ECHO "%~1" | FIND "?" >NUL
IF NOT ERRORLEVEL 1 GOTO Syntax
ECHO "%~1" | FIND "/" >NUL
IF NOT ERRORLEVEL 1 GOTO Syntax

:: Check if command line parameter is a valid number
ECHO "%~1"| FINDSTR /R /B /C:"\"[0-9]*\"$" >NUL
IF ERRORLEVEL 1 GOTO Syntax

:: Enable delayed variable expansion
SETLOCAL ENABLEDELAYEDEXPANSION

:: Use PING to split the number into 4 2-digit hexadecimal numbers that
:: are displayed again as 4 decimal numbers from 0 to 255 (FOD or Four
:: Octet Decimal)
FOR /F "tokens=2 delims= " %%A IN ('PING %1 -n 1 -w 1 2^>NUL') DO IF "!FOD!"=="" SET FOD=%%A
FOR /F "tokens=1-4 delims=." %%A IN ('ECHO.%FOD%') DO (
	IF "%%~D"=="" (
		ENDLOCAL
		GOTO Syntax
	) ELSE (
		CALL :D2H TmpA %%A
		CALL :D2H TmpB %%B
		CALL :D2H TmpC %%C
		CALL :D2H TmpD %%D
	)
)

:: Display the end result
ECHO.%1 = 0x%TmpA%%TmpB%%TmpC%%TmpD%

:: Done
ENDLOCAL
GOTO:EOF


:D2H
:: Split the number (0-255) into 2 single "digits"
SET /A Tmp2 = %2 / 16
SET /A Tmp1 = %2 - 16 * %Tmp2%
:: Convert decimal 0-15 to single digit hexadecimal
SET Cvt=0123456789ABCDEF
SET Tmp1=!Cvt:~%Tmp1%,1!
SET Tmp2=!Cvt:~%Tmp2%,1!
:: Concatenate the 2 hexadecimal digits
SET %1=%Tmp2%%Tmp1%
GOTO:EOF


:Syntax
ECHO.
ECHO Dec2Hex.bat,  Version 2.10 for Windows NT 4 / 2000 / XP
ECHO Convert a decimal number to 8 digit hexadecimal
ECHO.
ECHO Usage:  DEC2HEX  number
ECHO.
ECHO Where:  "number" is a decimal number ranging from 0 to 4,294,967,294
ECHO.
ECHO         This batch file (ab)uses PING for the first step in the decimal to
ECHO         hexadecimal conversion: PING splits up any decimal number into 4
ECHO         2-digit hexadecimal numbers, that are then displayed as 4 decimal
ECHO         numbers again. These 4 decimal numbers are then converted to 2-digit 
ECHO         hexadecimal again by the rest of the batch file.
ECHO         PING cannot handle 0xFFFFFFFF (DHCP broadcast address), so the highest
ECHO         valid number is 4,294,967,294 (0xFFFFFFFE or 2**32 - 2).
ECHO         This batch file uses FINDSTR to check the validity of the command
ECHO         line argument.
ECHO         For decimal numbers below 2,147,483,647 you can also use my
ECHO         DecToHex.bat, which uses CMD.EXE's internal commands only.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
