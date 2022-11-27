<?php 

function controller($controllerName){
    $controllerName=strtolower($controllerName);
   //PATH config.php icinde constant olarak root path i proje pathini veriyordu
   //PATH="C:.....test/php-cms-project/cms/"; 
   return PATH."/app/controller/".$controllerName.".php";
}


function view($viewName){
   
    $viewName=strtolower($viewName);
    return PATH."/app/view/".setting("theme")."/".$viewName.".php";
}


function route($index){
    global $route;
     return isset($route[$index]) ? $route[$index] : false;
}

function setting($name){
  //app/settings.php yi biz tum uygulamaya dahil etmistik init.php de ve ordan 1 tane $settings array degiskeni geliyor, o array $settings i burda kullanmak istyoruz onun icin global yapariz 
  global $settings; 
  //Burda parametrye verilen name value si ne ise biz setting[""] dizisi icine geleek sekilde dondururuz
  //Bunlari, html icinde name value si olarak kullanacagiz
  return isset($settings[$name]) ? $settings[$name] :false;
  //return $settings[$name] ?? false;

}

?>