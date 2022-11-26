<?php 

function controller($controllerName){
    $controllerName=strtolower($controllerName);
   //PATH config.php icinde constant olarak root path i proje pathini veriyordu
   //PATH="C:.....test/php-cms-project/cms/"; 
   return PATH."/app/controller/".$controllerName.".php";
}

function view($viewName){
    $viewName=strtolower($viewName);
    return PATH."/app/view/".$viewName.".php";
}


function route($index){
    global $route;
     return isset($route[$index]) ? $route[$index] : false;
}
?>