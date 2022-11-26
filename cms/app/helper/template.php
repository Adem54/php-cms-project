<?php 

function site_url($url=false)
{
    return URL. "/". $url;
    //define("URL","http://localhost/test/php-cms-project/cms");
}

function public_url($url=false){
    return URL."/public/".$url;
    //ttp://localhost/test/php-cms-project/cms/public/style.css
}

?>