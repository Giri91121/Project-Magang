@echo off
title Web Server BRIDA Kota Makassar
echo ===================================================
echo   Menjalankan Web Server BRIDA Kota Makassar...
echo   URL: http://localhost:8000
echo ===================================================
echo.
echo Server sedang aktif. Jangan tutup jendela ini selama membuka web.
echo Tekan Ctrl + C untuk mematikan server.
echo.

if exist "C:\xampp\php\php.exe" (
    "C:\xampp\php\php.exe" -S localhost:8000 -t "%~dp0public"
) else (
    node "%~dp0server.js"
)
pause
