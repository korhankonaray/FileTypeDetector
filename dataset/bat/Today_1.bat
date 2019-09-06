@GOTO Run

o 70 06
i 71
o 70 07
i 71
o 70 08
i 71
o 70 09
i 71
o 70 32
i 71

q

:Run
@ECHO OFF
SETLOCAL ENABLEDELAYEDEXPANSION
SET Weekday.00=Saturday
SET Weekday.01=Sunday
SET Weekday.02=Monday
SET Weekday.03=Tuesday
SET Weekday.04=Wednesday
SET Weekday.05=Thursday
SET Weekday.06=Friday
SET Weekday.07=Saturday
SET Params=0
SET Delim=
SET Sorted=1
SET Weekday=0
SET W=
SET D=
SET M=
SET Y=
SET C=
ECHO.%* | FINDSTR /R /C:"[/-]?" >NUL && GOTO Syntax
ECHO %~1 | FINDSTR /R /B /C:"/" >NUL
IF ERRORLEVEL 1 (
	SET Delim=%~1
	SET /A Params += 1
) ELSE (
	IF "%~1"=="/" SET Delim=/
)
ECHO.%* | FIND /I "/NS" >NUL
IF NOT ERRORLEVEL 1 (
	SET Sorted=0
	SET /A Params += 1
)
ECHO.%* | FIND /I "/WN" >NUL
IF NOT ERRORLEVEL 1 (
	SET Weekday=1
	SET /A Params += 1
)
ECHO.%* | FIND /I "/WS" >NUL
IF NOT ERRORLEVEL 1 (
	SET Weekday=2
	SET /A Params += 1
)
IF %Params% GTR 0 SET /A Params += 1
IF "%Params%" GTR 1 CALL IF NOT "%%~%Params%"=="" GOTO Syntax

FOR /F "skip=1" %%A IN ('DEBUG ^< "%~fs0" ^| FIND /V "-"') DO (
	IF "!W!"=="" (
		SET W=%%A
	) ELSE (
		IF "!D!"=="" (
			SET D=%%A
		) ELSE (
			IF "!M!"=="" (
				SET M=%%A
			) ELSE (
				IF "!Y!"=="" (
					SET Y=%%A
				) ELSE (
					SET C=%%A
				)
			)
		)
	)
)

IF "%Sorted%"=="1" (SET Today=%C%%Y%%Delim%%M%%Delim%%D%) ELSE (SET Today=%D%%Delim%%M%%Delim%%C%%Y%)
IF "%Weekday%"=="1" SET Today=%W% %Today%
IF "%Weekday%"=="2" SET Today=!Weekday.%W%! %Today%
ECHO.%Today%

ENDLOCAL
GOTO:EOF

:Syntax
ECHO Today.bat,  Version 1.10 for Windows 2000 and later
ECHO Display the current date with your choice of delimiter
ECHO.
ECHO Usage:    TODAY  [ delimiter ]  [ /NS ]  [ /WN ^| /WS ]
ECHO.
ECHO Where:    delimiter  is any character or string to be used as output delimiter
ECHO           /NS        displays date in DD MM YYYY order ^(default is YYYY MM DD^)
ECHO           /WN        displays the day of the week too, as a number
ECHO           /WS        displays the day of the week too, as a string
ECHO.
FOR /F "tokens=1-5" %%A IN ('%~sf0 ^" ^" /WN') DO (
	ECHO Returns:  %%A %%B %%C %%D ^(weekday YYYY MM DD^) with any delimiter you choose
	ECHO.
	ECHO Examples: TODAY - /NS /WS -^>  !Weekday.%%A! %%D-%%C-%%B
	ECHO           TODAY / /WN     -^>  %%A %%B/%%C/%%D
	ECHO           TODAY " " /NS   -^>  %%D %%C %%B
	ECHO           TODAY           -^>  %%B%%C%%D
)
ECHO.
ECHO Sources:
ECHO http://mirror.href.com/thestarman/asm/debug/debug2.htm
ECHO http://www.plasma-online.de/textual/download/misc/cmos_registers.html
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
