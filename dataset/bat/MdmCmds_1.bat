@ECHO OFF
:: Check Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Use local ERROR variable
SETLOCAL
SET Error=0

:: Check command line arguments (none required)
IF NOT "%~1"=="" GOTO Syntax

:: Display header
FOR /F "tokens=1* delims==" %%A IN ('WMIC Path Win32_POTSModem Get Model /Format:list 2^>NUL ^| FIND "="') DO (
	ECHO.
	ECHO Configuration commands for %%B
	ECHO.
	FOR /F "tokens=*" %%C IN ('ECHO.%%B') DO (
		WMIC Path Win32_POTSModem Where "Model='%%C'" Get BlindOff,BlindOn,CompressionOff,CompressionOn,ErrorControlForced,ErrorControlOff,ErrorControlOn,FlowControlHard,FlowControlOff,FlowControlSoft,ModulationBell,ModulationCCITT,Prefix,Pulse,Reset,SpeakerModeDial,SpeakerModeOff,SpeakerModeOn,SpeakerModeSetup,SpeakerVolumeHigh,SpeakerVolumeLow,SpeakerVolumeMed,Terminator,Tone /Format:list | FIND "="
		IF ERRORLEVEL 1 SET Error=1
	)
)

:: Final check for WMIC errors
IF "%Error%"=="1" GOTO Syntax

:: Done
ENDLOCAL
GOTO:EOF


:Syntax
ECHO.
ECHO MdmCmds.bat,  Version 1.00 for Windows XP Professional and later
ECHO Display the (AT) configuration commands available for your modem(s).
ECHO.
ECHO Usage:  MDMCMDS
ECHO.
ECHO Note:   This batch file uses WMIC.EXE, which is available
ECHO         in Windows XP Professional and Windows Server 2003
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
IF "%OS%"=="Windows_NT" ENDLOCAL
EXIT /B 1
