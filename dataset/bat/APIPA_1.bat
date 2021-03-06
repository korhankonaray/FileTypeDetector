@ECHO OFF
:: Check Windows version and command line
IF NOT [%1]==[] IF NOT [%1]==[0] IF NOT [%1]==[1] GOTO Syntax
IF NOT [%2]==[] IF /I NOT [%2]==[/Y] GOTO Syntax
IF NOT "%OS%"=="Windows_NT" GOTO Syntax
VER | FIND "Windows 2000" >NUL
IF NOT ERRORLEVEL 1 GOTO Begin
VER | FIND "Windows XP" >NUL
IF ERRORLEVEL 1 GOTO Syntax

:Begin
SETLOCAL ENABLEEXTENSIONS
:: Save command line parameter
SET Enable=%1
SET Force=%2

:: Make sure the impact of this batch file is understood
IF DEFINED Enable IF NOT DEFINED Force CALL :Disclaimer
IF [%Exit%]==[1] GOTO:EOF

:: Initialize variables
SET Agreed=NO
SET Count=0
SET Exit=0
SET Restore=0
SET RollBackDir=%Temp%.
TYPE NUL > _ApipaRollBack.txt 2>NUL
IF NOT ERRORLEVEL 1 (
	DEL _ApipaRollBack.txt
	SET RollBackDir=.
)
SET Title=The following interface^^(s^^) with IP Autoconfiguration settings was/were found:

:: Enumerate interfaces
REGEDIT /E %Temp%.\apipaorg.reg "HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\TCPIP\Parameters\Interfaces"
FOR /F "tokens=8 delims=\" %%A IN ('TYPE %Temp%.\apipaorg.reg ^| FIND "[HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\TCPIP\Parameters\Interfaces\"') DO CALL :Enum "%%A"

:: Search for APIPA in each interface
FOR /L %%A IN (1,1,%Count%) DO CALL :FindApipa "%%Interface.%%A%%"

:: Done
ENDLOCAL
GOTO:EOF


:: End of main batch procedure


:: Subroutines


:Enum
:: Store interface "name" in array
SET /A Count += 1
SET Interface=%~1
SET Interface.%Count%=%Interface:]=%
GOTO:EOF


:FindApipa
IF [%Exit%]==[1] GOTO:EOF
:: Check if Autoconfiguration is specified for this interface
REGEDIT /E %Temp%.\_apipa.reg "HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\TCPIP\Parameters\Interfaces\%~1"
TYPE %Temp%.\_apipa.reg | FIND /I "IPAutoconfiguration" >NUL
:: If not, then leave
IF ERRORLEVEL 1 GOTO:EOF
:: Display some IP settings for this interface,
:: to make sure we are going to edit the right one.
:: Display and reset title
ECHO.
IF DEFINED Title (
	ECHO.%Title%
	SET Title=
	ECHO.
)
:: Display "header"
TYPE %Temp%.\_apipa.reg | FIND /I "[HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\TCPIP\Parameters\Interfaces\%~1"
:: Convert IP addresses from hexadecimal to decimal
FOR /F "tokens=2 delims=:" %%A IN ('TYPE %Temp%.\_apipa.reg ^| FIND /I "IPAddress" ^| FIND "hex("') DO CALL :X2D "%%A"
:: Display converted IP addresses
FOR /F "tokens=1,2* delims==" %%A IN ('TYPE %Temp%.\_apipa.reg ^| FIND /I "IPAddress" ^| FIND "hex("') DO ECHO %%~A=%IPAddress%
:: Display IP addresses that were already stored in decimal
FOR /F "tokens=1* delims==" %%A IN ('TYPE %Temp%.\_apipa.reg ^| FIND /I "IPAddress" ^| FIND /I /V "hex("') DO ECHO %%~A=%%~B
:: Display current Autoconfiguration settings
FOR /F "tokens=1* delims==" %%A IN ('TYPE %Temp%.\_apipa.reg ^| FIND /I "IPAutoconfiguration"') DO ECHO %%~A=%%~B
ECHO.
IF DEFINED Enable CALL :Confirm "%~1"
GOTO:EOF


:Confirm
IF DEFINED Force GOTO SkipConf
SET Message=Are you sure you want to
IF %Enable%==0 (
	SET Message=%Message% disable
) ELSE (
	SET Message=%Message% enable
)
(SET Message=%Message% IP Autoconfiguration? [Yes/No] )
SET /P Continue=%Message%
SET Continue=%Continue:~0,1%
IF /I NOT [%Continue%]==[Y] GOTO:EOF
:SkipConf
CALL :Settings "%~1"
GOTO:EOF


:Settings
:: Create temporary .REG file to change the settings
> %Temp%.\Apipa%Count%.reg ECHO REGEDIT4
>>%Temp%.\Apipa%Count%.reg ECHO.
>>%Temp%.\Apipa%Count%.reg ECHO [HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\TCPIP\Parameters\Interfaces\%~1]
>>%Temp%.\Apipa%Count%.reg ECHO "IPAutoconfigurationEnabled"=dword:0000000%Enable%
>>%Temp%.\Apipa%Count%.reg ECHO.
START /WAIT REGEDIT /S %Temp%.\Apipa%Count%.reg
DEL %Temp%.\Apipa%Count%.reg
REGEDIT /E %Temp%.\Apipa%Count%.reg "HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\TCPIP\Parameters\Interfaces\%~1"
ECHO Checking new setting:
TYPE %Temp%.\Apipa%Count%.reg | FIND "IPAutoconfigurationEnabled"
IF ERRORLEVEL 1 (
	ECHO Error modifying registry setting.
	ECHO Start REGEDIT and check the following key:
	ECHO HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\TCPIP\Parameters\Interfaces\%~1
	ECHO IPAutoconfigurationEnabled
	ECHO.
	ECHO At startup of this batch file your original settings were backed up in:
	ECHO.
	ECHO %Temp%.\apipaorg.reg
	ECHO.
	ECHO This file can be used to restore your original settings, either manually by
	ECHO doubleclicking it, or automatically by this batch file.
	SET /P Restore=Would you like to automatically restore your original settings now? [Yes/No] 
	SET Restore=%Restore:~0,1%
	IF /I [%Restore%]==[/Y] REGEDIT /S %Temp%.\apipaorg.reg
	ECHO.
	SET /P Restore=Would you like to abort this batch file now? [Yes/No] 
	SET Restore=%Restore:~0,1%
	IF /I [%Restore%]==[/Y] SET Exit=1
)
IF [%Exit%]==[1] GOTO:EOF
:: Create rollback file
> "%RollBackDir%\ApipaRollback.reg" ECHO REGEDIT4
>>"%RollBackDir%\ApipaRollback.reg" ECHO.
>>"%RollBackDir%\ApipaRollback.reg" ECHO [HKEY_LOCAL_MACHINE\System\CurrentControlSet\Services\TCPIP\Parameters\Interfaces\%~1]
>>"%RollBackDir%\ApipaRollback.reg" ECHO "IPAutoconfigurationEnabled"=-
>>"%RollBackDir%\ApipaRollback.reg" ECHO.
ECHO.
ECHO A rollback file has been created:
ECHO "%RollBackDir%\ApipaRollback.reg"
ECHO.
ECHO Either doubleclick this file to restore Windows' default APIPA settings,
ECHO or run the following command from a command prompt:
ECHO.
ECHO REGEDIT /S "%RollBackDir%\ApipaRollback.reg"
ECHO.
IF NOT DEFINED Force PAUSE
GOTO:EOF


:X2D
:: Convert IP address from hexadecimal to decimal
SET IPAddress=%~1
SET IPAddress=%IPAddress:,00=,%
SET IPAddress=%IPAddress:2e,=.,%
SET IPAddress=%IPAddress:30,=0,%
SET IPAddress=%IPAddress:31,=1,%
SET IPAddress=%IPAddress:32,=2,%
SET IPAddress=%IPAddress:33,=3,%
SET IPAddress=%IPAddress:34,=4,%
SET IPAddress=%IPAddress:35,=5,%
SET IPAddress=%IPAddress:36,=6,%
SET IPAddress=%IPAddress:37,=7,%
SET IPAddress=%IPAddress:38,=8,%
SET IPAddress=%IPAddress:39,=9,%
SET IPAddress=%IPAddress:,=%
GOTO:EOF


:Disclaimer
CLS
ECHO.
ECHO APIPA.BAT,  Version 1.00 for Windows 2000 / XP
ECHO Display or modify APIPA settings (Automatic Private IP Addressing)
ECHO.
ECHO * * What is APIPA? * *
ECHO APIPA or Automatic Private IP Addressing is the mechanism in Windows 2000
ECHO and XP DHCP clients that automatically configures these clients to use an
ECHO IP address from the private range 169.254.*.* whenever a DHCP server is
ECHO not available.
ECHO More details are available at the following URLs:
ECHO http://webopedia.internet.com/TERM/A/APIPA.html
ECHO http://www.win2000mag.com/Articles/Index.cfm?ArticleID=7464
ECHO.
ECHO * * Why would I want to disable it? * *
ECHO Though APIPA may be great for stand-alone computers or small networks, it
ECHO will cause problems both on large networks and on small networks using a
ECHO shared cable or DSL connection.
ECHO Disabling APIPA will result in DHCP error messages whenever a DHCP server
ECHO is not available. Using APIPA may result in network error messages
ECHO whenever you try to connect to another computer on your network or on the
ECHO internet.
ECHO It's up to you to decide which option you prefer.
ECHO.
PAUSE
CLS
ECHO.
ECHO APIPA.BAT,  Version 1.00 for Windows 2000 / XP
ECHO Display or modify APIPA settings (Automatic Private IP Addressing)
ECHO.
ECHO * * Is it safe to disable APIPA? * *
ECHO Disabling APIPA does not seem to impose any risk. After all, we have done
ECHO without it for over two decades. However, disabling APIPA means modifying
ECHO the registry. Though hundreds of modifications are made every day on every
ECHO computer running Windows, it is NEVER without risk! Modifying the registry
ECHO incorrectly may make your computer inaccessible, forcing you to reinstall
ECHO Windows from scratch, thereby possibly losing data and settings.
ECHO.
ECHO * * DISCLAIMER * *
ECHO I have done my utmost best to prevent damage and to enable simple
ECHO rollbacks. However, I cannot guarantee that this batch file will function
ECHO correctly on every computer. I cannot take any responsibility for damage
ECHO caused by the use of, or inability to use this batch file or its rollback
ECHO script. Use this batch file entirely at your own risk.
ECHO.
ECHO Type YES and press Enter if you have read and understood these terms,
ECHO and agree to them:
SET /P Agreed=
IF /I NOT [%Agreed%]==[YES] (
	ECHO Canceled on user's request.
	ENDLOCAL
	SET Exit=1
)
CLS
GOTO:EOF


:Syntax
IF "%OS%"=="Windows_NT" CALL :Disclaimer
ECHO.
ECHO APIPA.BAT,  Version 1.00 for Windows 2000 / XP
IF     "%OS%"=="Windows_NT" ECHO Display or modify APIPA settings ^(Automatic Private IP Addressing^)
IF NOT "%OS%"=="Windows_NT" ECHO Display or modify APIPA settings (Automatic Private IP Addressing)
ECHO.
IF     "%OS%"=="Windows_NT" ECHO Usage:  %~n0  [ 0 ^| 1  [ /Y ] ]
IF NOT "%OS%"=="Windows_NT" ECHO Usage:  %~n0  [ 0 or 1  [ /Y ] ]
ECHO.
ECHO     No parameters     Display current settings for each interface
ECHO     0                 Disable APIPA for current interface
ECHO     1                 Enable APIPA for current interface
IF "%OS%"=="Windows_NT" ECHO     /Y                Do not ask for confirmation ^(valid with 0 or 1 only^)
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
ECHO.


:End
