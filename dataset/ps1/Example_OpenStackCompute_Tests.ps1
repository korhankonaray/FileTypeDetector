Clear
Remove-Module PoshStack
Import-Module PoshStack
$account_name = "rackiad"
$list = Get-OpenStackComputeServer -Account $account_name
foreach ($vm in $list) {
    Write-Host "SERVER " $vm.Name
    $vlist = Get-OpenStackComputeServerVolume -Account $account_name -ServerId $vm.id
    foreach ($v in $vlist) { 
        Write-Host "------- Get-OpenStackComputeServerVolumeDetail"
        Get-OpenStackComputeServerVolumeDetail -Account $account_name -ServerId $vm.Id -VolumeId $v.Id
    }
    Write-Host "---- Get-OpenStackComputeServerAddress"
    Get-OpenStackComputeServerAddress -Account $account_name -ServerId $vm.Id
}
Write-Host "-- Get-OpenStackBlockStorageVolume"
Get-OpenStackBlockStorageVolume -Account $account_name
