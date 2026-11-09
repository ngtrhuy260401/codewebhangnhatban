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
fclose($myfile);

//sitemap.php
$connect = mysqli_connect($servername, $username, $password, $dbname);
if (!$connect->set_charset("utf8")) {
	printf("Error loading character set utf8: %s\n", $connect->error);
} else {
	printf("Current character set: %s\n", $connect->character_set_name());
}
$query = "SELECT title,id FROM categories WHERE deleted_at is NULL";
$query2 = "SELECT title,id FROM posts WHERE deleted_at is NULL";
//this will query all post url in your database in the post table
//$query = "SELECT post_title FROM post";
//this will query all post title in your database in the post table

// $d['link'] = '/'.Helper::getPathFromString($d['title']).'-2523'.$d['id'];
// $d['link'] = '/'.Helper::getPathFromString($d['title']).'-3425'.$d['id'];

$result = mysqli_query($connect, $query);
$result2 = mysqli_query($connect, $query2);
while($row = mysqli_fetch_array($result))
{
	$resultx = mysqli_query($connect, "INSERT INTO slugs (`link`, `type`, `item`) VALUES ('/".getPathFromString($row['title'])."','category','".$row['id']."');");
}
while($row2 = mysqli_fetch_array($result2))
{
	$resultx2 = mysqli_query($connect, "INSERT INTO slugs (`link`, `type`, `item`) VALUES ('/".getPathFromString($row2['title'])."','post','".$row['id']."');");
}

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