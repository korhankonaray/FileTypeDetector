@ECHO OFF
:: Force Ctrl+Alt+DEl at logon (Windows XP and Server 2003 only)
REG Add "HKLM\SOFTWARE\Microsoft\Windows NT\CurrentVersion\Winlogon" /v DisableCAD /t REG_DWORD /d 0
