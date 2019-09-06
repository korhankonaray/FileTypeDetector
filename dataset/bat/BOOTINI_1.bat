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

:: Remove file attributes:
ATTRIB -H -S -R %SystemDrive%\BOOT.INI
:: Rename BOOT.INI for backup purposes:
REN %SystemDrive%\BOOT.INI *.BAK
:: Read renamed BOOT.INI and write each line to the
:: new BOOT.INI, modifying only the timeout value:
(FOR /F "tokens=1* delims==" %%A IN (%SystemDrive%\BOOT.BAK) DO IF "%%B"=="" (ECHO %%A) ELSE (IF /I "%%A"=="timeout" (ECHO %%A=5) ELSE (ECHO %%A=%%B)))>%SystemDrive%\BOOT.INI
:: Restore the file attributes:
ATTRIB +H +S +R %SystemDrive%\BOOT.INI

:: Display the modifications:
ECHO Modified BOOT.INI:
ECHO.
TYPE %SystemDrive%\BOOT.INI
ECHO.

:: Safety check; if no BOOT.INI exists, restore the backup:
IF NOT EXIST %SystemDrive%\BOOT.INI (ECHO Restoring original BOOT.INI&COPY %SystemDrive%\BOOT.BAK %SystemDrive%\BOOT.INI)

:: End program
GOTO:EOF

:Syntax
ECHO BOOTINI.BAT,  Version 1.00 for Windows NT
ECHO Changes BOOT.INI's timeout value to 5 seconds.
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
