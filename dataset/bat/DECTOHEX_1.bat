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

:: Enable delayed variable expansion
SETLOCAL ENABLEDELAYEDEXPANSION
:: Check if command line parameter is a valid number
SET /A X = %1 >NUL 2>&1
IF NOT "%X%"=="%~1" (
	ENDLOCAL
	GOTO Syntax
)
IF %1 LSS 0 (
	ENDLOCAL
	GOTO Syntax
)

SET Hex=
SET Cvt=0123456789ABCDEF

SET /A Tmp0 = %1

:Loop
:: Get the last (least significant) digit
SET /A Tmp1 = %Tmp0% / 16
SET /A Tmp2 = %Tmp0% - 16 * %Tmp1%
:: Convert that last digit (still decimal) to hexadecimal
SET Tmp2=!Cvt:~%Tmp2%,1!
:: Prepend it to the intermediate hexadecimal result
SET Hex=%Tmp2%%Hex%
:: Remove the last digit from the original number
SET Tmp0=%Tmp1%
:: If there are any digits left, loop once more
IF %Tmp0% GTR 0 GOTO Loop

:: Display the end result
ECHO.%1 = 0x%Hex%

:: Done
ENDLOCAL
GOTO:EOF


:Syntax
ECHO.
ECHO DecToHex.bat,  Version 1.01 for Windows NT 4 / 2000 / XP
ECHO Convert a decimal number to "7.5" digit hexadecimal
ECHO.
ECHO Usage:  DECTOHEX  number
ECHO.
ECHO Where:  "number" is a decimal number ranging from 0 to 2,147,483,647
ECHO                                            (0x7FFFFFFF or 2**31 - 1)
ECHO.
ECHO         This batch file uses CMD.EXE's internal commands only.
ECHO         For numbers up to 4,294,967,294 (0xFFFFFFFE or 2**32 - 2)
ECHO         you can use my Dec2Hex.bat, which uses PING and FINDSTR.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
