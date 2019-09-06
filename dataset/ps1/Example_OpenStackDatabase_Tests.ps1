Clear
Remove-Module PoshStack
Import-Module PoshStack
$account_name = "rackiad"
Get-OpenStackDatabaseFlavor -Account $account_name
$instanceList = Get-OpenStackDatabaseInstance -Account $account_name
foreach ($instance in $instanceList) {
    # Following line gets all the databases in the instance
    Get-OpenStackDatabase -Account $account_name -InstanceId $instance.Id
    # Following four lines gets all the databases but returns only one.
    $dbname = "database_name"; $dbnameLength = $dbname.Length; $marker = $dbname.Substring(0, $dbnameLength-1)
    Get-OpenStackDatabase -Account $account_name -InstanceId $instance.Id -Marker $marker | WHERE {$_.Name -eq $dbname}
}
