<?php 

require __DIR__.'/app/init.php';


$route=explode("/",$_SERVER["REQUEST_URI"]);
if(SUBFOLDER){
    while(true){
        if(isset($route[0]) && in_array("cms",$route)){
              array_shift($route);  
        }else {
            break;
        }
  }
}else {
    while(true){
        if(isset($route[0]) && in_array("cms",$route)){
            if($route[0]=="cms"):break;
            else: array_shift($route);  
        endif;
            
        }else {
            break;
        }
  }
}


if(!route(0) || empty(route(0)) ):$route[0]="index";
endif;


//if we don't have index.php under controller folder
if(!file_exists(controller($route[0]))){
     $route[0]="404";
}

if(setting("maintenance")==true && route(0)!="admin"){
    $route[0]="maintenance";
}


//Controller folder is ready to be required
require (controller(route(0)));




?>