<?php 

class User{

    //parametrye $data alsin bu $data session lari alsin
    public static function Login($data){
        $_SESSION["user_id"]=$data["user_id"];
        $_SESSION["user_name"]=$data["user_name"];
    }

    //Bu userExist i hem register isleminde tek paramtre aliyor ise hem de login islmeinde kullanacagiz ondan dolayi email de hata vermesin format kontrolu oldugu icin boyle bir default deger atioruz ki zaten boyle bir email adresi olmadigi icin ve de veya kontrolundde de username i de bulsa sartin saglanmasi icin yeterli olcagi icin bu methodu biz login icin de kullanabilmis oluyoruz
    public static function userExist($username,$email="@@"){
        global $db;
        $query=$db->prepare("SELECT * FROM users where user_name = :username || user_email= :email");
        $query->execute([":username"=>$username, ":email"=>$email]);
        return $query->fetch(PDO::FETCH_ASSOC);//dizi olarak dondursun diye FETCH_ASSOC kullaniyoruz

    }

    public static function addUser($values){
        global $db;
        $query=$db->prepare("INSERT INTO users SET user_name=?,user_url=?,user_email=?,user_password=?");  
        return $query->execute($values);
    }
}

?>