# Create user accounts for a workshop
Clear
Remove-Module PoshStack
Import-Module PoshStack

$acct = "workshop"

$DefaultRegion = "DFW"
$NumberToCreate = 40
$UserNamePrefix = "workshop"
$PasswordPrefix = "iTt"
$EmailAddress = "don.schenck@rackspace.com"

$path = "c:\temp\workshop.csv"
$fso = New-Object -ComObject scripting.filesystemobject
$file = $fso.CreateTextFile($path, $true)

$nl = [Environment]::NewLine

$i=1
do {
    $CreatedName = $UserNamePrefix + $i
    $pn = Get-Random
    $CreatedPassword = $PasswordPrefix + $pn + '&$'
    
    $csv +=$CreatedName + "," + $CreatedPassword + $nl
    

    ## Create user Account
    Write-Host $CreatedName
    $NewUser = New-OpenStackIdentityUser -Account $acct -UserName $CreatedName -UserPass $CreatedPassword -UserEmail $EmailAddress 
    


    ## Assign roles:
    ##  179       Nova Creator
    ##  173       Cloud Block Storage creator
    ##  10000256  Object Store Admin
    ##  129       LBaaS Creator
    ##  167       Cloud Database Creator
    Add-OpenStackIdentityRoleForUser -Account $acct -UserID $NewUser.id -RoleID 179
    Add-OpenStackIdentityRoleForUser -Account $acct -UserID $NewUser.id -RoleID 173
    Add-OpenStackIdentityRoleForUser -Account $acct -UserID $NewUser.id -RoleID 10000256
    Add-OpenStackIdentityRoleForUser -Account $acct -UserID $NewUser.id -RoleID 129
    Add-OpenStackIdentityRoleForUser -Account $acct -UserID $NewUser.id -RoleID 167

    Edit-OpenStackIdentityUser -Account $acct -UserID $NewUser.id -DefaultRegion $DefaultRegion
    
    
    $i++
}
while ($i -le $NumberToCreate)

$file.write($csv)

$file.close()
