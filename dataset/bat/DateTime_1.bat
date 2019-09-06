@ECHO OFF
:: DateTime.bat
:: Set environment variables with current Date, Time and DayOfWeek

:: Recursion
IF NOT "%3"=="" GOTO SecondTime
:: Create temporary batch file
> TEMPDTT1.BAT ECHO @PROMPT %0 $D $T
:: Do _N_O_T_ replace "COMMAND /C" with CALL in the next line
> TEMPDTT2.BAT COMMAND /C TEMPDTT1.BAT
TEMPDTT2

:SecondTime
DEL TEMPDTT?.BAT
SET DOW=%1
SET DATE=%2
SET TIME=%3

:: Remove forward slashes from DATE variable and store result in DATE2
IF EXIST DATE2.BAT DEL DATE2.BAT
SET DATE2=
:: Parse DATE variable and create temporary batch
:: file to recreate DATE without forward slashes
>> DATE2.BAT FOR %%A IN (/%DATE%) DO ECHO SET DATE2=%%DATE2%%%%A
CALL DATE2.BAT
DEL  DATE2.BAT
