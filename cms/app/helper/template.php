<?php 

function site_url($url=false)
{
    return URL. "/". $url;
    //define("URL","http://localhost/test/php-cms-project/cms");
}

function public_url($url=false){
    return URL."/public/".setting("theme")."/".$url;
    //ttp://localhost/test/php-cms-project/cms/public/style.css
   
}


function admin_site_url($url=false)
{
    return URL. "/admin/". $url;
    //define("URL","http://localhost/test/php-cms-project/cms/admin");
}

function admin_public_url($url=false){
    return URL."/admin/public/".$url;
    //http://localhost/test/php-cms-project/cms/admin/public/style.css
}

function error(){
    global $error;
    return $error ?? false;
    //return isset($error) ? $error :false;
}
function success(){
    global $success;
    return $success ?? false;
    //return isset($success) ? $success :false;
}

?>