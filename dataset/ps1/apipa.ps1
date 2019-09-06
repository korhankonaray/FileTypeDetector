Rob van der Woude's Scripting Pages
Menu
Home
News
FAQ
Search
Scripting Languages ►
Technologies ►
Books
Scripting Tools ►
Miscellaneous ►
About This Site ►
 
Powered by GeSHi
Source code for apipa.ps
(view source code of apipa.ps as plain text)

param(
	[parameter( ValueFromRemainingArguments = $true )]
	[string[]]$args # Leave all argument validation to the script, not to PowerShell
)
 
function Show-Help {
	#
	# APIPA.ps1,  Version 1.00
	# Get or set the IP AutoConfiguration status (aka APIPA) for all network adapters
	#
	# Usage:  powershell  ./APIPA.ps1  [ newstatus ]
	#
	# Where:  newstatus   is either Enabled (or 1, On, Set, True or Yes),
	#                     or Disabled (or 0, Off, Reset, False or No).
	#
	# Notes:  Be careful when changing system settings in the registry; if you
	#         do not fully understand what this script does, then don't use it.
	#         More information on APIPA: http://www.tech-faq.com/apipa.html
	#
	# Written by Rob van der Woude
	# http://www.robvanderwoude.com
	#
 
	Clear-Host
 
	Write-Host
	Write-Host "APIPA.ps1,  Version 1.00"
 
	Write-Host "Get or set the IP AutoConfiguration status (aka APIPA) for " -NoNewline
	Write-Host "all " -ForegroundColor White -NoNewline
	Write-Host "network adapters"
 
	Write-Host
 
	Write-Host "Usage:  " -NoNewline
	Write-Host "powershell  ./APIPA.ps1  [ newstatus ]" -ForegroundColor White
 
	Write-Host
 
	Write-Host "Where:  " -NoNewline
	Write-Host "newstatus   " -ForegroundColor White -NoNewline
	Write-Host "is either " -NoNewline
	Write-Host "Enabled " -ForegroundColor White -NoNewline
	Write-Host "(or " -NoNewline
	Write-Host "1" -ForegroundColor White -NoNewline
	Write-Host ", " -NoNewline
	Write-Host "On" -ForegroundColor White -NoNewline
	Write-Host ", " -NoNewline
	Write-Host "Set" -ForegroundColor White -NoNewline
	Write-Host ", " -NoNewline
	Write-Host "True " -ForegroundColor White -NoNewline
	Write-Host "or " -NoNewline
	Write-Host "Yes" -ForegroundColor White -NoNewline
	Write-Host "),"
 
	Write-Host "                    or " -NoNewline
	Write-Host "Disabled " -ForegroundColor White -NoNewline
	Write-Host "(or " -NoNewline
	Write-Host "0" -ForegroundColor White -NoNewline
	Write-Host ", " -NoNewline
	Write-Host "Off" -ForegroundColor White -NoNewline
	Write-Host ", " -NoNewline
	Write-Host "Reset" -ForegroundColor White -NoNewline
	Write-Host ", " -NoNewline
	Write-Host "False " -ForegroundColor White -NoNewline
	Write-Host "or " -NoNewline
	Write-Host "No" -ForegroundColor White -NoNewline
	Write-Host ")."
 
	Write-Host
	Write-Host "Notes:  Be careful when changing system settings in the registry; if you"
	Write-Host "        do not fully understand what this script does, then don't use it."
	Write-Host "        More information on APIPA: " -NoNewline
	Write-Host "http://www.tech-faq.com/apipa.html" -ForegroundColor DarkGray
	Write-Host
	Write-Host "Written by Rob van der Woude"
	Write-Host "http://www.robvanderwoude.com"
	Write-Host
 
	Exit 1
}
 
if ( ( $args.Length -gt 1 ) -or $h ) {
	Show-Help
}
 
$action = ""
 
# Interpret the command line argument
if ( $args.Length -eq 1 ) {
	switch ( $args[0] ) {
		"0"        { $action = "Off"; break }
		"1"        { $action = "On";  break }
		"Disable"  { $action = "Off"; break }
		"Disabled" { $action = "Off"; break }
		"Enable"   { $action = "On";  break }
		"Enabled"  { $action = "On";  break }
		"False"    { $action = "Off"; break }
		"No"       { $action = "Off"; break }
		"Off"      { $action = "Off"; break }
		"On"       { $action = "On";  break }
		"Reset"    { $action = "Off"; break }
		"Set"      { $action = "On";  break }
		"True"     { $action = "On";  break }
		"Yes"      { $action = "On";  break }
		default    { Show-Help;       break }
	}
}
 
# Make sure the variable is not set
Clear-Variable apipa -ErrorAction SilentlyContinue
 
$regpath = "HKLM:\SYSTEM\CurrentControlSet\services\Tcpip\Parameters"
 
# Read the registry value
$IPParameters = ( Get-ItemProperty -Path $regpath -ErrorAction SilentlyContinue )
$apipa = $IPParameters.IPAutoconfigurationEnabled
 
# Show current status before change
Write-Host "Current APIPA Status: " -NoNewline
[string]$apipa = $IPParameters.IPAutoconfigurationEnabled
# switch( $apipa ) cannot be used here because it handles 0, null
# and whitespace all as 0, so we'll have to use if..elseif..else
if ( $apipa -eq "" ) {
	Write-Host "not set"  -ForegroundColor White
} elseif ( $apipa -eq 0 ) {
	Write-Host "disabled" -ForegroundColor White
} elseif ( $apipa -eq 1 ) {
	Write-Host "enabled"  -ForegroundColor White
} else {
	Write-Host "unknown"  -ForegroundColor White
}
 
# Change the registry value if requested
if ( $action ) {
	if ( $action -eq "On" ) {
		$newvalue = 1
	}
	if ( $action -eq "Off" ) {
		$newvalue = 0
	}
 
	# Set the new registry value
	New-ItemProperty -Path $regpath -Name "IPAutoconfigurationEnabled" -Value $newvalue -PropertyType DWORD -ErrorAction SilentlyContinue -ErrorVariable err | Out-Null
	if ( $err ) {
		if ( $err[0].CategoryInfo.Category -eq "ResourceExists" ) {
			# Clear the ResourceExists error
			$err.Clear( )
			# If the registry value already exists, just set it to its new value
			Set-ItemProperty -Path $regpath -Name "IPAutoconfigurationEnabled" -Value $newvalue -ErrorAction SilentlyContinue | Out-Null
		} else {
			# Abort on all errors except ResourceExists
			Write-Host "Error: " -ForegroundColor Red -NoNewline
			Write-Host $err[0].Exception.Message -ForegroundColor White
			Exit 1
		}
	}
 
	# Reread the registry value
	$IPParameters = ( Get-ItemProperty -Path $regpath -ErrorAction SilentlyContinue )
	$apipa = $IPParameters.IPAutoconfigurationEnabled
 
	# Show status after change
	Write-Host "Changed APIPA Status: " -NoNewline
	if ( $apipa -eq "" ) {
		Write-Host "not set"  -ForegroundColor White
	} elseif ( $apipa -eq 0 ) {
		Write-Host "disabled" -ForegroundColor White
	} elseif ( $apipa -eq 1 ) {
		Write-Host "enabled"  -ForegroundColor White
	} else {
		Write-Host "unknown"  -ForegroundColor White
	}
}
 
page last uploaded: 2019-01-21, 22:48