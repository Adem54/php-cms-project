<?php 



if(!route(1)){
    $route[1]="index";
}


if(!file_exists(admin_controller(route(1)))){
    $route[1]="index";
}



$menus=[
    "index"=>[
        "title"=>"Homepage",
        "icon"=>"tachometer"
    ],
    "users"=>[
        "title"=>"Members",
        "icon"=>"user",
        "submenu"=>[
            "add-user"=>"Add Member",
            "get-users"=>"Show Members"
        ]
    ],
    "settings"=>[
        "title"=>"Settings",
        "icon"=>"cog"
    ]
    
   
    ];



require(admin_controller(route(1)));






?>