<?php 
//foreach(glob(PATH."/app/view/*",GLOB_ONLYDIR)
//glob(PATH."/app/view/*/");
$themes=[];
foreach(glob(PATH."/app/view/*/") as $value){
        $value=explode("/",rtrim($value,"/"));
      // print_r($value);
        $themes[]=end($value);
         //netsense-v1,udemy-v1
}






if(isset($_POST['submit'])){
    
    $html='<?php '.PHP_EOL.PHP_EOL;//2 kez new line yapmak icin php nin inbuild new line islemi yapan sabitini 2 kez kullanmis olduk

    foreach (post("settings") as $key => $value) {
        # code...
        $html.='$settings["'.$key.'"]="'.$value.'";'.PHP_EOL;
    };
    //olusturudgmuz ayarlar icerigini, app altindaki settings.php sayfamiza  yazdiracgiz
  file_put_contents(PATH."/app/settings.php",$html);
  header("Location:".admin_site_url("settings"));
  //icinde bulundgumuz sayfaya yonlendirerek post ettikten sonra buraya geri gelsin diye 
    
}
//Normalde, bu sayfadan biz, admin/view/settings.php yi require ediyoruz ondan dolayi setting.php yi gosteriyoruz, bu sayfadan gosteriyoruz, biz bu sayfadayiz yani settings sayfasini actimigz zaman

function getUserNameOfSocial($name){
  $value=explode("/",$name);
  return end($value);
};



require admin_view("settings");

?>