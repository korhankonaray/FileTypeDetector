# DnsDomainRecordConfiguration dnsDomainRecordConfiguration = new DnsDomainRecordConfiguration(DnsRecordType.Ptr,"name","data",TimeSpan.FromSeconds(100),"comment",priority);
Clear
Import-Module PoshStack

$Priority = 1

$TTL = New-TimeSpan -Seconds 100
$DnsDomainRecordConfiguration = New-Object -Type ([net.openstack.Providers.Rackspace.Objects.Dns.DnsDomainRecordConfiguration]) -ArgumentList @([net.openstack.Providers.Rackspace.Objects.Dns.DnsRecordType]::A, "name", "data", $TTL, "comment", $null)
