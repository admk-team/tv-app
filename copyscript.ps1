# Define the Laravel source directory
$sourceDir = "D:\tv-app"

# Array of subdomain directories to update
$subdomainDirs = @("testdomain", "testdomain1") # Replace with your actual subdomain folder names

# Files and directories to exclude, including subdomains
$exclude = @("vendor", ".env", ".htaccess") + $subdomainDirs

foreach ($subdomain in $subdomainDirs) {
    Write-Host "Updating $subdomain..."

    # Full path to the subdomain directory
    $targetDir = Join-Path $sourceDir $subdomain

    # Copy all files from source, excluding specified items and subdomains
    Copy-Item -Path "$sourceDir\*" -Destination $targetDir -Recurse -Force `
        -Exclude $exclude

    Write-Host "Update completed for $subdomain."
}

Write-Host "All subdomains have been updated."
