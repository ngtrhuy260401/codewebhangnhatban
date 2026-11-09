<?php

// $filename = "backup-" . date("d-m-Y") . ".sql.gz";
// Mat Bao find Scheduled Tasks
// Run a PHP script
// vietlogos.com.vn/mysql_backup.php
// Daily
// Cronjob /usr/local/bin/php /home/bytec612/public_html/backup.php
// Phải cấp full quyền cho user sang data

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$database = 'lub94776_lubox';
$user = 'lub94776_lubox';
$pass = 'tWfz314~';
$host = 'localhost';
$filename = "backup-" . date("d-m-Y");
$dir = dirname(__FILE__) . '/public/upload/BACKUP_KHONGXOA/'.$filename.'.sql';

echo "<h3>Backing up database to `<code>{$dir}</code>`</h3>";

exec("mysqldump --user={$user} --password={$pass} --host={$host} {$database} --result-file={$dir} 2>&1; gzip {$dir};", $output);

var_dump($output);
?>