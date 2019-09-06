@ECHO OFF
:: Check Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: First command line check
IF NOT "%~2"=="" GOTO Syntax

:: Thorough command line check
ECHO.%~1| FINDSTR /R /B /I /C:"[A-Z0-9_-]*$" >NUL
IF ERRORLEVEL 1 GOTO Syntax

:: Proceed
SETLOCAL ENABLEDELAYEDEXPANSION

:: Determine name of computer to be investigated
IF "%~1"=="" (
	SET Computer=%ComputerName%
) ELSE (
	SET Computer=%~1
)

:: Find the network adapter link speed
FOR /F "tokens=1* delims==" %%A IN ('WMIC.EXE /Node:"%Computer%" /NameSpace:\\root\WMI Path MSNdis_EthernetCurrentAddress Where "Active='TRUE'" Get InstanceName /Format:LIST ^| FIND "="') DO (
	REM * * * * * *  Chomp off the trailing CR/LF  * * * * * *
	FOR /F "tokens=*" %%C IN ("%%~B") DO (
		FOR /F "tokens=1* delims==" %%D IN ('WMIC.EXE /Node:"%Computer%" /NameSpace:\\root\CIMV2 Path Win32_NetworkAdapter Where "(AdapterTypeId='0' And Name='%%~C' And PhysicalAdapter='TRUE')" Get Name /Format:LIST 2^>NUL ^| FIND "="') DO (
			REM * * * * * *  Chomp off the trailing CR/LF  * * * * * *
			FOR /F "tokens=*" %%F IN ("%%~E") DO (
				FOR /F "tokens=1* delims==" %%G IN ('WMIC.EXE /Node:"%Computer%" /NameSpace:\\root\CIMV2 Path Win32_NetworkAdapter Where "(Name='%%~F' And PhysicalAdapter='TRUE' And AdapterTypeId=0)" Get Name /Format:LIST 2^>NUL ^| FIND "="') DO (
					REM * * * * * *  Chomp off the trailing CR/LF  * * * * * *
					FOR /F "tokens=*" %%I IN ("%%~H") DO (
						SET InstanceName=
						SET NdisLinkSpeed=
						SET Multiplier=k
						FOR /F "tokens=*" %%J IN ('WMIC.EXE /Node:"%Computer%" /NameSpace:\\root\WMI Path MSNdis_LinkSpeed Where "InstanceName='%%~I'" Get InstanceName^,NdisLinkSpeed /Format:LIST 2^>NUL ^| FIND "="') DO (
							REM * * * * * *  Chomp off the trailing CR/LF  * * * * * *
							FOR /F "tokens=*" %%K IN ("%%~J") DO (
								SET %%K
							)
						)
						REM * * * * * *  If over 1000 kb/s display in Mb/s  * * * * * *
						IF !NdisLinkSpeed! GTR 1000 (
							SET /A NdisLinkSpeed = !NdisLinkSpeed! + 500
							SET /A NdisLinkSpeed = !NdisLinkSpeed! / 1000
							SET Multiplier=M
						)
						REM * * * * * *  If over 1000 Mb/s display in Gb/s  * * * * * *
						IF !NdisLinkSpeed! GTR 1000 (
							SET /A NdisLinkSpeed = !NdisLinkSpeed! + 500
							SET /A NdisLinkSpeed = !NdisLinkSpeed! / 1000
							SET Multiplier=G
						)
						REM * * * * * *  Display results  * * * * * *
						ECHO NIC   : !InstanceName!
						ECHO Speed : !NdisLinkSpeed! !Multiplier!b/s
						ECHO.
					)
				)
			)
		)
	)
)

ENDLOCAL
GOTO:EOF


:Syntax
ECHO.
ECHO NICSpeed.bat,  Version 1.00 for Windows XP Professional and later
ECHO Display active Ethernet adapters' link speed
ECHO.
ECHO Usage:  NICSPEED.BAT  [ remote_computer ]
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
