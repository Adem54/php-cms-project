<?php 
$meta=[
    "title"=>"Sign Up"
];

//post methodunda submit var ise demekki bu register formu gonderilmis submit edilmis butona bsailmis demektir
if(post("submit")){
    $username=post("username");
    $email=post("email");
    $password=post("password");
    $password_again=post("password-again");
   
    if(!$username){//empty($username) ayni sey aslinda
        $error="Please write your username";
    }else if(empty($email)){//!$email demek aslinda
        $error="Please write your email";
    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    //eposta nin gecerli formatta olup olmadigni php den inbuild bir method ile kontrol edebiliyoruz... BESTPRACTSIE
        $error="Please write your email, right format";
    }elseif(!$password){
        $error="Please write your password";
    }elseif($password != $password_again){
        $error="Your passwords are not fit eachother";
    }else {//Burda kayit islemlerini yapmaya baslayacagiz
//SIMDI BURDA ILK OLARAK AYNI USERNAME VEYA AYNI EPOST ILE KAYIT VAR MI ONA BAKARIZ VAR ISE AYNI USERNAME VEYA EPOST ADRSI ILE KAYIT YAPMAYIZ VE BIR MESAJ DONERIZ 

//SELECT query with positional placeholders
//$query=$db->prepare("SELECT * FROM users where user_name = ? || user_email= ?");
//$query->execute(["$username,$email]);

//SELECT query with named placeholders
// $query=$db->prepare("SELECT * FROM users where user_name = :username || user_email= :email");
// $query->execute([":username"=>$username, ":email"=>$email]);
// $row=$query->fetch(PDO::FETCH_ASSOC);//dizi olarak dondursun diye FETCH_ASSOC kullaniyoruz
$row=User::userExist($username,$email);
//Eger boyle bir member var ise hata mesaji yazdiracgiz
if($row){
    $error="This username or email is already in use, please try to another one";
}else{
    //Eger $row yok ise demekki boyle bir username veya email de bir uyem, kullanicim yok o zaman artk bu kullaniciyi eklemeliyiz

//VERITABANIMIZA BIZ PASSWORDU HASHLEYEREK KAYDETMEMLIYIZ BUU COOK ONEMLIDR.
$hash=password_hash($password,PASSWORD_DEFAULT);

//Veritabanindaki user_url SEF(SEO-ENGINE-FRIENDLY) demektir, tayfun-erbilen sitesi icinde permalink diye bir coklu dile uygun sef-link yapimi icin bir fonksiyon var o fonksiyonu alip kullanabiliiriz.. permalink fonksiyonunu helper/app.php ye aliyoruz sonra kullanaagiz..Oraya norvecce karakterleri de ekledik
//https://www.erbilen.net/php-sef-link-fonksiyonu/
$url=permalink($username);

//  $query=$db->prepare("INSERT INTO users(user_name,user_email,user_password) VALUES(?,?,?)");  

//   $query=$db->prepare("INSERT INTO users SET user_name=?,user_url=?,user_email=?,user_password=?");  
  $credentials = [$username,$url, $email ,$hash];
//   $result=$query->execute($values);
  $result=User::addUser($credentials);
  if($result){
    $success="Your membership is created successfully, you are redirecting ";
   User::Login([
    "user_id"=>$db->lastInsertId(),
    "user_name"=>$username
   ]);
    //Kullaniciyi 2 saniye sonra siteye yonlendirecegiz 
    header("Refresh:2,url=".site_url());
    //Once successfull mesaji gorecek sonra hemen 2 saniye sonra da kullanicyi ana sayfaya yonlendirecek... 
    //header("Location:site_url()"); direk yonlendir demek
    //header("Refresh:2,url=".site_url());2 saniye sonra bu urle yonlendir demektir   
  }else{
    //Veritabani ile ilgili o anlik bir problem cikma durumunda veya, bizim insert islemindeki yzdimgiz degisken ismlerinde vs bir hata olusursa burya duser,sorgumuzda hata vardir demektir
    $error="An erro occured, please try again, later";
  }
}
    }
}

require view("register");
?>