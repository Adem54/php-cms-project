<?php 

function admin_controller($controllerName){
    $controllerName=strtolower($controllerName);
   //PATH config.php icinde constant olarak root path i proje pathini veriyordu
   //PATH="http://localhost/test/php-cms-project/cms/"; 
   return PATH."/admin/controller/".$controllerName.".php";
}

function admin_view($viewName){
    $viewName=strtolower($viewName);
    return PATH."/admin/view/".$viewName.".php";
}



?>