@echo off
echo Starting Pacudan's Bakeshop Server...
php -d extension_dir=C:\php-8.3.25\ext -d extension=mbstring -d extension=intl -d extension=mysqli spark serve
pause