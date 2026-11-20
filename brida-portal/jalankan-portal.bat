@echo off
title Menjalankan Portal BRIDA Kota Makassar (Laravel)
echo ========================================================
echo   PORTAL RESMI & DASHBOARD BRIDA KOTA MAKASSAR
echo ========================================================
echo.
echo Menjalankan Laravel Development Server...
echo.
echo URL Portal Publik : http://localhost:8000
echo URL Login Masuk   : http://localhost:8000/login
echo URL Dashboard     : http://localhost:8000/dashboard
echo.
echo Akun Demo Tersedia:
echo   1. Admin       : admin@brida.makassarkota.go.id / password123
echo   2. Peneliti    : peneliti@brida.makassarkota.go.id / password123
echo   3. Fasilitator : fasilitator@brida.makassarkota.go.id / password123
echo   4. Pemohon     : pemohon@brida.makassarkota.go.id / password123
echo.
echo Tekan Ctrl+C untuk menghentikan server.
echo.

cd /d "%~dp0"
C:\xampp\php\php.exe artisan serve --host=0.0.0.0 --port=8000
pause
