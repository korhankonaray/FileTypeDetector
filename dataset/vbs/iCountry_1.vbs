Option Explicit

Dim numCountry

numCountry = 0

With WScript.Arguments
	If .Named.Count > 0 Then Syntax
	With .Unnamed
		If .Count = 1 Then
			If IsNumeric( .Item(0) ) Then
				If CStr( Int( .Item(0) ) ) = CStr( .Item(0) ) Then
					numCountry = Int( .Item(0) )
				End If
			End If
			If numCountry = 0 Then Syntax
		End If
	End With
End With

WScript.Echo Country( numCountry )


Function Country( numCountry )
	' Extracted from Microsoft Internet Explorer 6 Resource Kit,
	' Appendix F: Country/Region and Language Codes
	' http://technet.microsoft.com/en-us/library/dd346950.aspx

	Dim dctCountryCodes, wshShell

	Country = ""

	Set dctCountryCodes = CreateObject( "Scripting.Dictionary" )
	dctCountryCodes.Add    1, "United States"
	dctCountryCodes.Add    2, "Canada"
	dctCountryCodes.Add    7, "Russia"
	dctCountryCodes.Add   20, "Egypt"
	dctCountryCodes.Add   27, "South Africa"
	dctCountryCodes.Add   30, "Greece"
	dctCountryCodes.Add   31, "The Netherlands"
	dctCountryCodes.Add   32, "Belgium"
	dctCountryCodes.Add   33, "France"
	dctCountryCodes.Add   34, "Spain"
	dctCountryCodes.Add   36, "Hungary"
	dctCountryCodes.Add   39, "Italy"
	dctCountryCodes.Add   40, "Romania"
	dctCountryCodes.Add   41, "Switzerland"
	dctCountryCodes.Add   43, "Austria"
	dctCountryCodes.Add   44, "United Kingdom"
	dctCountryCodes.Add   45, "Denmark"
	dctCountryCodes.Add   46, "Sweden"
	dctCountryCodes.Add   47, "Norway"
	dctCountryCodes.Add   48, "Poland"
	dctCountryCodes.Add   49, "Germany"
	dctCountryCodes.Add   51, "Peru"
	dctCountryCodes.Add   52, "Mexico"
	dctCountryCodes.Add   53, "Cuba"
	dctCountryCodes.Add   54, "Argentina"
	dctCountryCodes.Add   55, "Brazil"
	dctCountryCodes.Add   56, "Chile"
	dctCountryCodes.Add   57, "Colombia"
	dctCountryCodes.Add   58, "Venezuela"
	dctCountryCodes.Add   60, "Malaysia"
	dctCountryCodes.Add   61, "Australia"
	dctCountryCodes.Add   62, "Indonesia"
	dctCountryCodes.Add   63, "Philippines"
	dctCountryCodes.Add   64, "New Zealand"
	dctCountryCodes.Add   65, "Singapore"
	dctCountryCodes.Add   66, "Thailand"
	dctCountryCodes.Add   81, "Japan"
	dctCountryCodes.Add   82, "Korea"
	dctCountryCodes.Add   84, "Viet Nam"
	dctCountryCodes.Add   86, "China"
	dctCountryCodes.Add   90, "Turkey"
	dctCountryCodes.Add   91, "India"
	dctCountryCodes.Add   92, "Pakistan"
	dctCountryCodes.Add   93, "Afghanistan"
	dctCountryCodes.Add   94, "Sri Lanka"
	dctCountryCodes.Add   95, "Myanmar"
	dctCountryCodes.Add   98, "Iran"
	dctCountryCodes.Add  101, "Anguilla"
	dctCountryCodes.Add  102, "Antigua and Barbuda"
	dctCountryCodes.Add  103, "The Bahamas"
	dctCountryCodes.Add  104, "Barbados"
	dctCountryCodes.Add  105, "Bermuda"
	dctCountryCodes.Add  106, "British Virgin Islands"
	dctCountryCodes.Add  108, "Cayman Islands"
	dctCountryCodes.Add  109, "Dominica"
	dctCountryCodes.Add  110, "Dominican Republic"
	dctCountryCodes.Add  111, "Grenada"
	dctCountryCodes.Add  112, "Jamaica"
	dctCountryCodes.Add  113, "Montserrat"
	dctCountryCodes.Add  115, "St. Kitts and Nevis"
	dctCountryCodes.Add  116, "St. Vincent and the Grenadines"
	dctCountryCodes.Add  117, "Trinidad and Tobago"
	dctCountryCodes.Add  118, "Turks and Caicos Islands"
	dctCountryCodes.Add  120, "Antigua and Barbuda"
	dctCountryCodes.Add  121, "Puerto Rico"
	dctCountryCodes.Add  122, "St. Lucia"
	dctCountryCodes.Add  123, "Virgin Islands"
	dctCountryCodes.Add  124, "Guam"
	dctCountryCodes.Add  212, "Morocco"
	dctCountryCodes.Add  213, "Algeria"
	dctCountryCodes.Add  216, "Tunisia"	
	dctCountryCodes.Add  218, "Libya"
	dctCountryCodes.Add  220, "Gambia"
	dctCountryCodes.Add  221, "Senegal"
	dctCountryCodes.Add  222, "Mauritania"
	dctCountryCodes.Add  223, "Mali"
	dctCountryCodes.Add  224, "Guinea"
	dctCountryCodes.Add  225, "C“te d'Ivoire"
	dctCountryCodes.Add  226, "Burkina Faso"
	dctCountryCodes.Add  227, "Niger"
	dctCountryCodes.Add  228, "Togo"
	dctCountryCodes.Add  229, "Benin"
	dctCountryCodes.Add  230, "Mauritius"
	dctCountryCodes.Add  231, "Liberia"
	dctCountryCodes.Add  232, "Sierra Leone"
	dctCountryCodes.Add  233, "Ghana"
	dctCountryCodes.Add  234, "Nigeria"
	dctCountryCodes.Add  235, "Chad"
	dctCountryCodes.Add  236, "Central African Republic"
	dctCountryCodes.Add  237, "Cameroon"
	dctCountryCodes.Add  238, "Cape Verde"
	dctCountryCodes.Add  239, "SÆo Tom‚ and Pr¡ncipe"
	dctCountryCodes.Add  240, "Equatorial Guinea"
	dctCountryCodes.Add  241, "Gabon"
	dctCountryCodes.Add  242, "Congo"
	dctCountryCodes.Add  243, "Congo (DRC)"
	dctCountryCodes.Add  244, "Angola"
	dctCountryCodes.Add  245, "Guinea-Bissau"
	dctCountryCodes.Add  246, "Diego Garcia"
	dctCountryCodes.Add  247, "Ascension Island"
	dctCountryCodes.Add  248, "Seychelles"
	dctCountryCodes.Add  249, "Sudan"
	dctCountryCodes.Add  250, "Rwanda"
	dctCountryCodes.Add  251, "Ethiopia"
	dctCountryCodes.Add  252, "Somalia"
	dctCountryCodes.Add  253, "Djibouti"
	dctCountryCodes.Add  254, "Kenya"
	dctCountryCodes.Add  255, "Tanzania"
	dctCountryCodes.Add  256, "Uganda"
	dctCountryCodes.Add  257, "Burundi"
	dctCountryCodes.Add  258, "Mozambique"
	dctCountryCodes.Add  260, "Zambia"
	dctCountryCodes.Add  261, "Madagascar"
	dctCountryCodes.Add  262, "Reunion"
	dctCountryCodes.Add  263, "Zimbabwe"
	dctCountryCodes.Add  264, "Namibia"
	dctCountryCodes.Add  265, "Malawi"
	dctCountryCodes.Add  266, "Lesotho"
	dctCountryCodes.Add  267, "Botswana"
	dctCountryCodes.Add  268, "Swaziland"
	dctCountryCodes.Add  269, "Mayotte"
	dctCountryCodes.Add  290, "St. Helena"
	dctCountryCodes.Add  291, "Eritrea"
	dctCountryCodes.Add  297, "Aruba"
	dctCountryCodes.Add  298, "Faroe Islands"
	dctCountryCodes.Add  299, "Greenland"
	dctCountryCodes.Add  350, "Gibraltar"
	dctCountryCodes.Add  351, "Portugal"
	dctCountryCodes.Add  352, "Luxembourg"
	dctCountryCodes.Add  353, "Ireland"
	dctCountryCodes.Add  354, "Iceland"
	dctCountryCodes.Add  355, "Albania"
	dctCountryCodes.Add  356, "Malta"
	dctCountryCodes.Add  357, "Cyprus"
	dctCountryCodes.Add  358, "Finland"
	dctCountryCodes.Add  359, "Bulgaria"
	dctCountryCodes.Add  370, "Lithuania"
	dctCountryCodes.Add  371, "Latvia"
	dctCountryCodes.Add  372, "Estonia"
	dctCountryCodes.Add  373, "Moldova"
	dctCountryCodes.Add  374, "Armenia"
	dctCountryCodes.Add  375, "Belarus"
	dctCountryCodes.Add  376, "Andorra"
	dctCountryCodes.Add  377, "Monaco"
	dctCountryCodes.Add  378, "San Marino"
	dctCountryCodes.Add  379, "Vatican City"
	dctCountryCodes.Add  380, "Ukraine"
	dctCountryCodes.Add  381, "Yugoslavia"
	dctCountryCodes.Add  385, "Croatia"
	dctCountryCodes.Add  386, "Slovenia"
	dctCountryCodes.Add  387, "Bosnia and Herzegovina"
	dctCountryCodes.Add  389, "Macedonia"
	dctCountryCodes.Add  420, "Czech Republic"
	dctCountryCodes.Add  421, "Slovakia"
	dctCountryCodes.Add  423, "Liechtenstein"
	dctCountryCodes.Add  500, "Falkland Islands (Islas Malvinas)"
	dctCountryCodes.Add  501, "Belize"
	dctCountryCodes.Add  502, "Guatemala"
	dctCountryCodes.Add  503, "El Salvador"
	dctCountryCodes.Add  504, "Honduras"
	dctCountryCodes.Add  505, "Nicaragua"
	dctCountryCodes.Add  506, "Costa Rica"
	dctCountryCodes.Add  507, "Panama"
	dctCountryCodes.Add  508, "St. Pierre and Miquelon"
	dctCountryCodes.Add  509, "Haiti"
	dctCountryCodes.Add  590, "Guadeloupe"
	dctCountryCodes.Add  591, "Bolivia"
	dctCountryCodes.Add  592, "Guyana"
	dctCountryCodes.Add  593, "Ecuador"
	dctCountryCodes.Add  594, "French Guiana"
	dctCountryCodes.Add  595, "Paraguay"
	dctCountryCodes.Add  596, "Martinique"
	dctCountryCodes.Add  597, "Suriname"
	dctCountryCodes.Add  598, "Uruguay"
	dctCountryCodes.Add  599, "Netherlands Antilles"
	dctCountryCodes.Add  670, "East Timor"
	dctCountryCodes.Add  672, "Norfolk Island"
	dctCountryCodes.Add  673, "Brunei"
	dctCountryCodes.Add  674, "Nauru"
	dctCountryCodes.Add  675, "Papua New Guinea"
	dctCountryCodes.Add  676, "Tonga"
	dctCountryCodes.Add  677, "Solomon Islands"
	dctCountryCodes.Add  678, "Vanuatu"
	dctCountryCodes.Add  679, "Fiji Islands"
	dctCountryCodes.Add  680, "Palau"
	dctCountryCodes.Add  681, "Wallis and Futuna"
	dctCountryCodes.Add  682, "Cook Islands"
	dctCountryCodes.Add  683, "Niue"
	dctCountryCodes.Add  684, "American Samoa"
	dctCountryCodes.Add  685, "Samoa"
	dctCountryCodes.Add  686, "Kiribati"
	dctCountryCodes.Add  687, "New Caledonia"
	dctCountryCodes.Add  688, "Tuvalu"
	dctCountryCodes.Add  689, "French Polynesia"
	dctCountryCodes.Add  690, "Tokelau"
	dctCountryCodes.Add  691, "Micronesia"
	dctCountryCodes.Add  692, "Marshall Islands"
	dctCountryCodes.Add  705, "Kazakhstan"
	dctCountryCodes.Add  850, "North Korea"
	dctCountryCodes.Add  852, "Hong Kong SAR"
	dctCountryCodes.Add  853, "Macau SAR"
	dctCountryCodes.Add  855, "Cambodia"
	dctCountryCodes.Add  856, "Laos"
	dctCountryCodes.Add  880, "Bangladesh"
	dctCountryCodes.Add  886, "Taiwan"
	dctCountryCodes.Add  960, "Maldives"
	dctCountryCodes.Add  961, "Lebanon"
	dctCountryCodes.Add  962, "Jordan"
	dctCountryCodes.Add  963, "Syria"
	dctCountryCodes.Add  964, "Iraq"
	dctCountryCodes.Add  965, "Kuwait"
	dctCountryCodes.Add  966, "Saudi Arabia"
	dctCountryCodes.Add  967, "Yemen"
	dctCountryCodes.Add  968, "Oman"
	dctCountryCodes.Add  971, "United Arab Emirates"
	dctCountryCodes.Add  972, "Israel"
	dctCountryCodes.Add  973, "Bahrain"
	dctCountryCodes.Add  974, "Qatar"
	dctCountryCodes.Add  975, "Bhutan"
	dctCountryCodes.Add  976, "Mongolia"
	dctCountryCodes.Add  977, "Nepal"
	dctCountryCodes.Add  992, "Tajikistan"
	dctCountryCodes.Add  993, "Turkmenistan"
	dctCountryCodes.Add  994, "Azerbaijan"
	dctCountryCodes.Add  995, "Georgia"
	dctCountryCodes.Add  996, "Kyrgyzstan"
	dctCountryCodes.Add  998, "Uzbekistan"
	dctCountryCodes.Add 2691, "Comoros"
	dctCountryCodes.Add 5399, "Guantanamo Bay"
	dctCountryCodes.Add 6101, "Cocos (Keeling) Islands"

	If numCountry < 1 Then
		Set wshShell = CreateObject( "Wscript.Shell" )
		numCountry = wshShell.RegRead( "HKEY_CURRENT_USER\Control Panel\International\iCountry" )
		Set wshShell = Nothing
		If IsNumeric( numCountry ) Then numCountry = CInt( numCountry )
	End If

	Country = dctCountryCodes( numCountry )

	Set dctCountryCodes = Nothing
End Function


Sub Syntax
	Dim strMsg
	strMsg = vbcrlf _
	       & "iCountry.vbs,  Version 1.01" _
	       & vbCrLf _
	       & "Return the (English) country name for the specified numeric country code" _
	       & vbCrLf & vbCrLf _
	       & "Usage:  CSCRIPT  //NoLogo  ICOUNTRY.VBS  nn" _
	       & vbCrLf & vbCrLf _
	       & "Where:  ""nn""  is either a numeric country code as found in the Windows registry" _
	       & vbCrLf _
	       & "              value HKEY_CURRENT_USER\Control Panel\International\iCountry, or" _
	       & vbCrLf _
	       & "              0 to use that same registry value from the local computer" _
	       & vbCrLf & vbCrLf _
	       & "Written by Rob van der Woude" _
	       & vbCrLf _
	       & "http://www.robvanderwoude.com"
	WScript.Echo strMsg
	WScript.Quit 1
End Sub
