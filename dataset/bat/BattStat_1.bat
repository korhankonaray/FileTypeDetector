@ECHO OFF
:: Check for Windows NT 4 or later (though XP or later is required)
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Localize variables
SETLOCAL

:: No command line arguments required
IF NOT "%~1"=="" GOTO Syntax

:: Check if WMIC.EXE is available
WMIC.EXE Alias /?:Brief >NUL 2>&1 || GOTO Syntax

:: Use WMI to retrieve battery status information
FOR /F "tokens=1* delims==" %%A IN ('WMIC /NameSpace:"\\root\WMI" Path BatteryStatus              Get Charging^,Critical^,Discharging /Format:list ^| FIND "=TRUE"') DO ECHO Battery is %%A
FOR /F "tokens=*  delims="  %%A IN ('WMIC /NameSpace:"\\root\WMI" Path BatteryStatus              Get PowerOnline^,RemainingCapacity  /Format:list ^| FIND "="')     DO SET  Battery.%%A
FOR /F "tokens=*  delims="  %%A IN ('WMIC /NameSpace:"\\root\WMI" Path BatteryRuntime             Get EstimatedRuntime                /Format:list ^| FIND "="')     DO SET  Battery.%%A
FOR /F "tokens=*  delims="  %%A IN ('WMIC /NameSpace:"\\root\WMI" Path BatteryFullChargedCapacity Get FullChargedCapacity             /Format:list ^| FIND "="')     DO SET  Battery.%%A

:: Calculate runtime left and capacity
SET /A Battery.EstimatedRuntime  = ( %Battery.EstimatedRuntime% + 30 ) / 60
SET /A Battery.RemainingCapacity = ( %Battery.RemainingCapacity%00 + %Battery.FullChargedCapacity% / 2 ) / %Battery.FullChargedCapacity%

:: Display results
IF /I "%Battery.PowerOnline%"=="TRUE" (
	ECHO Now working on mains power
	ECHO Battery %Battery.RemainingCapacity%%% charged
) ELSE (
	ECHO Estimated remaining runtime %Battery.EstimatedRuntime% minutes
	ECHO Remaining capacity %Battery.RemainingCapacity%%%
)
GOTO:EOF


:Syntax
ECHO.
ECHO BattStat.bat,  Version 1.00 for Windows XP Pro or later
ECHO Display current battery status for the local computer
ECHO.
ECHO Usage:  BATTSTAT
ECHO.
ECHO Note:   Uses WMIC to query the battery status;
ECHO         WMIC is native in Windows XP Professional,
ECHO         Windows Server 2003 and Windows Vista.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

:: End localization
IF "%OS%"=="Windows_NT" ENDLOCAL
