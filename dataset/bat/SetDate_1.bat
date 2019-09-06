@ECHO OFF
FOR /F "tokens=*" %%A IN ('DATE/T') DO FOR %%B IN ("%%~A") DO SET Today=%%B
ECHO It's %Today% today
