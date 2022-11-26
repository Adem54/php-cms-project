<?php 

/*
cms isminde bir veritabani olusturuyoruz
unicode olarak  utf8mb4_unicode_ci bunu seceriz 

Dikkat edilecekler
1-Oncelikle projede herzaman index.php yi olusturuyoruz
Burasi herseyi yonettgimz dosya olacaktir
Klasor yapimiza gelince 
app/controller->controller dosyalarimz olacak
app/view -> tema dosyalarimz olacak
app/helper(utils veya tools da diyebiliriz ismine)-> yardimci fonksiyonlar icin kullanacagiz
app/classes-> burda da yardimci siniflar icin kullanacagmz siniflari tutacagiz 
app/init.php->index.php i acildiginda  init.php yi safyamiza cagiracgiz

index.php 
require __DIR__.'/app/init.php';

BESTPRACITSE-1 
1-Oncelikle projede herzaman index.php yi olusturuyoruz
Burasi herseyi yonettgimz dosya olacaktir
cunku burda biz diger tum sayfalari redirect veya navigate islemi yapariz aynii react ta app.jsx icerisinde yaptigmz gibi 
ve de ondan dolayi da yapacagimz tum baslatma islemleri genel islemleri de indexe cagirdigmz zaman o zaman tum diger sayfalar da onlari kullanabileceklerdir..bu onemlidir yoksa gidip her sayfaya ayri ayri ayni dosyalar require edilmez zaten
BESTPRACITSE-2 
BIZ TUM BASLANGIC AYARLARI ILE ILGILI METHOD FONKSIYON VS HEPSINI INIT.PHP DE CALISTIRIRIZ
init.php
init.php mizde ilk once session_start ile oturum baslatacagiz
bunu yapma sebebimz bir kere uyelik sistemi vs olacagiz icin session i baslatmamiz gerekiyor
bunu da init.php de baslatiyoruz, cunku, tum baslatma ayarlari, class yukletme, helper lar gibi
 ayarlarin hepsini burda yapacagiz
 Yani uygulamamiz, init.php den baslayacak ve orda once tum ayarlari yapacak ordan gelecek
 Sonra init.php de loadClass(){ } function imizi olustururup bu fonksiyonu spl_autoload_register('loadClasses'); ile cagiracagiz
 Bu ne is yapacak, siniflarimizi ototmaitk yukletmemizi saglayacak
 Dinamik olarak bizim siniflarimizin include veya require edilmesini sagliyor yoksa her bir class icin gidip ayri aryi include islemi yapmak zorunda kalacagiz.. buu cook onnemldir
BESTPRACTISE-3
BIZ CLASS LARIN HEPSINI AYRI AYRI INCLUDE-REQURE ETMEK YERINE ONLARI SPL_AUTOLOAD_REGISTER ILE DINAMIK BIR SEKILDE
HANGI CLASS KULLANILIR ISE ONUN REQUIRE EDILMESINI SAGLAYABILIRZ...BU HARIKA BESTPRACTISE DIR... BUNU UYGULAMALARIMZDA MUTLAKA KULLANMALIYIZ
ORNEGIN BIZ VERITABANI ICIN, CACHE ICIN, BIR DOSYA OKUMA ISLEMI ICN AYRI AYRI CLASS LAR YAZACAGIMIZ ICIN ONLARI CLASSES ALTINDA CAGIRABILIRIZ VE DE HEPSINI AYRI AYRI TEK TEK CAGIRMAK YERINE BU SEKILDE DINAMIKK BIR SEKILDE CAGRILMASINI SAGLAYABILIRZ
BESTPRACTISE-4 
VERITABANI AYARLARINI CONFIG.PHP DE TUTACAGIZ
CONFIG PHP DE AYARLARIMIZI RETURN ILE DONDURUP BUNU DA BIR INIT ICERISINDE DEGISKENE ATARIZ CUNKU AYARLARI KULLANACAGIZ..
BIZ BU AYARLARI BIR DOSYA ICINDEN DE OKUYARAK DA ALABILIRDIK, YANI DOSYA ICINDE YAZILI TUM VERITABANI AYARLARI GELIR VE BIZ O DOSYAYI OKUYUP PARSE EDIP KENDI ARRAY,STRING VS DEGISKENLERIMIZE AKTARARAK ARTIK O DATALARI HAZIR KULLANACAK HALE GETIRMEMIZ GEREKIR VE SADECE BU ISI YAPAN AYRI BIR CLASS TA OLUTURABILIRIZ
BESTPRACTISE-5 
PROJEMIZIN OLDUGU PATH I YANI ROOT PATHI, ANA PATHI CONSTANT BIR DEGISKEN OLARAK TANIMLARIZ BIR DAHA DEGISTIRILEMESIN DIYE , DEFINE() KULLANARAK VE DE BUNU REALPATH("."); METHODU ILE YAPARIZ.. 
__DIR__ ILE DE CURRENT PATH I ALABILIYORDUK YANI SU AN ICINDE OLDUGMUZ PATHI ALABILIYORUZ
AYRICA BIZ CONSTANT DEGISKENLERI  DEFINE("PATH",REALPATH(".")); SEKLIDNE VE DE CONST PATH=REALPATH(".") SEKLINDE DE OLUSTURURUZ
ANA ROOT PATHIMIZ BIZE PROJELERIMIZ ICINDE COK LAZIM OLUYOR DOLAYISI ILE ONU DA YINE CONFIG.PHP ICINE YERLESTIRIRIZ , MUHTEMELEN BIZ CONFIG.PHP YI DE INIT.PHP ICERISINDE KULLANARAK, DEFINE ILE TANIMLANAN PATH CONSTANT DEGISKENININ HER YERDEN ERISILMESINI SAGLAMAK ICIN
BESTPRACTISE-6 
Simdi config.php dosyasinda bir dizi degerini direk return yaparak bir data yazdik 
config.php

return [
 "db"=>[
    "name"=>"cms",
    "host"=>"localhost",
    "user"=>"root",
    "pass"=>""
 ]
];
ayni zamanda da bir constant degisken tanimliyoruz config.php icinde
define("PATH", realpath("."));
Peki nasil oluyor da biz config.php de direk return ettgimz bir diziiyi diger sayfaflarda kullaniyoruz, bu bizim ilk defa gordugmuz bir durum..cok onemli anlamamiz bu yuzden  
init.php sayfasina gelip 
$config=require(__DIR__."/config.php");
bu sekilde require ile config.php yi buraya dahil edip ve de onu bir degiskene aktaracak olursak artik biz, $config ile return ettimgiz diziye erisebilirken ayni zaman da da config.php icinde tanimlanan  constant PATH degsikenine erisebiliriz.. 

$config=require(__DIR__."/config.php");

print_r($config);

db: {
name: "cms",
host: "localhost",
user: "root",
pass: ""
}

BESTPRACTISE-7
config.php yi biz init.php icinde require ettik ve config.php miz database bilgilerinin oldugu dosyamizdi bir dedgimz gibi database ile ilgili baslangic islemlerini de init.php de yapacgiz 

database baglantisini burda yapacagimz icin hicbirzaman unutmamaliyiz ne yapacagiz try-catch yapisi ile ele alacagiz tabi ki... 

init.php icerisinde

$dbname=$config["db"]["name"];
$host=$config["db"]["host"];
$user=$config["db"]["user"];
$psw=$config["db"]["pass"];

try {
    $db=new PDO("mysql:host=".$host.";dbname=".$dbname,$user,$psw);
} catch (PDOException $e) {
  die($e->getMessage());
}

BESTPRACTISE-8
VERITABANI BAGLANTISI YAPARKEN, HATA DURUMUNDA MESAJI YAZDIRIRKEN DIE() ILE YAZDIRARAK ONDAKI SONRAKI KODLARIN CALISMAMASINI VE ORDA UYGULAMANIN DURMASINI AMA KULLANICI DOSTU ANLASILIR BIR MESAJ VEREREK, DOGRUDAN HEDEFE YONELIK MESAJ VEREREK HATA DURUMUNU YONETMEK ISETERIZ ISTE BUNU TRY-CATCH BLOGU ICERISINDE CATCH ICERISINDE DIE() METHODU ILE YAPARIZ

try {
    $db=new PDO("mysql:host=".$host.";dbname=".$dbname,$user,$psw);
}
 catch (PDOException $e) {
  die($e->getMessage());
}

BESTPRACTISE-9
COK PRATIK BIR SEKIDLE KLASOR ICINDEKI TUM DOSYALARIMIZI PROJEMIZE DAHIL ETMEK 
HELPER ICERISINDE KULLANACAGIMZ TUM PHP DOSYALARINI DA YINE INIT.PHP YE REQUIRE EDECEGIZ.. INIT.PHP BIZIM INDEX.PHP DE CALSITIRILMAK UZERE NE KADAR YAPIMIZI DIZINMIZI KLASORUMUZ VAR ISE BUNLARIN HEPSINI INITE DAHIL EDECEGIZ VE INITI DE INDEX.PHP YE DAHIL EDINCE DOGAL OLARAK HEPSINI INDEX.PHP DE KULLANABILMIS YANI ASLINDA TUM UYGULAMADA KULLANABILMIS HEM DE INDEX.PHP YI COK TEMIZ TUTABILMIS OLACAGIZ... ASIL ONEMLI OLAN NOKTA DA BU ASLINDA ... 

$helper_php_files=glob(__DIR__."/helper/*.php");

foreach ($helper_php_files as $helper_file) {
//    echo $helper_file."<br>";
//     $helper_file ile bize helper klasoru icindeki php dosyalarinin dosya path lerini verecek
//     C:\Users\ae_netsense.no\utv\test\php-cms-project\cms\app/helper/test1.php
//     C:\Users\ae_netsense.no\utv\test\php-cms-project\cms\app/helper/test2.php
    require($helper_file);
}
BOYLELIKLE HELPER KLASORUM ICINDEKI TUM PHP DOSYALARIMI DA PROJEMIZE DAHIL EDEREK INDEX.PHP ICINDE YANI TUM DOSYALARIM ICIND E PROJEM ICINDE ISTEDFIGMIZ GIBI KULLANABILMIS OLACAGIZ

BESTPRACTISE-10 
LINK YAPILARI ICIN BIR DE .HTACCESS OLUSTURACGIZ

RewriteEngine On
RewriteEngine On burda baslatiyoruz kullanacagimzi soyluyoruz 
RewriteRule ^([a-zA-Z0-9-_/]+)$ index.php[QSA]
Bir kural belirliyoruz, index.php de ne olursa olsun QUERYSTRINGAPPENDE[QSA]
QUERYSTRINGAPPEND DEMEK localhost/cms/test?a=b  url imizin test?a=b kismi querystring append
anlamina geliyor iste, .htaccess in dosyamizda get degerlerini kabul
 etmesi icin ayarlarina [QSA] querystringappendi koyamamiz gerekiyor
 Regular expression da 
 ^ dizenin baslangicini gosterir				
 /^Merhaba/g				
$ dizenin sonunu gosterir	
RewriteRule ^([a-zA-Z0-9-_/]+)$ index.php[QSA]
^([a-zA-Z0-9-_/]+)$ index.php
index.php ye ne gelirse gelsin biz su sekilde kabul edecegiz
a-z ye kadar ve A dan Z ye kadar ayni zamnda 0 ile 9 arasinda, -,_/ olabilir ve + koyarak 1 ve daha fazla olabilir diyoruz 
yani regex deseni kurallari disinda gelen karakterler ile link girince sayfayi gosteremeycek kurallara uymadigi icin
^([a-zA-Z0-9-_/]+)$ bu bir regex desenidr parantez icindeki degerler ile baslasin ve yine o degerlerle bitsin anlamina gelyor
Artik index.php ye link olarak url e ne gelirse gelsin link yapimiz bozulmayacak artik 
regex 	
“.“
Sayfa ya da paragraf sonu dışındaki herhangi bir karakteri temsil eder. Örnek olarak “k.re” ifadesi “küre”, “kare”, “kore”, “kere” ile eşlenecektir.
“$“
Eşlendiği ifadenin sonunu belirtir. Boşluklar ve paragraf başındaki özel nesneler dikkate alınmaz. Örneğin paragraf sonundaki iner$ ifadesini belirlemek bu şekilde mümkün olacaktır. Bu şekilde paragraf sonlarını bulup değiştirmek mümkün olmaktadır.
iner$
Adem iner cikar iner naber iner nasil gidiyor isler adem iner
bir tek en son kelime olan iner i alacaktir, iner eger en son kelime olmasa idi almayacakti

“^“
$ ifadesine ters olarak, eğer terim sadece paragraf başında ise aranılan ifadeyi bulur. Örnek olarak ^Sabahleyin ifadesi “Sabah, Sabahleyin…” gibi ifadelere sınır belirtilmemişse eşleşmeye devam eder.
^Adem
Adem iner Adem  cikar Adem iner Adem naber iner nasil gidiyor isler adem
Burda da sadece en bastaki Ademi alacaktir digerlerini almayacaktir, eger Adem i en basta kullanmasa idik o zaman da hicbirsey almayacakti

BESTPRACTISE-11-MANTIK HARIKA..  
HARIKA BESTPRACTISE
Biz $_SERVER I EKRANA BASTIGIMZ ZAMAN BIR DIZI GELIYOR VE DIZI KEY LERI ICCERISINDE REQUEST_URI ISMINDE BIR KEY BULUNUYOR 
REQUEST_URI: "/test/php-cms-project/cms/adem/test1",
BU SEKILDE VE BURASI PROJEMIZIN EN BASTA YAPGIMIZ CMS KLASOR YOLU ILE BASLIYOR ve bizim adem/test1 olarka yazdigimz link yapisini aliyor 
Simdi onemli olan bizim cms den sonra gelen, ornegin adem/test1 link yapimzii nasil alacagiz birde seo-dostu olmasi acisindan da biz ana klasoru gostermesek daha iyi oolur yani cms klasoru link te gozukmemesi daha iyi olacaktir onun icin de soyle bir sey ya
config.php icerisine 
define("SUBFOLDER",true);
bir constant SUBFOLDER degeri belirleyecegiz ve 
eger subfolder imiz true ise yani cms/ den sonra baska dosyalar gelirse yani ana dosya cms/index.php gostermiyor da altinda subfolder da var ise o zaman cms yi kaldir yok sadece cms/index.php gosterip subfolder imiz yok ise o zaman cms yi kaldirma diyecegiz 
O zaman biz ne ile ugrasacagiz yani bizim linkimizi dinamik olarak alacak olursak, dikkat edelim biz bu islemleri hep dinamik yapmamiz gerekiyor dolayisi ile linkimizi dinamik olarak yani biz hangi linke gidiyorsak bize o linki verecek olan, bir degsikenden veya methoddan alacagiz o da zaten  ne idi $_SERVER["REQUEST_URI"] IDI
BU BIZE NE VERIYORDU
REQUEST_URI: "/test/php-cms-project/cms/adem/test1",
string veriyor ve biz bu stringi parcalamak istiyoruz dikkat edelim.. 
o zaman biz bu stringi / slash leri baz alarak explode ile dizi haline getiririz slahs larla bolerek 

SIMDI SURAYI DOGRU ANLAYALIM..BIZIM BU ISLEMI YAPMA AMACIMIZ SU KI, BIZIM ANA REQUEST URL IMIZ BUDUR BURDAN CMS VE ONDAN SONRA KULLANICININ TIKLAMASI ILE BIZIM UYGULAMAMIZDA OLUSTURACAGIMIZ LINK-URL SISTEMINI DINAMIK SEKILDE YONETMEK .... HARIKA BESTPRACTISE COOK IYI BIR SEKILDE ANLAMAMIZ GEREKIYOR  
http://localhost/test/php-cms-project/cms


BESTPRACTISE-12
COK HARIKA BESTPRACTISE... 
$route=explode("/",$_SERVER["REQUEST_URI"]);
print_r($route);

{
0: "",
1: "test",
2: "php-cms-project",
3: "cms",
4: "adem",
5: "_test1"
},


BESTPRACTISE-13
BIR BESTPRACTISE DAHA.. DIZIMIZ ICERISINDE BOS BIR ALAN GELDI, 0.INDEX BOS GELDI BUNU NASIL ENGELLERIZ.. 
TABI KI ARRAYIMZI FILTEREDEN GECIRIP EGER GELEN DEGER BOS ISE ONU GONDERME DIYEREK 
$route=array_filter(explode("/",$_SERVER["REQUEST_URI"]),function($value){
    return $value!="";
});
print_r($route);
{
1: "test",
2: "php-cms-project",
3: "cms",
4: "adem",
5: "_test1"
},

BESTPRACTISE-14
BU SEKILDE BOS OLAN VALUE NIN GELMESINI ENGELLEMIS OLDUK AMA BIR PROBLEMIMIZ DAHA VAR NEDIR BU SEFERDE DATALAR GELDI AMA 0.INDEX OLAN BOSLUGU SILDI DIGERLERI DE BIZ BOS VALUE YI SILMEDEN ONCE HANGI INDEX ISE YINE O INDEX LER ILE GELDIER BU SEKILDE KULLANAMAYIZ NORMAL 0 DAN BASLAYARAK 0-1-2... SEKLINDE GIDEREK GELMESINI ISTIYORUZ BUNU NASIL  YAPACAGIZ PEKI.. 
BIR HARIKA BESTPRACTISE DAHA COK IHTIYACIMIZ OLACAK 
yaptgimiz filtreleme islemini array_values icerisinde yaptigmiz zaman bu sorunumuzu da halletmis olacagiz 

ARRAY_VALUES ILE INDEXLERI DUZENE SOKMAK
$route=array_values(array_filter(explode("/",$_SERVER["REQUEST_URI"]),function($value){
    return $value!="";
}));
print_r($route);

{
0: "test",
1: "php-cms-project",
2: "cms",
3: "adem",
4: "_test1"
},


BESTPRACTISE-15
YUKARDA YAPTIKLARIMIZ COK PRATIK ISLEMLER AMA BIZIM LINKIMIZIN
COK DAHA EKSTRA UZUN OLDUGU ICIN VE BIZ EGER SUBMENU VAR ISE O ZAMAN CMS DEN SONRAKILERI GOSTERMESINI YOK SUBEMNU YOK ISE DE O ZAMAN DA SADECE CMS YI GOSTERMESINI ISTYORUZ

$route=explode("/",$_SERVER["REQUEST_URI"]);
print_r($route);
{
0: "test",
1: "php-cms-project",
2: "cms",
3: "adem",
4: "test1"
},

    SUBMENU TRUE ISE
    while(true){
            if(isset($route[0]) && in_array("cms",$route)){
                array_shift($route);  
            }else {
                break;
            }
    }
    print_r($route);
    {
    0: "adem",
    1: "test1"
    }


SUBMENU FALSE ISE

while(true){
        if(isset($route[0]) && in_array("cms",$route)){
            if($route[0]=="cms"):break;
            else: array_shift($route);  
        endif;
            
        }else {
            break;
        }
  }
print_r($route);

{
0: "cms",
1: "adem",
2: "test1"
},
http://localhost/test/php-cms-project/cms/adem/test1



SUBMENU=TRUE YAPTIGMZ ICIN 
  {
    0: "adem",
    1: "test1"
    }
   

    BU SEKILDE BIR URL GIRILIR ISE EGER
    http://localhost/test/php-cms-project/cms
    
    print_r($route);
    {
    0: ""
    },


   BU SEKILDE GELECEK VE 0.INDEX TEKI DEGERLER HER ZAMAN CONTROLLER KLASORUMUZ ICNDEKI DOSYAYI TEMSIL EDECEK YANI BOYLE BIR DURUMDA CONTROLLER DOSYASI ICERISINDE adem diye bir dosya arayacak
CONTROLLER ICERISINDE 0.elementteki value her ne ise 
controller/adem.php yi arayacak

http://localhost/test/php-cms-project/cms

print_r($route);
{
0: ""
},

BESTPRACTISE-16
DEFAULT OLARAK UZANTIDA  BASKA BIR DOSYA YOKSA OTOMATIK OLARAK INDEX.PHP YI CALISTIRMASINI SAGLAMAK..BESTPRACTISE..
if(!isset($route[0]) || empty($route[0]) ):$route[0]="index";
endif;

print_r($route);
{
0: "index"
},
O zaman bu artik ilk etapta controller altinda index.php yi arayacak 
controller altina 1 tane index.php dosyasi olusturduk

http://localhost/test/php-cms-project/cms/abc
boyle birsey yazarsak da tabi ki bos olmadigi icinde abc yi donecek

{
0: "abc"
},

BESTPRACTISE-17
Eger kullanici olmayan bir controller klasorunu acmaya calisiyorlar ise veya controller altinda hic olmayan bir dosyayi acmaya calisiyor lar ise o zaman 404 e esitleyelim
if we don't have index.php under controller folder
if(!file_exists(__DIR__."/app/controller/".strtolower($route[0]).".php")){
    $route[0]="404";
}
Tabi kontroller altinda 404.php yi de olusturup
controller bulunamadi mesaji verelim

Ve artik 
http://localhost/test/php-cms-project/cms/ab

{
0: "404"
}
neden boyle verdi cunu ab.php isminde bir dosyam yokki 
ama ornegin bir controller altinda test.php olsuturp onu acmaya calisirsak

http://localhost/test/php-cms-project/cms/test

if(!file_exists(__DIR__."/app/controller/".strtolower($route[0]).".php")){
    $route[0]="404";
}
test.php yi bulabilecegi icin, 

{
0: "test"
},

Son olarak artik tum controllerida yaptitan sonra controller altinda yazilacak olan dosyamizi dinamik bir sekilde hangi dosya acilacaksa url de o dosyanin require edilmesni dinamik olarak sagalyabilirz

if(!isset($route[0]) || empty($route[0]) ):$route[0]="index";
endif;


if we don't have index.php under controller folder
if(!file_exists(__DIR__."/app/controller/".strtolower($route[0]).".php")){

   
     $route[0]="404";
}
BESTPRACTISE-17
Controller folder is ready to be required
require (__DIR__."/app/controller/".strtolower($route[0]).".php");

ARTIK 
http://localhost/test/php-cms-project/cms/test
controller test
controller.php altindaki test.php geliyor
http://localhost/test/php-cms-project/cms/
index controller
controller altindaki index.php  geliyor
http://localhost/test/php-cms-project/cms/abc
Controller Not Found
abc.php bulamadigi icnde 404.php yi calistiracak 


BESTPRACTISE-17
PHP UZANTILI DOSYALARIMIZI KULLANICININ GIRECEGI LINKE GORE  YAZACAGMIZ ZAMAN KULLANICIIDAN BUNLARIN BUYUK HARFLE GELME IHTIMALINI HER ZAMAN DUSUNERKEK LOWERCASE KULLANARAK KUCUK HARFE CEVIRMELIYIZ

if(!file_exists(__DIR__."/app/controller/".strtolower($route[0]).".php"


&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
MUTHIS HARIKA BIR SISTEM KESINLIKLE COK IYI OGRENIP UYGULAMALIYIZ KENDI PROJELERIMIZDE------

URL E GIRILEN LINKE GORE BIZ PROJEMIZ IN ALTINDAKI KLAASORLER ALTINDA HANGI DOSYALARIMIZIN CALISACAGI ILE ILGILI HARIKA BIR BESTPRACTISI DIR HEPSINI BIR ARADA YAZIYORUZ SON DURUMDA BIR BUTUN OLARAK INCELEYELIM BIRDE 

NEYI SAGLADIK
BIZ ANA BIR KLASORUMUZ OLSUN ONUN ALTINDA CALISSIN CALISACAK TUM DOSYALAR ISTIYORUZ AMA AYNI ZAMANDA PROJE TARAFINDA TABI KI DOSYALARI AYIRMAK ISTIYORUZ CONTROLLER KLSORU ALTINDA ORNEGIN CALISACAK DOSYALAR OLACAK BASKA KLASORLER ALTNDA CALISACAK DOSYALAR OLACAK PEKI BU ISLEMI NASIL YONETECEGIZ BU SEKILDE .. 

YANI BENIM
C:\Users\ae_netsense.no\utv\test\php-cms-project\cms\app\controller/inde.php dosyam calisiyor ancak... 
url linki olarak dikkat edelim, controller vs hicbirsey yok 
http://localhost/test/php-cms-project/cms/
AYRICA SUNA DIKKAT EDELIM BIZ EGER INDEX.PHP ICINDE ORNEGIN 
require("app/controller/index.php");
require("app/controller/test.php");
require("app/controller/404.php");
CAGIRDIGMZ ZAMAN HEPSINI BIRDEN CALISTIRACAK AMA BIZ ONU ISTEMIYORUZ URL LINKINDE KULLANCI HANGI SAYFA ILE GELIRSE SADECE ONU CAGIRSIN YANI BU ISLEMI DINAMIK YAPAILIM BIZ ISIYORUZ 

BESTPRACTISE-18
AYRICA DIKKKAT ETMEMIZ GEREKEN BIR BESTPRACTISE DAHA 
ANCAK BUNU DINAMIK YAZARKEN EGER EN DOSYAYI BIR DINAMIK OLARAK HAZIRLADIGMIZ BIR DIZIMIDEN ALACAK OLURSAK																	
															
require ("/app/controller/".strtolower($route[0]).".php");																	
Warning: require(/app/controller/index.php): Failed to open stream: No such file or directory in C:\Users\ae_netsense.no\utv\test\php-cms-project\cms\index.php on line 39																	
BU SEKILDE HATA ALACAGIZ ONDAN DOLAYI KASRISTIRMAYALIM....DINAMIK OLARAK YAZDIGMIZ ICIN ONU BULMASI ICIN CURRENT DIRECTORYDEN ITIBAREN ALMAMIZ GEREKIYOR ASAGIDAKI GIBI 																	
require (__DIR__."/app/controller/".strtolower($route[0]).".php");																	
																	


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


if(!isset($route[0]) || empty($route[0]) ):$route[0]="index";
endif;


if we don't have index.php under controller folder
if(!file_exists(__DIR__."/app/controller/".strtolower($route[0]).".php")){
     $route[0]="404";
}

Controller folder is ready to be required
require (__DIR__."/app/controller/".strtolower($route[0]).".php");

print_r($route);
&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

BESTPRACTISE-19
BIZ CONTROLLER ICIN YAPTGIMIZ ISLEMLERIN AYNISINI VIEW ICINDE YAPACAGIZ DOLAYISI ILE BUNLARLA ILIGLI ISLEMLERI GELIP INDEX.PHP DE UZUN UZUN YAZMAK YERINE BIZ INDEX.PHP DE CONTROLLER DA CALISACAK OLAN DOSYALARIMZI DINAMIK OLARAK AYARLARKEN KULLANDIGMZ ISLEMLER ICIN HELPER DA FONKSIYON OLUSTURALIM

helper/app.php de fonksyon yazarak 

function controller($controllerName){
    $controllerName=strtolower($controllerName);
   PATH config.php icinde constant olarak root path i proje pathini veriyordu
   PATH="http://localhost/test/php-cms-project/cms/"; 
   return PATH."/app/controller/".$controllerName.".php";
}

index.php de artik 

if(!file_exists(__DIR__."/app/controller/".strtolower($route[0]).".php")){
     $route[0]="404";
}

yerine 

if(!file_exists(controller($route[0]))){
     $route[0]="404";
}

require (__DIR__."/app/controller/".strtolower($route[0]).".php");
yerine de asagidakini yazabiliriz
require (controller($route[0]));

BESTPRACTISE-20 
Bir fonksiyon daki parametre yi biz fonksiyon icerisinde bir takim degiskliklere maruz birakip, ve yine o degisklkikleri almasi icin o parametrenin kendisine o degisiklikleri assign edebiliriz ... 

function view($viewName){
    $viewName=strtolower($viewName);
    return PATH."/app/view/".$viewName.".php";
}

BESTPRACTISE-21
OTOMATIK REQUIRE ETME ISLEMI DINAMIK  
Ve artik view i istedgimiz her yerde direk require karsisinda fonksiyonu invoke ederek kullanabliirz

function view($viewName){
    $viewName=strtolower($viewName);
    return PATH."/app/view/".$viewName.".php";
}

ornegin controller altinda  view i artik otomatik bir sekilde require edebiliriz 
view klasoru altina index.php olusturruz 

require view("index");

OLAYIN MANTIGINI VE NE YAPILDIGININ COK IYI ANLAMALIYIZI COOK ONEMLI
BESTPRACTISE-22
Simdi cok enteresan bir yapi kurduk yani biz veiw icindeki php kodumuzu calistiriyoruz controller da link yapsini kurduk ve controller daki ornegini index.php icine gelip view daki index.php yi require ederek aslinda controller uzerinden kurudgumuz siste icinde son kullaniciya view i gostermis oluyoruz ama bu islemi yapan controller sistemi ve controller iceriisinde view i require ederek kullaniciya ulastiiriyoruz harika bir sistem kurmus olyoruz dinamik bir sekilde

BESTPRACTISE-23 
init.php de 

session_start();
ob_start();

session baslatmistik onun hemen altinda 
ob_start() i da baslatiyoruz yani output buffering i de baslatiyoruz
yonlendirmelerde de sknti olmamasi icn, ve html ciktimizi farkli yerlerde de kullanabilmek icin

ob_start neden kullaniriz?
sayfalarda header işlemleri ob_start(); olmazsa yönlendirmeler çalışmıyor
ob_start ile içeriğin görüntülenmeye hazır olana kadar sunucu tarafında arabellekte tutmasını sağlıyor
ayrıca ifade ile çıkacak olan her şeyi hatırlamaya başla ve henüz bir şey yapma diyerek düşünebilirsin

ob = output buffering = çıktı tamponlama diyebiliriz.

Örneğin yorum gönderme işlemini ajax ile yaptığını düşünelim. Ve listelenen yorumlarıda bir php dosyasında tutuyorsun. Ve ajax ile yorum gönderdiğinde bu yorum sayfasını kullanmak istiyorsun.
Fakat require ya da include kullanırsan direk çıktıyı bastıracaktır. Bu durumda ob kullanarak çıktıyı sonradan yazdırmak üzere saklayabilirsin

ob_start();
require 'view/comment.php';
$output = ob_get_clean();

echo $output;

CONTROLLER/ADMIN.PHP OLUTURULMASI
Simdi ise adminin view ve controller kismini ayirmak isityoruz ondan dolayi da controller klasoru altinda admin isminde bir php dosyasi  olustururuz
controller/admin.php olusturduk ve artik 
http://localhost/test/php-cms-project/cms/admin
bu sekiilde admin.php in icerigi gosteriliyor

Simdi tekrar helper a gideriz ve orda bir de 

function route($index){
    BESTPRACTISE-24-GLOBAL ILE FONKSIYON DISINDAKI DEGISKENI FONKSIYON ICINDE KULLANABILMEK 
    $route disarda tanimlandi index.php de helper icindeki tum php dosyalarini require ile index.php ye dahil etttgimgz icin $route un tanimlandigi yer ile ayni sayfadayiz aslinda ondan dolayi da fonksiyon iicindeki scopumuzda kullanabilmek icin bu sekilde global $route haline getiririz
    global $route;
     return isset($route[$index]) ? $route[$index] : false; 
   // return $route[$index] ?? false;
   
}

     BESTPRACTISE-25 
      return isset($route[$index]) ? $route[$index] : false;
      bu thernary ile yapilan islemin aynisini asagidaki gibi yapabiliriz artik
     return $route[$index] ?? false; 

     BESTPRACTISE-26 

     helper icindeki app.php de 

     function route($index){
    global $route;
     return isset($route[$index]) ? $route[$index] : false;}

     Neden kulllandik
     Bu fonksiyon ne is yapiyor bu fonksiyon 
     $route yani bizim linklerimizi barindiran bir dizi idi 

     http://localhost/test/php-cms-project/cms/admin/test

     print_r($route);

     {
        0: "admin",
        1: "test"
     },

    http://localhost/test/php-cms-project/cms/
     {
        0: "index"
        }
 seklinde veriyordu bize $route dizimiz

 function route($index){
    global $route;
     return isset($route[$index]) ? $route[$index] : false;}
    
   burda yapilan ise bakacak olursak eger $route[$key] bir key verilirse icindeki keyi isset ile sorgulayip eger  key var ise onu calistiriyor yok oyle bir key $route dizisinde yok ise o zamanda, false donuyor, biz bunu nerde calisitiyorduk , require islemleri yaparken dolayi si ile onu kullandigmiz yerlerde simdi daha pratik kullanacagiz
   
   index.php ye geliriz ana index.php ye 

require (controller($route[0]));
asagidaki gibi degistirebiliriz
require (controller(route(0)));
if(!isset($route[0]) || empty($route[0]) ):$route[0]="index";
endif;
asagidaki gibi degistirebilirz
if(!$route(0) || empty($route(0)) ):$route[0]="index";
endif;
Yani isset($route[0] bu sekilde check edilen, ama check edilen if parantezleri icinde kullanilan, her yerde biz artik route()fonksiyonunu invoke ederek kullanabiliriz 

eger url de http://localhost/test/php-cms-project/cms/admin bunu ararsak ve 
controller klasoru altindaki admin.php de  
route(0) dersek bize 
admin  basar ekranimiza
cunku niye $route umuz {0=>"admin"}

http://localhost/test/php-cms-project/cms/admin/members

print_r($route);

{
    0: "admin",
    1: "members"
},

echo route(1);//members

http://localhost/test/php-cms-project/cms/admin
 {0=>"admin"}
echo route(1);
Bos gelecektir 
Yani,admin url de calistirilmaya calisiliyor ve biz 
http://localhost/test/php-cms-project/cms/admin url de girildigi zaman index.php gelmesini istiyorsak o zaman soyle bir logic yazariz 

  BESTPRACTISE-27
  COK ONEMLI URL DE CMS DEN SONRA SADECE ADMIN.PHP CAGRILDIGINDA SONUNA INDEX EKLETMEK....  
BESTPRACTISE-ADMIN.PHP ICINDE EGER ADMIN LINKINE GELINMISSE VE ADMINDEN SONRA BASKA BIRSEY YOK ISE(BUNU DA ROUTE(1) NULL GELIR ORDAN ANLARIZ) O ZAMAN ADMIN ALTINA INDEX GETIR DIYORUZ 

Burasi admin.php ve admin url de link olarak geldiginde ki burasi her zaman icin, cms den sonra gelecek url de ve 0.index admin olacak controller altinda oldugu icin o kesin o zaman biz de diyoruz ki buraya geldi ise eger link araciligi ile bu da su demektir o zaman link kesinlikle http://localhost/test/php-cms-project/cms/admin boyledir ve bizde eger lik boyle ise o zaman admin altinda bir index gozuksun diyecegiz

if(!route(1)){
    $route[1]="index";
}
echo route(1);//index olark geldi ekran simdi
print_r($route);
/*
{
0: "admin",
1: "index"
},


Ayrica birde ana root klasorumuz olan cms altinda bir de admin klasoru ve o admin klasoru altina da 1 tane  controller 1 tane de view klasoru olusturacgiz
ve de cms/admin/controller altinda index.php olusturuz ve icerisinde de admin index controller i echo ile yazdiririz
Bu sekilde adminimizi diger taraftan ayrimis olacagiz cunku

helper klasoru altinda bir de admin icin helper olusturacagiz
Yani biz helper altinda bir app klasoru icin app.php tutuyrouz bir de admin klasoru icin admin.php tutacagiz

ve de helper altindaki app.php de yaptgimz controller ve view helper fonksiyonlarinin admin olan icinini yazacagiz burda da

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

ardindan artik biz app altindaki controller altina gelip cunku dikkat edelim biz herseyi burda calistiracagiz yani baska bir sayfadaki dosya da olsa buraya cagiriip calistiracagiz 

cms/app/controller/admin.php 

BESPRACTISE-28 NEDEN ROUTE(1) 1. INDEX I KONTROL EDILIP TE EGER 1. IDNEX I BOS ISE O ZAMAN, ORAYA IDNEX ATA DENIYOR... 
 NEDEN BU ISLEM CMS/APP/CONTROLLER/ADMIN.PHP ICNDE YAPILIYOR 

if(!route(1)){
    $route[1]="index";
}

bu islemde burda  yapiliyor cunku, biz ancak admin.php son sayfa olarak  gelindigini ancak admin sayfasi icinde anlayabiliriz bu da bestpractise dolayisi ile ege

BESTPRACTISE-29 
MANTIGI ANLAMAK COOK ONEMLI... 
BIZ NEDEN cms/app/controller/admin.php  BURDAKI ADMIN ALTINDA 
NETICE ITIBARI ILE
--Bunlari yapiyoruz---
if(!route(1)){
    $route[1]="index";
}


require(admin_controller(route(1)));
--Bunlari yapiyoruz---

 BU ADRES YOLUNU CAGIRMIS OLUYORUZ CUNKU BIZ,
 CMS/APP/CONTROLLER/ADMIN.PHP altinda cms den sonra 0.index direk controller altinda var olan herhangi bir php sayfasi cagirildigi zaman o sayfa ekrana basiliyordu ki burda biz senaryo olarak 
 url e 
 http://localhost/test/php-cms-project/cms/admin/
 bu sekilde gelindigi senaryoda  bu admin.php altinda gelip, tamamen ayirdigmiz cms/admin/controller/index.php nin calismasini sagliyoruz, cunku biz tum link islemlerini 
cms/app/controller/admin.php  burda yapacak sekilde ayarladik..
require(admin_controller(route(1)));

function admin_controller($controllerName){
    $controllerName=strtolower($controllerName);
return PATH."/admin/controller/".$controllerName.".php";
--------
function route($index){//burdan index donecek
    global $route;
route(1) ise eger admin den baska bir admin/ bir sey var sa onu getirir ama yoksa index getirecek 
$index parametre yani 1 i temsil ediyor
return isset($route[$index]) ? $route[$index] : false;

Sonuc itibari ile 
http://localhost/test/php-cms-project/cms/admin/ boyle bir url ile gelindiginde asagidaki yol require edilmis olacak
return PATH."/admin/controller/".$controllerName.".php";
require return PATH."/admin/controller/index.php";

BESTPRACTISE-30  

ANLAMAK COK ONEMLI BURALARI COK TEMIZ VE DINAMIK BIR ISLEM YAPMAMIZ SAGLANMIS OLUYOR
cms/admin/controller/index.php icerisinde
--Burayi require ediyoruz----
require(admin_view("index"));
--Burayi require ediyoruz----

http://localhost/test/php-cms-project/cms/ bu uzantida view icindeki index.php calisacak. Bizim url de herhangi bir adres cagirildiginda bu controller cms/app/controller klasoru altinda calisacak sekilde ayarlandi ama biz admin imizi ana cms altinda ayri ttutuk ve orda root altindaki admin klasoru altindaki view icindeki index.php burda calissin istedik ondan da dolayi iste  bu sekilde burda admin_view("index")  methodunu require karsisinda invoke ederek
kullanici url olarak adres cubuguna 
http://localhost/test/php-cms-project/cms/  ile geldigi zaman
asagidaki yolu cagirimis oluyoruz esasinda
require C:\Users\ae_netsense.no\utv\test\php-cms-project\cms/admin/view/index.php;
Burasi view klasoru altindaki index.php nin calisma yeri
cms/app/controller/index.php burdas view calisacak dostum yani view altindaki index.php calisacak
require view("index");

BESTPRACTISE-31 
BIR PROBLEMIMIZ DAHA VAR KULLANICI
http://localhost/test/php-cms-project/cms/admin/members
BOYLE BIR URL ILE GELIRSE HATA ALIYORUZ CUNKU $route[1] geldigi zaman hangi sayfa calisacak herhangi bir kontrol yapmadik 
cms/app/controller/admin.php de neden admin de yapiyoruz cunku kullanici 
http://localhost/test/php-cms-project/cms/admin/members
boyle bir url ile adresimize gelecegini varsayiyoruz ve bu durumda da bizim kullaniciyi farki bir sekilde  yonlendirme planimiz var ve bu plani burda uygulayacagiz
o zaman onu da yapalim 

cms/app/controller/admin.php de 

--bunu  yaptik---

if(!file_exists(admin_controller(route(1)))){
    $route[1]="index";
}
--bunu yaptik---

http://localhost/test/php-cms-project/cms/admin/members
members.php nin varligi kontrol ediliyor burda varsa var olan dosya calistirilacak zaten yoksa da $route[1]="index" olsun diyecegiz, burda 404 sayfasi yapmamiza gerek yok yani ne yaptik dikkkat edelim, admin sayfasi oldugu icin burayi tedarikciler kullanacak ve burda eger kullanici 
Yani ager cms/admin/controller/members isminde bir dosya var ise o calistirilacak o gosterilecek ama yok ise 
cms/admin/controller/index.php yi calistiracak..dosya olarak 
http://localhost/test/php-cms-project/cms/admin/members boyle bir url ile gelse bile biz ona diyoruz ki sen ordan members i sil yerine index koy o yine
http://localhost/test/php-cms-project/cms/admin
buraya gitsin diye ve o her turlu admin sayfasina gelmis olacak

HARIKA BESTPRACTISE ILE MUTHIS BIR COZUM URETMIS OLUYORUZ DIKKAT EDELIM.. 
EGER BURDAKI DINAMIK LINK MANTIGINI ANLAMAK ISTIYOR ISEK O ZAMAN OZELLIKLE ASAGIDAKI DOSYALARI OZELLIKLE IYI INCELEYELIM... 

CMS/INDEX.PHP 
CMS/APP/CONTROLLER/ADMIN.PHP 
CMS/APP/CONTROLLER/INDEX.PHP 
CMS/APP/HELPER/APP.PHP 
CMS/APP/HELPER/ADMIN.PHP 

BESTPRACTISE-32
BU ISLEM DE DIKKAT EDELIM BIR DOSYA VARLIGI SORGULANIYOR VE BU ISLEM DE FILE_EXISTS ILE YAPILIYOR BU TARZ SORGULAMALARI BU SEKILDE FILE_EXIST GIBI DINAMIK SEKILDE SORGULAYABILMEK COOK ONEMLIDIR... 
if(!file_exists(admin_controller(route(1)))){
    $route[1]="index";
}

BIZ SU ANA KADAR CONTROLLER VE VIEWIMIZI CMS/ADMIN/CONTROLLER VE 
CMS/ADMIN/VIEW I ADMIN ICIN OZEL OLARAK AYIRMIS OLDUK YANI BURDAKI VIEW ADMIN E AIT TEMANIN VIEW I OLACAK 

DIGER CMS/APP/VIEW ALTINDA ISE DIREK SON KULLANICININ GORECEGI TEMAMIZ OLACAK

BESTPRACTISE-33 -COOK ONEMLI
$_SERVER altinda dinamiklestirmek icin kullanacagimz o kadar cok arguman var ki biz $_SERVER I RESMEN EZBERE BILMELIYIZ VE ORDAKI DEGERLERI ALIP SABITLERI TUTTUGUMUZ CONFIG.PHP YE DEFINE ILE VEYA CONST ILE ALARAK, DINAMIKLESTIRME FONKSIHYONLARIMIZ ICINDE NERDE IHTIYACIMZ VAR ISE ORDA KULLANALIM... MANTIK BU SEKILDE ILERLEMELIDIR

CONFIG.PHP ICERISINDE BIR SABIT DAHA OLUSTURURUZ MANUEL BIR SEKILDE 

define("URL","http://localhost/test/php-cms-project/cms");

SON KULLANICI SITE-URL INI OLUSTURMAK
ARDINDAN DA 
helper altinda template.php dosyasi olustururuz ve 

Bu bizim son kullanicimizin,(slutt kunde), gorecegi site url i olacak, yani admin kismi degil son kullaniciya gosterdgimiz site url i burasi
app altindaki view da html icerisinde kullanilacak

function site_url($url=false)
{
    return URL. "/". $url;
    define("URL","http://localhost/test/php-cms-project/cms");
}

Ve bunu test edecek olacak olursak da  gidip 
cms/app/view/index.php de 

<body>
    <h3>View</h3>
    <?=site_url(); ?>
</body>

bu sekilde yazariz ve adres cubugunda
http://localhost/test/php-cms-project/cms/

burayi calisitirirsak eger ozaman sunu goruruz
ekrana asagidaki ciktilarin basildigini gorebiliriz 

View
http://localhost/test/php-cms-project/cms/

veya 

<body>
    <h3>View</h3>
    <?=site_url("admin"); ?> 
</body>
yaparsak ve adres cubuguna
http://localhost/test/php-cms-project/cms/
yaparsak 
View
http://localhost/test/php-cms-project/cms/admin

BESTPRACTISE-34 
SONUC OLARAK SUNU COK IYI ANLAYALIM 

http://localhost/test/php-cms-project/cms/
Bu adres son kullanicinin onunde dusecek web adresi dir ve 
dosya olarak 
cms/app/controller/index.php de ki 
require view("index"); sayesinde 
cms/app/view/index.php(html li php) sayfasini kullaniciya sunar


http://localhost/test/php-cms-project/cms/admin/
Bu adres ise tedarikcilerin onune dusecek admin paneli sayfasidir ve dosya olarak 
cms/admin/controller/index.php deki 
require(admin_view("index")); calismasi ile 
cms/admin/view/index.php(htmlli php) sayfasini tedarikci admin kullanicisina sunar

BESTPRACTISE-35 
Birde ana root proje klasoru olan cms altinda public isminde dosya olustururuz ve burda ise html css e ait resim dosyasi gibi, css dosyasi gibi assets dosyalarini tutacagiz

helper altinda public_url isminde bir fonksiyon olusturacagiz
helper/template.php de 

function public_url($url=false){
    return URL."/public/".$url;
}

olustururuz 
bunu neden yapiyoruz 
ornegin public klasorumuz icinde bir tane style.css dosyasi olusturup icerisine body altinda background-color:tomato; yazdik 
ve bu style.css dosyasini cms/app/view.index.php de link etiketleri arasindan cagirdik

   <link rel="stylesheet" href="public/style.css">
   bu sekilde cagirmak yerine daha dinamik bir sekilde 
    <link rel="stylesheet" href="<?= public_url("style.css"); ?>">
    href in bu sekilde http://localhost/test/php-cms-project/cms/public/style.css bu yolla dogrudan style.css i bularak dosyalarin almasini saglariz
    boyle cagirmis oluyoruz css dosyamizi link etiketleri arasindan

    BUNDAN SONRA LINKKLEME YAPARKEN YANI 
    HERHANGI BIR A ETIKETI ICINDE HREF KULLANACAGIMZ ZAMAN(HEADER("LOCATION="))SITE LINKLEME ICIN SITE_URL I  YA DA PUBLIC KLASORUM ICINDEKILER HTML ICERIISNDE CSS DOSYASI VEYA BASKA BIR DOSYAYI HREF ILE CAGIRIRKEN, LINKLEME YAPARKEN 

    helper/template.php icerisindeki  
    asgidaki fonksiyonlari kullaniriz 

    
    function site_url($url=false)
{
    return URL. "/". $url;
    //define("URL","http://localhost/test/php-cms-project/cms");
}

function public_url($url=false){
    return URL."/public/".$url;
}

BURAYA KADAR NELER YAPTIK 
1-KLASOR YAPIMIZI KURDUK
2-VERITABANIN BAGLANTISINI GERCEKLESTIRDIK 
3-ADMIN SAYFAMIZI AYIRDIK
4-CONTROLLER-VIEW LARIMIZ OLUSTURDUK
5-HELPER VE CLASS LARMIZI OLUSTURDUK

PROJEDEKI ANA YAPIMIZI OLUSTURMUS OLDUK
ARTIK ISTEDIGIMZ KADAR SAYFA OLUSTURUP ISTEDGIMZ KADAR DA ISLEM YAPTIRMAYA HAZIR BIR SISTEMIMIZ VAR ARTIK

*/





 

?>