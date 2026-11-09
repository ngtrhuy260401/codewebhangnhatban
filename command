D:
cd D:\xampp\htdocs\1-happycms
"C:\Program Files\Google\Chrome\Application\chrome.exe" happycms.l/public/CreateDB.php
php artisan clear-compiled
composer dump-autoload
php artisan optimize
php artisan migrate
php artisan db:seed
php artisan view:clear
exit
