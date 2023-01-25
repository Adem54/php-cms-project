<?php 
session_destroy();
// header("Location:".isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url());
header("Location:".$_SERVER["HTTP_REFERER"] ?? site_url());
//BURDA KULLANICIIYI GELDIGI  YERE GONDERIYORUZ EGER VAR ISE BIR GELDIGI YER YOK ISE O ZAMAN DA ANA SAYFAYA GONDERIYORUZ...BESTPRACTISE HARIKA BESTPRACTISE...YA
exit();//Burdan sonra kodumuz artik calismasin diye exit yaziyoruz
?>