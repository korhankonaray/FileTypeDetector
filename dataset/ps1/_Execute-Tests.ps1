#Requires -Version 2
param(
    [string]$PesterPath = $null,
    [string]$PesterRef = "anurse/teamcity",
    [string]$PesterRepo = "https://github.com/anurse/Pester",
    [string]$TestsPath = $null,
    [string]$TargetPath = $null,
    [string]$TestName = $null,
    [string]$TestWorkingDir = $null,
    [string]$TestAppsDir = $null,
    [Alias("Tags")][string]$Tag = $null,
    [string]$OutputFile = $null,
    [string]$OutputFormat = $null,
    [switch]$Strict,
    [switch]$Quiet,
    [switch]$Debug,
    [switch]$TeamCity,

    # Cheap and relatively effective way to scare users away from running this script themselves
    [switch]$RunningInNewPowershell)

if(!$RunningInNewPowershell) {
    throw "Don't use this script to run the tests! Use Run-Tests.ps1, it sets up a new powershell instance in which to run the tests!"
}

$scriptDir = $PSScriptRoot
if (!$scriptDir) {
    if ($MyInvocation.MyCommand.Path) {
        $scriptDir = Split-Path $MyInvocation.MyCommand.Path -Parent
    }
}

Write-Host "Script Dir: $scriptDir"

. "$scriptDir\_Common.ps1"

# Set defaults
if(!$PesterPath) { $PesterPath = Join-Path $scriptDir ".pester" }
if(!$TestsPath) { $TestsPath = Join-Path $scriptDir "tests" }
if(!$TargetPath) { $TargetPath = Convert-Path (Join-Path $scriptDir "../../src/dnvm.ps1") }
if(!$TestWorkingDir) { $TestWorkingDir = Join-Path $scriptDir "testwork" }
if(!$TestWorkingGlobalDir) { $TestWorkingGlobalDir = Join-Path $scriptDir "testworkGlobal" }
if(!$TestAppsDir) { $TestAppsDir = Convert-Path (Join-Path $scriptDir "../apps") }


# Configure the Runtimes we're going to use in testing. The actual runtime doesn't matter since we're only testing
# that dnvm can find it, download it and unpack it successfully. We do run an app in the runtime to do that sanity
# test, but all we care about in these tests is that the app executes.
#$env:DNX_FEED = "https://www.myget.org/F/aspnetrelease/api/v2"
#NOTE: This should be set back to release once we have non windows DNX on that feed.
$env:DNX_FEED = "https://nuget.org/api/v2/"
$TestRuntimeVersion = "1.0.0-beta7"
$specificNupkgUrl = "$($env:DNX_FEED)/package/dnx-coreclr-win-x64/$TestRuntimeVersion"
$specificNupkgHash = "AvYCzI6R94VSFfzrLF79T9bPQXHjWLB73BwSNJkxOYA="
$specificNupkgName = "dnx-coreclr-win-x64.$TestRuntimeVersion.nupkg"
$specificNuPkgFxName = "Asp.Net,Version=v5.0"

# Set up context
$CommandPath = $TargetPath

# Create test working directory
if(Test-Path "$TestWorkingDir\$RuntimeFolderName") {
    Write-Banner "Wiping old test working area"
    del -rec -for "$TestWorkingDir\$RuntimeFolderName"
}
if(Test-Path "$TestWorkingGlobalDir\$RuntimeFolderName") {
    Write-Banner "Wiping old global test working area"
    del -rec -for "$TestWorkingGlobalDir\$RuntimeFolderName"
}

if(!(Test-Path $TestWorkingDir)) {
    mkdir $TestWorkingDir | Out-Null
}
if(!(Test-Path $TestWorkingGlobalDir)) {
    mkdir $TestWorkingGlobalDir | Out-Null
}

# Import the module and set up test environment
Import-Module "$PesterPath\Pester.psm1"

# Turn on Debug logging if requested
if($Debug) {
    $DebugPreference = "Continue"
    $VerbosePreference = "Continue"
}

# Unset KRE_HOME for the test
$oldKreHome = $env:DNX_HOME
Remove-EnvVar DNX_HOME

# Unset KRE_TRACE for the test
Remove-EnvVar DNX_TRACE

# Unset PATH for the test
Remove-EnvVar PATH

# Set up the user/global install directories to be inside the test work area
$UserPath = "$TestWorkingDir\$RuntimeFolderName"
$GlobalPath = "$TestWorkingGlobalDir\$RuntimeFolderName"
$env:DNX_HOME="$($UserPath);$($GlobalPath)"
$env:DNX_USER_HOME=$UserPath
$env:DNX_GLOBAL_HOME=$GlobalPath
mkdir $UserPath | Out-Null

# Helper function to run dnvm and capture stuff.
function __dnvmtest_run {
    $oldWP = $WarningPreference
    $WarningPreference = "SilentlyContinue"

    
    $Global:__dnvmtest_out = $null
    $Global:__dnvmtest_exit = $null
    $__TestWriteTo = "__dnvmtest_out"
    try {
        & $CommandPath @args
        $Global:__dnvmtest_exit = $LASTEXITCODE
    } catch {
        $Global:__dnvmtest_err = $_
    }

    $WarningPreference = $oldWP
}

# Fetch a nupkg to use for the 'dnvm install <path to nupkg>' scenario
Write-Banner "Fetching test prerequisites"

$downloadDir = Join-Path $TestWorkingDir "downloads"
if(!(Test-Path $downloadDir)) { mkdir $downloadDir | Out-Null }
$specificNupkgPath = Join-Path $downloadDir $specificNupkgName

# If the test package exists
if(Test-Path $specificNupkgPath) {
    # Test it against the expected hash
    if((Get-FileHash $specificNupkgPath) -ne $specificNupkgHash) {
        # Failed to match, kill it with fire!
        Write-Host "Test prerequisites are corrupt, redownloading."
        rm -for $specificNupkgPath
    }
}

# Check if the the test package exists again (since we might have deleted it above)
if(!(Test-Path $specificNupkgPath)) {
    # It doesn't, redownload it
    $wc = New-Object System.Net.WebClient
    $wc.DownloadFile($specificNupkgUrl, $specificNupkgPath)

    # Test it against the expected hash
    $actualHash = (Get-FileHash $specificNupkgPath)
    if($actualHash -ne $specificNupkgHash) {
        # Failed to match, we downloaded a corrupt package??
        throw "Test prerequisite $specificNupkgUrl failed to download. The hash '$actualHash' does not match the expected value."
    }
}

# Run the tests!
# Powershell complains if we pass null in for -OutputFile :(
Write-Banner "Running Pester Tests in $TestsPath"
if($OutputFile) {
    $result = Invoke-Pester `
        -Path $TestsPath `
        -TestName $TestName `
        -Tag $Tag `
        -Strict:$Strict `
        -Quiet:$Quiet `
        -OutputFile $OutputFile `
        -OutputFormat $OutputFormat `
        -PassThru
} else {
    $result = Invoke-Pester `
        -Path $TestsPath `
        -TestName $TestName `
        -Tag $Tag `
        -Strict:$Strict `
        -Quiet:$Quiet `
        -PassThru
}

function TeamCityEscape($str) {
    if($str) {
        $str.Replace("|", "||").Replace("'", "|'").Replace("`n", "|n").Replace("`r", "|r").Replace("[", "|[").Replace("]", "|]")
    }
}

# Generate TeamCity Output
if($TeamCity) {
    Write-Host "##teamcity[testSuiteStarted name='$CommandName.ps1 on PSv$($Host.Version.Major)']"
    $result.TestResult | Group-Object Describe | ForEach-Object {
        $describe = TeamCityEscape $_.Name
        Write-Host "##teamcity[testSuiteStarted name='$describe']"
        $_.Group | Group-Object Context | ForEach-Object {
            $context = TeamCityEscape $_.Name
            Write-Host "##teamcity[testSuiteStarted name='$context']"
            $_.Group | ForEach-Object {
                $name = "It $(TeamCityEscape $_.Name)"
                $message = TeamCityEscape $_.FailureMessage
                Write-Host "##teamcity[testStarted name='$name']"
                switch ($_.Result) {
                    Skipped
                    {
                        Write-Host "##teamcity[testIgnored name='$name' message='$message']"
                    }
                    Pending
                    {
                        Write-Host "##teamcity[testIgnored name='$name' message='$message']"
                    }
                    Failed
                    {
                        Write-Host "##teamcity[testFailed name='$name' message='$message' details='$(TeamCityEscape $_.StackTrace)']"
                    }
                }
                Write-Host "##teamcity[testFinished name='$name']"
            }
            Write-Host "##teamcity[testSuiteFinished name='$context']"
        }
        Write-Host "##teamcity[testSuiteFinished name='$describe']"
    }
    Write-Host "##teamcity[testSuiteFinished name='$CommandName.ps1']"
}

# Set the exit code!
$host.SetShouldExit($result.FailedCount)
