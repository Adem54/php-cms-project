<?php 
//We take root path as constant by using define();
define("PATH", realpath("."));
define("SUBFOLDER",true);
define("URL","http://localhost/test/php-cms-project/cms");

//database configuration
return [
 "db"=>[
    "name"=>"cms",
    "host"=>"localhost",
    "user"=>"root",
    "pass"=>""
 ]
];

?>