@echo off
@title WIFI�������

REM @version 1.1
REM @author Payne
REM @email huyang110yahoo@gmail.com
REM @github https://github.com/peinhu
REM @date 2015-09-12

::��ȡ����ԱȨ��
:------------------------------------- 
net session >nul 2>&1
if '%errorlevel%' NEQ '0' ( 
echo �����������ԱȨ��...
echo Set UAC = CreateObject^("Shell.Application"^) > "%temp%\getadmin.vbs" 
echo UAC.ShellExecute "%~s0", "", "", "runas", 1 >> "%temp%\getadmin.vbs" 
"%temp%\getadmin.vbs"
exit /B 
) else ( 
if exist "%temp%\getadmin.vbs" ( del "%temp%\getadmin.vbs" ) 
pushd "%CD%" 
CD /D "%~dp0" 
) 
:-------------------------------------- 
echo ===========================
echo ==== WIFI������� v1.1 ====
echo ===========================
goto CheckAuth

:MenuSelect
echo.
echo 1 - ����WIFI����
echo 2 - ����WIFI����
echo 3 - �ر�WIFI����
echo 0 - ��ʾWIFI״̬
echo bye/exit - �˳�
set input=
set /p input=��ѡ��
if not defined input ( goto Exception )
if %input%==0 ( goto WIFIStatus ) else if %input%==1 ( goto WIFISet ) else if %input%==2 ( goto WIFIStart ) else if %input%==3 ( goto WIFIStop ) else if %input%==bye ( goto Bye ) else if %input%==exit ( goto Exit ) else ( goto Exception )

:WIFIStatus
netsh wlan show hostednetwork
goto MenuSelect

:WIFISet
set ssid=
set /p ssid=������������:
if not defined ssid ( goto Exception )
set key=
set /p key=������������(����8λ):
if not defined key ( goto Exception )
netsh wlan set hostednetwork mode=allow ssid=%ssid% key=%key%
goto MenuSelect

:WIFIStart
netsh wlan start hostednetwork
echo ��������ȷ�� ��������-����-���� ���ѹ�ѡ�������ӹ�����ѡ����Ҫ���빲��������������ơ�
echo.
goto MenuSelect

:WIFIStop
netsh wlan stop hostednetwork
goto MenuSelect

:Exception
echo ������Ч��ָ��!
goto MenuSelect

:Bye
echo Bye!
ping -n 2 localhost >nul
exit

:Exit
exit

:CheckAuth
net session >nul 2>&1
if '%errorlevel%' NEQ '0' ( 
echo Ȩ�޲��㣡���ֶ��Թ���Ա�������
pause
goto Exit
)
goto MenuSelect
