Option Explicit

' Registry related constants
Const HKEY_CLASSES_ROOT   = &H80000000
Const HKEY_CURRENT_USER   = &H80000001
Const HKEY_LOCAL_MACHINE  = &H80000002
Const HKEY_USERS          = &H80000003
Const HKEY_CURRENT_CONFIG = &H80000005

Dim arrSubKeys
Dim blnAPIPA, blnDHCP, blnErr, blnQuiet, blnUndo
Dim i, intErr, intArgs, intWinStyle
Dim objFSO, objReg, objUndo
Dim strHive, strIP, strKey, strKeyPath
Dim strMsg, strRegPath, strTitle, strUndo

' Check command line arguments
With WScript.Arguments
	blnQuiet = False
	intArgs  = 0
	If .Named.Exists( "C" ) Then
		blnQuiet = True
		intArgs  = intArgs + 1
	End If
	If .Named.Exists( "U" ) Then
		intArgs = intArgs + 1
	End If
	If intArgs <> .Count Then Syntax
End With

' Ask for confirmation
strMsg      = "Are you sure you want to change the APIPA "   _
            & "registry settings for your network adapters?" _
            & vbCrLf & vbCrLf _
            & "If in doubt, please click ""No"" or ""Cancel""."
strTitle    = "Registry Change"
intWinStyle = vbYesNoCancel + vbExclamation + vbDefaultButton2 + vbApplicationModal

If Not blnQuiet Then
	If MsgBox( strMsg, intWinStyle, strTitle ) <> vbYes Then
		Syntax
	End If
End If

' Initialize variables
blnAPIPA   = False
blnDHCP    = False
blnErr     = False
blnUndo    = False
strHive    = HKEY_LOCAL_MACHINE
strKeyPath = "System\CurrentControlSet\Services\TCPIP\Parameters\Interfaces"
strMsg     = ""
strRegPath = "C:\apipa_undo_" _
           & Year( Now )      _
           & Right( 100 + Month( Now ),  2 ) _
           & Right( 100 + Day( Now ),    2 ) _
           & "_" _
           & Right( 100 + Hour( Now ),   2 ) _
           & Right( 100 + Minute( Now ), 2 ) _
           & Right( 100 + Second( Now ), 2 ) _
           & ".reg"
strUndo    = "REGEDIT4" & vbCrLf & vbCrLf

' Connect to the local registry
Set objReg = GetObject( "winmgmts:{impersonationLevel=impersonate}!//./root/default:StdRegProv" )

' List all subkeys of
' HKLM\System\CurrentControlSet\Services\TCPIP\Parameters\Interfaces
intErr = objReg.EnumKey( strHive, strKeyPath, arrSubKeys )

' Loop through the list of subkeys
For i = 0 To UBound( arrSubKeys )
	strKey = strKeyPath & "\" & arrSubKeys(i)
	' Check if the adapter is DHCP enabled
	blnDHCP = False
	intErr = objReg.GetDWORDValue( strHive, strKey, "EnableDHCP", blnDHCP )
	If intErr = 0 Then
		blnDHCP = CBool( blnDHCP )
	Else
		blnDHCP = False
	End If
	If blnDHCP Then
		' If so, look up its IP address
		strIP = ""
		intErr = objReg.GetStringValue( strHive, strKey, "DhcpIPAddress", strIP )
		strIP = "" & strIP
		If intErr = 0 Then
			' If the adapter does have an IP address, check if it is APIPA enabled
			intErr = objReg.GetDWORDValue( strHive, strKey, "IPAutoconfigurationEnabled", blnAPIPA )
			If intErr = 0 Then
				blnAPIPA = CBool( blnAPIPA )
			Else
				blnAPIPA = False
			End If
			If blnAPIPA Then
				' If APIPA enabled, display its IP address, ...
				strMsg  = strMsg _
				        & "Disabling IP AutoConfiguration (APIPA) for " _
				        & "the network adapter"                & vbCrLf _
				        & "with IP address "       & strIP     & vbCrLf
				' ... prepare the undo file, ...
				strUndo = strUndo _
				        & "[HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet"  _
				        & "\Services\Tcpip\Parameters\Interfaces\"        _
				        & arrSubKeys(i) & "]"                    & vbCrLf _
				        & """IPAutoconfigurationEnabled""=dword:00000001" _
				        & vbCrLf & vbCrLf
				blnUndo = True
				' ... and disable APIPA
				intErr = objReg.SetDWORDValue( strHive, strKey, "IPAutoconfigurationEnabled", 0 )
				If intErr <> 0 Then
					strMsg = strMsg _
					       & "Error " & intErr _
					       & " while trying to change the value of" & vbCrLf _
					       & "[HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet"  _
					       & "\Services\Tcpip\Parameters\Interfaces\"        _
					       & arrSubKeys(i) & "\IPAutoconfigurationEnabled"
				End If
			End If
		End If
	End If
Next

' Save the undo settings in the undo file, unless the /U switch was used
If blnUndo Then
	If Not WScript.Arguments.Named.Exists( "U" ) Then
		On Error Resume Next
		Set objFSO  = CreateObject( "Scripting.FileSystemObject" )
		If Err Then
			blnErr = True
		End If
		Set objUndo = objFSO.CreateTextFile( strRegPath, True, False )
		If Err Then
			blnErr = True
		End If
		objUndo.Write strUndo
		If Err Then
			blnErr = True
		End If
		objUndo.Close
		If Err Then
			blnErr = True
		End If
		Set objUndo = Nothing
		Set objFSO  = Nothing
		On Error Goto 0
		If blnErr Then
			strMsg = "Error creating the Undo file." _
			       & vbCrLf _
			       & "You may want to write down or print the following values:" _
			       & vbCrLf _
			       & strUndo
		Else
			strMsg = strMsg _
			       & vbCrLf _
			       & "The changes will take effect after the next reboot." _
			       & vbCrLf _
			       & "An Undo file has been created (" & strRegPath & ")." _
			       & vbCrLf _
			       & "In case the change turns out to be a disaster, doubleclick this" _
			       & vbCrLf _
			       & "undo file to restore the previous settings."
		End If
	End If
Else
	strMsg = strMsg _
	       & vbCrLf _
	       & "No network adapter needed to be reconfigured."
End If

' Display the results
WScript.Echo strMsg

Set objReg  = Nothing
Set objUndo = Nothing
Set objFSO  = Nothing


Sub Syntax
	strMsg = vbCrLf _
	       & UCase( WScript.ScriptName ) & ",  Version 1.00" _
	       & vbCrLf _
	       & "Disable IP Autoconfiguration (APIPA) for all DHCP enabled network adapters"  _
	       & vbCrLf & vbCrLf _
	       & "Usage: " & UCase( WScript.ScriptName ) & "  [ /C ]"                          _
	       & vbCrLf & vbCrLf _
	       & "Where: /Q  skips the prompt for Confirmation"                                _
	       & vbCrLf _
	       & "       /U  skips the Undo file"                                _
	       & vbCrLf & vbCrLf _
	       & "Notes:" _
	       & vbCrLf _
	       & "[1] APIPA is disabled by setting ""IPAutoconfigurationEnabled"" to 0 in the" _
	       & vbCrLf _
	       & "    ""HKLM\SYSTEM\CurrentControlSet\Services\Tcpip\Parameters\Interfaces"""  _
	       & vbCrLf _
	       & "    subkeys of the registry."                                                _
	       & vbCrLf _
	       & "[2] An undo file will be created: ""C:\apipa_undo_YYYYMMDD_HHmmss.reg""."    _
	       & vbCrLf _
	       & "    To restore the previous settings, just doubleclick this undo file."      _
	       & vbCrLf _
	       & "[3] APIPA is an acronym for Automatic Private Internet Protocol Addressing." _
	       & vbCrLf _
	       & "    In short it means an IP address in the 169.254.*.* range is used if no"  _
	       & vbCrLf _
	       & "    DHCP server is available. More info about APIPA:"                        _
	       & vbCrLf _
	       & "    http://support.microsoft.com/kb/220874"                                  _
	       & vbCrLf _
	       & "    http://www.petri.co.il/disable_apipa_in_windows_2000_xp_2003.htm"        _
	       & vbCrLf & vbCrLf _
	       & "Written by Rob van der Woude" _
	       & vbCrLf _
	       & "http://www.robvanderwoude.com"
	WScript.Echo strMsg
	WScript.Quit 1
End Sub
