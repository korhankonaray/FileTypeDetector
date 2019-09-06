@ECHO OFF
:: Check Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Use variables locally
SETLOCAL ENABLEDELAYEDEXPANSION

:: Check if FINDSTR and WMIC are available
FINDSTR.EXE /? >NUL 2>&1 || GOTO Syntax
WMIC.EXE    /? >NUL 2>&1 || GOTO Syntax

:: Set initial and default values
SET _40_Spaces=                                        % 40 spaces %
SET idxCDROM=0
SET idxCPU=0
SET idxHDD=0
SET idxNIC=0
SET idxVDU=0
SET Node=%ComputerName%

:: Check command line argument
IF NOT "%~2"=="" GOTO Syntax
ECHO.%* | FINDSTR.EXE /R /C:"[/?]" >NUL && GOTO Syntax
IF "%~1"=="" (SET Node=%ComputerName%) ELSE (SET Node=%~1)

:: Check validity of node name
ECHO.%Node%| FINDSTR.EXE /R /C:"[/?*,;:/\\&<>+ ]" >NUL && GOTO Syntax
PING %Node% -n 2 2>NUL | FIND "TTL=" >NUL || GOTO Syntax

:: Initialize log file
FOR /F "skip=2 tokens=2-7 delims=," %%A IN ('WMIC Path Win32_LocalTime Get Day^,Hour^,Minute^,Month^,Second^,Year /Format:csv') DO (
	SET Today=%%F%%D%%A
	SET Now=%%B%%C%%E
)
SET Log=Hardware_%Today%_%Now%.csv

IF NOT "%Debug%"=="" (
	SET Log
)

:: Create a header with the computer name
CALL :CreateLine "Host" "Name=%ComputerName%"
SET csvHostName=%Value%
SET hdrHostName=%csvProperty%

IF NOT "%Debug%"=="" (
	SET csvHostName
	SET hdrHostName
)

:: Run inventory; Component Subroutine's 4th argument may be modified to change the detail level; See comments in Component Subroutine
CALL :Component "BaseBoard"                 "BaseBoard"     "Manufacturer Product Version"                                        "0"
CALL :Chassis
CALL :Component "CPU"                       "CPU"           "Name CurrentClockSpeed Manufacturer MaxClockSpeed SocketDesignation" "2"
CALL :Component "Win32_PhysicalMemoryArray" "Memory"        "MemoryDevices"                                                       "0" "Banks"
CALL :Component "Win32_PhysicalMemory"      "Memory Module" "Capacity"                                                            "3"
CALL :Component "Win32_PhysicalMemory"      "Memory Module" "Speed"                                                               "4"
CALL :HardDisk
CALL :CDROM
CALL :Component "Win32_VideoController"     "VideoCard"     "AdapterRAM Name VideoModeDescription"                                "2"
CALL :NIC
CALL :Ports
CALL :Slots
CALL :Component "BIOS"                      "BIOS"          "Manufacturer Name ReleaseDate Version"                               "0"

:: Concatenate text and write to CSV file
SET csvLine=%Today%,%Now%,%csvHostName%%csvBaseBoard%%csvChassis%%csvCPU%%csvWin32_PhysicalMemoryArray%%csvWin32_PhysicalMemory%%csvHardDisk%%csvCDROM%%csvWin32_VideoController%%csvNIC%%csvPorts%%csvSlots%%csvBIOS%
SET hdrLine=Date,Time,%hdrHostName%%hdrBaseBoard%%hdrChassis%%hdrCPU%%hdrWin32_PhysicalMemoryArray%%hdrWin32_PhysicalMemory%%hdrHardDisk%%hdrCDROM%%hdrWin32_VideoController%%hdrNIC%%hdrPorts%%hdrSlots%%hdrBIOS%

>  %Log% ECHO.%hdrLine%
>> %Log% ECHO.%csvLine%

IF NOT "%Debug%"=="" (
	SET csvLine
	SET hdrLine
)

:: Done
ENDLOCAL
GOTO:EOF


:: * :: * :: * :: * :: Subroutines :: * :: * :: * :: * ::


:CDROM
FOR /F "skip=2 tokens=2,3 delims=," %%A IN ('WMIC /Node:%Node% CDROM Get DeviceId^,Name /Format:csv') DO (
	CALL :CreateLine "CD-ROM #!idxCDROM!" "Name=%%~B"
	CALL :GetLength "%%~B"
	SET /A Length = !Length! + 5
	FOR /F "tokens=1,2 delims=\" %%C IN ("%%~A") DO (
		SET FwVer=%%~D
		CALL SET FwVer=%%FwVer:~^!Length^!%%
		SET FwVer=!FwVer:_=!
		CALL :CreateLine "CD-ROM #!idxCDROM!" "InterfaceType=%%~C"
		CALL :CreateLine "CD-ROM #!idxCDROM!" "FirmwareVersion=!FwVer!"
		SET csvCDROM=!csvCDROM!,%%~B,%%~C,!FWVer!
		SET hdrCDROM=!hdrCDROM!,CDROM#!idxCDROM! Name,CDROM#!idxCDROM! Interface,CDROM#!idxCDROM! FirmwareVersion
	)
	SET /A idxCDROM = idxCDROM + 1
)
CALL :CreateLine "CD-ROM" "Count=%idxCDROM%"
SET csvCDROM=%csvCDROM%,%Value%
SET hdrCDROM=%hdrCDROM%,%csvProperty%
IF NOT "%Debug%"=="" (
	SET csvCDROM
	SET hdrCDROM
)
GOTO:EOF


:Chassis
:: Based on Chassis.vbs, a VBScript to interogate a machine's
:: chassis type, by Guy Thomas http://computerperformance.co.uk/
FOR /F "tokens=2 delims=={}" %%A IN ('WMIC /Node:%Node% SystemEnclosure Get ChassisTypes /format:list') DO (
	IF %%A EQU  1 SET csvChassis=,Maybe Virtual Machine
	IF %%A EQU  2 SET csvChassis=,??
	IF %%A EQU  3 SET csvChassis=,Desktop
	IF %%A EQU  4 SET csvChassis=,Thin Desktop
	IF %%A EQU  5 SET csvChassis=,Pizza Box
	IF %%A EQU  6 SET csvChassis=,Mini Tower
	IF %%A EQU  7 SET csvChassis=,Full Tower
	IF %%A EQU  8 SET csvChassis=,Portable
	IF %%A EQU  9 SET csvChassis=,Laptop
	IF %%A EQU 10 SET csvChassis=,Notebook
	IF %%A EQU 11 SET csvChassis=,Hand Held
	IF %%A EQU 12 SET csvChassis=,Docking Station
	IF %%A EQU 13 SET csvChassis=,All in One
	IF %%A EQU 14 SET csvChassis=,Sub Notebook
	IF %%A EQU 15 SET csvChassis=,Space-Saving
	IF %%A EQU 16 SET csvChassis=,Lunch Box
	IF %%A EQU 17 SET csvChassis=,Main System Chassis
	IF %%A EQU 18 SET csvChassis=,Lunch Box
	IF %%A EQU 19 SET csvChassis=,SubChassis
	IF %%A EQU 20 SET csvChassis=,Bus Expansion Chassis
	IF %%A EQU 21 SET csvChassis=,Peripheral Chassis
	IF %%A EQU 22 SET csvChassis=,Storage Chassis
	IF %%A EQU 23 SET csvChassis=,Rack Mount Unit
	IF %%A EQU 24 SET csvChassis=,Sealed-Case PC
)
SET hdrChassis=,Chassis Type
CALL :CreateLine "Chassis" "Type=%csvChassis:,=%
IF NOT "%Debug%"=="" (
	SET csvChassis
	SET hdrChassis
)
GOTO:EOF


:Component
:: %1 = "Component Name or Alias", e.g. "BIOS", "HDD", "Win32_PhysicalMemoryArray"
:: %2 = "Component Friendly Name", e.g. "BIOS", "Harddisk", "Memory"
:: %3 = "Alphabetized Properties List", e.g. "Manufacturer Product Version"
:: %4 = "Multiple Instances", 0=No, 1=List, 2=Count Number, 3=Count Value, 4=Count Number But Don't Show Count, e.g.  "0" for BaseBoard, BIOS, "1" for CD-ROM, Harddisk, Memory Modules, "2" for CPU, Memory Banks, "3" for Memory Capacity
:: %5 = "Property Alias", use only on single property queries, will replace the property name
SET Alias=%~1
IF /I "%Alias:~0,6%"=="Win32_" SET Alias=Path %Alias%
SET Properties=%~3
IF "%~4"=="0" (
	FOR /F "tokens=1* delims==" %%A IN ('WMIC.EXE /Node:%Node% %Alias% Get %Properties: =^^^,% /Format:List ^| FIND.EXE "="') DO (
		IF "%~5"=="" (
			CALL :CreateLine "%~2" "%%~A=%%~B"
		) ELSE (
			CALL :CreateLine "%~2" "%~5=%%~B"
		)
		CALL SET csv%~1=!csv%~1!,!Value!
		CALL SET hdr%~1=!hdr%~1!,!csvProperty!
	)
)
IF "%~4"=="1" (
	SET idxInstance=0
	FOR %%A IN (%Properties%) DO SET LastProperty=%%A
	FOR /F "tokens=1* delims==" %%A IN ('WMIC.EXE /Node:%Node% %Alias% Get %Properties: =^^^,% /Format:List ^| FIND.EXE "="') DO (
		CALL :CreateLine "%~2 #!idxInstance!" "%%~A=%%~B"
		CALL SET csv%~1=!csv%~1!,!Value!
		CALL SET hdr%~1=!hdr%~1!,!csvProperty!
		IF "%%~A"=="!LastProperty!" SET /A idxInstance = !idxInstance! + 1
	)
	CALL :CreateLine "%~2" "Count=!idxInstance!"
	CALL SET csv%~1=!csv%~1!,!Value!
	CALL SET hdr%~1=!hdr%~1!,!csvProperty!
)
IF "%~4"=="2" (
	SET idxInstance=0
	FOR %%A IN (%Properties%) DO SET LastProperty=%%A
	FOR /F "tokens=1* delims==" %%A IN ('WMIC.EXE /Node:%Node% %Alias% Get %Properties: =^^^,% /Format:List ^| FIND.EXE "="') DO (
		IF "!idxInstance!"=="0" (
			CALL :CreateLine "%~2" "%%~A=%%~B"
			CALL SET csv%~1=!csv%~1!,!Value!
			CALL SET hdr%~1=!hdr%~1!,!csvProperty!
		)
		IF "%%~A"=="!LastProperty!" SET /A idxInstance = !idxInstance! + 1
	)
	CALL :CreateLine "%~2" "Count=!idxInstance!"
	CALL SET csv%~1=!csv%~1!,!Value!
	CALL SET hdr%~1=!hdr%~1!,!csvProperty!
)
IF "%~4"=="3" (
	SET idxInstance=0
	SET TotalCount=0
	FOR /F "tokens=1* delims==" %%A IN ('WMIC.EXE /Node:%Node% %Alias% Get %Properties: =^^^,% /Format:List ^| FIND.EXE "="') DO (
		CALL SET /A TotalCount = !TotalCount! + %%~B
		SET /A idxInstance = !idxInstance! + 1
	)
	CALL :CreateLine "%~2" "Capacity=!TotalCount!"
	CALL :CreateLine "%~2" "Count=!idxInstance!"
	CALL SET csv%~1=!csv%~1!,!Value!
	CALL SET hdr%~1=!hdr%~1!,!csvProperty!
)
IF "%~4"=="4" (
	SET idxInstance=0
	FOR %%A IN (%Properties%) DO SET LastProperty=%%A
	FOR /F "tokens=1* delims==" %%A IN ('WMIC.EXE /Node:%Node% %Alias% Get %Properties: =^^^,% /Format:List ^| FIND.EXE "="') DO (
		IF "!idxInstance!"=="0" (
			CALL :CreateLine "%~2" "%%~A=%%~B"
			CALL SET csv%~1=!csv%~1!,!Value!
			CALL SET hdr%~1=!hdr%~1!,!csvProperty!
		)
		IF "%%~A"=="!LastProperty!" SET /A idxInstance = !idxInstance! + 1
	)
)
IF NOT "%Debug%"=="" (
	CALL SET csv%~1
	CALL SET hdr%~1
)
GOTO:EOF


:CreateLine
FOR /F "tokens=1* delims==" %%a IN ("%~2") DO (
	SET csvProperty=%~1 %%~a
	SET Property=%~1 %%~a%_40_Spaces%
	SET Value=%%~b
)
ECHO.%Property:~0,40%= %Value%
GOTO:EOF


:GetLength
SET Var=%~1
SET Length=0
FOR /L %%Z IN (80,-1,0) DO (
	IF "!Var:~%%Z,1!"=="" SET Length=%%Z
)
SET Var=
GOTO:EOF


:HardDisk
FOR /F "tokens=*" %%A IN ('WMIC DiskDrive Where "SCSITargetID Is Not Null" Get Index^,InterfaceType^,Model^,Size /Format:list ^| FIND "="') DO (
	ECHO.%%A | FIND /I "Index=" >NUL
	IF ERRORLEVEL 1 (
		CALL :CreateLine "HardDisk #!Index!" "%%~A"
		CALL SET csvHardDisk=!csvHardDisk!,!Value!
		CALL SET hdrHardDisk=!hdrHardDisk!,!csvProperty!
	) ELSE (
		SET %%A
	)
)
SET /A Index = %Index% + 1
CALL :CreateLine "HardDisk" "Count=%Index%"
SET csvHardDisk=%csvHardDisk%,%Value%
SET hdrHardDisk=%hdrHardDisk%,%csvProperty%
IF NOT "%Debug%"=="" (
	SET csvHardDisk
	SET hdrHardDisk
)
GOTO:EOF


:NIC
FOR /F "tokens=2-5 delims=," %%A IN ('WMIC /Node:%Node% Path Win32_NetworkAdapter Get AdapterType^,MACAddress^,Manufacturer^,ProductName /Format:csv ^| FIND /I ",Ethernet" ^| FIND /I /V ",Microsoft,"') DO (
	CALL :CreateLine "NIC #!idxNIC!" "AdapterType=%%~A"
	CALL SET csvNIC=!csvNIC!,!Value!
	CALL SET hdrNIC=!hdrNIC!,!csvProperty!
	CALL :CreateLine "NIC #!idxNIC!" "MACAddress=%%~B"
	CALL SET csvNIC=!csvNIC!,!Value!
	CALL SET hdrNIC=!hdrNIC!,!csvProperty!
	CALL :CreateLine "NIC #!idxNIC!" "Manufacturer=%%~C"
	CALL SET csvNIC=!csvNIC!,!Value!
	CALL SET hdrNIC=!hdrNIC!,!csvProperty!
	CALL :CreateLine "NIC #!idxNIC!" "ProductName=%%~D"
	CALL SET csvNIC=!csvNIC!,!Value!
	CALL SET hdrNIC=!hdrNIC!,!csvProperty!
	FOR /F "tokens=3 delims=," %%E IN ('WMIC /Node:%Node% /Namespace:"\\root\WMI" Path MSNdis_LinkSpeed Where Active^=TRUE Get InstanceName^,NdisLinkSpeed /Format:csv ^| FIND ",%%~D,"') DO (
		CALL :CreateLine "NIC #!idxNIC!" "NdisLinkSpeed=%%~E"
		CALL SET csvNIC=!csvNIC!,!Value!
		CALL SET hdrNIC=!hdrNIC!,!csvProperty!
	)
	SET /A idxNIC = !idxNIC! + 1
)
CALL :CreateLine "NIC" "Count=%idxNIC%"
CALL SET csvNIC=%csvNIC%,%Value%
CALL SET hdrNIC=%hdrNIC%,%csvProperty%
IF NOT "%Debug%"=="" (
	SET csvNIC
	SET hdrNIC
)
GOTO:EOF



:Ports
FOR /F %%A IN ('WMIC /Node:%Node% Path Win32_USBController Get Name /Format:list 2^>NUL ^| FIND /C "="') DO CALL :CreateLine "USB"      "Ports=%%A"
SET csvPorts=,%Value%
SET hdrPorts=,%csvProperty%
FOR /F %%A IN ('WMIC /Node:%Node% Path Win32_ParallelPort  Get Name /Format:list 2^>NUL ^| FIND /C "="') DO CALL :CreateLine "Parallel" "Ports=%%A"
SET csvPorts=%csvPorts%,%Value%
SET hdrPorts=%hdrPorts%,%csvProperty%
FOR /F %%A IN ('WMIC /Node:%Node% Path Win32_SerialPort    Get Name /Format:list 2^>NUL ^| FIND /C "="') DO CALL :CreateLine "Serial"   "Ports=%%A"
SET csvPorts=%csvPorts%,%Value%
SET hdrPorts=%hdrPorts%,%csvProperty%
IF NOT "%Debug%"=="" (
	SET csvPorts
	SET hdrPorts
)
GOTO:EOF


:Slots
FOR /F %%A IN ('WMIC /Node:%Node% Path Win32_SystemSlot Get SlotDesignation /Format:List 2^>NUL ^| FINDSTR /R /I /C:"=AGP" ^| FIND /C "="') DO SET AGPSlots=%%A
FOR /F %%A IN ('WMIC /Node:%Node% Path Win32_SystemSlot Get SlotDesignation /Format:List 2^>NUL ^| FINDSTR /R /I /C:"=PCI" ^| FIND /C "="') DO SET PCISlots=%%A
FOR /F %%A IN ('WMIC /Node:%Node% Path Win32_SystemSlot Get SlotDesignation /Format:List 2^>NUL ^| FIND /C "="')                            DO SET AllSlots=%%A
SET /A OtherSlots = %AllSlots% - %AGPSlots% - %PCISlots%
CALL :CreateLine "AGP Slot" "Count=%AGPSlots%"
SET csvSlots=,%Value%
SET hdrSlots=,%csvProperty%
CALL :CreateLine "PCI Slot" "Count=%PCISlots%"
SET csvSlots=%csvSlots%,%Value%
SET hdrSlots=%hdrSlots%,%csvProperty%
CALL :CreateLine "Other Slots" "Count=%PCISlots%"
SET csvSlots=%csvSlots%,%Value%
SET hdrSlots=%hdrSlots%,%csvProperty%
IF NOT "%Debug%"=="" (
	SET csvSlots
	SET hdrSlots
)
GOTO:EOF


:Syntax
ECHO.
ECHO Hardware.bat, Version 3.10 for Windows XP Professional and later
ECHO Display hardware summary for any WMI enabled computer on the network
ECHO.
ECHO Usage:  HARDWARE    [ computer ]
ECHO.
ECHO Where:  "computer"  is the computer to be checked (default is local system)
ECHO.
ECHO Notes:  Requires WMIC, which is native in Windows XP Professional and
ECHO         Windows Server 2003.
ECHO         The results are displayed on screen in list format, and written
ECHO         to a "time stamped" CSV file named Hardware_yyyyMMdd_hhmmss.csv.
ECHO         To debug, SET environment variable DEBUG to anything and run again.
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com
IF "%OS%"=="Windows_NT" ENDLOCAL
EXIT /B 1
