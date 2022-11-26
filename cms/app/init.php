<?php

session_start();
ob_start();

//auto include our class under classes folder
function loadClass($className)
{
    $dir=__DIR__."/classes/".strtolower($className).".php";
    require($dir);
}

spl_autoload_register('loadClass');

$config=require(__DIR__."/config.php");

$dbname=$config["db"]["name"];
$host=$config["db"]["host"];
$user=$config["db"]["user"];
$psw=$config["db"]["pass"];

try {
    $db=new PDO("mysql:host=".$host.";dbname=".$dbname,$user,$psw);
} catch (PDOException $e) {
  die($e->getMessage());
}

$helper_php_files=glob(__DIR__."/helper/*.php");

foreach ($helper_php_files as $helper_file) {
    require($helper_file);
}




?>