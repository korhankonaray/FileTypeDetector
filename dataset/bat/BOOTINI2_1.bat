@ECHO OFF
ECHO.

:: No command line parameters needed:
IF NOT "%1"=="" GOTO Syntax

:: Windows NT only:
VER | FIND "Windows NT" >NUL
IF ERRORLEVEL 1 GOTO Syntax

:: Check if BOOT.INI exists; if it doesn't,
:: display a warning message and quit:
IF NOT EXIST %SystemDrive%\BOOT.INI (ECHO BOOT.INI not found.&ECHO Correct the problem and try again.&GOTO:EOF)

:: Check if backup file exists; if it does,
:: display a warning message and quit:
IF EXIST %SystemDrive%\BOOT.BAK (ECHO Backup of BOOT.INI ^(BOOT.BAK^) already exists.&ECHO Rename it and try again.&GOTO:EOF)

:: Display original file:
ECHO Original BOOT.INI:
ECHO.
TYPE %SystemDrive%\BOOT.INI
ECHO.

:: Check if this update has been done before,
:: to prevent adding the switch more than once:
TYPE %SystemDrive%\BOOT.INI | FIND /I " /NoSerialMice" >NUL
:: If the update has been done before, display a message and quit:
IF NOT ERRORLEVEL 1 (ECHO The "/NoSerialMice" switch has been added before.&ECHO Aborting...&GOTO End)

:: Remove file attributes:
ATTRIB -H -S -R %SystemDrive%\BOOT.INI
:: Rename BOOT.INI for backup purposes:
REN %SystemDrive%\BOOT.INI *.BAK
:: Read renamed BOOT.INI and write each line to the
:: new BOOT.INI, only adding the /NoSerialMice value:
(FOR /F "tokens=1* delims==" %%A IN (%SystemDrive%\BOOT.BAK) DO (
	IF "%%B"=="" (
		ECHO %%A
	) ELSE (
		ECHO.%%A | FIND "partition" >NUL
		IF ERRORLEVEL 1 (
			ECHO %%A=%%B
		) ELSE (
			ECHO %%A=%%B /NoSerialMice
		)
	)
))>%SystemDrive%\BOOT.INI

:: Restore the file attributes:
ATTRIB +H +S +R %SystemDrive%\BOOT.INI

:: Display the modifications:
ECHO Modified BOOT.INI:
ECHO.
TYPE %SystemDrive%\BOOT.INI
ECHO.

:: Safety check; if BOOT.INI exists end program, otherwise restore the backup:
IF EXIST %SystemDrive%\BOOT.INI GOTO End

:: If you arrived here, BOOT.INI wasn't found and needs to be restored:
:Restore
ECHO Restoring original BOOT.INI
COPY %SystemDrive%\BOOT.BAK %SystemDrive%\BOOT.INI

:: End program
:End
GOTO:EOF

:Syntax
ECHO BOOTINI2.BAT,  Version 2.01 for Windows NT
ECHO Adds /NoSerialMice switch to the operating system lines in BOOT.INI.
ECHO The original BOOT.INI is stored as BOOT.BAK.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
ECHO.
ECHO DISCLAIMER:
ECHO Incorrect changes to BOOT.INI may prevent the system to boot next time.
ECHO Use this tool entirely at your own risk.
ECHO Do not use this tool unless you know how to repair any possible damage.
GOTO:EOF
