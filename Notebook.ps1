$serial = (Get-WmiObject -Class Win32_BIOS).SerialNumber
$os = (Get-ComputerInfo).WindowsProductName -replace "\s", "%20"
Start "http://localhost/notebook/register?serial=$serial&os=$os"
Rename-Computer -NewName (Invoke-WebRequest -Uri "http://localhost/notebook/hostname.txt").Content
Restart-Computer