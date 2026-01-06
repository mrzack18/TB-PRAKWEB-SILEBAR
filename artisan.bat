@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
set "SCRIPT_DIR=%~dp0"

php "%SCRIPT_DIR%artisan.php" %*