@ECHO OFF
:: Check Windows version
IF NOT "%OS%"=="Windows_NT" GOTO Syntax

:: Switch to local environment
SETLOCAL ENABLEDELAYEDEXPANSION

:: Check command line arguments (none required)
IF NOT "%~1"=="" GOTO Syntax

:: Export a list of all monitors from the registry
START /WAIT REGEDIT.EXE /E "%Temp%\dispedid0.dat" "HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Enum\DISPLAY"

:: Convert it from Unicode to ASCII
TYPE "%Temp%\dispedid0.dat" > "%Temp%\dispedid0.txt"

:: Loop through the list of all monitors to find the "real" ones
FOR /F "tokens=1 delims=[]" %%A IN ('TYPE "%Temp%\dispedid0.txt" ^| FINDSTR.EXE /R /B /I /C:"\[HKEY_LOCAL_MACHINE\\SYSTEM\\CurrentControlSet\\Enum\\DISPLAY\\[^\\]*\]" ^| FIND.EXE /I /V "Default"') DO CALL :Display1 "%%~A"

:: Display the results
ECHO.
ECHO Monitor EDID asset information
ECHO.
ECHO Manufacturer  : %Manufacturer%
ECHO Description   : %DeviceDescr%
ECHO Model         : %Model%
ECHO Serial number : %Serial%
ECHO.

:: Clean up the pile of temporary files
FOR /L %%A IN (0,1,3) DO (
	IF EXIST "%Temp%\dispedid%%A.dat" DEL "%Temp%\dispedid%%A.dat"
	IF EXIST "%Temp%\dispedid%%A.txt" DEL "%Temp%\dispedid%%A.txt"
)

:: Done
ENDLOCAL
GOTO:EOF


:: == :: == :: == ::   S U B R O U T I N E S   :: == :: == :: == ::


:Display1
:: Export a list of monitor details from the registry
START /WAIT REGEDIT.EXE /E "%Temp%\dispedid1.dat" %1
:: Convert it from Unicode to ASCII
TYPE "%Temp%\dispedid1.dat" > "%Temp%\dispedid1.txt"
:: Escape the backslashes in the path search string
SET Key=%1
SET Key=%Key:\=\\%
:: Call the next subroutine to export a smaller, more relevant part of the list (one level deeper)
FOR /F "tokens=1 delims=[]" %%B IN ('TYPE "%Temp%\dispedid1.txt" ^| FINDSTR.EXE /R /B /I /C:"\[%Key:"=%\\[^\\]*\]"') DO CALL :Display2 "%%~B"
GOTO:EOF


:Display2
:: Export a list of monitor details from the registry
START /WAIT REGEDIT.EXE /E "%Temp%\dispedid2.dat" %1
:: Convert it from Unicode to ASCII
TYPE "%Temp%\dispedid2.dat" > "%Temp%\dispedid2.txt"
:: Skip Windows' default plug and play monitors
TYPE "%Temp%\dispedid2.txt" | FINDSTR.EXE /R /B /I /C:".Mfg.=.(" >NUL && GOTO:EOF
TYPE "%Temp%\dispedid2.txt" | FINDSTR.EXE /R /B /I /C:".DeviceDesc.=.Plug and Play Monitor." >NUL && GOTO:EOF
:: Extract the manufacturer name and device description
FOR /F "tokens=2 delims==" %%C IN ('TYPE "%Temp%\dispedid2.txt" ^| FINDSTR.EXE /R /B /I /C:".Mfg.="') DO SET Manufacturer=%%~C
FOR /F "tokens=2 delims==" %%C IN ('TYPE "%Temp%\dispedid2.txt" ^| FINDSTR.EXE /R /B /I /C:".DeviceDesc.="') DO SET DeviceDescr=%%~C
:: Escape the backslashes in the path search string
SET SubKey=%1
SET SubKey=%SubKey:\=\\%
:: Call the next subroutine to export only the EDID data
FOR /F "tokens=1 delims=[]" %%C IN ('TYPE "%Temp%\dispedid2.txt" ^| FINDSTR.EXE /R /B /I /C:"\[%SubKey:"=%\\Device Parameters\]"') DO CALL :Display3 "%%~C"
GOTO:EOF


:Display3
:: Export the raw EDID data from the registry
START /WAIT REGEDIT.EXE /E "%Temp%\dispedid3.dat" %1
:: Convert it from Unicode to ASCII
TYPE "%Temp%\dispedid3.dat" > "%Temp%\dispedid3.txt"
:: Read the raw EDID data from the temporary file and store it in a variable named EDID
SET EDID=
FOR /F "skip=3 tokens=1 delims=\ " %%D IN (%Temp%\dispedid3.txt) DO SET EDID=!EDID!%%D
:: Trim the string to contain only the raw data
FOR /F "tokens=2 delims=:" %%D IN ("%EDID%") DO SET EDID=%%D
:: Call the next subroutine to find the model and serial
:: number and convert these from hexadecimal to ASCII
CALL :ParseEDID %EDID%
GOTO:EOF


:ParseEDID
:: Search 4 locations for "marker strings"
FOR /L %%E IN (1,1,54) DO SHIFT
IF /I "%1 %2 %3 %4"=="00 00 00 FC" CALL :Parse Model   56 %*
IF /I "%1 %2 %3 %4"=="00 00 00 FF" CALL :Parse Serial  56 %*
FOR /L %%E IN (1,1,18) DO SHIFT
IF /I "%1 %2 %3 %4"=="00 00 00 FC" CALL :Parse Model   74 %*
IF /I "%1 %2 %3 %4"=="00 00 00 FF" CALL :Parse Serial  74 %*
FOR /L %%E IN (1,1,18) DO SHIFT
IF /I "%1 %2 %3 %4"=="00 00 00 FC" CALL :Parse Model   92 %*
IF /I "%1 %2 %3 %4"=="00 00 00 FF" CALL :Parse Serial  92 %*
FOR /L %%E IN (1,1,18) DO SHIFT
IF /I "%1 %2 %3 %4"=="00 00 00 FC" CALL :Parse Model  110 %*
IF /I "%1 %2 %3 %4"=="00 00 00 FF" CALL :Parse Serial 110 %*
GOTO:EOF


:Parse
:: Remember what we're parsing here
SET What=%1
:: Move to the start of the "marker"
FOR /L %%F IN (1,1,%2) DO SHIFT
:: Read and store 9 hexadecimal characters
SET RawEDID=%1,%2,%3,%4,%5,%6,%7,%8,%9
:: Move 9 positions forward
FOR /L %%F IN (1,1,9) DO SHIFT
:: Read and append the next 9 hexadecimal characters
SET RawEDID=!RawEDID!,%1,%2,%3,%4,%5,%6,%7,%8,%9
:: Remove the "marker"
SET RawEDID=%RawEDID:~12%
:: Start the hexadecimal to ASCII conversion
SET RawEDIDStr=
FOR %%G IN (%RawEDID%) DO (
	CALL :Hex2Str %%G
	SET RawEDIDStr=!RawEDIDStr!!Char!
)
:: Trim the result
SET EDIDStr=
FOR %%G IN (%RawEDIDStr%) DO SET EDIDStr=!EDIDStr! %%G
:: Return the result to the value whose
:: NAME was stored in the variable WHAT.
SET %What%=%EDIDStr:~1%
GOTO:EOF


:Hex2Str
:: Default is a space
(SET Char= )
:: Brute force conversion of valid characters
IF /I "%~1"=="23" SET Char=#
IF /I "%~1"=="24" SET Char=$
IF /I "%~1"=="27" SET Char='
IF /I "%~1"=="28" SET Char=(
IF /I "%~1"=="29" SET Char=)
IF /I "%~1"=="2A" SET Char=*
IF /I "%~1"=="2B" SET Char=+
IF /I "%~1"=="2C" SET Char=,
IF /I "%~1"=="2D" SET Char=-
IF /I "%~1"=="2E" SET Char=.
IF /I "%~1"=="2F" SET Char=/
IF /I "%~1"=="30" SET Char=0
IF /I "%~1"=="31" SET Char=1
IF /I "%~1"=="32" SET Char=2
IF /I "%~1"=="33" SET Char=3
IF /I "%~1"=="34" SET Char=4
IF /I "%~1"=="35" SET Char=5
IF /I "%~1"=="36" SET Char=6
IF /I "%~1"=="37" SET Char=7
IF /I "%~1"=="38" SET Char=8
IF /I "%~1"=="39" SET Char=9
IF /I "%~1"=="3A" SET Char=:
IF /I "%~1"=="3B" SET Char=;
IF /I "%~1"=="3D" SET Char==
IF /I "%~1"=="3F" SET Char=?
IF /I "%~1"=="40" SET Char=@
IF /I "%~1"=="41" SET Char=A
IF /I "%~1"=="42" SET Char=B
IF /I "%~1"=="43" SET Char=C
IF /I "%~1"=="44" SET Char=D
IF /I "%~1"=="45" SET Char=E
IF /I "%~1"=="46" SET Char=F
IF /I "%~1"=="47" SET Char=G
IF /I "%~1"=="48" SET Char=H
IF /I "%~1"=="49" SET Char=I
IF /I "%~1"=="4A" SET Char=J
IF /I "%~1"=="4B" SET Char=K
IF /I "%~1"=="4C" SET Char=L
IF /I "%~1"=="4D" SET Char=M
IF /I "%~1"=="4E" SET Char=N
IF /I "%~1"=="4F" SET Char=O
IF /I "%~1"=="50" SET Char=P
IF /I "%~1"=="51" SET Char=Q
IF /I "%~1"=="52" SET Char=R
IF /I "%~1"=="53" SET Char=S
IF /I "%~1"=="54" SET Char=T
IF /I "%~1"=="55" SET Char=U
IF /I "%~1"=="56" SET Char=V
IF /I "%~1"=="57" SET Char=W
IF /I "%~1"=="58" SET Char=X
IF /I "%~1"=="59" SET Char=Y
IF /I "%~1"=="5A" SET Char=Z
IF /I "%~1"=="5B" SET Char=[
IF /I "%~1"=="5C" SET Char=\
IF /I "%~1"=="5D" SET Char=]
IF /I "%~1"=="5F" SET Char=_
IF /I "%~1"=="60" SET Char=`
IF /I "%~1"=="61" SET Char=a
IF /I "%~1"=="62" SET Char=b
IF /I "%~1"=="63" SET Char=c
IF /I "%~1"=="64" SET Char=d
IF /I "%~1"=="65" SET Char=e
IF /I "%~1"=="66" SET Char=f
IF /I "%~1"=="67" SET Char=g
IF /I "%~1"=="68" SET Char=h
IF /I "%~1"=="69" SET Char=i
IF /I "%~1"=="6A" SET Char=j
IF /I "%~1"=="6B" SET Char=k
IF /I "%~1"=="6C" SET Char=l
IF /I "%~1"=="6D" SET Char=m
IF /I "%~1"=="6E" SET Char=n
IF /I "%~1"=="6F" SET Char=o
IF /I "%~1"=="70" SET Char=p
IF /I "%~1"=="71" SET Char=q
IF /I "%~1"=="72" SET Char=r
IF /I "%~1"=="73" SET Char=s
IF /I "%~1"=="74" SET Char=t
IF /I "%~1"=="75" SET Char=u
IF /I "%~1"=="76" SET Char=v
IF /I "%~1"=="77" SET Char=w
IF /I "%~1"=="78" SET Char=x
IF /I "%~1"=="79" SET Char=y
IF /I "%~1"=="7A" SET Char=z
IF /I "%~1"=="7B" SET Char={
IF /I "%~1"=="7D" SET Char=}
IF /I "%~1"=="7F" SET Char=
IF /I "%~1"=="80" SET Char=Ä
IF /I "%~1"=="81" SET Char=Å
IF /I "%~1"=="82" SET Char=Ç
IF /I "%~1"=="83" SET Char=É
IF /I "%~1"=="84" SET Char=Ñ
IF /I "%~1"=="85" SET Char=Ö
IF /I "%~1"=="86" SET Char=Ü
IF /I "%~1"=="87" SET Char=á
IF /I "%~1"=="88" SET Char=à
IF /I "%~1"=="89" SET Char=â
IF /I "%~1"=="8A" SET Char=ä
IF /I "%~1"=="8B" SET Char=ã
IF /I "%~1"=="8C" SET Char=å
IF /I "%~1"=="8D" SET Char=ç
IF /I "%~1"=="8E" SET Char=é
IF /I "%~1"=="8F" SET Char=è
IF /I "%~1"=="90" SET Char=ê
IF /I "%~1"=="91" SET Char=ë
IF /I "%~1"=="92" SET Char=í
IF /I "%~1"=="93" SET Char=ì
IF /I "%~1"=="94" SET Char=î
IF /I "%~1"=="95" SET Char=ï
IF /I "%~1"=="96" SET Char=ñ
IF /I "%~1"=="97" SET Char=ó
IF /I "%~1"=="98" SET Char=ò
IF /I "%~1"=="99" SET Char=ô
IF /I "%~1"=="9A" SET Char=ö
IF /I "%~1"=="9B" SET Char=õ
IF /I "%~1"=="9C" SET Char=ú
IF /I "%~1"=="9D" SET Char=ù
IF /I "%~1"=="9E" SET Char=û
IF /I "%~1"=="9F" SET Char=ü
IF /I "%~1"=="A0" SET Char=†
IF /I "%~1"=="A1" SET Char=°
IF /I "%~1"=="A2" SET Char=¢
IF /I "%~1"=="A3" SET Char=£
IF /I "%~1"=="A4" SET Char=§
IF /I "%~1"=="A5" SET Char=•
IF /I "%~1"=="A6" SET Char=¶
IF /I "%~1"=="A7" SET Char=ß
IF /I "%~1"=="A8" SET Char=®
IF /I "%~1"=="A9" SET Char=©
IF /I "%~1"=="AA" SET Char=™
IF /I "%~1"=="AB" SET Char=´
IF /I "%~1"=="AC" SET Char=¨
IF /I "%~1"=="AD" SET Char=≠
IF /I "%~1"=="AE" SET Char=Æ
IF /I "%~1"=="AF" SET Char=Ø
GOTO:EOF


:Syntax
ECHO.
ECHO DispEDID.bat,  Version 1.01 for Windows XP
ECHO Read and display your monitor's EDID asset information
ECHO.
ECHO Usage:  DISPEDID
ECHO.
ECHO Note:   Though this batch file might work in Windows 2000, Server 2003
ECHO         and Vista, it has been tested in Windows XP Professional only.
ECHO.
ECHO Based on a VBScript by Michael Baird:
ECHO http://cwashington.netreach.net/depo/view.asp?Index=980^&ScriptType=vbscript
ECHO.
ECHO Written by Rob van der Woude
ECHO http://www.robvanderwoude.com

IF "%OS%"=="Windows_NT" ENDLOCAL
