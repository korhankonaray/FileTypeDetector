@GOTO :Batch

a 0100
MOV AH, 09
MOV DX, 0000
INT 21
RET
DB "ÿþ$"

a 102
MOV DX, 108

u 0100
n C:\UNIHD.COM
r BX
0
r CX
B
w
q

:Batch
@ECHO OFF
:: Requires "CMD based" Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
:: ASCII file must be specified and must exist
IF "%~1"=="" GOTO Syntax
IF NOT EXIST "%~1" GOTO Syntax

SETLOCAL
SET ASCIIFile=%~1
IF "%~2"=="" (SET UnicodeFile=%~n1_Unicode.%~x1) ELSE (SET UnicodeFile=%~2)

:: DEBUG won't work on 64-bit Windows
IF "%ProgramFiles(x86)%"=="" (CALL :Header32) ELSE (CALL :Header64)

:: ASCII to Unicode conversion with CMD /U /C (after first
:: creating a 2-byte header containing character 0xFF and
:: 0xFE) as discovered by Jacques Bensimon.
CMD.EXE /U /C TYPE "%ASCIIFile%" >> "%UnicodeFile%"
ENDLOCAL
GOTO:EOF


:Header32
:: DEBUG script code based on an article by "JustBurn":
:: http://www.instructables.com/id/How-to-write-the-world-s-smallest-%22Hello-World!%22-e/
:: Feel free to customize the path where UNIHD.COM will be stored (line 14: "n C:\UNIHD.COM").
::
:: Use the "embedded" DEBUG script to create the 11 byte UNIHD.COM
DEBUG < %~sf0 >NUL 2>&1
:: Redirect UNIHD.COM's output to write the 0xFF and 0xFE
:: characters to the target file
C:\unihd.com > "%UnicodeFile%"
GOTO:EOF


:Header64
:: Unfortunately ECHOing the header will insert an extra line break
IF EXIST "%~dpn0.header" (
	COPY "%~dpn0.header" "%UnicodeFile%" >NUL 2>&1
) ELSE (
	ECHO.ÿþ> "%UnicodeFile%"
)
GOTO:EOF


:Syntax
ECHO.
ECHO ASCII2Uc.bat,  Version 2.01 for Windows NT 4 and later
ECHO Converts an ASCII text file to valid Unicode
ECHO.
ECHO Usage:  ASCII2UC  ascii_file  [ unicode_file ]
ECHO.
ECHO Where:  ascii_file    (mandatory) name of the ASCII source file
ECHO         unicode_file  (optional) name of the Unicode target file (default:
ECHO                       the name of the source file with "_Unicode" appended)
ECHO.
ECHO Notes:
ECHO [1] ASCII to Unicode conversion command and header by Jacques Bensimon.
ECHO [2] For 32-bit Windows versions, the Unicode file header is created by an
ECHO     "embedded" DEBUG script.
ECHO     In 64-bit Windows versions either an "external" header file or ECHO is used
ECHO     to create the header.
ECHO     Unfortunately, ECHO inserts an extra line break before the original text.
ECHO [3] The path of the temporary file is hard coded in the embedded DEBUG script.
ECHO [4] DEBUG script code based on an article by "JustBurn":
ECHO     www.instructables.com/id/How-to-write-the-world-s-smallest-"Hello-World!"-e
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
