<?php
// Kết nối DB
$servername = "127.0.0.1";
// Get value from .env file ===================================
$myfile = fopen(".env", "r") or die("Unable to open file!");
$text = fread($myfile,filesize(".env"));

// DB_USERNAME=xxxx 
$matches = [];
preg_match_all("/DB\_USERNAME\=(.+?)\n/is", $text, $matches);
$username = $matches[1][0]; 

// DB_PASSWORD=xxxx
$matches = [];
preg_match_all("/DB\_PASSWORD\=(.+?)\n/is", $text, $matches);
$password = $matches[1][0]; 

// DB_DATABASE=xxxxx 
$matches = [];
preg_match_all("/DB\_DATABASE\=(.+?)\n/is", $text, $matches);
$dbname = $matches[1][0];

// COMPANY_WEBSITE=xxxxx 
// $matches = [];
// preg_match_all("/APP\_URL\_REAL\=\'(.+?)\'\n/is", $text, $matches);
// $base_url = $matches[1][0];
$base_url = 'http://'.$_SERVER['HTTP_HOST'];

fclose($myfile);

//sitemap.php
$connect = mysqli_connect($servername, $username, $password, $dbname);
if (!$connect->set_charset("utf8")) {
	// printf("Error loading character set utf8: %s\n", $connect->error);
} else {
	// printf("Current character set: %s\n", $connect->character_set_name());
}
$query = "SELECT title,id FROM categories WHERE active='1' and deleted_at is NULL";
$query2 = "SELECT title,id FROM posts WHERE active='1' and deleted_at is NULL";
//this will query all post url in your database in the post table
//$query = "SELECT post_title FROM post";
//this will query all post title in your database in the post table

// $d['link'] = '/'.Helper::getPathFromString($d['title']).'-2523'.$d['id'];
// $d['link'] = '/'.Helper::getPathFromString($d['title']).'-3425'.$d['id'];

$result = mysqli_query($connect, $query);
$result2 = mysqli_query($connect, $query2);
header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;
echo '<url>' . PHP_EOL;
echo '<loc>'.$base_url.'/</loc>' . PHP_EOL;
echo '<priority>1.00</priority>' . PHP_EOL;
echo '</url>' . PHP_EOL;
while($row = mysqli_fetch_array($result))
{
	echo '<url>' . PHP_EOL;
	echo '<loc>'.$base_url.'/'.getPathFromString($row["title"]).'-2523'.$row['id'].'/</loc>' . PHP_EOL;
	echo '<changefreq>daily</changefreq>' . PHP_EOL;
	echo '</url>' . PHP_EOL;
}
while($row2 = mysqli_fetch_array($result2))
{
	echo '<url>' . PHP_EOL;
	echo '<loc>'.$base_url.'/'.getPathFromString($row2["title"]).'-3425'.$row2['id'].'/</loc>' . PHP_EOL;
	echo '<changefreq>daily</changefreq>' . PHP_EOL;
	echo '</url>' . PHP_EOL;
}
echo '</urlset>' . PHP_EOL;

function getPathFromString($text){
	$marTViet=["à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
	"ằ","ắ","ặ","ẳ","ẵ","è","é","ẹ","ẻ","ẽ","ê","ề"
	,"ế","ệ","ể","ễ",
	"ì","í","ị","ỉ","ĩ",
	"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
	,"ờ","ớ","ợ","ở","ỡ",
	"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
	"ỳ","ý","ỵ","ỷ","ỹ",
	"đ",
	"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă"
	,"Ằ","Ắ","Ặ","Ẳ","Ẵ",
	"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề","Ế","Ệ","Ể","Ễ",
	"Ì","Í","Ị","Ỉ","Ĩ",
	"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
	,"Ờ","Ớ","Ợ","Ở","Ỡ",
	"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
	"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
	"Đ"];

	$marKoDau=["a","a","a","a","a","a","a","a","a","a","a"
	,"a","a","a","a","a","a",
	"e","e","e","e","e","e","e","e","e","e","e",
	"i","i","i","i","i",
	"o","o","o","o","o","o","o","o","o","o","o","o"
	,"o","o","o","o","o",
	"u","u","u","u","u","u","u","u","u","u","u",
	"y","y","y","y","y",
	"d",
	"A","A","A","A","A","A","A","A","A","A","A","A"
	,"A","A","A","A","A",
	"E","E","E","E","E","E","E","E","E","E","E",
	"I","I","I","I","I",
	"O","O","O","O","O","O","O","O","O","O","O","O"
	,"O","O","O","O","O",
	"U","U","U","U","U","U","U","U","U","U","U",
	"Y","Y","Y","Y","Y",
	"D"];
	return str_replace(' ','-', preg_replace('!\s+!', ' ', preg_replace('/[^a-z0-9]/i', ' ', strtolower(str_replace($marTViet,$marKoDau ,$text)))));
}