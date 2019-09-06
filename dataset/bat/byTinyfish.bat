@echo off
setlocal EnableExtensions EnableDelayedExpansion
color 3f

cd /d "%~dp0"
set "path=%~dp0Binary;%~dp0jre\bin;!path!"


set "UseAdb=1"
if /i "%~1"=="NoAdb" (
	ex
	echo.
	pause
)

echo.
echo.

:CHECK_ENV

if "!UseAdb!"=="1" (
	for /f "tokens=*" %%t in ('adb get-state') do set "adbState=%%t"
	echo.
	if not "!adbState!"=="device" (
		echo.
		call "InstallUsbDriver.cmd"

		echo.
		call "AddAndroidVendorID.cmd"

		adb kill-server
		ping -n 2 127.0.0.1 >nul
		
		for /f "tokens=*" %%t in ('adb get-state') do set "adbState=%%t"
		echo.
		if not "!adbState!"=="device" (
			echo.
			echo.
			echo.
			echo.
			pause
			goto :CHECK_ENV
		)
	)

	for /f "tokens=1 delims=." %%t in ('adb shell getprop ro.build.version.release') do set "androidVersion=%%t"
) else (
	echo.
	set /p androidVersion=
)

echo.

FastCopy /cmd=delete /no_ui "apk" "services" "classes.dex" "services.jar"

if "!UseAdb!"=="1" (
	FastCopy /cmd=delete /no_ui "framework"
)

if "!UseAdb!"=="1" (
	echo.
	echo.

	adb shell ls -lR "/system/framework"|find "services.odex"
	if errorlevel 1 (
		if not exist "framework" md "framework"
		cd "framework"
		adb pull "/system/framework/services.jar"
		cd "%~dp0"
	) else (
		adb pull "/system/framework"
	)
)

if not exist "framework\services.jar" (
	echo.
	pause >nul
	exit /b
)
echo.


cd "framework"
for /f "tokens=*" %%a in ('dir /b /s services.odex 2^>nul') do set "servicesOdexPath=%%a"
cd "%~dp0"
if not exist "!servicesOdexPath!" 
for %%a in ("!servicesOdexPath!") do set "servicesOdexDir=%%~dpa"
set "servicesOdexDir=!servicesOdexDir:~0,-1!"

cd "framework"
for /f "tokens=*" %%a in ('dir /b /s boot.oat') do set "bootOatPath=%%a"
cd "%~dp0"
if not exist "!bootOatPath!" (
	echo.
	exit /b
)
for %%a in ("!bootOatPath!") do set "bootOatDir=%%~dpa"
set "bootOatDir=!bootOatDir:~0,-1!"

:TRY_MOVE_FRAMEWORK
md "\BreventAutoPatchTemp"
move "framework" "\BreventAutoPatchTemp\\"
if errorlevel 1 echo   

cd "/BreventAutoPatchTemp/framework"
for /f "tokens=*" %%a in ('dir /b /s services.odex 2^>nul') do set "servicesOdexFrameworkPath=%%a"
cd "%~dp0"

move "\BreventAutoPatchTemp\framework" ".\\"
rd "\BreventAutoPatchTemp"

set "servicesOdexFrameworkPath=!servicesOdexFrameworkPath:~24!"
set "servicesOdexFrameworkDir=!servicesOdexFrameworkPath:~0,-14!"

set "servicesOdexMobilePath=/system/!servicesOdexFrameworkPath!"
set "servicesOdexMobilePath=!servicesOdexMobilePath:\=/!"

echo.
echo.

:SKIP_SERVICES_ODEX

echo.
echo.

copy /y "Package\Update.zip" "BreventRestoreRaw.zip"
FastCopy /cmd=delete /no_ui "system"
md "system\framework"

copy /y "framework\services.jar" "system\framework\\"
if exist "!servicesOdexPath!" (
	md "system\!servicesOdexFrameworkDir!" 2>nul
	copy /y "!servicesOdexPath!" "system\!servicesOdexFrameworkDir!\\"
)

zip -r "BreventRestoreRaw.zip" "system\\"
if errorlevel 1 echo   

del /q "BreventRestoreRaw.zip"
FastCopy /cmd=delete /no_ui "system"

if exist "!servicesOdexPath!" (
	echo.
	if "!androidVersion!"=="5" (
		java -jar "%~dp0Binary\oat2dex.jar" boot "!bootOatPath!"
		java -jar "%~dp0Binary\oat2dex.jar" "!servicesOdexPath!" "!bootOatDir!\dex"
		java -jar "%~dp0Binary\baksmali-2.2b4.jar" d "!servicesOdexDir!\services.dex" -o "services"
		java -jar "%~dp0Binary\baksmali-2.2b4.jar" x -d "!bootOatDir!" "!servicesOdexPath!" -o "services"
	)
) else (
	echo.
	echo =================================================
	echo.
	java -jar "%~dp0Binary\baksmali-2.2b4.jar" d "framework\services.jar" -o "services"
)

echo.
java -jar "%~dp0Binary\baksmali-2.2b4.jar" d "Package\Brevent.apk" -o "apk"

echo.¡£
echo.
patch -a "apk" -s "services"
if errorlevel 1 (
	pause >nul
	exit /b
)

echo.
echo =================================================
echo.
java -jar "%~dp0Binary\smali-2.2b4.jar" a -o "classes.dex" "services"
copy /y "framework\services.jar" ".\\"
zip "services.jar" "classes.dex"

echo.
echo.

copy /y "Package\Update.zip" "BreventPatchRaw.zip"
FastCopy /cmd=delete /no_ui "system"
md "system\framework"
copy /y "services.jar" "system\framework\\"

zip -r "BreventPatchRaw.zip" "system\\"

del /q "BreventPatchRaw.zip"
FastCopy /cmd=delete /no_ui "system"

if "!UseAdb!"=="1" (
	echo.
	echo =================================================
	echo   
	echo.

	adb shell pm list packages|find "me.piebridge.prevent"
	if errorlevel 1 (
		echo   
		echo.
		adb install "Package\Brevent.apk"
	)

	echo.
	echo =================================================
	echo 
	echo.

	adb push "services.jar" "/sdcard/"
	if errorlevel 1 echo :PushError

	adb push "BreventRestore.zip" "/sdcard/"
	if errorlevel 1 echo 

	adb push "BreventPatch.zip" "/sdcard/"
	if errorlevel 1 echo 

	:CHECK_ROOT
	adb shell su -c 'chmod 666 "/data/data/com.android.providers.contacts/databases/contacts2.db"'
	if errorlevel 1 (
		echo.
		echo   
		echo.
		echo   
		echo.
		echo   
		echo.
		echo   
		echo.
		pause
		goto :CHECK_ROOT
	) else (
		adb shell su -c 'chmod 660 "/data/data/com.android.providers.contacts/databases/contacts2.db"'
	)

	adb shell su -c 'mount -o rw,remount "/system"'
	if errorlevel 1 echo   
	adb shell su -c 'cp -f "/sdcard/services.jar" "/system/framework/"'
	if errorlevel 1 echo   
	adb shell su -c 'chmod 644 "/system/framework/services.jar"'
	if errorlevel 1 echo   

	if exist "!servicesOdexPath!" (
		adb shell su -c 'rm -f "!servicesOdexMobilePath!"'
		if errorlevel 1 echo   
	)
)

echo.
echo =================================================
echo   
echo.

FastCopy /cmd=delete /no_ui "apk" "services" "classes.dex"

if "!UseAdb!"=="1" (
	FastCopy /cmd=delete /no_ui "framework"
)

if "!UseAdb!"=="1" (
	echo.
	echo =================================================
	echo   
	echo.
	echo   
	echo.
	pause
) else (
	echo.
	echo =================================================
	echo   
	echo.
	echo   
	echo.
	pause
)

goto :EOF
:PushError
setlocal
echo.
echo   
echo.
pause
exit /b
(endlocal)
goto :EOF

endlocal
