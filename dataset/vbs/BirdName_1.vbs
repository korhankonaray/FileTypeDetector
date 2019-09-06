Option Explicit

Dim blnVerbose
Dim intValid
Dim strLocLang, strBirdName, strMsg, strScientific, strSrcLang, strTgtLang, strTranslation

With WScript.Arguments
	If .Unnamed.Count <> 1 Then Syntax
	If .Named.Count    > 3 Then Syntax
	intValid = 0
	If .Named.Exists( "SL" ) Then ' Source Language
		strSrcLang = LCase( .Named.Item( "SL" ) )
		If Not WCheck( "http://" & strSrcLang & ".wikipedia.org/" ) Then Syntax
		intValid = intValid + 1
	End If
	If .Named.Exists( "TL" ) Then ' Target Language
		strTgtLang = LCase( .Named.Item( "TL" ) )
		If Not WCheck( "http://" & strTgtLang & ".wikipedia.org/" ) Then Syntax
		intValid = intValid + 1
	End If
	If .Named.Exists( "V" ) Then ' Verbose output
		blnVerbose = True
		intValid = intValid + 1
	Else
		blnVerbose = False
	End If
	If intValid <> .Named.Count Then Syntax
	If strSrcLang = "" Then ' No source language specified: name specified must be scientific name
		strScientific = Cap( .Unnamed(0) )
		If Not WCheck( "http://en.wikipedia.org/wiki/" & Und( strScientific ) ) Then Syntax
	Else
		strBirdName = .Unnamed(0)
	End If
End With

' Translate from source language to scientific name
If strScientific = "" Then
	strScientific = GetScName( strBirdName, strSrcLang )
End If
' Translate scientific name to target language
strTranslation = Cap( Translate( strScientific, strTgtLang ) )

If blnVerbose Then
	strMsg = ""
	If strSrcLang <> "" Then strMsg = UCase( strSrcLang ) & ": " & Cap( strBirdName ) & vbCrLf
	strMsg = strMsg & "Sc: " & strScientific & vbCrLf & UCase( strTgtLang ) & ": "
End If
strMsg = strMsg & strTranslation
WScript.Echo strMsg


' Capitalize
Function Cap( myString )
	Dim strString
	strString = Replace( myString, "  ", " " )
	strString = LCase( Trim( strString ) )
	Cap = UCase( Left( strString, 1 ) ) & Mid( strString, 2 )
End Function


' Read scientific name from WikiPedia page
Function GetScName( myBirdName, myLanguage )
	Dim objMatches, objRE
	Dim strBirdName, strHTML, strName, strURL
	strName = "-- Not Found --"
	strBirdName = Cap( myBirdName )
	strURL = "http://" & myLanguage & ".wikipedia.org/wiki/" & Und( strBirdName )
	strHTML = WGet( strURL )
	If Left( strHTML, 11 ) = "--Not found" Then
		GetScName = strHTML
		Exit Function
	End If
	Set objRE = New RegExp
	objRE.Global = False
	objRE.IgnoreCase = True
	objRE.Pattern = "<b>" & myBirdName & "</b> \(<i>(<b>)?([^<\n\r]+)(</b>)?</i>\)"
	Set objMatches = objRE.Execute( strHTML )
	If objMatches.Count > 0 Then
		If objMatches.Item(0).Submatches.Count > 2 Then
			strName = objMatches.Item(0).Submatches(1)
		End If
	End If
	Set objMatches = Nothing
	Set objRE = Nothing
	GetScName = strName
End Function


' Translate scientific name to specified language using WikiPedia
Function Translate( mySciName, myLanguage )
	Dim objMatches, objRE
	Dim strHTML, strName, strURL
	strName = "-- Not Found --"
	strURL = "http://" & myLanguage & ".wikipedia.org/wiki/" & Und( mySciName )
	strHTML = WGet( strURL )
	If Left( strHTML, 11 ) = "--Not found" Then
		Translate = strHTML
		Exit Function
	End If
	Set objRE = New RegExp
	objRE.Global = False
	objRE.IgnoreCase = True
	' First, let's assume the page title is the translated name
	objRE.Pattern = "<h1 id=""firstHeading"" class=""firstHeading"">([^<]+)</h1>"
	Set objMatches = objRE.Execute( strHTML )
	If objMatches.Count > 0 Then
		If objMatches.Item(0).Submatches.Count > 0 Then
			strName = objMatches.Item(0).Submatches(0)
		End If
	End If
	' In case the page title is the scientific name, try an alternative search pattern
	If LCase( mySciName ) = LCase( strName ) Then
		objre.Pattern = "<b>([^<]+)</b> \(<i>(<b>)?" & mySciName & "(</b>)?</i>(,|\)) [^\n\r]{20,}[\n\r]"
		Set objMatches = objRE.Execute( strHTML )
		If objMatches.Count > 0 Then
			If objMatches.Item(0).Submatches.Count > 0 Then
				strName = objMatches.Item(0).Submatches(0)
			End If
		End If
	End If
	Set objMatches = Nothing
	Set objRE = Nothing
	Translate = strName
End Function


' Replace spaces by underscores to create URL
Function Und( myString )
	Und = Replace( myString, " ", "_" )
End Function


' Check if the specified subdomain exists
Function WCheck( myURL )
	Dim objHTTP, objRE
	Dim strResponse
	WCheck = False
	Set objHTTP = CreateObject( "WinHttp.WinHttpRequest.5.1" )
	objHTTP.Open "GET", myURL
	objHTTP.Send
	If objHTTP.Status = 200 Then
		Set objRE = New RegExp
		objRE.Global = False
		objRE.IgnoreCase = True
		objRE.Pattern = "\.wiki[pm]edia\.org"
		If objRE.Test( objHTTP.GetAllResponseHeaders( ) ) Then WCheck = True
		Set objRE = Nothing
	End If
	Set objHTTP = Nothing
End Function


' Read the entire web page
Function WGet( myURL )
	Dim objHTTP
	WGet = "--Not Found: " & myURL & "--"
	Set objHTTP = CreateObject( "WinHttp.WinHttpRequest.5.1" )
	objHTTP.Open "GET", myURL
	objHTTP.Send
	If objHTTP.Status = 200 Then
		WGet = objHTTP.ResponseText
	Else
		WGet = "--Not found (" & objHTTP.Status & ") " & myURL & "--"
	End If
	Set objHTTP = Nothing
End Function


' Display help
Sub Syntax
	Dim strMsg
	strMsg = "BirdName.vbs,  Version 1.01" & vbCrLf _
	       & "Use Wikipedia to translate a bird name from one language to another" _
	       & vbCrLf & vbCrLf _
	       & "Usage:" & vbTab & "BIRDNAME  /SL:lang  ""bird name""  /TL:lang  [ /V ]" _
	       & vbCrLf _
	       & "   or:" & vbTab & "BIRDNAME  ""scientific name""      /TL:lang  [ /V ]" _
	       & vbCrLf & vbCrLf _
	       & "Where:" & vbTab & """bird name""      " & vbTab & "full bird name to be translated" _
	       & vbCrLf _
	       & "      " & vbTab & """scientific name""" & vbTab & "scientific name to be translated" _
	       & vbCrLf _
	       & "      " & vbTab & "/SL              " & vbTab & "specifies ""Source Language"" (to translate from)" _
	       & vbCrLf _
	       & "      " & vbTab & "/TL              " & vbTab & "specifies ""Target Language"" (to translate to)" _
	       & vbCrLf _
	       & "      " & vbTab & "/V               " & vbTab & "display specified and scientific names too" _
	       & vbCrLf _
	       & "      " & vbTab & "lang             " & vbTab & "language code, as used by Wikipedia (e.g. EN)" _
	       & vbCrLf & vbCrLf _
	       & "Examples:" & vbTab & "BIRDNAME  /SL:EN  ""Great bittern""  /TL:FR  /V" _
	       & vbCrLf _
	       & "         " & vbTab & "BIRDNAME  ""Fulica atra""  /TL:RU" _
	       & vbCrLf & vbCrLf _
	       & "Notes:" & vbTab & "Specified bird names must be full names, as used in Wikipedia." _
	       & vbCrLf _
	       & "      " & vbTab & "See http://meta.wikimedia.org/wiki/List_of_Wikipedias for a list" _
	       & vbCrLf _
	       & "      " & vbTab & "of available languages (or use my ListWikipediaLanguages.vbs)." _
	       & vbCrLf _
	       & "      " & vbTab & "Availability of a language doesn't guarantee correct translations." _
	       & vbCrLf _
	       & "      " & vbTab & "This script will fail if Wikipedia changes its page layout." _
	       & vbCrLf _
	       & "      " & vbTab & "No guarantees, use this script at your own risk." _
	       & vbCrLf & vbCrLf _
	       & "Written by Rob van der Woude" _
	       & vbCrLf _
	       & "http://www.robvanderwoude.com"
	If Right( UCase( WScript.FullName ), 12 ) = "\CSCRIPT.EXE" Then
		WScript.StdErr.Write strMsg
	Else
		WScript.Echo strMsg
	End If
	WScript.Quit 1
End Sub
