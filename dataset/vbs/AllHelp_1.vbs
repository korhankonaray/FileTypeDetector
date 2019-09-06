Option Explicit

Dim arrHelpWin, arrHelpWinChr1, arrIntCmd, arrTemp, dicHelpLong, dicHelpShort, dicSystemFiles
Dim blnAdditional, blnDebug, blnDebugLog, blnIgnoreBatch, blnNoAdmin, blnNohlpChr1, blnOverwrite, blnQuiet, blnWindowsOnly
Dim intBitsOS, intCodePage, intOSVersion, intUnexpectedCodepage, intValidArgs, i, j
Dim colItems, objDebugLog, objExec, objHTMLFile, objFolder
Dim objFolderItem, objFSO, objItem, objKey, objMatches, objMatches2
Dim objRE, objShell, objWMISvc, wshShell
Dim strAlphabet, strArg, strClass, strCmdInfo, strCommand, strCommandLine, strComSpec, strCSDVer, strFile, strFileVer
Dim strDebugLog, strFirstLetter, strHelpAll, strHelpLong, strHelpShort, strHead, strHTML, strMsg, strNumVer
Dim strOSLocl, strPattern, strPreviousLetter, strScriptEngine, strScriptPath, strScriptVer, strUnknownCommand, strWinVer

Const INTERNAL_COMMON      = "BREAK CALL CD CHCP CHDIR CLS COPY DATE DEL DIR DPATH ECHO ERASE EXIT FOR GOTO IF MD MKDIR MOVE PATH PAUSE PROMPT RD REM REN RENAME RMDIR SET SHIFT TIME TYPE VER VERIFY VOL"
Const INTERNAL_CMD_EXE     = "ASSOC COLOR ENDLOCAL FTYPE MKLINK POPD PUSHD SETLOCAL START TITLE"
Const INTERNAL_COMMAND_COM = "CTTY LFNFOR LH LOADHIGH LOCK TRUENAME UNLOCK"

Const MY_DOCUMENTS = &H5

Const dictKey  = 1
Const dictItem = 2

Const TristateFalse      =  0
Const TristateMixed      = -2
Const TristateTrue       = -1
Const TristateUseDefault = -2

Const ForAppending = 8
Const ForReading   = 1
Const ForWriting   = 2

Set objFSO   = CreateObject( "Scripting.FileSystemObject" )
Set wshShell = CreateObject( "Wscript.Shell" )

strDebugLog           = ""
strMsg                = ""
strScriptVer          = "3.29"
intValidArgs          = 0
blnAdditional         = False
blnIgnoreBatch        = True
blnDebug              = False
blnDebugLog           = False
blnNoAdmin            = False
blnOverwrite          = False
blnQuiet              = False
blnWindowsOnly        = False
intCodePage           = GetCodePage( )
intUnexpectedCodepage = 0

With WScript.Arguments
	If .Named.Exists( "BAT" ) Then
		blnIgnoreBatch = False
		intValidArgs   = intValidArgs + 1
	End If
	If .Named.Exists( "NOADMIN" ) Then
		blnNoAdmin = True
		intValidArgs   = intValidArgs + 1
	End If
	If .Named.Exists( "WHO" ) Then
		blnWindowsOnly = True
		intValidArgs   = intValidArgs + 1
	End If
	If .Named.Exists( "Q" ) Then
		blnQuiet     = True
		intValidArgs = intValidArgs + 1
	Else
		If .Named.Exists( "DEBUG" ) Then
			blnDebug     = True
			intValidArgs = intValidArgs + 1
			strDebugLog  = .Named.Item( "DEBUG" )
			If strDebugLog = "" Then
				blnDebugLog = False
			Else
				If objFSO.FolderExists( objFSO.GetParentFolderName( strDebugLog ) ) Then
					blnDebugLog = True
					Set objDebugLog = objFSO.OpenTextFile( strDebugLog, ForWriting, True, TristateUseDefault )
				Else
					blnDebugLog = False
				End If
			End If
			DebugDisplay "Show intermediate results"
			If blnDebugLog Then
				DebugDisplay "Logging to """ & strDebugLog & """"
			End If
		End If
		If .Named.Exists( "NOADMIN" ) Then
			If blnDebug Then DebugDisplay "Script restarted with elevated privileges"
		End If
		If .Named.Exists( "BAT" ) Then
			If blnDebug Then DebugDisplay "Include batch files (.bat and .cmd)"
		Else
			If blnDebug Then DebugDisplay "Ignore batch files (.bat and .cmd)"
		End If
		If .Named.Exists( "WHO" ) Then
			If blnDebug Then DebugDisplay "Show commands listed by HELP only"
		Else
			If blnDebug Then DebugDisplay "Show ""all"" commands"
		End If
		If .Named.Exists( "Y" ) Then
			blnOverwrite = True
			intValidArgs = intValidArgs + 1
			If blnDebug Then DebugDisplay "HTML file overwrite ON"
		Else
			If blnDebug Then DebugDisplay "HTML file overwrite OFF"
		End If
		If .Unnamed.Count > 0 Then
			strFile = .Unnamed(0)
			intValidArgs = intValidArgs + 1
			If blnDebug Then DebugDisplay "Output HTML file: " & strFile
		Else
			' Find the path to "My Documents"
			Set objShell      = CreateObject( "Shell.Application" )
			Set objFolder     = objShell.Namespace( MY_DOCUMENTS )
			Set objFolderItem = objFolder.Self
			strFile = objFSO.BuildPath( objFolderItem.Path, "allhelp.html" )
			If blnDebug Then DebugDisplay "Output HTML file: " & strFile
			Set objFolderItem = Nothing
			Set objFolder     = Nothing
			Set objShell      = Nothing
		End If
		If objFSO.FileExists( strFile ) And Not blnOverwrite Then
			strMsg = strMsg & "ERROR: The specified output file exists and file overwrite is OFF" & vbCrLf & vbCrLf
			Syntax
		End If
		If objFSO.FolderExists( strFile ) Then
			strMsg = strMsg & "ERROR: A folder with the name of the specified output file exists" & vbCrLf & vbCrLf
			Syntax
		End If
		If Not objFSO.FolderExists( objFSO.GetParentFolderName( strFile ) ) Then
			strMsg = strMsg & "ERROR: The parent folder for the specified output file does not exists" & vbCrLf & vbCrLf
			Syntax
		End If
	End If
	If intValidArgs <> .Count Then
		strMsg = strMsg & "ERROR: Invalid command line arguments" & vbCrLf & vbCrLf
		Syntax
	End If
End With

' Get the script engine, path and arguments
strScriptEngine = WScript.FullName
strScriptPath   = WScript.ScriptFullName
strCommandLine  = ""
For Each strArg In WScript.Arguments
	strCommandLine = Trim( strCommandLine & " " & strArg )
Next

' Check for elevated privileges
If IsAdmin( ) Then
	If blnDebug Then DebugDisplay "Elevated privileges"
Else
	If blnDebug Then DebugDisplay "No elevated privileges"
End If

' Get the OS version
Set objWMISvc = GetObject( "winmgmts://./root/cimv2" )
Set colItems  = objWMISvc.ExecQuery( "SELECT * FROM Win32_OperatingSystem", , 48 )
For Each objItem in colItems
	strWinVer = objItem.Caption
	strCSDVer = objItem.CSDVersion
	strOSLocl = objItem.OSLanguage
	strNumVer = objItem.Version
Next

' Check if OS is 32-bit or 64-bit
Set colItems  = objWMISvc.ExecQuery( "SELECT * FROM Win32_Processor", , 48 )
For Each objItem in colItems
	intBitsOS = CInt( objItem.AddressWidth )
Next
Set colItems  = Nothing
Set objWMISvc = Nothing

' Determine the list of internal commands, based on the command processor (COMMAND.COM or CMD.EXE)
Set arrIntCmd = CreateObject( "System.Collections.Sortedlist" )
strComSpec = UCase( wshShell.ExpandEnvironmentStrings( "%COMSPEC%" ) )
arrTemp    = Split( INTERNAL_COMMON )
For i = 0 To UBound( arrTemp )
	arrIntCmd.Add arrTemp(i), arrTemp(i)
Next
arrTemp = Null
If Right( strComSpec, 12 ) = "\COMMAND.COM" Then
	arrTemp = Split( INTERNAL_COMMAND_COM )
Else
	If Right( strComSpec, 8 ) = "\CMD.EXE" Then
		arrTemp = Split( INTERNAL_CMD_EXE )
	End If
End If
For i = 0 To UBound( arrTemp )
	arrIntCmd.Add arrTemp(i), arrTemp(i)
Next

' Change the working directory to %windir%\system32
Set objShell = CreateObject( "Wscript.Shell" )
objShell.CurrentDirectory = wshShell.ExpandEnvironmentStrings( "%windir%\system32" )

' Retrieve the error message for unknown commands, i.e. what string to look for to detect errors
strUnknownCommand = GetCommandError( )

' Create a Dictionary objects to contain the commands and associated help texts
Set dicHelpLong    = CreateObject( "Scripting.Dictionary" )
Set dicHelpShort   = CreateObject( "Scripting.Dictionary" )
Set dicSystemFiles = CreateObject( "Scripting.Dictionary" )
Set arrHelpWin     = CreateObject( "System.Collections.ArrayList" )
Set arrHelpWinChr1 = CreateObject( "System.Collections.ArrayList" )

' Store all descriptions for files in %windir%\system32 in a dictionary for later use by GetFileDescription function.
' This speeds up this script enormously, when combined with a check in this dictionary first in GetFileDescription.
GetSystemFileDescriptions

' Fill the commands lists
Set objExec = wshShell.Exec( "CMD.EXE /A /C (TITLE AllHelp " & strScriptVer & ": HELP&HELP)" )
strHelpAll  = objExec.StdOut.ReadAll( )
objExec.Terminate
Set objExec = Nothing
Set objRE   = New RegExp
objRE.Global     = True
objRE.IgnoreCase = False
objRE.Pattern    = "(^|[\n\r])[A-Z]+ +([^\n\r]+)(\r\n +([^\n\r]+))*"
Set objMatches = objRE.Execute( strHelpAll )
For i = 0 To objMatches.Count - 1
	strCommand   = Mid( objMatches.Item(i), 2, InStr( objMatches.Item(i), " " ) - 2 )
	strHelpShort = SuperTrim( Mid( objMatches.Item(i), InStr( objMatches.Item(i), " " ) ) )
	dicHelpShort.Add   strCommand, strHelpShort
	dicHelpLong.Add    strCommand, GetCmdHelp( strCommand )
	arrHelpWin.Add     strCommand
	arrHelpWinChr1.Add Left( strCommand, 1 )
Next
Set objMatches = Nothing
Set objRE      = Nothing

' Display intermediate results for debugging purposes
If blnDebug Then
	strMsg = DebugDisplayHelpFound( )
	WScript.Echo strMsg
	If blnDebugLog Then
		On Error Resume Next
		objDebugLog.Write strMsg
		If Err Then
			WScript.Echo "==================================================="
			WScript.Echo "DEBUG: Error while trying to write to the log file:"
			WScript.Echo Err.Description
			WScript.Echo "==================================================="
		End If
		On Error Goto 0
	End If
End if

If Not blnWindowsOnly Then
	AddCommand      "ACCESSCHK",     "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "ACINIUPD",      ":[^\r\n]+",                                    "[^:\r\n][^\r\n]+"
	AddCommand      "ADRESTORE",     "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "APPEND",        "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCommand      "APPVERIF",      "[^\r\n]+",                                     "[^\r\n]+"
	AddCommand      "ARP",           "\r\n[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",     "(\r\n[^\r\n]+)+"
	AddCommand      "AT",            "([^ ][^\r\n]+\r\n)+",                          "([^\r\n]+\r\n)+"
	AddCmdNoSummary "AUDITPOL"
	AddCommand      "AUTORUNSC",     "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\r\n]+"
	AddCommand      "BCDBOOT",       "[^\r\n]+\r\n\r\n([^\r\n\<]+\r\n)+",            "(.|\r|\n)+"
	AddCommand      "BDEHDCFG",      "Description:\s+([^\n]+\n)+",                   "\s.*[\n\r]{0,2}.*"
	AddCommand      "BITSADMIN",     "\r\n[^\r\n\(\[]+\r\n([^\r\n\(\[]+\r\n)*",      "([^\r\n]+\r\n)+"
	AddCommand      "BOOTCFG",       ":\r\n +[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",  "(\r\n +[^\r\n]+)+"
	AddCmdNoSummary "CDBURN"
	AddCmdNoSummary "CERTREQ"
	AddCmdNoSummary "CERTUTIL"
	AddCmdNoSummary "CHANGE"
	AddCommand      "CHGLOGON",      "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCommand      "CHGPORT",       "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCommand      "CHGUSR",        "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCommand      "CHOICE",        "[\r\n]+CHOICE +\[ */[^\r\n]+[\r\n]+[A-Za-z ]+:[\r\n]+( +[^\/\r\n]+[\r\n]+)+[A-Za-z ]+:[\r\n]", "([\r\n]+ +[^\/\r\n]+)+[\r\n]"
	AddCommand      "CIPHER",        "([^ ][^\r\n]+\r\n)+",                          "([^\r\n]+\r\n)+"
	AddCommand      "CLIP",          ":\r\n +[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",  "([^:][^\r\n]+\r\n)+"
	AddCommand      "CMDKEY",        "\r\n[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",     "(\r\n[^\r\n]+)+"
	AddCommand      "CONTIG",        "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\r\n]+"
	AddCommand      "COREINFO",      "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\r\n]+"
	AddCmdNoSummary "CSCRIPT"
	AddCommand      "CSVDE",         "\r\n[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",     "(\r\n[^\r\n]+)+"
	AddCommand      "DCDIAG",        "([^\r\n]+[\r\n]{1,2})+",                       "([^\r\n]+[\r\n]{1,2})+"
	AddCommand      "DEBUG",         "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCommand      "DEFRAG",        ":[\n\r]+(\s+[^\r\n]+[\r\n]+)+",                "([^\r\n:][^\r\n]+[\r\n]+)+"
	AddCommand      "DEVCON",        "[A-Z][^\r\n\[]+:[\r\n]{2,3}",                  "[^:\r\n]+"
	AddCmdNoSummary "DHCPLOC"
	AddCommand      "DIANTZ",        "([^\r\n\[]+ [^\r\n\[]+[\r\n]+)+",              "(.|\r|\n)+"
	AddCmdNoSummary "DISKPERF"
	AddCommand      "DISKRAID",      "[\r\n]([^\r\n\(]+[\r\n])+",                    "[\r\n]([^\r\n\(]+[\r\n])+"
	AddCommand      "DISM",          ":\r?\n\r?\n( +[^\r\n]+\r?\n)+\r?\n",           "([^:][^\r\n]+\r?\n)+"
	AddCommand      "DISPDIAG",      "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCmdNoSummary "DJOIN"
	AddCommand      "DPATH",         "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCommand      "DSACLS",        "[A-Z][^\r\n\[]+[\r\n]{2,3}",                   "[^\r\n]+"
	AddCommand      "DSADD",         ": +[A-Z][^\r\n]+(\r\n[^\r\n]+)*:\r\n\r\n",     "[^:](.|\r|\n)+\."
	AddCommand      "DSDBUTIL",      "\n([^ \r\n\(][^\r\n\(]+\r?\n)+\r?\n",          "(.|\r|\n)+"
	AddCommand      "DSGET",         ": +[A-Z][^\r\n]+(\r\n[^\r\n]+)*:\r\n\r\n",     "[^:](.|\r|\n)+\."
	AddCommand      "DSMOD",         ": +[A-Z][^\r\n]+(\r\n[^\r\n]+)*:\r\n\r\n",     "[^:](.|\r|\n)+\."
	AddCommand      "DSMOVE",        ": +[A-Z][^\r\n]+(\r\n[^\r\n]+)*\r\n\r\n",      "[^:](.|\r|\n)+\."
	AddCommand      "DSQUERY",       ": +[A-Z][^\r\n]+(\r\n[^\r\n]+)*:\r\n\r\n",     "[^:](.|\r|\n)+\."
	AddCommand      "DSRM",          ": +[A-Z][^\r\n]+(\r\n[^\r\n]+)*\r\n\r\n",      "[^:](.|\r|\n)+\."
	AddCommand      "DU",            "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\r\n]+"
	AddCmdNoSummary "DVDBURN"
	AddCommand      "EDIT",          "[^\r\n]+\r\n([^\s\r\n][^\r\n]+\r\n)+",         "(.|\r|\n)+"
	AddCommand      "EDLIN",         "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "EPAL",          "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "EVENTCREATE",   ":\r\n +[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",  "(\r\n +[^\r\n]+)+"
	AddCommand      "EXE2BIN",       "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "EXPAND",        "\r\n\r\n[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n", "(\r\n[^\r\n]+)+"
	AddCommand      "EXTRACT",       "\)[^\n\r]+\r\n",                               "[^\)\r\n][^\r\n]+"
	AddCommand      "FILEVER",       "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "FINDLINKS",     "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\r\n]+"
	AddCommand      "FINGER",        "\r\n[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",     "(\r\n[^\r\n]+)+"
	AddCmdNoSummary "FLTMC"
	AddCommand      "FORFILES",      ":\r\n +[A-Z][^\r\n]+(\r\n[^\r\n]+)*\r\n\r\n",  "(\r\n[^\r\n]+)+"
	AddCommand      "FTP",           "\r\n[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",     "(\r\n[^\r\n]+)+"
	AddCommand      "GETMAC",        ":\r\n +[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",  "(\r\n +[^\r\n]+)+"
	AddCommand      "GPFIXUP",       "([^\r\n]+[\r\n]{2,3})+[\r\n]{2,3}",            "([^\r\n]+[\r\n]{2,3})+"
	AddCommand      "GPUPDATE",      ": +[A-Z][^\r\n]+[\r\n]{2,3}([^\r\n]+[\r\n]{2,3})*[\r\n]{4,6}", "([^:][^\r\n]+[\r\n]{2,3})+"
	AddCommand      "GRAFTABL",      "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "HANDLE",        "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "HEX2DEC",       "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "HOSTNAME",      "\r\n[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",     "(\r\n[^\r\n]+)+"
	AddCommand      "IFMEMBER",      "\r\n[^/]+\r\n",                                "(.|\r|\n)+"
	AddCmdNoSummary "IISRESET"
	AddCommand      "IPCONFIG",      "\r\n\r\n[A-Z][^\r\n]+\r\n([^\r\n\s][^\r\n]+\r\n)+\r\n", "([^\r\n]+\r\n)+"
	AddCommand      "ISCSICLI",      "([^\r\n]+ [^\r\n]+[\r\n]{1,2})+",              "(.|\r|\n)+"
	AddCommand      "JT",            "[^\r\n]+",                                     "(.|\r|\n)+"
	AddCommand      "JUNCTION",      "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "LDIFDE",        "[\r\n]+([^\r\n]+ [^\r\n]+[\r\n]{1,2}[^=])+",   "([^\r\n]+ [^\r\n]+[\r\n]+)+"
	AddCommand      "LDMDUMP",       "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "LISTDLLS",      "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "LODCTR",        "\r\n +[A-Z][^\r\n]+\r\n( +[^\r\n]+\r\n)*\r\n", "([^\r\n]+\r\n)+"
	AddCommand      "LOGEVENT",      ": +[^\r\n]+\r\n([^\r\n]+\r\n)*",               "[^:][^\r\n]+\r\n([^\r\n]+\r\n)*"
	AddCommand      "LOGMAN",        "[\r\n]+[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",  "([^\r\n]+\r\n)+"
	AddCommand      "LOGOFF",        "[^\r\n]+\r\n",                                 "[^\r\n]+"
	AddCommand      "LOGONSESSIONS", "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\r\n]+"
	AddCommand      "LPR",           "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\r\n]+"
	AddCommand      "MAKECAB",       "([^\r\n\[]+ [^\r\n\[]+[\r\n]+)+",              "(.|\r|\n)+"
	AddCommand      "MANAGE-BDE",    "Description:\s+([^\n]+\n)+",                   "\s.*[\n\r]{0,2}.*"
	AddCommand      "MBR2GPT",       "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "MEM",           "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "MOUNTVOL",      "[\r\n]*[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",  "([^\r\n]+\r\n)+"
	AddCommand      "MOVEFILE",      "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\r\n]+"
	AddCmdNoSummary "MRINFO"
	AddCommand      "MSG",           "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "NBTSTAT",       "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCmdNoSummary "NET"
	AddCmdNoSummary "NETCFG"
	AddCmdNoSummary "NETDOM"
	AddCmdNoSummary "NETSH"
	AddCommand      "NETSTAT",       "[\r\n]*[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",  "([^\r\n]+\r\n)+"
	AddCommand      "NLSFUNC",       "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCmdNoSummary "NLTEST"
	AddCmdNoSummary "NSLOOKUP"
	AddCommand      "NTDSUTIL",      "\n([^ \r\n\(][^\r\n\(]+\r?\n)+\r?\n",          "(.|\r|\n)+"
	AddCommand      "OPENFILES",     ":\r\n\s([^\r\n]+\r\n)+\r\n",                   "[^:](.|\r|\n)+"
	AddCmdNoSummary "PATHPING"
	AddCmdNoSummary "PING"
	AddCommand      "PNPUNATTEND",   ":[\r\n]+[^:\r\n]+",                            "[^:\r\n]+"
	AddCommand      "PNPUTIL",       "^[\n\r]*[^:\r\n]+[\n\r]+",                     "[^\n\r]+"
	AddCommand      "PORTQRY",       "[\r\n]*[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",  "([^\r\n]+\r\n)+"
	AddCommand      "POWERCFG",      ":\r\n +[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",  "(\r\n +[^\r\n]+)+"
	AddCmdNoSummary "POWERSHELL"
	AddCommand      "PRINTBRM",      "^[\n\r]*[^\n\r]+",                             "[^\n\r]+"
	AddPrnScript    "PRNCNFG.VBS"
	AddPrnScript    "PRNDRVR.VBS"
	AddPrnScript    "PRNJOBS.VBS"
	AddPrnScript    "PRNMNGR.VBS"
	AddPrnScript    "PRNPORT.VBS"
	AddPrnScript    "PRNQCTL.VBS"
	AddCommand      "PROCDUMP",      "^[\n\r]+(?:[^\n\r]+[\n\r]{1,3}){4}[\n\r]{1,3}((?:[^\n\r\-:\(]+[\n\r]{1,3}){1,2})[\n\r]+", "[\n\r]+([^\n\r\(\-]+[\n\r]{1,3})[\n\r]+"
	AddCommand      "PSEXEC",        "- ([^\r\n\-]+[\r\n]{1,2})+",                   "[^-]([^\r\n]+\r\n)+"
	AddCommand      "PSFILE",        "([\r\n]{1,2}[A-Za-z .]+ [A-Za-z .]+)+\.",      "(.|\r|\n)+"
	AddCommand      "PSGETSID",      "- ([^\r\n\-]+[\r\n]{1,2})+",                   "[^-]([^\r\n]+\r\n)+"
	AddCommand      "PSINFO",        "- ([^\r\n\-]+[\r\n]{1,2})+",                   "[^-]([^\r\n]+\r\n)+"
	AddCommand      "PSKILL",        "- ([^\r\n\-]+[\r\n]{1,2})+",                   "[^-]([^\r\n]+\r\n)+"
	AddCommand      "PSLIST",        "- ([^\r\n\-]+[\r\n]{1,2})+",                   "[^-]([^\r\n]+\r\n)+"
	AddCommand      "PSLOGGEDON",    "- ([^\r\n\-]+[\r\n]{1,2})+",                   "[^-]([^\r\n]+\r\n)+"
	AddCommand      "PSLOGLIST",     "- ([^\r\n\-]+[\r\n]{1,2})+",                   "[^-]([^\r\n]+\r\n)+"
	AddCommand      "PSPASSWD",      "- ([^\r\n\-]+[\r\n]{1,2})+",                   "[^-]([^\r\n]+\r\n)+"
	AddCommand      "PSPING",        "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "PSSERVICE",     "- ([^\r\n\-]+[\r\n]{1,2})+",                   "[^-]([^\r\n]+\r\n)+"
	AddCommand      "PSSHUTDOWN",    "- ([^\r\n\-]+[\r\n]{1,2})+",                   "[^-]([^\r\n]+\r\n)+"
	AddCommand      "PSSUSPEND",     "- ([^\r\n\-]+[\r\n]{1,2})+",                   "[^-]([^\r\n]+\r\n)+"
	AddPrnScript    "PUBPRN.VBS"
	AddCommand      "QAPPSRV",       "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCommand      "QPROCESS",      "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCmdNoSummary "QUERY"
	AddCommand      "QUSER",         "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCommand      "QWINSTA",       "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCmdNoSummary "RASDIAL"
	AddCmdNoSummary "RDPSIGN"
	AddCommand      "REAGENTC",      "([^\r\n\\<[]+[\r\n]+)+",                       "(.|\r|\n)+"
	AddCommand      "RECIMG",        "^([^\r\n]+\r\n)+",                             "(.|\r|\n)+"
	AddCommand      "RECOVER",       "[\r\n]*[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",  "([^\r\n]+\r\n)+"
	AddCmdNoSummary "REDIRCMP"
	AddCmdNoSummary "REDIRUSR"
	AddCmdNoSummary "REG"
	AddCommand      "REGDELNULL",    "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCmdNoSummary "REGINI"
	AddCommand      "REGISTER-CIMPROVIDER", "([^\r\n\:]+[\r\n]+)+",                  "(.|\r|\n)+"
	AddCommand      "RELOG",         "[\r\n]+[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)+\r\n",  "([^\r\n]+\r\n)+"
	AddCommand      "RENDOM",        "[\r\n]([^\r\n\(\:]+[\r\n]+)+",                 "(.|\r|\n)+"
	AddCmdNoSummary "REPADMIN"
	AddCommand      "REPAIR-BDE",    "Description:\s+([^\n]+\n)+",                   "\s.*[\n\r]{0,2}.*"
	AddCmdNoSummary "RESET"
	AddCommand      "ROUTE",         "\r\n[A-Z][^\r\n]+\r\n([^\r\n]+\r\n)*\r\n",     "([^\r\n]+\r\n)+"
	AddCmdNoSummary "RPCPING"
	AddCommand      "RU",            "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCmdNoSummary "RUNAS"
	AddCommand      "RWINSTA",       "RWINSTA\s+[^\n\r]+[\n\r]{0,2}[^\n\r]+[\n\r]{3,}", "[\n\r].*[\n\r]"
	AddCmdNoSummary "SDBINST"
	AddCommand      "SDELETE",       "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCmdNoSummary "SECEDIT"
	AddCmdNoSummary "SETSPN"
	AddCommand      "SETVER",        "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "SETX",          ":\r\n +[^\r\n/]+\r\n( +[^\r\n/]+\r\n)*",       "[^:](.|\r|\n)+"
	AddCommand      "SFC",           "[\r\n]([^\r\n\(\[]+[\r\n]{2,3})+",             "(.|\r|\n)+"
	AddCommand      "SHADOW",        "SHADOW\s+[^\n\r]+[\n\r]{0,2}[^\n\r]+[\n\r]{3,}", "[\n\r].*[\n\r]"
	AddCmdNoSummary "SHORTCUT"
	AddCommand      "SIGCHECK",      "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "SOON",          ":[^:]*:",                                      "[^:]+"
	AddCommand      "STREAMS",       "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "STRINGS",       "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "SUBINACL",      "([^\r\n]+\r\n)+",                              "([^\r\n]+\r\n)+"
	AddCmdNoSummary "SXSTRACE"
	AddCommand      "SYNC",          "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "TAKEOWN",       ":\r\n +[^\r\n]+\r\n( +[^\r\n]+\r\n)*",         "([^:\r\n][^\r\n]+\r\n)+"
	AddCommand      "TIMEOUT",       ":\r\n +[^\r\n]+\r\n( +[^\r\n]+\r\n)*",         "[^:](.|\r|\n)+"
	AddCmdNoSummary "TRACERPT"
	AddCmdNoSummary "TRACERT"
	AddCommand      "TSCON",         "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "TSDISCON",      "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "TSKILL",        "([^\r\n]+\r\n)+",                              "(.|\r|\n)+"
	AddCommand      "TYPEPERF",      "\)[\r\n]{2,4}([^\s\r\n][^\r\n]+[^:\r\n][\r\n]{2,4})+", "([^\)\s\r\n][^\r\n]+[\r\n]{2,4})+"
	AddCmdNoSummary "TZUTIL"
	AddCommand      "UNLODCTR",      "\r\n +[A-Z][^\r\n]+\r\n( +[^\r\n]+\r\n)*\r\n", "([^\r\n]+\r\n)+"
	AddCommand      "VAULTCMD",      "[^\r\n]+",                                     ".+"
	AddCmdNoSummary "VERIFIER"
	AddCommand      "VOLUMEID",      "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "VSSADMIN",      "[^\(\r\n]+\r\n([^\(\r\n\(]+)*",                "([^\r\n]+\r\n)+"
	AddCmdNoSummary "W32TM"
	AddCommand      "WAITFOR",       ":\r\n +[^\r\n]+\r\n( +[^\r\n]+\r\n)*",         "[^:](.|\r|\n)+"
	AddCommand      "WBADMIN",       "[^\r\n]+",                                     ".+"
	AddCmdNoSummary "WECUTIL"
	AddCmdNoSummary "WEVTUTIL"
	AddCommand      "WHERE",         ":\r\n +[^\r\n]+\r\n( +[^\r\n]+\r\n)*",         "[^:](.|\r|\n)+"
	AddCommand      "WHOAMI",        "[^\d]:\r\n +[^\r\n]+\r\n( +[^\r\n]+\r\n)*",    "[^:]{2}(.|\r|\n)+"
	AddCommand      "WHOIS",         "^[\n\r]*[^\n\r]*[\n\r]+",                      "[^\n\r]+"
	AddCommand      "WINRM",         "\r\n[^\r\n]+\r\n([^\r\n]+\r\n)*",              "([^\r\n]+\r\n)+"
	AddCmdNoSummary "WINRS"
	AddCommand      "WINSAT",        "\r\n[^\r\n]+\r\n([^\r\n]+\r\n)*",              ".+"
	AddCmdNoSummary "WMIC"
	
	' Extra check for RUNAS, because it doesn't always use Standard Output
	If GetAddedCmdHelp( "RUNAS" ) <> "" Then
		AddCmdNoSummary "RUNAS"
	End If
	
	' Sort the list of commands
	SortDictionary dicHelpShort, dictKey
	
	' Display intermediate results for debugging purposes
	If blnDebug Then
		strMsg = DebugDisplayHelpFound( )
		WScript.Echo strMsg
		If blnDebugLog Then
			On Error Resume Next
			objDebugLog.Write strMsg
			If Err Then
				WScript.Echo "==================================================="
				WScript.Echo "DEBUG: Error while trying to write to the log file:"
				WScript.Echo Err.Description
				WScript.Echo "==================================================="
			End If
			On Error Goto 0
		End If
	End if
End If

If blnDebug Then
	DebugDisplay Max( dicHelpShort.Count, dicHelpLong.Count ) & " commands processed," & vbCrLf _
	           & dicHelpShort.Count & " with summary," & vbCrLf _
	           & dicHelpLong.Count & " with long help text."
End If

' Create the head for the HTML page
strHead = HTMLHead( )

' Create the commands index for the HTML page
strPreviousLetter = "@"
strAlphabet       = "<table class=""Alphabet"">" & vbCrLf & "<tr>" & vbCrLf
strHTML           = "<table class=""List"">" & vbCrLf
For Each objKey In dicHelpShort.Keys( )
	strCommand = objKey
	' Only add the command if there is a help text or summary
	If Not SuperTrim( dicHelpLong.Item( strCommand ) ) & SuperTrim( dicHelpShort.Item( strCommand ) ) = "" Then
		strFileVer = FileVer( strCommand )
		If strFileVer <> "-1" Then
			If arrIntCmd.Contains( strCommand ) Then
				strClass = " class=""Internal"""
			Else
				If arrHelpWin.Contains( strCommand ) Then
					strClass = ""
				Else
					strClass = " class=""Additional"""
				End If
			End If
			If arrHelpWinChr1.Contains( Left( strCommand, 1 ) ) Then
				blnNohlpChr1 = False
			Else
				blnNohlpChr1 = True
			End If
			strFirstLetter = UCase( Left( strCommand, 1 ) )
			If strFirstLetter <> strPreviousLetter Then
				If strFirstLetter <> "A" Then
					strHTML = strHTML & "<tr"
					If blnNohlpChr1 Then strHTML = strHTML & strClass
					strhtml = strhtml & "><td colspan=""2"">&nbsp;</td></tr>" & vbCrLf
				End If
				strHTML = strHTML & "<tr id=""" & strFirstLetter & """"
				If blnNohlpChr1 Then strHTML = strHTML & strClass
				strHTML = strHTML _
				        & ">" _
				        & vbCrLf _
				        & vbTab & "<th colspan=""2"">" & strFirstLetter & "</th>" _
				        & vbCrLf _
				        & "</tr>" _
				        & vbCrLf _
				        & "<tr"
				If blnNohlpChr1 Then strHTML = strHTML & strClass
				strHTML = strHTML _
				        & "><td colspan=""2"">&nbsp;</td></tr>" _
				        & vbCrLf
				If strFirstLetter <> "A" Then
					If Asc( strFirstLetter ) - Asc( strPreviousLetter ) > 1 Then
						For i = Asc( strFirstLetter ) - Asc( strPreviousLetter ) - 1 To 1 Step -1
							strAlphabet = strAlphabet _
							            & vbTab & "<th style=""color: gray;"">" & Chr( Asc( strFirstLetter ) - i ) & "</th>" _
							            & vbCrLf
						Next
					End If
				End If
				strAlphabet = strAlphabet & vbTab & "<th><a href=""#" & strFirstLetter & """"
				If blnNohlpChr1 Then strAlphabet = strAlphabet & " class=""AdditionalChar"""
				strAlphabet = strAlphabet & ">" & strFirstLetter & "</a></th>" & vbCrLf
				strPreviousLetter = strFirstLetter
			End If
			strHTML = strHTML _
			        & "<tr" & strClass & ">" _
			        & vbCrLf
			If dicHelpLong.Exists( strCommand ) Then
				If dicHelpLong.Item( strCommand ) = "" Then
					strHTML = strHTML & vbTab & "<td class=""Command"">" & strCommand & "</td>" & vbCrLf
				Else
					strHTML = strHTML & vbTab & "<td class=""Command""><a href=""#" & strCommand & """>" & strCommand & "</a></td>" & vbCrLf
				End If
			End If
			strHTML = strHTML & vbTab & "<td>" & Escape( dicHelpShort.Item( strCommand ), intCodePage ) & "</td>" & vbCrLf
			strHTML = strHTML & "</tr>" & vbCrLf
		End If
	End If
Next
If strFirstLetter <> "Z" Then
	For i = 1 To Asc( "Z" ) - Asc( strFirstLetter )
		strAlphabet = strAlphabet & vbTab & "<th style=""color: gray;"">" & Chr( Asc( strFirstLetter ) + i ) & "</th>" & vbCrLf
	Next
End If
strHTML     = strHTML     & "</table>" & vbCrLf & vbCrLf
If Not blnWindowsOnly Then
	strAlphabet = strAlphabet & vbTab & "<th><input type=""button"" id=""WinOnlyButton"" value=""Windows Help Only"" onclick=""toggleVisibility();"" /></th>" & vbCrLf
End If
strAlphabet = strAlphabet & "</tr>" & vbCrLf & "</table>" & vbCrLf & vbCrLf
strHTML     = strHead & strAlphabet & "<p>&nbsp;</p>" & vbCrLf & vbCrLf & strHTML

' Add detailed help for each command, if available
For Each objKey In dicHelpShort.Keys( )
	strCommand = objKey
	' Only add the command if there is a help text
	If Not SuperTrim( dicHelpLong.Item( strCommand ) ) = "" Then
		strFileVer = FileVer( strCommand )
		If strFileVer <> "-1" Then
			If dicHelpLong.Exists( strCommand ) Then
				' WinSAT ignores the actual code page, so we use code page 1252 to "escape" its output
				If strCommand = "WINSAT" Then
					strHelpLong = Escape( dicHelpLong.Item( strCommand ), 1252 )
				Else
					strHelpLong = Escape( dicHelpLong.Item( strCommand ), intCodePage )
				End If
				If strHelpLong <> "" Then
					If arrIntCmd.Contains( strCommand ) Then
						strHTML    = strHTML & "<div class=""InternalCommand"">" & vbCrLf & vbCrLf
						strCmdInfo = " &nbsp; <span style=""font-size: 60%;"">(internal command)</span>"
					Else
						If Not arrHelpWin.Contains( strCommand ) Then
							strHTML = strHTML & "<div class=""AdditionalHelp"">" & vbCrLf & vbCrLf
						End If
						If strFileVer = "" Then
							strCmdInfo = ""
						Else
							strCmdInfo = " &nbsp; <span style=""font-size: 60%;"">(Version " & strFileVer & ")</span>"
						End If
					End If
					strHTML = strHTML & "<p>&nbsp;</p>" & vbCrLf & vbCrLf _
					        & "<h2 id=""" & strCommand & """>" & strCommand & strCmdInfo & "</h2>" & vbCrLf & vbCrLf _
					        & "<pre>" & strHelpLong & "</pre>" & vbCrLf & vbCrLf _
					        & "<div style=""text-align: center;""><a href=""#"">Back to the top of this page</a></div>" & vbCrLf & vbCrLf
					If arrIntCmd.Contains( strCommand ) Or Not arrHelpWin.Contains( strCommand ) Then
						strHTML = strHTML & "</div>" & vbCrLf & vbCrLf
					End If
				End If
			End If
		End If
	End If
Next

' Write the "footer"
strHTML = strHTML & HTMLFoot( )

'Trim leading and trailing blank lines inside PRE blocks (workaround for CR/CR/LF bug)
strHTML = TrimCrLf( strHTML )

If intUnexpectedCodepage > 0 Then
	WScript.Echo "Unexpected Code Page: " & intCodePage & vbCrLf
	WScript.Echo "To have it added to the list of correctly translated code pages, notify the author of this script." & vbCrLf
	WScript.Echo "Until this code page is added to the script, accented letters will be displayed incorrectly in the HTML output."
End If

If blnQuiet Then
	WScript.Echo strHTML
Else
	' Write the complete HTML code to a file
	On Error Resume Next
	Set objHTMLFile = objFSO.CreateTextFile( strFile, True, False )
	objHTMLFile.Write strHTML
	Set objHTMLFile = Nothing
	If Err Then
		DebugDisplay "Error: " & Err.Description & vbCrLf & "Try ""ALLHELP.VBS /Q > ""outputfile"" if you cannot correct the error"
	End If
	On Error Goto 0
	
	' Allow the virus scanner some time before opening the HTML file we just created
	WScript.Sleep 3000
	
	'Open the HTML file
	wshShell.Run """" & strFile & """", 0, False

	' Display this script's help screen when in debugging mode
	If blnDebug Then Syntax
End If

If blnDebugLog Then
	objDebugLog.Close
	Set objDebugLog = Nothing
End If

' Close the last remaining objects
Set objFSO   = Nothing
Set wshShell = Nothing



Sub AddCmdNoSummary( myCommand )
' Add a command using the file description without checking for a command summary first
	Dim strCmdHelp, strCommand, strDebug, strFileDescription
	strCommand = Trim( UCase( myCommand ) )
	If Not dicHelpShort.Exists( strCommand ) Then
		blnAdditional = True
		If blnDebug Then
			strDebug = "DEBUG: Adding help for the " & strCommand & " command"
			WScript.Echo String( Len( strDebug ), "=" ) & vbCrLf & strDebug
			WScript.Echo String( Len( strDebug ), "=" ) & vbCrLf
		End If
		' Get the complete help text
		strCmdHelp         = GetAddedCmdHelp( strCommand )
		' Get the file description
		strFileDescription = GetFileDescription( strCommand )
		If ( strCmdHelp <> "" Or strFileDescription <> "" ) Then
			dicHelpLong.Add  strCommand, strCmdHelp
			dicHelpShort.Add strCommand, strFileDescription
		Else
			If blnDebug Then DebugDisplay "No help nor description available for " & strCommand
		End If
	End If
End Sub



Sub AddCommand( myCommand, myPattern1, myPattern2 )
' Check if a command is available and, if so, get its complete help text
	Dim objMatches, objMatches2, objRE, strCommand, strDebug, strFolder
	strCommand = Trim( UCase( myCommand ) )
	If dicHelpShort.Item( strCommand ) = "" Then
		blnAdditional = True
		If blnDebug Then DebugDisplay "Trying to get help for the " & strcommand & " command:"
		' Get the complete help text for the command
		dicHelpLong.Item( strCommand ) = GetAddedCmdHelp( strCommand )
		' Try to extract the command help summary using two regular expressions
		Set objRE = New RegExp
		objRE.Global     = False
		objRE.IgnoreCase = False
		objRE.Pattern    = myPattern1
		Set objMatches = objRE.Execute( dicHelpLong.Item( strCommand ) )
		If blnDebug Then
			WScript.Echo "DEBUG: " & Right( Space( 3 ) & objMatches.Count, 3 ) & " match(es) for the regular expression"
			If objMatches.Count = 0 Then
				If dicHelpLong.Item( strCommand ) = "" Then
					WScript.Echo "DEBUG: Empty help text (unknown command?)"
				Else
					WScript.Echo "DEBUG: The following help text did not match:"
					WScript.Echo dicHelpLong.Item( strCommand )
				End If
			End If
			WScript.Echo String( Len( strDebug ), "=" ) & vbCrLf
		End If
		If objMatches.Count > 0 Then
			objRE.Pattern = myPattern2
			Set objMatches2 = objRE.Execute( objMatches.Item(0) )
			If objMatches2.Count > 0 Then
				dicHelpShort.Item( strCommand ) = SuperTrim( objMatches2.Item(0) )
			End If
			Set objMatches2 = Nothing
		End If
		Set objMatches = Nothing
		Set objRE      = Nothing
	End If
	' If no help text summary was found, try using the file description
	If dicHelpShort.Item( strCommand ) = "" Then
		If strCommand = "PRINTBMR" Then
			strFolder = wshShell.ExpandEnvironmentStrings( "%windir%\system32\spool\tools" )
		End If
		dicHelpShort.Item( strCommand ) = GetFileDescription( strCommand )
	End If
	' For debugging purposes
	If blnDebug Then
		DebugDisplay vbCrLf _
		           & "ShortHelp for """ & strCommand & """ is :" & dicHelpShort.Item( strCommand ) _
		           & vbCrLf _
		           & "LongHelp  for """ & strCommand & """ is :" & dicHelpLong.Item( strCommand )
	End If
End Sub



Sub AddPrnScript( myCommand )
	Dim blnFound
	Dim intFolders
	Dim colMatches, colSubFolders, objExec, objFolder, objRE
	Dim strCommand, strFolder, strHelp, strScriptPath
	strFolder = wshShell.ExpandEnvironmentStrings( "%windir%\System32\Printing_Admin_Scripts" )
	If objFSO.FolderExists( strFolder ) Then
		Set colSubFolders = objFSO.GetFolder( strFolder ).SubFolders
		intFolders = colSubFolders.Count
		blnFound   = False
		If intFolders = 1 Then
			strFolder = colSubFolders(0).Path
			blnFound  = True
		ElseIf intFolders > 1 Then
			For Each objFolder In colSubFolders
				If ( Left( GetOSLanguage( strOSLocl ), 7 ) = "English" ) And  ( InStr( UCase( objFolder.Name ), "EN-" ) > 0 ) Then
					strFolder = objFolder.Path
					blnFound  = True
				End If
			Next
			If Not blnFound Then
				For Each objFolder In colSubFolders
					strFolder = objFolder.Path
					blnFound  = True
				Next
			End If
		End If
		Set colSubFolders = Nothing
		If blnFound Then
			With objFSO
				If .FileExists( .BuildPath( strFolder, myCommand ) ) Then
					strScriptPath = .BuildPath( strFolder, myCommand )
				ElseIf .FileExists( .BuildPath( strFolder, myCommand & ".vbs" ) ) Then
					strScriptPath = .BuildPath( strFolder, myCommand & ".vbs" )
				Else
					Exit Sub
				End If
				strCommand = UCase( .GetFileName( strScriptPath ) )
			End With
			If blnDebug Then DebugDisplay "Trying to get help for the " & strCommand & " command:"
			' Get the complete help text for the command
			Set objExec = wshShell.Exec( "CMD /A /C TYPE """ & strScriptPath & """ | MORE" )
			strHelp = objExec.StdOut.ReadAll( )
			Set objExec = Nothing
			Set objRE   = New RegExp
			objRE.Pattern = "^('[^\n\r]*[\n\r]{1,2})+"
			objRE.Global  = False
			If objRE.Test( strHelp ) Then
				Set colMatches = objRE.Execute( strHelp )
				strHelp = vbCrLf & colMatches.Item(0).Value
				Set colMatches = Nothing
				objRE.Pattern = "[\n\r]+'-*"
				objRE.Global  = True
				strHelp = objRE.Replace( strHelp, vbCrLf )
				dicHelpLong.Item( strCommand ) = strHelp
				objRE.Pattern    = "Abstract:\s*" & strCommand & "\s*-\s*((?:.|\n|\r)+)Usage:"
				objRE.Global     = True
				objRE.IgnoreCase = True
				If objRE.Test( strHelp ) Then
					Set colMatches = objRE.Execute( strHelp )
					strHelp = SuperTrim( colMatches.Item(0).Submatches.Item(0) )
					dicHelpShort.Item( strCommand ) = UCase( Left( strHelp, 1 ) ) & Mid( strHelp, 2 )
					Set colMatches = Nothing
				Else
					objRE.Pattern    = "\s+" & strCommand & "\s+-\s+((?:.|\n|\r)*)Arguments are:"
					objRE.Global     = True
					objRE.IgnoreCase = True
					If objRE.Test( strHelp ) Then
						Set colMatches = objRE.Execute( strHelp )
						strHelp = SuperTrim( colMatches.Item(0).Submatches.Item(0) )
						dicHelpShort.Item( strCommand ) = UCase( Left( strHelp, 1 ) ) & Mid( strHelp, 2 )
						Set colMatches = Nothing
					Else
						dicHelpShort.Item( strCommand ) = ""
					End If
				End If
			Else
				Exit Sub
			End If
			Set objRE = Nothing
			If blnDebug Then
				DebugDisplay vbCrLf _
				           & "ShortHelp for """ & strCommand & """ is :""" & dicHelpShort.Item( strCommand ) & """" _
				           & vbCrLf _
				           & "LongHelp  for """ & strCommand & """ is :" & dicHelpLong.Item( strCommand )
			End If


		End If
	End If
End Sub



Sub DebugDisplay( myString )
' Format and then display debugging info
	Dim strSep, strMsg
	If blnQuiet Then Exit Sub
	strMsg = "DEBUG: " & myString
	strSep = String( Min( Len( strMsg ), 80 ), "=" )
	strMsg = strSep & vbCrLf & strMsg & vbCrLf & strSep & vbCrLf
	WScript.Echo strMsg
	If blnDebugLog Then
		On Error Resume Next
		objDebugLog.Write strMsg
		If Err Then
			WScript.Echo "=================================================="
			WScript.Echo "DEBUG: Error while trying to write to the log file"
			WScript.Echo "=================================================="
		End If
		On Error Goto 0
	End If
End Sub



Function DebugDisplayHelpFound( )
' Show intermediate results
	Dim strMsg
	strMsg = "====================================" _
	       & vbCrLf _
	       & "DEBUG: The following help was found:" _
	       & vbCrLf _
	       & "====================================" _
	       & vbCrLf
	For Each objKey In dicHelpShort.Keys( )
		strMsg = strMsg & Left( objKey & Space( 16 ), 16 ) & Escape( dicHelpShort.Item( objKey ), intCodePage ) & vbCrLf
		' strMsg = strMsg & Left( objKey & Space( 16 ), 16 ) & dicHelpShort.Item( objKey ) & vbCrLf
	Next
	strMsg = strMsg _
	       & "====================================" _
	       & vbCrLf
	DebugDisplayHelpFound = strMsg
End Function



Function Escape( myText, myCodePage )
' Remove characters that HTML cannot properly handle
	Dim strText
	strText = Replace( myText,  "&", "&amp;"  )
	strText = Replace( strText, "^", "&circ;" )
	strText = Replace( strText, "<", "&lt;"   )
	strText = Replace( strText, ">", "&gt;"   )
	Select Case myCodePage
		Case 437:
			strText = Replace( strText, Chr(160), "&aacute;" )
			strText = Replace( strText, Chr(131), "&acirc;"  )
			strText = Replace( strText, Chr(133), "&agrave;" )
			strText = Replace( strText, Chr(134), "&aring;"  )
			strText = Replace( strText, Chr(143), "&Aring;"  )
			strText = Replace( strText, Chr(132), "&auml;"   )
			strText = Replace( strText, Chr(142), "&Auml;"   )
			strText = Replace( strText, Chr(145), "&aelig;"  )
			strText = Replace( strText, Chr(146), "&AElig;"  )
			strText = Replace( strText, Chr(135), "&ccedil;" )
			strText = Replace( strText, Chr(128), "&Ccedil;" )
			strText = Replace( strText, Chr(130), "&eacute;" )
			strText = Replace( strText, Chr(144), "&Eacute;" )
			strText = Replace( strText, Chr(136), "&ecirc;"  )
			strText = Replace( strText, Chr(138), "&egrave;" )
			strText = Replace( strText, Chr(137), "&euml;"   )
			strText = Replace( strText, Chr(161), "&iacute;" )
			strText = Replace( strText, Chr(140), "&icirc;"  )
			strText = Replace( strText, Chr(141), "&igrave;" )
			strText = Replace( strText, Chr(139), "&iuml;"   )
			strText = Replace( strText, Chr(164), "&ntilde;" )
			strText = Replace( strText, Chr(165), "&Ntilde;" )
			strText = Replace( strText, Chr(162), "&oacute;" )
			strText = Replace( strText, Chr(147), "&ocirc;"  )
			strText = Replace( strText, Chr(149), "&ograve;" )
			strText = Replace( strText, Chr(148), "&ouml;"   )
			strText = Replace( strText, Chr(153), "&Ouml;"   )
			strText = Replace( strText, Chr(163), "&uacute;" )
			strText = Replace( strText, Chr(150), "&ucirc;"  )
			strText = Replace( strText, Chr(151), "&ugrave;" )
			strText = Replace( strText, Chr(129), "&uuml;"   )
			strText = Replace( strText, Chr(154), "&Uuml;"   )
			strText = Replace( strText, Chr(230), "&micro;"  )
			strText = Replace( strText, Chr(248), "&deg;"    )
			strText = Replace( strText, Chr(173), "&iexcl;"  )
			strText = Replace( strText, Chr(168), "&iquest;" )
			strText = Replace( strText, Chr(241), "&plusmn;" )
		Case 850:
			strText = Replace( strText, Chr(160), "&aacute;" )
			strText = Replace( strText, Chr(181), "&Aacute;" )
			strText = Replace( strText, Chr(131), "&acirc;"  )
			strText = Replace( strText, Chr(182), "&Acirc;"  )
			strText = Replace( strText, Chr(133), "&agrave;" )
			strText = Replace( strText, Chr(183), "&Agrave;" )
			strText = Replace( strText, Chr(134), "&aring;"  )
			strText = Replace( strText, Chr(143), "&Aring;"  )
			strText = Replace( strText, Chr(198), "&atilde;" )
			strText = Replace( strText, Chr(199), "&Atilde;" )
			strText = Replace( strText, Chr(132), "&auml;"   )
			strText = Replace( strText, Chr(142), "&Auml;"   )
			strText = Replace( strText, Chr(145), "&aelig;"  )
			strText = Replace( strText, Chr(146), "&AElig;"  )
			strText = Replace( strText, Chr(135), "&ccedil;" )
			strText = Replace( strText, Chr(128), "&Ccedil;" )
			strText = Replace( strText, Chr(130), "&eacute;" )
			strText = Replace( strText, Chr(144), "&Eacute;" )
			strText = Replace( strText, Chr(136), "&ecirc;"  )
			strText = Replace( strText, Chr(210), "&Ecirc;"  )
			strText = Replace( strText, Chr(138), "&egrave;" )
			strText = Replace( strText, Chr(212), "&Egrave;" )
			strText = Replace( strText, Chr(137), "&euml;"   )
			strText = Replace( strText, Chr(211), "&Euml;"   )
			strText = Replace( strText, Chr(161), "&iacute;" )
			strText = Replace( strText, Chr(214), "&Iacute;" )
			strText = Replace( strText, Chr(140), "&icirc;"  )
			strText = Replace( strText, Chr(215), "&Icirc;"  )
			strText = Replace( strText, Chr(141), "&igrave;" )
			strText = Replace( strText, Chr(222), "&Igrave;" )
			strText = Replace( strText, Chr(139), "&iuml;"   )
			strText = Replace( strText, Chr(216), "&Iuml;"   )
			strText = Replace( strText, Chr(164), "&ntilde;" )
			strText = Replace( strText, Chr(165), "&Ntilde;" )
			strText = Replace( strText, Chr(162), "&oacute;" )
			strText = Replace( strText, Chr(224), "&Oacute;" )
			strText = Replace( strText, Chr(147), "&ocirc;"  )
			strText = Replace( strText, Chr(226), "&Ocirc;"  )
			strText = Replace( strText, Chr(149), "&ograve;" )
			strText = Replace( strText, Chr(227), "&Ograve;" )
			strText = Replace( strText, Chr(228), "&otilde;" )
			strText = Replace( strText, Chr(229), "&Otilde;" )
			strText = Replace( strText, Chr(148), "&ouml;"   )
			strText = Replace( strText, Chr(153), "&Ouml;"   )
			strText = Replace( strText, Chr(163), "&uacute;" )
			strText = Replace( strText, Chr(233), "&Uacute;" )
			strText = Replace( strText, Chr(150), "&ucirc;"  )
			strText = Replace( strText, Chr(234), "&Ucirc;"  )
			strText = Replace( strText, Chr(151), "&ugrave;" )
			strText = Replace( strText, Chr(235), "&Ugrave;" )
			strText = Replace( strText, Chr(129), "&uuml;"   )
			strText = Replace( strText, Chr(154), "&Uuml;"   )
			strText = Replace( strText, Chr(236), "&yacute;" )
			strText = Replace( strText, Chr(237), "&Yacute;" )
			strText = Replace( strText, Chr(225), "&szlig;"  )
			strText = Replace( strText, Chr(230), "&micro;"  )
			strText = Replace( strText, Chr(248), "&deg;"    )
			strText = Replace( strText, Chr(173), "&iexcl;"  )
			strText = Replace( strText, Chr(191), "&iquest;" )
			strText = Replace( strText, Chr(169), "&copy;"   )
			strText = Replace( strText, Chr(174), "&reg;"    )
			strText = Replace( strText, Chr(171), "&laquo;"  )
			strText = Replace( strText, Chr(175), "&raquo;"  )
			strText = Replace( strText, Chr(241), "&plusmn;" )
			strText = Replace( strText, Chr(244), "&para;"   )
		Case 1252
			strText = Replace( strText, Chr(128), "&euro;"   )
			strText = Replace( strText, Chr(130), "&sbquo;"  )
			strText = Replace( strText, Chr(131), "&fnof;"   )
			strText = Replace( strText, Chr(132), "&bdquo;"  )
			strText = Replace( strText, Chr(136), "&circ;"   )
			strText = Replace( strText, Chr(137), "&permil;" )
			strText = Replace( strText, Chr(138), "&Scaron;" )
			strText = Replace( strText, Chr(139), "&lsaquo;" )
			strText = Replace( strText, Chr(140), "&OElig;"  )
			strText = Replace( strText, Chr(142), "&Zcaron;" )
			strText = Replace( strText, Chr(145), "&lsquo;"  )
			strText = Replace( strText, Chr(146), "&rsquo;"  )
			strText = Replace( strText, Chr(147), "&ldquo;"  )
			strText = Replace( strText, Chr(148), "&rdquo;"  )
			strText = Replace( strText, Chr(149), "&bull;"   )
			strText = Replace( strText, Chr(150), "&ndash;"  )
			strText = Replace( strText, Chr(151), "&mdash;"  )
			strText = Replace( strText, Chr(152), "&tilde;"  )
			strText = Replace( strText, Chr(153), "&trade;"  )
			strText = Replace( strText, Chr(154), "&scaron;" )
			strText = Replace( strText, Chr(155), "&rsaquo;" )
			strText = Replace( strText, Chr(156), "&oelig;"  )
			strText = Replace( strText, Chr(158), "&zcaron;" )
			strText = Replace( strText, Chr(159), "&Yuml;"   )
			strText = Replace( strText, Chr(161), "&iexcl;"  )
			strText = Replace( strText, Chr(162), "&cent;"   )
			strText = Replace( strText, Chr(163), "&pound;"  )
			strText = Replace( strText, Chr(164), "&curren;" )
			strText = Replace( strText, Chr(165), "&yen;"    )
			strText = Replace( strText, Chr(166), "&brvbar;" )
			strText = Replace( strText, Chr(167), "&sect;"   )
			strText = Replace( strText, Chr(168), "&uml;"    )
			strText = Replace( strText, Chr(169), "&copy;"   )
			strText = Replace( strText, Chr(170), "&ordf;"   )
			strText = Replace( strText, Chr(171), "&laquo;"  )
			strText = Replace( strText, Chr(172), "&not;"    )
			strText = Replace( strText, Chr(173), "&shy;"    )
			strText = Replace( strText, Chr(174), "&reg;"    )
			strText = Replace( strText, Chr(175), "&macr;"   )
			strText = Replace( strText, Chr(176), "&deg;"    )
			strText = Replace( strText, Chr(177), "&plusmn;" )
			strText = Replace( strText, Chr(178), "&sup2;"   )
			strText = Replace( strText, Chr(179), "&sup3;"   )
			strText = Replace( strText, Chr(180), "&acute;"  )
			strText = Replace( strText, Chr(181), "&micro;"  )
			strText = Replace( strText, Chr(182), "&para;"   )
			strText = Replace( strText, Chr(183), "&middot;" )
			strText = Replace( strText, Chr(184), "&cedil;"  )
			strText = Replace( strText, Chr(185), "&sup1;"   )
			strText = Replace( strText, Chr(186), "&ordm;"   )
			strText = Replace( strText, Chr(187), "&raquo;"  )
			strText = Replace( strText, Chr(188), "&frac14;" )
			strText = Replace( strText, Chr(189), "&frac12;" )
			strText = Replace( strText, Chr(190), "&frac34;" )
			strText = Replace( strText, Chr(191), "&iquest;" )
			strText = Replace( strText, Chr(192), "&Agrave;" )
			strText = Replace( strText, Chr(193), "&Aacute;" )
			strText = Replace( strText, Chr(194), "&Acirc;"  )
			strText = Replace( strText, Chr(195), "&Atilde;" )
			strText = Replace( strText, Chr(196), "&Auml;"   )
			strText = Replace( strText, Chr(197), "&Aring;"  )
			strText = Replace( strText, Chr(198), "&AElig;"  )
			strText = Replace( strText, Chr(199), "&Ccedil;" )
			strText = Replace( strText, Chr(200), "&Egrave;" )
			strText = Replace( strText, Chr(201), "&Eacute;" )
			strText = Replace( strText, Chr(202), "&Ecirc;"  )
			strText = Replace( strText, Chr(203), "&Euml;"   )
			strText = Replace( strText, Chr(204), "&Igrave;" )
			strText = Replace( strText, Chr(205), "&Iacute;" )
			strText = Replace( strText, Chr(206), "&Icirc;"  )
			strText = Replace( strText, Chr(207), "&Iuml;"   )
			strText = Replace( strText, Chr(208), "&ETH;"    )
			strText = Replace( strText, Chr(209), "&Ntilde;" )
			strText = Replace( strText, Chr(210), "&Ograve;" )
			strText = Replace( strText, Chr(211), "&Oacute;" )
			strText = Replace( strText, Chr(212), "&Ocirc;"  )
			strText = Replace( strText, Chr(213), "&Otilde;" )
			strText = Replace( strText, Chr(214), "&Ouml;"   )
			strText = Replace( strText, Chr(215), "&times;"  )
			strText = Replace( strText, Chr(216), "&Oslash;" )
			strText = Replace( strText, Chr(217), "&Ugrave;" )
			strText = Replace( strText, Chr(218), "&Uacute;" )
			strText = Replace( strText, Chr(219), "&Ucirc;"  )
			strText = Replace( strText, Chr(220), "&Uuml;"   )
			strText = Replace( strText, Chr(221), "&Yacute;" )
			strText = Replace( strText, Chr(222), "&THORN;"  )
			strText = Replace( strText, Chr(223), "&szlig;"  )
			strText = Replace( strText, Chr(224), "&agrave;" )
			strText = Replace( strText, Chr(225), "&aacute;" )
			strText = Replace( strText, Chr(226), "&acirc;"  )
			strText = Replace( strText, Chr(227), "&atilde;" )
			strText = Replace( strText, Chr(228), "&auml;"   )
			strText = Replace( strText, Chr(229), "&aring;"  )
			strText = Replace( strText, Chr(230), "&aelig;"  )
			strText = Replace( strText, Chr(231), "&ccedil;" )
			strText = Replace( strText, Chr(232), "&egrave;" )
			strText = Replace( strText, Chr(233), "&eacute;" )
			strText = Replace( strText, Chr(234), "&ecirc;"  )
			strText = Replace( strText, Chr(235), "&euml;"   )
			strText = Replace( strText, Chr(236), "&igrave;" )
			strText = Replace( strText, Chr(237), "&iacute;" )
			strText = Replace( strText, Chr(238), "&icirc;"  )
			strText = Replace( strText, Chr(239), "&iuml;"   )
			strText = Replace( strText, Chr(240), "&eth;"    )
			strText = Replace( strText, Chr(241), "&ntilde;" )
			strText = Replace( strText, Chr(242), "&ograve;" )
			strText = Replace( strText, Chr(243), "&oacute;" )
			strText = Replace( strText, Chr(244), "&ocirc;"  )
			strText = Replace( strText, Chr(245), "&otilde;" )
			strText = Replace( strText, Chr(246), "&ouml;"   )
			strText = Replace( strText, Chr(247), "&divide;" )
			strText = Replace( strText, Chr(248), "&oslash;" )
			strText = Replace( strText, Chr(249), "&ugrave;" )
			strText = Replace( strText, Chr(250), "&uacute;" )
			strText = Replace( strText, Chr(251), "&ucirc;"  )
			strText = Replace( strText, Chr(252), "&uuml;"   )
			strText = Replace( strText, Chr(253), "&yacute;" )
			strText = Replace( strText, Chr(254), "&thorn;"  )
			strText = Replace( strText, Chr(255), "&yuml;"   )
		Case Else
			intUnexpectedCodepage = myCodePage
	End Select
	Escape  = strText
End Function



Function FileVer( myCommand )
	Dim strExt, strFile, strFullPath
	FileVer = "-1" ' Default when file or command not found
	strFile = UCase( myCommand )
	If UCase( objFSO.GetExtensionName( myCommand ) ) = "VBS" Then
		FileVer = ""
	ElseIf strFile = "PRINTBRM" Then
		strFullPath = wshShell.ExpandEnvironmentStrings( "%windir%\system32\spool\tools\PRINTBRM.EXE" )
	Else
		strFullPath = Which( strFile )
	End If
	If strFullPath <> "" Then
		FileVer = objFSO.GetFileVersion( strFullPath )
	End If
End Function



Function GetAddedCmdHelp( myCommand )
' Get the short help text for the specified command and remove some unwanted characters
	Dim colMatches, objExec, objFile, objMatch, objRE, strCommand, strCommandLine, strFile, strHelp, strOutput
	strCommand = Trim( UCase( myCommand ) )
	' Build the command line to extract the help text
	strCommandLine = "CMD.EXE /A /C (TITLE AllHelp " & strScriptVer & ": " & strCommand & "&" & strCommand & " /? 2>&1)"
	' Not all commands use the same standard for getting their help text
	If strCommand = "AUTORUNSC" Then
		' AutorunsC's output encoding is a mess, so we need temporary files and MORE to clean up its output
		strFile = wshShell.ExpandEnvironmentStrings( "%Temp%\" & LCase( strCommand ) & ".txt" )
		strCommandLine = "CMD /A /C (" & strCommand & " /? > """ & strFile & """)"
		Set objExec = wshShell.Exec( strCommandLine )
		objExec.Terminate
		strCommandLine = "CMD /C (MORE < """ & strFile & """ > " & strFile & ".2)"
		Set objExec = wshShell.Exec( strCommandLine )
		objExec.Terminate
		strCommandLine = "CMD /A /C (TYPE """ & strFile & ".2"")"
	End If
	If strCommand = "HEX2DEC" Or strCommand = "IFMEMBER" Then
		' These commands show an error message if /? is used, they are best called without any arguments
		strCommandLine = "CMD.EXE /A /C (TITLE AllHelp " & strScriptVer & ": " & strCommand & "&" & strCommand & " 2>&1)"
	End If
	If strCommand = "PRINTBRM" Then
		' PRINTBRM is not in the PATH
		strCommandLine = "CMD.EXE /A /C (TITLE AllHelp " & strScriptVer & ": PRINTBRM&""" & wshShell.ExpandEnvironmentStrings( "%windir%\system32\spool\tools\PRINTBRM.EXE" ) & """ | FIND /V "":"")"
	End If
	If strCommand = "REGISTER-CIMPROVIDER" Then
		strCommandLine = "CMD.EXE /A /C (TITLE AllHelp " & strScriptVer & ": REGISTER-CIMPROVIDER&REGISTER-CIMPROVIDER -help 2>&1)"
	End If
	If strCommand = "RPCPING" Then
		' Use MORE to remove ASCII null characters
		strCommandLine = "CMD.EXE /A /C (TITLE AllHelp " & strScriptVer & ": RPCPING&RPCPING /? 2>&1 | MORE)"
	End If
	If strCommand = "SC" Then
		' SC requires non-directed keyboard input, so we'll add a message to the title bar
		strCommandLine = "CMD.EXE /A /C (TITLE AllHelp " & strScriptVer & ": SC - Press Enter to continue&SC /? 2>&1)"
	End If
	If strCommand = "SFC" Then
		' SFC's output encoding in Windows 8 is a mess, so we need temporary files and MORE to clean up its output
		strFile = wshShell.ExpandEnvironmentStrings( "%Temp%\" & LCase( strCommand ) & ".txt" )
		strCommandLine = "CMD /C (" & strCommand & " /? > """ & strFile & """ 2>&1)"
		Set objExec = wshShell.Exec( strCommandLine )
		objExec.Terminate
		strCommandLine = "CMD /C (MORE < """ & strFile & """ > " & strFile & ".2)"
		Set objExec = wshShell.Exec( strCommandLine )
		objExec.Terminate
		strCommandLine = "CMD /A /C (TYPE """ & strFile & ".2"")"
	End If
	If strCommand = "SUBINACL" Then
		' SUBINACL's output is incomplete Unicode and poses quite a challenge to redirect and then read;
		' so we first create an Unicode text file with 1 blank line, and then append SUBINACL's output
		strFile = wshShell.ExpandEnvironmentStrings( "%Temp%\" & LCase( strCommand ) & ".txt" )
		Set objFile  = objFSO.CreateTextFile( strFile, True, True )
		objFile.WriteBlankLines 1
		objFile.Close
		strCommandLine = "CMD /C (VER | " & strCommand & " /help /full >> """ & strFile & """ 2>&1)"
		Set objExec = wshShell.Exec( strCommandLine )
		objExec.Terminate
		Set objFile = objFSO.GetFile( strFile )
		If objFile.Size < 2048 Then
			Set objFile = Nothing
			Set objFile = objFSO.CreateTextFile( strFile, True, True )
			objFile.WriteBlankLines 1
			objFile.Close
			strCommandLine = "CMD /C (" & strCommand & " /? >> """ & strFile & """ 2>&1)"
			Set objExec = wshShell.Exec( strCommandLine )
			objExec.Terminate
		End If
		Set objFile = Nothing
		strCommandLine = "CMD /A /C (TYPE """ & strFile & """)"
	End If
	' Remove ASCII null characters; trick by Austin France
	' http://austinfrance.wordpress.com/2011/01/13/howto-vbscript-remove-chr0-null-from-a-string/
	Set objRE = New RegExp
	objRE.Global     = True
	objRE.Pattern    = "[\0]"
	objRE.IgnoreCase = False
	strHelp   = ""
	strOutput = ""
	Set objExec = wshShell.Exec( strCommandLine )
	strOutput = objExec.StdOut.ReadAll( )
	strHelp   = objRE.Replace( strOutput, "" )
	objExec.Terminate
	' Correct missing linefeed
	If strCommand = "BITSADMIN" Then
		strHelp = Replace( strHelp, "SetNotifyFlags/GETNOTIFYINTERFACE", "SetNotifyFlags" & vbCrLf & "/GETNOTIFYINTERFACE" )
	End If
	If strCommand = "DHCPLOC" Then
		' Strip path from program name
		objRE.Pattern    = "[\r\n][^\r\n]\\dhcploc\.exe \["
		objRE.IgnoreCase = True
		strHelp          = objRE.Replace( strHelp, "DHCPLOC.EXE [" )
	End If
	If strCommand = "FINDLINKS" Then
		' Strip path from program name
		objRE.Global     = False
		objRE.IgnoreCase = True
		objRE.Pattern    = ":(\s+)[A-Z]:\\([^\\]+\\)*FindLinks(\.exe)?" ' ":\1FindLinks"
		' Remove path from command
		strHelp = objRE.Replace( strHelp, ": FINDLINKS" )
	End If
	If strCommand = "SFC" Then
		' Convert incorrect Unicode to ASCII
		strHelp = ToASCII( strHelp )
	End If
	' Check if the command line returned an "unknown command" error
	If strHelp = Replace( strUnknownCommand, "MY_DUMMY_UNKNOWN_COMMAND.EXE", strCommand ) Then
		If blnDebug Then DebugDisplay SuperTrim( strHelp )
		strHelp = ""
	End If
	' Clean up
	Set objRE    = Nothing
	Set objExec  = Nothing
	' Return the result
	GetAddedCmdHelp = strHelp
End Function



Function GetCmdHelp( myCommand )
' Get the help text for the specified command
' and format it to fit in the generated HTML page
	Dim objExec, objRE1, objRE2, strCommand, strCommandLine, strHelp
	strCommand = Trim( UCase( myCommand ) )
	' Check if there is any help available at all; if not, try <command> /? instead.
	Set objRE1 = New RegExp
	objRE1.Global     = True
	objRE1.Pattern    = """" & strCommand & " /\?"""
	objRE1.IgnoreCase = True
	' Remove ASCII null characters; trick by Austin France
	' http://austinfrance.wordpress.com/2011/01/13/howto-vbscript-remove-chr0-null-from-a-string/
	Set objRE2 = New RegExp
	objRE2.Global     = True
	objRE2.Pattern    = "[\0]"
	objRE2.IgnoreCase = False
	' Build the command line to extract the help text
	strCommandLine = "CMD.EXE /A /C (TITLE AllHelp " & strScriptVer & ": " & strCommand & "&HELP " & strCommand & ")"
	If strCommand = "SC" Then
		strCommandLine = "CMD.EXE /A /C (TITLE AllHelp " & strScriptVer & ": SC - Press Enter to continue&HELP SC)"
		If Not blnQuiet Then
			WScript.Echo vbCrLf & "AllHelp " & strScriptVer & ":" & vbCrLf & vbCrLf & "Press Enter to continue . . ."
		End If
	End If
	Set objExec = wshShell.Exec( strCommandLine )
	strHelp = objRE2.Replace( objExec.StdOut.ReadAll, "" )
	objExec.Terminate
	' Check if there is any help available at all; if not, try <command> /? instead.
	If objRE1.Test( strHelp ) Then strHelp = GetAddedCmdHelp( strCommand )
	' Clean up
	Set objRE1   = Nothing
	Set objRE2   = Nothing
	Set objExec  = Nothing
	' Return the result
	GetCmdHelp = strHelp
End Function



Function GetCodePage( )
	Dim arrCodePage, idxCodePage, numCodePage, objExec, strCodePage
	numCodePage = 0
	'On Error Resume Next
	Set objExec = wshShell.Exec( "CMD.EXE /C CHCP" )
	strCodePage = objExec.StdOut.ReadAll( )
	arrCodePage = Split( strCodePage, " " )
	If IsArray( arrCodePage ) Then
		idxCodePage = UBound( arrCodePage )
		numCodePage = CInt( arrCodePage( idxCodePage ) )
	End If
	'objExec.Terminate
	Set objExec  = Nothing
	On Error Goto 0
	GetCodePage = numCodePage
End Function



Function GetCommandError( )
' Get the OS' message text for non-existing commands
	Dim objExec, strCommandLine, strError
	strCommandLine = "CMD.EXE /A /C (TITLE AllHelp " & strScriptVer & ": TESTING&MY_DUMMY_UNKNOWN_COMMAND.EXE /? 2>&1)"
	Set objExec  = wshShell.Exec( strCommandLine )
	strError = objExec.StdOut.ReadAll
	objExec.Terminate
	Set objExec  = Nothing
	GetCommandError = strError
End Function



Function GetFileDescription( myCommand )
' Find a command file and get its file description
	Dim objFolder, objItem, objShell, strDescription, strFile, strFolder
	GetFileDescription = ""
	' First check if the file description is available in the dictionary we created for %windir%\system32\*.exe files
	If Not dicSystemFiles.Item( UCase( myCommand ) & ".EXE" ) = "" Then
		GetFileDescription = dicSystemFiles.Item( UCase( myCommand ) & ".EXE" )
	Else
		If Left( strNumVer, InStr( strNumVer, "." ) - 1 ) > 5 Then ' Vista and later
			' Get th fully qualified path for the command
			If myCommand = "PRINTBMR" Then
				strFile = wshShell.ExpandEnvironmentStrings( "%windir%\system32\spool\tools\PRINTBMR.EXE" )
			Else
				strFile = Which( myCommand )
			End If
			' Get its file description (this is SLOW for directories with many files, i.e. %windir%\system32)
			If objFSO.FileExists( strFile ) Then
				' Based on code by Allen on the KiXtart forum:
				' http://www.kixtart.org/forums/ubbthreads.php?ubb=showflat&Number=160880
				strFolder = objFSO.GetParentFolderName( strFile )
				Set objShell  = CreateObject( "Shell.Application" )
				Set objFolder = objShell.NameSpace( strFolder )
				For Each objItem In objFolder.Items
					If UCase( objItem.Name ) = UCase( myCommand & ".EXE" ) Then
						strDescription = objFolder.GetDetailsOf( objItem, 34 ) ' Vista and later
						strDescription = SuperTrim( strDescription )
						GetFileDescription = strDescription
					End If
				Next
				Set objFolder = Nothing
				Set objShell  = Nothing
			End If
		End if
	End If
End Function



Function GetOSLanguage( myLocale )
' Get the description for the OS language/locale number
	Dim i, arrOSLanguage(20490)
	For i = 0 To 20490
		arrOSLanguage(i) = ""
	Next
	arrOSLanguage(1)     = "Arabic"
	arrOSLanguage(4)     = "Chinese (Simplified) - China"
	arrOSLanguage(9)     = "English"
	arrOSLanguage(1025)  = "Arabic - Saudi Arabia"
	arrOSLanguage(1026)  = "Bulgarian"
	arrOSLanguage(1027)  = "Catalan"
	arrOSLanguage(1028)  = "Chinese (Traditional) - Taiwan"
	arrOSLanguage(1029)  = "Czech"
	arrOSLanguage(1030)  = "Danish"
	arrOSLanguage(1031)  = "German - Germany"
	arrOSLanguage(1032)  = "Greek"
	arrOSLanguage(1033)  = "English - United States"
	arrOSLanguage(1034)  = "Spanish - Traditional Sort"
	arrOSLanguage(1035)  = "Finnish"
	arrOSLanguage(1036)  = "French - France"
	arrOSLanguage(1037)  = "Hebrew"
	arrOSLanguage(1038)  = "Hungarian"
	arrOSLanguage(1039)  = "Icelandic"
	arrOSLanguage(1040)  = "Italian - Italy"
	arrOSLanguage(1041)  = "Japanese"
	arrOSLanguage(1042)  = "Korean"
	arrOSLanguage(1043)  = "Dutch - Netherlands"
	arrOSLanguage(1044)  = "Norwegian - Bokmal"
	arrOSLanguage(1045)  = "Polish"
	arrOSLanguage(1046)  = "Portuguese - Brazil"
	arrOSLanguage(1047)  = "Rhaeto-Romanic"
	arrOSLanguage(1048)  = "Romanian"
	arrOSLanguage(1049)  = "Russian"
	arrOSLanguage(1050)  = "Croatian"
	arrOSLanguage(1051)  = "Slovak"
	arrOSLanguage(1052)  = "Albanian"
	arrOSLanguage(1053)  = "Swedish"
	arrOSLanguage(1054)  = "Thai"
	arrOSLanguage(1055)  = "Turkish"
	arrOSLanguage(1056)  = "Urdu"
	arrOSLanguage(1057)  = "Indonesian"
	arrOSLanguage(1058)  = "Ukrainian"
	arrOSLanguage(1059)  = "Belarusian"
	arrOSLanguage(1060)  = "Slovenian"
	arrOSLanguage(1061)  = "Estonian"
	arrOSLanguage(1062)  = "Latvian"
	arrOSLanguage(1063)  = "Lithuanian"
	arrOSLanguage(1065)  = "Persian"
	arrOSLanguage(1066)  = "Vietnamese"
	arrOSLanguage(1069)  = "Basque"
	arrOSLanguage(1070)  = "Serbian"
	arrOSLanguage(1071)  = "Macedonian (FYROM)"
	arrOSLanguage(1072)  = "Sutu"
	arrOSLanguage(1073)  = "Tsonga"
	arrOSLanguage(1074)  = "Tswana"
	arrOSLanguage(1076)  = "Xhosa"
	arrOSLanguage(1077)  = "Zulu"
	arrOSLanguage(1078)  = "Afrikaans"
	arrOSLanguage(1080)  = "Faeroese"
	arrOSLanguage(1081)  = "Hindi"
	arrOSLanguage(1082)  = "Maltese"
	arrOSLanguage(1084)  = "Gaelic"
	arrOSLanguage(1085)  = "Yiddish"
	arrOSLanguage(1086)  = "Malay - Malaysia"
	arrOSLanguage(2049)  = "Arabic - Iraq"
	arrOSLanguage(2052)  = "Chinese (Simplified) - PRC"
	arrOSLanguage(2055)  = "German - Switzerland"
	arrOSLanguage(2057)  = "English - United Kingdom"
	arrOSLanguage(2058)  = "Spanish - Mexico"
	arrOSLanguage(2060)  = "French - Belgium"
	arrOSLanguage(2064)  = "Italian - Switzerland"
	arrOSLanguage(2067)  = "Dutch - Belgium"
	arrOSLanguage(2068)  = "Norwegian - Nynorsk"
	arrOSLanguage(2070)  = "Portuguese - Portugal"
	arrOSLanguage(2072)  = "Romanian - Moldova"
	arrOSLanguage(2073)  = "Russian - Moldova"
	arrOSLanguage(2074)  = "Serbian - Latin"
	arrOSLanguage(2077)  = "Swedish - Finland"
	arrOSLanguage(3073)  = "Arabic - Egypt"
	arrOSLanguage(3076)  = "Chinese (Traditional) - Hong Kong SAR"
	arrOSLanguage(3079)  = "German - Austria"
	arrOSLanguage(3081)  = "English - Australia"
	arrOSLanguage(3082)  = "Spanish - International Sort"
	arrOSLanguage(3084)  = "French - Canada"
	arrOSLanguage(3098)  = "Serbian - Cyrillic"
	arrOSLanguage(4097)  = "Arabic - Libya"
	arrOSLanguage(4100)  = "Chinese (Simplified) - Singapore"
	arrOSLanguage(4103)  = "German - Luxembourg"
	arrOSLanguage(4105)  = "English - Canada"
	arrOSLanguage(4106)  = "Spanish - Guatemala"
	arrOSLanguage(4108)  = "French - Switzerland"
	arrOSLanguage(5121)  = "Arabic - Algeria"
	arrOSLanguage(5127)  = "German - Liechtenstein"
	arrOSLanguage(5129)  = "English - New Zealand"
	arrOSLanguage(5130)  = "Spanish - Costa Rica"
	arrOSLanguage(5132)  = "French - Luxembourg"
	arrOSLanguage(6145)  = "Arabic - Morocco"
	arrOSLanguage(6153)  = "English - Ireland"
	arrOSLanguage(6154)  = "Spanish - Panama"
	arrOSLanguage(7169)  = "Arabic - Tunisia"
	arrOSLanguage(7177)  = "English - South Africa"
	arrOSLanguage(7178)  = "Spanish - Dominican Republic"
	arrOSLanguage(8193)  = "Arabic - Oman"
	arrOSLanguage(8201)  = "English - Jamaica"
	arrOSLanguage(8202)  = "Spanish - Venezuela"
	arrOSLanguage(9217)  = "Arabic - Yemen"
	arrOSLanguage(9226)  = "Spanish - Colombia"
	arrOSLanguage(10241) = "Arabic - Syria"
	arrOSLanguage(10249) = "English - Belize"
	arrOSLanguage(10250) = "Spanish - Peru"
	arrOSLanguage(11265) = "Arabic - Jordan"
	arrOSLanguage(11273) = "English - Trinidad"
	arrOSLanguage(11274) = "Spanish - Argentina"
	arrOSLanguage(12289) = "Arabic - Lebanon"
	arrOSLanguage(12298) = "Spanish - Ecuador"
	arrOSLanguage(13313) = "Arabic - Kuwait"
	arrOSLanguage(13322) = "Spanish - Chile"
	arrOSLanguage(14337) = "Arabic - U.A.E."
	arrOSLanguage(14346) = "Spanish - Uruguay"
	arrOSLanguage(15361) = "Arabic - Bahrain"
	arrOSLanguage(15370) = "Spanish - Paraguay"
	arrOSLanguage(16385) = "Arabic - Qatar"
	arrOSLanguage(16394) = "Spanish - Bolivia"
	arrOSLanguage(17418) = "Spanish - El Salvador"
	arrOSLanguage(18442) = "Spanish - Honduras"
	arrOSLanguage(19466) = "Spanish - Nicaragua"
	arrOSLanguage(20490) = "Spanish - Puerto Rico"
	If Trim( myLocale ) = "" Then
		GetOSLanguage = arrOSLanguage( GetLocale( ) )
	Else
		GetOSLanguage = arrOSLanguage( myLocale )
	End If
End Function



Sub GetSystemFileDescriptions( )
' List file names and descriptions for all *.exe files in %windir%\system32
	Dim objFolder, objItem, objShell, strDescription, strFile, strFolder
	strFolder = objFSO.GetParentFolderName( strFile )
	Set objShell  = CreateObject( "Shell.Application" )
	Set objFolder = objShell.NameSpace( wshShell.ExpandEnvironmentStrings( "%windir%\system32" ) )
	For Each objItem In objFolder.Items
		strFile = UCase( objItem.Name )
		If UCase( objFSO.GetExtensionName( strFile ) ) = "EXE" Then
			strDescription = objFolder.GetDetailsOf( objItem, 34 ) ' Vista and later
			strDescription = SuperTrim( strDescription )
			dicSystemFiles.Item( objItem.Name ) = strDescription
		End If
	Next
	Set objFolder = Nothing
	Set objShell  = Nothing
End Sub



Function HTMLFoot( )
' Create the foot for the HTML page
	HTMLFoot = "<p>&nbsp;</p>" & vbCrLf & vbCrLf _
	         & "<div style=""text-align: center;"">" & vbCrLf _
	         & "<p>This HTML help file was generated by <a href=""http://www.robvanderwoude.com/wshexamples.php?fc=A#AllHelp"">AllHelp.vbs</a>, Version " & strScriptVer & "<br />" & vbCrLf _
	         & "Written by Rob van der Woude<br />" & vbCrLf _
	         & "<a href=""http://www.robvanderwoude.com"">http://www.robvanderwoude.com</a></p>" & vbCrLf _
	         & "</div>" & vbCrLf & vbCrLf _
	         & "</div>" & vbCrLf & vbCrLf _
	         & "</div>" & vbCrLf & vbCrLf _
	         & "<script type=""text/javascript"">" & vbCrLf _
	         & "getDefaultAnchorColor( );" & vbCrLf _
	         & "</script>" & vbCrLf & vbCrLf _
	         & "</body>" & vbCrLf _
	         & "</html>"
End Function



Function HTMLHead( )
' Create the head for the HTML page
	HTMLHead = "<!DOCTYPE HTML>" & vbCrLf _
             & "<html>" & vbCrLf _
	         & "<head>" & vbCrLf
	Select Case intCodePage
		Case 437:
			HTMLHead =  HTMLHead & "<meta http-equiv=""Content-Type"" content=""text/html;charset=IBM437"" />" & vbCrLf
		Case 850:
			HTMLHead =  HTMLHead & "<meta http-equiv=""Content-Type"" content=""text/html;charset=IBM850"" />" & vbCrLf
		Case 1252:
			HTMLHead =  HTMLHead & "<meta http-equiv=""Content-Type"" content=""text/html;charset=windows-1252"" />" & vbCrLf
	End Select
	HTMLHead =  HTMLHead _
	         & "<title>Help for all " & strWinVer & " " & strCSDVer & " commands</title>" & vbCrLf _
	         & "<meta name=""generator"" content=""AllHelp.vbs, Version " & strScriptVer & ", by Rob van der Woude, www.robvanderwoude.com"" />" & vbCrLf _
	         & "<meta name=""viewport"" content=""width=device-width; initial-scale=1"" />" & vbCrLf _
	         & "<style type=""text/css"">" & vbCrLf _
	         & "a, a.visited" & vbCrLf _
	         & "{" & vbCrLf _
	         & vbTab & "color: blue;" & vbCrLf _
	         & "}" & vbCrLf & vbCrLf _
	         & "td.Command" & vbCrLf _
	         & "{" & vbCrLf _
	         & vbTab & "vertical-align: top;" & vbCrLf _
	         & vbTab & "padding-left: 10px;"  & vbCrLf _
	         & vbTab & "padding-right: 5px;"  & vbCrLf _
	         & vbTab & "font-weight: bold;"   & vbCrLf _
	         & vbTab & "white-space: nowrap;" & vbCrLf _
	         & "}" & vbCrLf & vbCrLf _
	         & "th" & vbCrLf _
	         & "{" & vbCrLf _
	         & vbTab & "vertical-align: top;" & vbCrLf _
	         & "}" & vbCrLf & vbCrLf _
	         & "table.Alphabet" & vbCrLf _
	         & "{" & vbCrLf _
	         & vbTab & "border: 2px solid blue;" & vbCrLf _
	         & vbTab & "margin: 0 auto 0 auto;"  & vbCrLf _
	         & vbTab & "text-align: center;"     & vbCrLf _
	         & vbTab & "vertical-align: middle;" & vbCrLf _
	         & vbTab & "width: 100%;"            & vbCrLf _
	         & "}" & vbCrLf & vbCrLf _
	         & "table.Alphabet th" & vbCrLf _
	         & "{" & vbCrLf _
	         & vbTab & "padding: 5px;" & vbCrLf _
	         & vbTab & "width: 4%;"    & vbCrLf _
	         & "}" & vbCrLf & vbCrLf _
	         & "table.List" & vbCrLf _
	         & "{" & vbCrLf _
	         & vbTab & "margin: 0 auto 0 auto;" & vbCrLf _
	         & vbTab & "width: 100%;"           & vbCrLf _
	         & "}" & vbCrLf & vbCrLf _
	         & "table.List th" & vbCrLf _
	         & "{" & vbCrLf _
	         & vbTab & "background-color: blue;" & vbCrLf _
	         & vbTab & "color: white;"           & vbCrLf _
	         & vbTab & "font-size: 120%;"        & vbCrLf _
	         & vbTab & "font-weight: bold;"      & vbCrLf _
	         & vbTab & "padding-left: 10px;"     & vbCrLf _
	         & "}" & vbCrLf & vbCrLf _
	         & "pre" & vbCrLf _
	         & "{"   & vbCrLf _
	         & vbTab & "white-space: pre-wrap;" & vbCrLf _
	         & "}" & vbCrLf _
	         & "</style>" & vbCrLf & vbCrLf _
	         & "<script type=""text/javascript"">" & vbCrLf _
	         & "var defaultColor;" & vbCrLf _
	         & "function getDefaultAnchorColor( ) {" & vbCrLf _
	         & vbTab & "var addchr = document.getElementsByClassName( 'AdditionalChar' );" & vbCrLf _
	         & vbTab & "for ( var i = 0; i < addchr.length; i++ ) {"   & vbCrLf _
	         & vbTab & vbTab & "defaultColor = addchr[i].style.color;" & vbCrLf _
	         & vbTab & "}" & vbCrLf _
	         & "}" & vbCrLf _
	         & "function toggleVisibility( ) {" & vbCrLf _
	         & vbTab & "var button = document.getElementById( 'WinOnlyButton' );"          & vbCrLf _
	         & vbTab & "var addchr = document.getElementsByClassName( 'AdditionalChar' );" & vbCrLf _
	         & vbTab & "var addcmd = document.getElementsByClassName( 'Additional' );"     & vbCrLf _
	         & vbTab & "var addhlp = document.getElementsByClassName( 'AdditionalHelp' );" & vbCrLf _
	         & vbTab & "if ( button.value == 'Windows Help Only' ) {" & vbCrLf _
	         & vbTab & vbTab & "button.value = 'All Commands';"       & vbCrLf _
	         & vbTab & vbTab & "for ( var i = 0; i < addchr.length; i++ ) {" & vbCrLf _
	         & vbTab & vbTab & vbTab & "addchr[i].style.color = 'gray';"     & vbCrLf _
	         & vbTab & vbTab & "}" & vbCrLf _
	         & vbTab & vbTab & "for ( var i = 0; i < addchr.length; i++ ) {" & vbCrLf _
	         & vbTab & vbTab & vbTab & "addchr[i].style.color = 'gray';"     & vbCrLf _
	         & vbTab & vbTab & "}" & vbCrLf _
	         & vbTab & vbTab & "for ( var i = 0; i < addcmd.length; i++ ) {" & vbCrLf _
	         & vbTab & vbTab & vbTab & "addcmd[i].style.display = 'none';"   & vbCrLf _
	         & vbTab & vbTab & "}" & vbCrLf _
	         & vbTab & vbTab & "for( var i = 0; i < addhlp.length; i++ ) {"  & vbCrLf _
	         & vbTab & vbTab & vbTab & "addhlp[i].style.display = 'none';"   & vbCrLf _
	         & vbTab & vbTab & "}" & vbCrLf _
	         & vbTab & "} else {"  & vbCrLf _
	         & vbTab & vbTab & "button.value = 'Windows Help Only'"            & vbCrLf _
	         & vbTab & vbTab & "for( var i = 0; i < addchr.length; i++ ) {"    & vbCrLf _
	         & vbTab & vbTab & vbTab & "addchr[i].style.color = defaultColor;" & vbCrLf _
	         & vbTab & vbTab & "}" & vbCrLf _
	         & vbTab & vbTab & "for( var i = 0; i < addcmd.length; i++ ) {"     & vbCrLf _
	         & vbTab & vbTab & vbTab & "addcmd[i].style.display = 'table-row';" & vbCrLf _
	         & vbTab & vbTab & "}" & vbCrLf _
	         & vbTab & vbTab & "for( var i = 0; i < addhlp.length; i++ ) {" & vbCrLf _
	         & vbTab & vbTab & vbTab & "addhlp[i].style.display = 'block';" & vbCrLf _
	         & vbTab & vbTab & "}" & vbCrLf _
	         & vbTab & "}" & vbCrLf _
	         & "}" & vbCrLf _
	         & "</script>" & vbCrLf & vbCrLf _
	         & "</head>"   & vbCrLf & vbCrLf _
	         & "<body>"    & vbCrLf & vbCrLf _
	         & "<div style=""text-align: center;"">" & vbCrLf _
	         & "<h1>" & strWinVer & " " & Trim( strCSDVer ) & "</h1>" & vbCrLf _
	         & "<h2>Version " & strNumVer & " (" & intBitsOS & " bits)</h2>" & vbCrLf _
	         & "<h3>" & GetOSLanguage( strOSLocl ) & "</h3>" & vbCrLf _
	         & "</div>"        & vbCrLf & vbCrLf _
	         & "<p>&nbsp;</p>" & vbCrLf & vbCrLf _
	         & "<div style=""width: 50em; text-align: center; margin: 0 auto 0 auto;"">" & vbCrLf & vbCrLf _
	         & "<div style=""width: 50em; text-align: left;"">" & vbCrLf & vbCrLf
End Function



Function IsAdmin( )
    ' Based on code by Denis St-Pierre
    Dim intAnswer, intButtons, intRC
    Dim objUAC
    Dim strMsg, strTitle
	IsAdmin = False
    On Error Resume Next
    intRC = wshShell.Run( "CMD /C OPENFILES > NUL 2>&1", 7, True )
    If Err Then intRC = 1
    On Error Goto 0
    If intRC = 0 Then
    	IsAdmin = True
    Else
	    If InStr( UCase( strCommandLine ), "/NOADMIN" ) > 0 Then
	    	IsAdmin = True
	    	Exit Function
	    End If
		strTitle   = "Elevated Privileges Required"
   		intButtons = vbYesNoCancel + vbApplicationModal
		strMsg     = "This script requires elevated privileges." & vbCrLf & vbCrLf & vbCrLf & vbCrLf _
		           & "Note:" & vbTab & "On some 64-bit systems, you may get this message whether" & vbCrLf _
		           & vbTab & "running with elevated privileges or not." & vbCrLf & vbCrLf _
		           & vbTab & "This MAY be caused by running the script with the 32-bit version" & vbCrLf _
		           & vbTab & "of " & UCase( objFSO.GetFileName( strScriptEngine ) ) & " (%windir%\SysWOW64\" & objFSO.GetFileName( strScriptEngine ) & ")." & vbCrLf & vbCrLf _
		           & vbTab & "In that case, add the path to the proper (64-bit) " & UCase( objFSO.GetFileName( strScriptEngine ) ) & " to" & vbCrLf _
		           & vbTab & "this script's command line:" & vbCrLf & vbCrLf _
		           & vbTab & """%windir%\system32\" & objFSO.GetFileName( strScriptEngine ) & """ """ & strScriptPath & """" & vbCrLf & vbCrLf & vbCrLf & vbCrLf _
		           & "Do you want to restart the script with elevated privileges now?" & vbCrLf & vbCrLf _
		           & "Yes:"    & vbtab & "Restart the script with elevated privileges" & vbCrLf _
		           & "No:"     & vbTab & "Try to continue without elevated privileges (NOT recommended)" & vbCrLf _
		           & "Cancel:" & vbTab & "Abort"
		intAnswer  = MsgBox( strMsg, intButtons, strTitle )
		If intAnswer = vbYes Then
			strCommandLine = Replace( Trim( strCommandLine ), """", """""" )
			' Elevate privileges
			Set objUAC = CreateObject( "Shell.Application" )
			objUAC.ShellExecute """" & strScriptEngine & """", """" & strScriptPath & """ /NOADMIN " & strCommandLine, "", "runas", 1
			Set objUAC = Nothing
			WScript.Quit 0
		ElseIf intAnswer = vbNo Then
			IsAdmin = True
		Else
			WScript.Quit 1
		End If
	End If
End Function



Function Max( num1, num2 )
' Return the largest of 2 numbers
	If num1 > num2 Then
		Max = num1
	Else
		Max = num2
	End If
End Function



Function Min( num1, num2 )
' Return the smallest of 2 numbers
	If num1 < num2 Then
		Min = num1
	Else
		Min = num2
	End If
End Function



Function SortDictionary( objDict, intSort )
' Sort a Dictionary object
' Code found on http://support.microsoft.com/kb/246067
	Dim arrDict( )
	Dim objKey
	Dim strKey, strItem
	Dim i,j,intCount
	
	' Get the dictionary count
	intCount = objDict.Count
	
	' We need more than one item to warrant sorting
	If intCount > 1 Then
		' create an array to store dictionary information
		ReDim arrDict( intCount, 2 )
		i = 0
		' Populate the string array
		For Each objKey In objDict
			arrDict( i, dictKey )  = CStr( objKey )
			arrDict( i, dictItem ) = CStr( objDict( objKey ) )
			i = i + 1
		Next

		' Perform a shell sort of the string array
		For i = 0 to ( intCount - 2 )
			For j = i to ( intCount - 1 )
				If StrComp( arrDict( i, intSort ), arrDict( j, intSort ),vbTextCompare ) > 0 Then
					strKey  = arrDict( i, dictKey )
					strItem = arrDict( i, dictItem )
					arrDict( i, dictKey )  = arrDict( j, dictKey )
					arrDict( i, dictItem ) = arrDict( j, dictItem )
					arrDict( j, dictKey )  = strKey
					arrDict( j, dictItem ) = strItem
				End If
			Next
		Next

		' Erase the contents of the dictionary object
		objDict.RemoveAll

		' Repopulate the dictionary with the sorted information
		For i = 0 to ( intCount - 1 )
			objDict.Add arrDict( i, dictKey ), arrDict( i, dictItem )
		Next
	End If
End Function



Function SuperTrim( myText )
' Remove linefeeds, tabs and multple spaces from a text
	Dim strText
	strText = Replace( myText,  vbCr,   " " )
	strText = Replace( strText, vbLf,   " " )
	strText = Replace( strText, vbCrLf, " " )
	strText = Replace( strText, vbTab,  " " )
	While ( InStr( strText, "  " ) )
		strText = Replace( strText, "  ", " " )
	Wend
	SuperTrim = Trim( strText )
End Function



Sub Syntax
' Display help and, optionally, debugging information
	strMsg = strMsg & vbCrLf _
	       & "AllHelp.vbs,  Version " & strScriptVer _
	       & vbCrLf _
	       & "Display help for ""all"" Windows commands, for" _
	       & vbCrLf _
	       & "the current Windows installion and language." _
	       & vbCrLf & vbCrLf _
	       & "Usage:  ALLHELP.VBS  [ ""outputfile"" ]  [ /Y ]  [ /WHO ]  [ /BAT ]  [ /DEBUG ]" _
	       & vbCrLf & vbCrLf _
	       & "   or:  ALLHELP.VBS  /Q  [ /WHO ]  [ /BAT ]  [ >  ""outputfile"" ]" _
	       & vbCrLf & vbCrLf _
	       & "Where:  ""outputfile""   is the fully qualified path of the HTML file to be" _
	       & vbCrLf _
	       & "                       created (default: ""allhelp.html"" in ""My Documents"")" _
	       & vbCrLf _
	       & "        /DEBUG         display DEBUGging information" _
	       & vbCrLf _
	       & "        /BAT           include BATch files (.bat and .cmd)" _
	       & vbCrLf _
	       & "        /Q             display only the HTML code, do not write to file" _
	       & vbCrLf _
	       & "        /WHO           show commands listed in Windows' Help Only" _
	       & vbCrLf _
	       & "        /Y             overwrite existing file (default: abort if exists)" _
	       & vbCrLf & vbCrLf _
	       & "Notes:  DISKPART and OPENFILES are protected by UAC; in order to retrieve" _
	       & vbCrLf _
	       & "        their help texts, run this script with elevated privileges." _
	       & vbCrLf _
	       & "        SC help requires keyboard input; its window title will ask you to" _
	       & vbCrLf _
	       & "        press Enter." _
	       & vbCrLf _
	       & "        The /Q switch can be used as a work-around to redirect the generated HTML" _
	       & vbCrLf _
	       & "        to a file in case of unexpected ""access denied"" errors in Windows 8.1." _
	       & vbCrLf & vbCrLf _
	       & "Written by Rob van der Woude" _
	       & vbCrLf _
	       & "http://www.robvanderwoude.com"
	WScript.Echo strMsg
	WScript.Quit 1
End Sub



Function ToASCII( myString )
' Strip special characters from SFC's output in Windows 8.1
	Dim objRE, strText
	strText = myString
	Set objRE = New RegExp
	objRE.Global  = True
	objRE.Pattern = "^" & Chr(255) & Chr(254)
	strText = objRE.Replace( strText, "" )
	objRE.Pattern = "[\0]"
	strText = objRE.Replace( strText, "" )
	Set objRE = Nothing
	ToASCII = strText
End Function



Function TrimCrLf( myString )
' Remove unnnecessary linefeeds inside <pre></pre> blocks
	Dim objMatches, objRE, strResult
	strResult = Trim( myString )
	If strResult = "" Then Exit Function
	Set objRE = New RegExp
	objRE.Global  = True
	objRE.Pattern = "<pre>(" & vbCr & "|" & vbLf & ")+"
	strResult     = objRE.Replace( strResult, "<pre>" )
	objRE.Pattern = "(" & vbCr & "|" & vbLf & ")+</pre>"
	strResult     = objRE.Replace( strResult, "</pre>" )
	Set objRE = Nothing
	strResult = Replace( strResult, vbCr & vbCrLf, vbCrLf )
	TrimCrLf = strResult
End Function



Function Which( myCommand )
' Get the fully qualified path to a command file
	Dim arrPath, arrPathExt
	Dim i, j
	Dim objRE
	Dim strComSpec, strPath, strPathExt, strTestPath
	Which = ""
	' Read the PATH and PATHEXT variables, and store their values in arrays; the current directory is prepended to the PATH first
	strPath    = wshShell.CurrentDirectory & ";" & wshShell.ExpandEnvironmentStrings( "%PATH%" )
	strPathExt = wshShell.ExpandEnvironmentStrings( "%PATHEXT%" )
	If blnIgnoreBatch Then
		' Remove .BAT and .CMD from %PATHEXT% to avoid listing batch files
		Set objRE = New RegExp
		objRE.Global     = True
		objRE.IgnoreCase = True
		objRE.Pattern    = "(\.bat|\.cmd)"
		strPathExt = objRE.Replace( strPathExt, "" )
		objRE.Pattern = "(^;|;$)"
		strPathExt = objRE.Replace( strPathExt, "" )
		objRE.Pattern = ";+"
		strPathExt = objRE.Replace( strPathExt, ";" )
		Set objRE = Nothing
	End If
	arrPath    = Split( strPath,    ";" )
	arrPathExt = Split( strPathExt, ";" )
	' But first let's check for INTERNAL commands
	If arrIntCmd.Contains( UCase( myCommand ) ) Then
		' Abort at the first match, return the path to the command processor
		Which = wshShell.ExpandEnvironmentStrings( "%COMSPEC%" ) ' & " /C " & arrIntCmd(i)
		Exit Function
	End If
	' Use list of valid extensions from PATHEXT
	For i = 0 To UBound( arrPathExt )
		' Search the PATH
		For j = 0 To UBound( arrPath )
			' Skip empty directory values, caused by the PATH variable being terminated with a semicolon
			If arrPath(j) <> "" Then
				' Build a fully qualified path of the file to test for
				strTestPath = objFSO.BuildPath( arrPath(j), myCommand & arrPathExt(i) )
				' Check if that file exists
				If objFSO.FileExists( strTestPath ) Then
					' Abort at the first match
					Which = objFSO.GetAbsolutePathName( strTestPath )
					Exit Function
				End If
			End If
		Next
	Next
End Function
