<?php 
$meta=[
    "title"=>"Log In"
];

//1-Dostum eger submit edilmis ise butun bu islemleri yap, yok ise hicbirsey yapma direk login forma devam et diyoruz dikkat edelim dogru anlayalim ezber yapmayalim....
//2-EGer kullanici submite basar ve form alanlarini bos birakarak gonderir ise o alanlar bize empty, bos string olarak gelir, yani input lar da name ler atanmis ise o name ler key olarak post icerisine gelecektir ama, string olarak bos gelecektir ancak tabi ki bura da bir front-end validation kullaniciyi ilk olarak karsilamalidir....bu onemli...
if(post("submit")){
    $username=post("username");
    $password=post("password");

    if(empty($username)){//!$username
        $error="Username must be filled";
    }elseif(!$password){//empty($password)
        $error="Password must be filled";
    }else{
        //Artik, username ve password veritabaninda bulunup bulunmadigini kontrol edebiliriz 
     
        // $query=$db->prepare("SELECT * FROM USERS WHERE user_name = ?");
        // $query->execute([$username]);
        // $row=$query->fetch(PDO::FETCH_ASSOC);
        $row=USER::userExist($username);
        //Eger boyle bir username var ise o zaman da passwordu checke edelim var mi diye
        if($row){
            $checkPassword=password_verify($password,$row["user_password"]);
            if($checkPassword){
                $success="You logged inn successfully, you are redirecting...";
                //GIRIS YAPTIGIMIZA GORE ARTIK KULLANICI BILGILERINI SESSIONA ALABILIRIZ...COOK ONEMLI BU
                // $_SESSION["user_id"]=$row["user_id"];
                // $_SESSION["user_name"]=$row["user_name"];
                User::Login($row);
  //SEssionlarimizi eger bu sayfanin require edildigi herhangi bir sayfada teste edersek session bilgilierimizin geldigini gorebilirz hatta sayfamizi defalarca yenilesek bile sesssion bilgilerini yine de koruyacaktir silmeyecektir ne zamana kadar tarayici kapatilmayana kadar, yani tarayici kapanmadigi surece actimz oturum acik kalacaktir              
                header("Refresh:2,url=".site_url());

            }else{
            $error="Your password doesn't fit, please check your password";
            }
            
        }else{
            $error="There is not any account like that in our system, please register first, you are redirecting register page....";
            header("Refresh:2,url=".site_url("register"));
        }
     
    }
}


require view("login");
?>