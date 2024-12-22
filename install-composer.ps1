php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
Move-Item composer.phar C:\xampp\php\composer.phar
$env:Path += ";C:\xampp\php"
echo "@php %~dp0composer.phar %*" | Out-File C:\xampp\php\composer.bat -Encoding ASCII 