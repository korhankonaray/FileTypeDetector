param( [string]$drive = "" )

[int]$Script:rc = 0


function IsOpticalWriter {
	param( [string]$drive )
	$iscdrom = $false
	$isdrive = $false
	$iswriter = $false
	[int]$Local:rc = Get-Variable -Name rc -Scope Script -ValueOnly
	foreach ( $_ in Get-WmiObject -Query "SELECT * FROM Win32_LogicalDisk WHERE DeviceID='$drive'" ) {
		$isdrive = $true
	}
	foreach ( $cdromdrive in Get-WmiObject -Query "SELECT Capabilities FROM Win32_CDROMDrive WHERE Drive='$drive'" ) {
		$iscdrom = $true
		foreach ( $capability in $cdromdrive.Capabilities ) {
			if ( $capability -eq 4 ) {
				$iswriter = $true
				$Local:rc += 1
				Set-Variable -Name rc -Scope Script -Value $Local:rc
			}
		}
	}
	if ( $iswriter ) {
		Write-Host "Drive $drive is a CD/DVD writer"
	} elseif ( $iscdrom ) {
		Write-Host "Though drive $drive is an optical drive, it is NOT a CD/DVD writer"
	} elseif ( $isdrive ) {
		Write-Host "Drive $drive is NOT an optical drive, so it cannot be a CD/DVD writer"
	} else {
		Write-Host "$drive is NOT a valid drive letter for this computer"
		$Local:rc = -1
		Set-Variable -Name rc -Scope Script -Value $Local:rc
	}
}


if ( $drive -eq "" ) {
	Write-Host
	foreach ( $cdromdrive in Get-WmiObject -Query "SELECT Drive FROM Win32_CDROMDrive" ) {
		IsOpticalWriter ( $cdromdrive.Drive )
	}
} elseif ( $drive -inotmatch "^[A-Z]:$" ) {
	Write-Host "`nIsCDWriter.ps1,  Version 1.00"
	Write-Host "Check whether specified drive is a CD/DVD writer or not`n"
	Write-Host "Usage:  IsCDWriter.ps1  [ drive ]`n"
	Write-Host "where:  `"drive`"         is the drive to test`n"
	Write-Host "Written by Rob van der Woude"
	Write-Host "http://www.robvanderwoude.com`n"
	exit -1
} else {
	IsOpticalWriter $drive.ToUpper( )
}

if ( $drive -eq "" ) {
	[string]$s = "s"
	Write-Host "`n$Script:rc" "CD/DVD writer" -NoNewline
	if ( $Script:rc -ne 1  ) { Write-Host "s" -NoNewline }
	Write-Host " found`n"
}

exit $Script:rc
