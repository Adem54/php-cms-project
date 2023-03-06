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

ADMIN PANELINDEKI TEMANIN ENTEGRE EDILMESI
179.Admin Tasariminin Entegresi 
https://github.com/tayfunerbilen/wp-admin-html-template
github adresinden
 admin paneli temasinin icinde bulundugu  wp-admin-html-template-master zip dosyasini 
 indirebilirz
 indirdgimiz dosyanin assets klasorunun icirisindeki klasoruleri 
 images,sass,scripts,styles, vendor klasorlerini cms/admin altinda public diye bir klasor olusturup o klasor altina yapistiriyoruz

 BESTPRACTISE-36
helper klasoru altindaki template.php icine geliriz orda hazirladimgiz link ile ilgili, href ile ilgli hem css, dosyasi link icinde bir html dosyasina include ettigmiz zaman kullancagimiz hem de url-link leri  yaparken a href lerde kullanabilmek icin yaptigmiz fonksioyonlardan bir de cms deki admin imizi icin yapacagiz

helper/template.php 
function admin_site_url($url=false)
{
    return URL. "/admin/". $url;
    define("URL","http://localhost/test/php-cms-project/cms/admin");
}

function admin_public_url($url=false){
    return URL."/admin/public/".$url;
    http://localhost/test/php-cms-project/cms/admin/public/style.css
}


BESTPRACTISE-37 
ADMIN TEMPLATE PARCALAMA VE STATIC VE DINAMIK KISIMLARA GORE AYIRMA 

 ADMIN INDEX.PHP TEMPLATE INI CMS/ADMIN/VIEW/INDEX.PHP YE YAPISTIRMA
SONRA CMS/ADMIN/VIEW/INDEX.PHP DOSYAMIZIN ICERIGINI TAMAMEN SILIP ONUN ICERISINE WP-ADMIN-HTML-TEMPLATE-MASTER ICINDEKI INDEX.PHP DOSYASININ ICERIGINI YAPISTIRIRIZ

admin/view/index.php mizde body etiketleri ustundeki script taglari icindeki ckeditoru yorum satirina aliriz simdilik
Bizim admin paneli temamizda dinamik olacak olan kisim content class ina sahip olan div etiketi icindeki alandir
Ondan dolayi div container class tan yukarisi tamamen view icerisinde static isminde bir klasor olusturup onun altinda header.php iceriisine yerlestirilecektir
Ayrica container class inin altinda kalan kisim olan div ,body ve html kapanma etiketini de yine static klasoru icinde footer.php ye alacagiz
Bu islemleri yaptikan sonra da admin/view/index.php 
de static altindaki header.php ve footer.php ye buraya admin de require  islemi icin hazirladigmiz fonksiyon vasitasi ile require ederiz


<?php require admin_view("static/header");  ?>
<div class="content">
. 
. 
.
</div>
 <?php require admin_view("static/footer");  ?>

Sonra da static/header.php deki asset url lerini degistirmem gerekecek, bizim assetleri admin altinda public klasoru altina koyudgumuz icin ordan cagiracagiz ve biz bu asset url lerini link ler altindaki href leri de cagirmak icin method olusturmustuk helper altinda, helper/template.php de onlari kullanacagiz tabi ki

    <!--styles-->
    <link rel="stylesheet" href="<?= admin_public_url("styles/main.css") ?>">

    <!--scripts-->
    <script src="<?= admin_public_url("scripts/jquery-1.12.2.min.js") ?>"></script>
    <!-- <script src="https://cdn.ckeditor.com/4.5.7/basic/ckeditor.js"></script> -->
    <script src="<?= admin_public_url("scripts/admin.js") ?>"></script>

Simdi bu islemi yaptiktan sonra artik 
http://localhost/test/php-cms-project/cms/admin/
actigimizda admin temamzin goruntusunu guzel bir sekilde gorebiliriz

Simdi wp-admin-html-template-master temamizin icerisinde hangi sayfalarimiz var mis admin imiz icin kullanacagimiz bakacak olursak eger login.php,lost-password.php,new-post.php, posts.php ve settings.php sayflarimiz var
Bu sayfalari biz kendimiz cogaltarak admin sayfamizi olusturacagiz

BESTPRACTISE-38
admin/view/static/header.php de ki navbar ve sidebar menu kisimlari font-awesome ile yapilmis, bunlari dinamik hale getirecegiz bunlari nerde dinamik hale getiriyoruz, app/controller/admin.php de yapacagiz bunu, cunku biz 
http://localhost/test/php-cms-project/cms/admin/
url adresine girildiginde app/controller/admin.php ye geliyor calistirmak icin ve admin.php de onu cms/admin/controller/index.php nin calismasini sagliyor orda da tabi ki cms/admin/view/index.php calistiriliyor
app/controller/admin.php
Burda elimzde menu elemanlari ile ilgili verilen hazir bir menu data si yok ki zaten bu genellikle hep bu sekilde yapilir biz reactta da boyle yapmistik
BESTPRACTISE-39 
BU MANTIGI BIR KERE DAHA IYI KAVRAYALIM VE KIMI ZAMAN COK ISIMIZE YARIYOR BIZ HER ZAMAN BIZE VERILEN HAZIR DATALAR UZERINDE PROBLEMLERIMIZI COZEMEYEBILIRZ, BIR PROBLEMLE UGRASIRKEN KENDIMIZ DE PROBLEMIMIZIN COZUMUNU KOLAYLASTIRAN DATALAR OLUSTURMAYI HERZAMAN DUSUNEBILMELIYIZ... BU COOOOK ONEMLI BIR YAKLASIMDIR ....

header.php de sidebar.php deki sidebar elemenlteri her birisi birer sayfaya gidecek, yani onmlar bizim sayfalarimz kullanici ordan tiklayarak admin de her birinisi ayri ayri acabilecek
app/controller/admin.php 
de sidebar datalarin  olustururken
her bir menu elemaninda neler gosteriliyor ona bakalim 
dinamik olarka degisen kisimlar bu kisimlar ozellikle

-title
-icon

 <li>
    <a href="#">
        <span class="fa fa-tachometer"></span>
        <span class="title">
            Dashboard
        </span>
    </a>
    </li>

app/controller/admin.php de 

$menu=[
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
    "setting"=>"Setting",
    "icon"=>"cog"
    ];

admin/view/static/header.php de sidebar da 1 tane submenu lu menu ornegi birakriz sadece plugins kismini digerlerini siliyoruz cunku zaten dinamik yapacagiz burayi

   

    <!--sidebar-->
    <div class="sidebar">
        <ul>
            <?php foreach ($menus as $value) : ?>
                <li>
                    <a href="#">
                        <span class="fa fa-<?= $value["icon"]; ?>"></span>
                        <span class="title">
                            <?= $value["title"]; ?>
                        </span>
                    </a>
                    <?php
                    if (isset($value["submenu"])) {  ?>
                        <ul class="sub-menu">
                            <?php
                            foreach ($value["submenu"] as $key => $value) {    ?>

                                <li>
                                    <a href="#">
                                        <?php echo $value ?>
                                    </a>
                                </li>
                            <?php     }

                            ?>

                        </ul>
                    <?php        }

                    ?>
                </li>
            <?php endforeach; ?>
            <li class="line">
                <span></span>
            </li>
        </ul>
        <a href="#" class="collapse-menu">
            <span class="fa fa-arrow-circle-left"></span>
            <span class="title">
                Collapse menu
            </span>
        </a>
    </div>

BESTPRACTISE-40 -SAYFALARIN HANGISI UZERINDE ISEK O SAYFA NIN ARKA PLAN RENGI OLMASI YANI ACTIVE OLMASININ SAGLANMASI

Mantikken biz asgidaki url ile gelince admin altindaki index.php nin aktif olmasi gerekyor     
http://localhost/test/php-cms-project/cms/admin/
<?php echo route(1);//index tir  ?>
 
ve de biz sidebar menu elementlerini dinamik bir sekilde listeledik ve orda biz sayfalari listeliyoruz ve bizim 1.sayfamiz index, ama eger direk admin sayfasi degil de diger sayfalarda olacaksa da o zaman da o sayfalar, users,settings gibi sayfalar gelsin yani sayfa gelme isi dinamik olsun istiyoruz

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
    "setting"=>[
        "title"=>"Setting",
        "icon"=>"cog"
    ]
    ];

<?php foreach ($menus as $mainUrl=> $value) : ?>
                <li class="<?php echo route(1)==$mainUrl ? "active" : null ?>">


   BESTPRACTISE-40 -SITE SAYFALARININ URL LERINI YAPALIM static/static/header.php de              
        admin_site_url($mainUrl);   

    <?php foreach ($menus as $mainUrl=> $value) : ?>
                <li class="<?php echo route(1)==$mainUrl ? "active" : null ?>">
                    <a href="<?php echo admin_site_url($mainUrl);  ?>">

         VE SUBMENULER ICIN DE admin_site_url($url);   
         
 if (isset($value["submenu"])) {  ?>
        <ul class="sub-menu">
            <?php
            foreach ($value["submenu"] as $url => $value) {    ?>
                <li>
                    <a href="<?= admin_site_url($url); ?>">
                        <?php echo $value ?>
                    </a>
                </li>
            <?php     }


     Simdi ne duruma geldik artik biz static/header.php de 
     menumuz de 
     homepage e tiklaninca     
     http://localhost/test/php-cms-project/cms/admin/index
     memnbers a tiklaninca  
     http://localhost/test/php-cms-project/cms/admin/users
     ve settings e tiklaninca
     http://localhost/test/php-cms-project/cms/admin/settings

     bu adreslere gidiyor ve ornegin 
     http://localhost/test/php-cms-project/cms/admin/settings
     settings adresine gittiginde ne yapiyor 

    cmd/app/controller/admin.php de 
    
    require(admin_controller(route(1))); 
    url bu old. icin
  http://localhost/test/php-cms-project/cms/admin/settings

    bu kod sayesinde admin 0 .index iken 
    settings 1. index oluyor 
     require(admin_controller(route(1)));
      require(admin_controller("settings"));
      SEn diyor git cms/admin/controller da settings sayfasini ara bul diyor o da oraya gidiyor ondan dolayi da biz admin/controller altinda 1 tane settings.php olustrduk    ve icerisnde 
      
      <?php 
require admin_view("settings");
?>
bu sekilde biz admin/controller altinda admin/view altindaki sayfalari cagirisp calistiriyoruz 
Ve de view altindaki settings.php yi calistir dedik sonra da 
admin/view altinda settings.php sayfasini olusturduk ve artik 
admin/view/static/header.php de menulerde 
nasil ki homepage e tiklayinca 
http://localhost/test/php-cms-project/cms/admin/index
gidip admin/view/index.php calistiriliyorsa 
http://localhost/test/php-cms-project/cms/admin/settings
menu cubugunda settins e tiklaninca artik adres cubugunda admin/settings e gidiyor ve bize admin/view/settings.php sayfasini gosteriyor
Ayni seklde users icin de yapiyoruz
Ayni sekilde alt menuler icinde sayfalari olusturarak tiklaninca o sayfalara gitmelerini saglamaliyiz 

BESTPRCTISE-41
Alt menulerin sayfalarini da olusturudgumuz zaman, soyle bir sorunla karsilasiyoruz Members uzerine gidip sonra onun bir alt menusu olan AddMenu ye tiklayip da addMenu sayfasini admin de addMenu sayfasini goruyoruz ancak, Members menu elemani aktif olmyor alt menusunu gosterince 

Bunun icin li icindeki class da sorgumuzu biraz genisltiriz deriz ki eger donen menu elemani icinde submenu var ve o submenu icinde bizim aktif olan url mizdeki elemnt key ise dersek o zaman alt menusu aktif olan tiklana menunnun kendisne de aktif class i verecektir 

http://localhost/test/php-cms-project/cms/admin/add-user
route(1)=add-user

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


    <?php foreach ($menus as $mainUrl=> $value) : ?>
                <li class="<?php echo route(1)==$mainUrl || isset($value["submenu"][route(1)]) ? "active" : null ?>">


ADMIN PANELINDE GENEL AYARLAR BOLUMU-SETTINGS 

Biz settings ile ilgili ayarlari veritabaninda tutmak yerine bir php dosyasinda dizi halinde tutacagiz, bu sekilde hem ayarlari istedgimiz yerde kolayca kullanabiliyoruz hem de veritabani sorgusu yapmak zorunda kalmiyoruz
admin tema mizda, wp-admin-html-template-master icinden settings.php yi aciyoruz ve icerisinden content class div inin iceriisnde kalan alani aliyoruz, ama o alanda bir problem cikiyor ondan dolauyi biz yine div content alani ile birlikte aliyoruz
admin/view altindaki settings.php ye bunu aliyoruz
Ne gibi ayarlar olabilir 
Sitenin title,description,keywords,footer da copyright

admin/view/settings.php de sadece li etiketi iicnde 1 tane Site Title inputu ile, Save Changes submit buttonunu birakiriz, gerisini siliyoruz

Bizim seo icin cok onemli head taglari arasina yazilan title, meta taglari arasina yazilan description ve de yine meta keywords leri bunlar search engine optimization icin cok kritik oneme sahiptir

title-meta title, title tag, or SEO title diye adlandirilir
 <meta name=”description” content=”Your discription.”/>		
 
 BESTPRCTISE-42 
 DIKKAT EDELIM DIZI OLARAK POSTA FORM ICINDEN ELEMENT GONDERME YANI COGUL OLARAK GONDERME VE HIDDEN TYPE , INPUT SUBMIT I ILE, FORMUMUZUN NE ZAMAN TIKLANIP NE ZAMAN TIKLANMADINGIN KONTROL ALTINA ALMAK!!!!!
Bizim html de head etiketleri arasinda meta ayarlari var title ayari var bunlar, search engine optimization icin cok onemlidir
Dolayisi ile bunlar wordpress gibi tum admin panellerde mutlaka settings icerisinde bulunurlar bizde bunu yapacagiz ve bunlari dizi olarak gondermek istiyoruz 
Bu ayarlari settings.php de ekliyoruz
<div class="box-">
        <form action="" metod="POST" class="form label">
            <ul>
                <li>
                    <label >Site Title</label>
                    <div class="form-content">
                        <input type="text" name="settings[title]" id="title">
                    </div>
                </li>
                <li>
                    <label >Site Description</label>
                    <div class="form-content">
                        <input type="text" name="settings[description]" id="title">
                    </div>
                </li>
                <li>
                    <label >Site Keywords</label>
                    <div class="form-content">
                        <input type="text" name="settings[keywords]" id="title">
                    </div>
                </li>
                <li class="submit">
                  <input type="hidden" name="submit" value="1"/>
                    <button type="submit">Save Changes</button>
                </li>
            </ul>
        </form>
        </div>
        </div>

name ler de post methodu ile gonderirken cogul olark veya dizi olarak gondermek icin, name valuesi yanina indexer koyuyoruz
 <input type="text" name="settings[description]" id="description">
 <input type="text" name="settings[title]" id="title">
   <input type="text" name="settings[keywords]" id="keywords">

   Ayrica bir type i hidden olan input daha olusturduk dikkat edelim 
      <input type="hidden" name="submit" value="1"/>
   
      settings.php deki formu biz kendi icinde submit edecegiz ondan dolayi form action="" bos birakabiliriz 
      Biz gonderme methodu belirtmez isek kendisi default olarak get methodu ile gondermeye calisir o yuzden methodu belirmek gerekecektir

Ve ardindan da admin/controller/settings.php imiz altinda bir kontrol yapabiliriz

bU HALDE IKEN EGER BIZ DENEMEK ICIN ADMIN/VIEW/SETTINGS.PHP ICINDEKI FORMU TEST1,TEST2,TEST3 DIYE DOLDURUP BUTONA BASARSAK 
VE DE HANGI DATALARIN GELDGIINI DE GORMEK ICIN 
ADMIN/CONTROLLER/SETTINGS ICINDE DE 

EGER BUTONA TIKILANMIS ISE YANI POST GONDERILMIS ISE DIYE BIR LOGIC YAZMIS OLDUK, OLUSTRUDUGMUZ GIZLI INPUT ILE.... 
if(isset($_POST["submit"])){
    print_r($_POST);
}
require admin_view("settings");

SEKLINDE YAZDIRIRSAK DATAYI ASAGIDAKI GIBI DATLAARI ALACAGIZ

 <input type="text" name="settings[description]" id="description">
 <input type="text" name="settings[title]" id="title">
   <input type="text" name="settings[keywords]" id="keywords">

Datalari name attributu icine indexer ile yazarak o datayi dizi icine atarak gondermis oluyoruz 

[
"settings"=> [
"title"=> "TEST1",
"description"=> "TEST2",
"keywords"=> "TEST3"
],
"submit"=> "1"
],

 BESTPRCTISE-43 
Simdi helper altina form.php olusturarak form helper larimizi yazacagiz

post ve get form islemlerimiz ile iligli gonderilen input elemntlerini isset kontrolu, htmlspecialchars ile saldirilara karsi onlem alma ve sag ve soldaki bosluklari silecek sekilde return ederek, alabilecegmiz fonksiyonlar yazariz

helper/form.php 

function post($name){
    if(isset($_POST[$name])){
       return htmlspecialchars(trim($_POST[$name])); 
    }
}

fonksiyonu sadece boyle yapip birakirsak bu fonksyon post isleminde dizi olarak gonderilen datalar icin ise yaarmayacaktir ondan dolayi da bu fonksioyona bir islem daha ekleyecegiz, gelen post degeri eger arrray ise diye bir islem yapaagiz

BESTPRACTISE-44
if kullanimi ile ilgili hemen bir bilgi 
Eger if kosulundan sonra sadece tek satir bir kod kullanacaksak o zaman if kosul parantezlerinden sonra hicbirsey koymadanda if cumlecigini kullanabiliriz 

if(is_array($_POST[$name]))
            return array_map($_POST[$name],function($value){

BESTPRACTISE-45 
ARRAY_MAP I PHP NIN HAZIR BIRDEN FAZLA(MULTIPLE) FONKSIYONLARI ILE NASIL KULLANIRIZ PRATIK BIR SEKILDE 

function post($name){
    if(isset($_POST[$name])){
        if(is_array($_POST[$name])):
            return array_map(function($value){
        return  htmlspecialchars(trim($value));
            },$_POST[$name]);
        endif;
        
       return htmlspecialchars(trim($_POST[$name])); 
    }
}

BESTPRACTISE-46 
SETTINGS AYARLAR DATASININ TUTULMASI 
CMS ALTINDA SETTINGS.PHP OLUSTRDUK
BURDA BIR MANTIK, BAKIS ACISI VE ANLAYIS KAZANMALIYZI DOGRU ANLAYISI KAZANMALIYZI BU COOK ONEMLIDIR BACKEDNDDE
BURADA BIR KONUDA DAHA NELER OLUP BITTIGININ FARKINDA OLMAMIZ GEREKIYOR CUNKU BIZ BURDA, DIKKAT EDERSEK IHITYACIMIZ OLAN SETTINGS DATA SININ BIRYERDEN GELMESINI BEKLEMIYORUZ NE YAPIYORUZ KENDIMIZ KULLANICIDAN GELECEK OLAN ILK DATA ILE OLUSTURULACAK VE DE KULLANICI ADMIN/VIEW/SETTINGS.PHP DE FORM ICINDE HER DATA YI EDIT VEYA UPDATE ETTIGINDE DE TUTTUMUZ APP/SETTINGS.PHP DATA KAYNADGI GUNCELLENCEK BIR SISTEM KURUYORUZ YANI DATA KAYNAGIMIZI DA KENDIMIZ OLUSTURYORUZ YANI MANTIK OLARAK ISTE BIRISI GETIRSIN BANA DATA VERSIN DIYE BEKLEME DIYE BIRRSEY YOK BURDA, HER ZAMAN OLUSACAK DATAYI KULLANCIIDAN ALINACAKSA KULLANICIDAN ALARAK DINAMIK BIR SEKILDE TEKRAR KULLANICIYA SUNACAK SURDURUELBILIR BIR SISTEM KURARIRZ YA DA DIREK DATA YI MANUEL OLARAK OLUSTURARAK DATAYI KULLANIRIZ
<?php 
//Ayarlari biz bu sekilde tutacagiz 
$settings["site_title"]="test1";
$settings["site_description"]="test2";
$settings["site_keywords"]="test3";
?>

BIZ SETTINS AYARLARI ILE ILGILI DATALALARI PHP DE DIZI ICINE YUKARDAKI GIBI YAZMA ISLEMININ HTML FORMATINI TUTARAK YAZACAGIZ
YANI YUKARDA PHP ETIKETLERI ICINDE YAZILMIS KODLARIN AYNISINI HTML FORMATINDA YAZACAGIZ

BESTPRACTISE-47
PHP_EOL INBUILD PHP SABITI ILE BIZ ORNEGIN BIR PHP ETIKETLERI ICINDE YUAPTIMIZ PHP ISLEMLERININ AYNISINI HTML FORMTINDA YAZARKEN BIR ASAGI GECME ISLEMINI BU SABITI KULLANARAK YAPABILIRIZ COOK ONEMLI BU ..... 

ADMIN/CONTROLLER/SETTINGS.PHP DE 

BESTPRACTISE-48 
BIZ, PHP ILE BAZEN HTML ETIKETLERINI PHP ETIKETLERI ARASINDA TIRNAKLAR ICINDE DINAMIK BIR SEKILDE OLUSTURUZU DIKKAT EDELIM BURASI COK ONEMLI  ORNEGIN 
$html="<div>";
$hmtl.="Hello";
$html.="</div>";
echo $html;
<div>Hello</div> yazdirmis olduk bunlarin cok daha ileri seviye dinamiklesme islemleri html etiketler i php etiktleri icerisinde parcalalya prcalaya cok ileri seviye dinamiklestirme islemleri yapaibiliyoruz aklimizda olsun bu her zaman cunku bazen cok kritik noktalarda ihityacimz olacaktir


"Ekranda php kodu eger direk yazilir ise kesinlikle onu biz goremeyiz ekrana basilamaz.. dikkat edelimmmm..oondan dolayi biz eger bir degsiken olusturup ornegin "
$html="<?php  ?>" bu sekilde php ettiketlerini tirnaklari icinde acip kapatip icerisine de php kodlari yazarsak bunun bir string gibi tarayicidan ekranda php yazan stringler gormeyi beklemeyelim...onemli bilmezsek neden gelmiyor diye dusnuruz

cms/settings.php de yazdigmz settings datlarini html formatinda asagidaki gibi yazariz 

BESTPRACTISE.. STRING.. BIR DEGISKEN OLUSTURUP ICERIINDE DINAMIK ISLEMLER YAPABILYORUZ....  VE BUNU OZELLIKLE ICERIISNDE HTML ETIKETLERI VE CSS STYLE DA DINAMIK BIR SEKILDE KULLANDIGMIZ ZAMAN COK EFEKTIF ISLER ORTAYA CIKARABILIYORUZ... 

if(isset($_POST['submit'])){
    
    $html='&lt;?>php '.PHP_EOL.PHP_EOL;//2 kez new line yapmak icin php nin inbuild new line islemi yapan sabitini 2 kez kullanmis olduk

    foreach (post("settings") as $key => $value) {
        # code...
        $html.='$settings["'.$key.'"]="'.$value.'";'.PHP_EOL;
    };
  
    echo $html;
}

Burayi yaptiktan sonra da app altina 1  tane settings.php dosyasi olusturuyoruz cms altinda olusturdugmuz settings.php yi kaldiriyoruz
Ve olustrudugmuz $html icerigi app/settings.php icerisine yazdiracagiz file_put_contents ile

BESTPRACTISE-49-
file_put_contents-file_get_contents kullanimi 
<?php 
$number;
$content="<h1>Hello world</h1>";
file_put_contens ile elimizdeki icerigi, baska bir dosyanin icerisine yazabiliyoruz 
1.parametreye hedef dosya yolu, ama tam yolu yazmamiz gerekir 
2.parametrede girilecek icerigi icinde barindiran degiskeni yazmalyiz 
$res=file_put_contents(__DIR__."/test2.php",$content);
var_dump($res);//sonucu eger eklemis ise true int(20) veriyor ekleyemezse bool-false veriyor
echo "<br>";
file_get_contents ile de biz bir dosyamizin icerini string olarak aliyoruz 
$res2=file_get_contents(__DIR__."/test2.php");
echo $res2;


Tekrar admin/controller/settings.php den devam edelim 

if(isset($_POST['submit'])){
    
    $html='&lt;?>php '.PHP_EOL.PHP_EOL;//2 kez new line yapmak icin php nin inbuild new line islemi yapan sabitini 2 kez kullanmis olduk

    foreach (post("settings") as $key => $value) {
        # code...
        $html.='$settings["'.$key.'"]="'.$value.'";'.PHP_EOL;
    };
    olusturudgmuz ayarlar icerigini, app altindaki settings.php sayfamiza  yazdiracgiz
  file_put_contents(PATH."/app/settings.php",$html);
  header("Location:".admin_site_url("settings"));
  icinde bulundgumuz sayfaya yonlendirerek post ettikten sonra buraya geri gelsin diye 
    
}

BURAYI ANLAMALYIZ.... 
BURASI COK ONEMLI BURAYI BIZ DINAMIK OLARAK YAZDIK CUNKU, BIZ, 
SETTINGS.PHP DOSYASINA DINAMIK BIR SEKILDE YAZIYORUZ YANI FORM INPUTLARINDAKKI DEGERLERI ALIYORUZ VE ONLARI, DINAMIK BIR SEKILDE APP/SETTINGS.PHP ICINE YAZDIRACAGIMIZ SETTINGS DIZISINI OLUSTURUYORUZ, YANI BIZ APP/SETTINGS.PHP DATA KAYNAGIMIZI, DINAMIK OLARAK FORM DAN GELEN DEGERLERLE POST EDILEN FORM DEGERLERI ILE YAZDIRIYORUZ VE BURDAYI BIRDE, PHP DATASI OLARAK YAZDIRIYIORUZ KI, GUNCEL VE EN SON GIRILEN VALUE DEGERLERINI SETTGINS.PHP FORMU ICINDEKI INPUT LARIN VALUE SINDE DINAMIK OALRAK APP/SETTINGS.PHP OLARAK BIR PHP DIZISI OLARAK DINAMIK BIR SEKILDE OLUSTURUGMUZ DATA DAN CEKMEK ICIN


Normalde, bu sayfadan biz, admin/view/settings.php yi require ediyoruz ondan dolayi setting.php yi gosteriyoruz, bu sayfadan gosteriyoruz, biz bu sayfadayiz yani settings sayfasini actimigz zaman
require admin_view("settings");

BESTPRACTISE-50 
HEADER YONLENDIRME ISLEVI..... COK KULLANILACAK
BIZ HERHANGI BIR POST,GET VS YAPTIKAN SONRA YANI BUTONA TIKLADIKTAN SONRA DATA GONDERME ISLEMINI YAPTIKTAN SONRA, SAYFAMIZ HERHANGI BASKA BIR SAYFAYA YONLENMESINI ISTEYEBILIRZ ORNEGIN REACT TA SIGN-UP FORMUNDA BASARILI BIR SEKILDE KAYIT YAPAN KULLANICININ HOMEPAGE A YONLENDIRILMESI GIBI VEYA IZNI VE GIRISI OLMADAN HOMEPAGE E URL DEN GIRMEYE CALISAN KULLANCIININ KONTROL EDILEREK EGER GIRIS YAPMAMIS ISE ONU LOGIN FORMUNUNU OLUDUGU LOGIN.PHP E YONLENDIRME GIBI NAVIGATE GIBI AYNEN BIZIM COK ISIMIZE YARAYACAK COK KULLANAGIZ HEADER() YONLENDIRME ISLEVINI

file_put_contents ile $html icerigimzi app/settings.php e yazdirmis olduk  

app/settings.php iceriginde gorebiliriz

<?php 

$settings["title"]="TEST1";
$settings["description"]="TEST2";
$settings["keywords"]="TEST3";

Bu islemden sonra settings.php mi, 
app/init.php de require ile uygulamaiza dahil ediyoruz

helper sayfasinin icindekileri require ettgimiz islemin hemen ustunde bu islemi yapariz 


require(__DIR__."/settings.php");


$helper_php_files=glob(__DIR__."/helper/*.php");

foreach ($helper_php_files as $helper_file) {
    require($helper_file);
}

Sonra helper/app icerisine 1 tane setting isminde fonksiyon olustururuz

BESTPRACTISE-51
REACTTA YAPTIGIMZ UPDATE FORM MANTIGIN AYNISI RESMEN AYNISINI FARKLI BIR SEKILDE YAPIYORUZ... 
REACTTA DA VALUE YI BIZIM OLUSTRURUDMZU STATE DEGERI NI VERIRKEN O STATE DE DE VARSAYILAN OLARAK O INPUTA EN SON GIRILEN DATA BIZDE OLURDU O DATA ILE BASLATIRDIK ANCAK INPUT VALUESINE YAZILAN DEGISKEN, HER ZAMAN, KULLANICI INPUTA NE GIRERSE VALUE OLARAK ONU ALACAK BIR DEGISKEN OLACAK....ISTE AYNI  MANTIK.... 
BURDA MUTHIS BIR OLAY VAR ASLLINDA BIZ VARSAYILAN DEGERLERIMIZI ADMIN/VIEW/SETTINGS.PHP DE GIRIYORUZ VE BU DEGERLERI APP/SETTINGS.PHP DIYE BIR DOSYAYA YAZDIRIYORUZ VE SONRA BURDAKI SETTINGS ARRAYI ICINDEKI DEGELER ICINDEKI TITLE,DESCRITPION,KEYWORDS KEY LERININ VALUE LERI,DAHA ONCEDEN NE DIYE FORM DA KAYDETTI ISEK DOSYAY OYLE KAYDOLACAGIZ ICIN, EN SON KAYDOLAN DEGERLER, ADMIN/VIEW/SETTINGS.PHP DEKI FORM INPUTLARINA VALUE OLARAK VARSAYILAN, DEGER OLARAN SETTINS.PHP ICINDE SETTINS ARRAY AYARLARI OLAN DOSYADAN CEKECEGIZ... BU ISLEM AYNI UPDATE ISLEMI MANTIGIDIR VE HEP BU SEKILDE YAPILIR, YANI ELIMZDE BIR TANE EN SON FORM INPUTLARI ICINE YAZILAN DEGERLERI VEREN ARRAY OLUR VE BIZ FORM VALUE LERINI ORDAKI DEGERDEN CEKERIZ AMA, AYNI ZAMANDA BIZ O VALUYE YAZDIMIGZ DEGER DE YANI DINAMIK OLARAK NERDEN GELIYORSA ONUN KAYNAGIDA KULLANICI FORM INPUTLARINI HER DEGISTITIRDIGINDE GUNCELLENEN YER OLACAKTIR KI, FORM INPUTLARI DINAMIK OLARAK KULLANICININ DEGISTIRMESINIE GORE SUREKLI VALUE YI ALSIN... 
HARIKA BESTPRACTISE BU MANTIK VER HER ZAMAN UYGULAYACAGIMZI BIR MANTIKTIR... 
function setting($name){
  app/settings.php yi biz tum uygulamaya dahil etmistik init.php de ve ordan 1 tane $settings array degiskeni geliyor, o array $settings i burda kullanmak istyoruz onun icin global yapariz 
  global $settings; 
  Burda parametrye verilen admin/view/settinngs de name lere ne verilmis ise attribute value ler icinde bu fonksiyon kullanilip name ler icin verilen deger paaramtereye verielefcektir 
  Bunlari, html icinde value attributu ne deger olarak kullanacagiz
    return isset($settings[$name]) ? $settings[$name] :false;
  //return $settings[$name] ?? false;
ARTIK BU FONKSIYONUMUZ BIZ, admin/view/index.php de ki form inputlari icinde valuer lerin value sinie bu fonksiyonu kullanabilecegiz 

admin/view/settings.php


<input type="text" name="settings[title]" value="<?= setting("title"); ?>" id="title">
<input type="text" name="settings[title]" value="<?= setting("title"); ?>" id="title">
<input type="text" name="setting [description]" value="<?= setting("description"); ?>" id="description">

datayi cektigmz app/settings.php ye bakacak olursak
<?php 

$settings["title"]="TEST1";
$settings["description"]="TEST2";
$settings["keywords"]="TEST3";

SAYFAMIZI YENILEDIGMIZ ZAMAN DEFAULT OLARAK VEYA EN SON FORM INPUTLARI ICINDE GIRILIP DE KAYDEDILEN SETTINGS DATALARI INPUT LAR ICERISINDE GOZUKECEKTIR.... 

BESTPRACTISE-52 
HARIKA ADVANCE ISLEMLER YAPABILIYORUZ
REACTTAKI BESTPRACTISE I HATIRLAYALIM HTML ISLEMMELRINDE BUNLAR COK ETKLI KULLANILIYR KI BIZDE KULLANMALYIIZ OZELLIKLE ATTRIBUTE LER UZERINDEN YURURYEREK COK ETKILI VE ADVANCE ISLEMELER YAPABLIYORZ ORNEGN DATASET I KULLANMAYI HER ZAMAN DSUNMELIYIZ AYRICA FORM INPUTLARINA NAME OLARAK KULLANIRKEN, HEPSINDE INPUT KULLANIP NAME DE NE VERIYORSAK BU INPUTLAR ICIN, YANI FORM ICIN TUTTUGMUZ ARRAY KEY LERI ICINDE AYNI ISMI VERMELIYIZ KI NAME LERI KULLANARAK, O KEY LERE DAHA PRATIK ERISEBILELIM...REACTTA HEP BU MANTIK UZERINE YURUMUSTUK(TABI JAVASCRIPTTE OBJE OLUYOR PYP DEKI DIZIININ KARSILIGI)
BU SAYEDE KULLANICI UPDATE SAYFASINA GELDIGI ZAMAN KULLANICINN EN SON GIRDIGI VEYA KAYDETMIS OLDUGU FORM INPUT DEGERLERI KULLANICIYI KARSILAYACAKTIR 


SETTINGS ISLEMLERIMIZIN TEMELINI OLUSTURMUS OLDUK VE OLUSTURDUGMUZ HELPER/APP ALTINDAKI SETTING FONKIYONUMUZ ILE SETTINGS AYARLARIMIZI ISTEDIGMZ HERYERDE DE KULLANABILECEGIZ ORNEGNI APP/VIEW/INDEX.PHP DE ANA SAYFADA SETTING TITLE I GOSTERMEK ISTERSEK, KI ZATEN BIZ BU AYARLARI OZELLIKLE ANA INDEX.PHP DE YANI APP/VIEW/INDEX.PHP KULLANACAGIZ..SEO OPTIMIZASYOJNU ICIN

<?= setting("title"); ?>
</body>
</html>


TEMA SISTEMININ OTURTULMASI KULLANICIYA BIR DEN FAZLA TEMA SECME IMKANI VERME VE AKTIF OLAN TEMAYI GOSTERME SEKLINDE BIR SISTEM KURACAGIZ 
(BU DA YINE BIZE, REACT TAKI E-COMMERCE PROJESINDE KULLANICIYA ON YUZDEKI LAYOUT U 2 YA DA 3 FARKLI SEKILDE SECEREK DATAYI GOREBILME FIRSATI SUNUYORDUK O MANTIK BURDA DA VAR... )
ANA SAYFAMIZ SON KULLANICINN GORDUGU-SLUTT BRUKER,SLUTT KUNDE
KULLANDIGI SAYFA APP/VIEW/INDEX.PHP 
APP/VIEW ALTINDA 2 TANE ORNEGIN TEMA KLASOURMUZ OLSUN VE ORNEK OLARAK 
1-udemy-v1
2-netsense-v1 olsun 

app/view/index.php yi bu temalarin icerisine yerletirelim 
Ve de test edince gorebilmek iicn body kisimlarina h1 etiketi icerisinde tema isimlerini yazalim 

BESTPRACTISE-53
Once bizim sunu yapmamiz lazim, dinamik olark bu temalari ana sayfada getirmemiz gerekiyor
yani temalarimizi dinamik olark bir dizi icine alip hangi temalar yerlestirilirse onu dinamik bir sekilde biz hicbirsey yapmadan getirecek sistemi kurmaliyz
Simdi app altinda init.php de biz helper altinda bulunan .php uzantili dosyalairmizi glob methodu ile dinamik bir sekilde dizi icerisine atarak onlari istedgimz gibi yonetmistik, ve getirtmistik

$helper_php_files=glob(__DIR__."/helper/*.php");

foreach ($helper_php_files as $helper_file) {
    require($helper_file);
}

Iste ayni mantikla bu seferde app/view altinda bulunan tema klasorlerini dinamik bir sekilde almak icin glob ile sadece klasorleri alabilecegimiz bir sistem kurup app/view altindaki klasorleri bir dizi iceriisne alarak sonra da dinamik hale getirmemiz gerekiyor
admin/controller/settings.php ye geliriz ve orda bu islemi yapacagiz

//foreach(glob(PATH."/app/view/*",GLOB_ONLYDIR)
//glob(PATH."/app/view/*/");
foreach(glob(PATH."/app/view/*/") as $value){
    echo $value."<br>";
 }
 
C:\Users\ae_netsense.no\utv\test\php-cms-project\cms/app/view/netsense-v1/
C:\Users\ae_netsense.no\utv\test\php-cms-project\cms/app/view/udemy-v1/



Ama bize ne lazim sadece en sagdaki klasor isimlerini almak istiyoruz once biz ne yapiyorduk aradigmiz bir ifadenin sagindaki solundaki bosluklari veya sagindaki solundaki spesifik karakterleri de kaldirabiliyorduk rtrim ile once en sagdaki slashi sileriz 

\ terslash yok normlde foreach parantezi altinda '*\' normlade ter slsh yok sadece yildiz/ yildiz ve normal slahs var  
foreach(glob(PATH."/app/view/*\/") as $value){
    print_r(explode("/",rtrim($value,"/")));
}

{
0: "C:\Users\ae_netsense.no\utv\test\php-cms-project\cms",
1: "app",
2: "view",
3: "netsense-v1"
},
{
0: "C:\Users\ae_netsense.no\utv\test\php-cms-project\cms",
1: "app",
2: "view",
3: "udemy-v1"
},
/*
explode ile /  e gore diziye cevir dersek bizim erismeye calistigmiz elemntler ortaya cikacak olan 2 dizinin en elmanlari olacaklar dolayisi iel bir dizi deki en son elmena da end($array) methodu ile eriserek erismek istedimgz folder name leri istedigmiz sekilde almis olacagiz

$templates=[];
foreach(glob(PATH."/app/view/*\/") as $value){
    $value=explode("/",rtrim($value,"/"));
    // print_r($value);
    $templates[]=end($value)."<br>";
       //Son elemani bu sekilde de alabilirdik
       //echo $value[count($value)-1]
       netsense-v1,udemy-v1
}
Evet bu sekilde istedgimiz datlara erismis olduk
//exit();

Burayi bu sekilde yaptiktan sonra, yani admin/controller/settings de bu sekilde tema isimlerini aldiktan sonra 

admin/view/settings.php ye geliriz ve bir Site Keywords altina bir li alani daha olustururuz ve oraya Site Themes yazacagiz

BESTPRACTISE-54
SIMDI BURDA HARIKA BIR SURDURULEBILIRLIK ORNEGI SERGILYORUZ YANI BIZ NE YAPTIK SETTINGS AYARLARA YENI BIR AYAR EKLEMEK ISTEDIK NE IDI O AYAR TEMA AYARLARI ILK ONCE NE YAPMAMIZ GEREKTI, SURDURULEBILIR VE YENI TEMA EKLENDIGINDE HIC SKNTI CIKMADAN BU DIREK SISTEME DAHIL EDEBILECEGIMIZ SEKILDE ONCE DATA OLUSTRDUK YANI ADMIN KULLANICISI SADECE GELECEK TEMA FOLDERLARINI KOYDGUMUZ YERE EKLMEEK ISTEDIGI YENI TEMA FOLDERINI YERLESTIRECEK VE BU OLUSTRDGUMUZ SISTEM SAYESINDE ADMIN/CONTROLLER/SETTINGS.PHP DE $THEME ARRYININ ICERISINE GELECEK ORDAN DA YINE ADMIN/VIEW/SETTINGS.PHP DE ISE, BIZ SURDURULEBILIR SISTEM KURMUSTUK, SETTINGS AYARLARIMIZ ICIN AYNI SISTEME ARTIK THEME YI ASAGIDAKI GIBI DAHIL EDIYORUZ VE SISTEMIMIZ TIKIR TIKIR ISLIYOR HARIKA MANTIKLA.... 

  <li>
    <label >Site Themes</label>
    <div class="form-content">
        <select name="settings[theme]" value="<?= setting("theme") ?>">
        <option value="">--choose theme--</option>
        <?php foreach($themes as $theme):  ?>
            <option <?= setting("theme") == $theme ? "selected":null ?> value="<?=  $theme ?>"><?php echo $theme ?> </option>
            <?php endforeach;?>
        </select>
    </div>
  </li>

SELECTED ATTRIBUTUNU DINAMIK BIR SEKILDE YAZARAK KULLANICI ADMIN/VIEW/SETTINGS.PHP DE NEYI SECTI ISE ONU DOSYA ICINDE TUTTUGMUZ DATAYA KAYDEDIP GUNCELLEDIKTEN SOJNRA  O DATAYI SELECTED I DINAMIK BIR SEKILDE BELIRLERKEN KULLANIYORUZ 

BESTPRACTISE-55 
BU HEP BU SEKILDE YAPILIR ASLINDA MANTIK HEP AYNIDIR.....BESTPRACTISE .... 
 <option <?= setting("theme") == $theme ? "selected":null ?> value="<?=  $theme ?>"><?php echo $theme ?> </option>

 BESTPRACTISE-56 
 SIMDI TAMAM BACKEND TARAFINDA ADMIN TARAFINDA YAPTIK THEME SECIMIZIN DINAMIK BIR SEKILDE AMA APP ALTINDAKI VEIW DA NASIL GOSTERECEGIZ BUNU 
 ISTE BU PROBLEMI COZMEK BIZIM PROJEDE NELER OLUP BITIYOR ANLAYIP ANLAMADIGMZI COK IYI GOSTERIR 

 SIMDI BIZ SON KULLANICININ GORECEGI ON YUZ VIEW IMIZ I ADRES CUBUNU ASGIDAKI GIBI OLUNCA GELIYORDU VE APP ALTINDAKI VIEW/INDEX.PHP GELYORDU VE BU APP/CONTROLLER DA
 require view("index"); edilmesi ile geliyordu bizim buralara dokunmadan, dogrudan helper altinda bu sistemin kuruldugu yere gidip orda dinamik olarka o an da secilen tema hangisi ise onun sisteme entegresni saglamaliyiz 
http://localhost/test/php-cms-project/cms/

app/helper/app 

function view($viewName){
    global $settings;
    $viewName=strtolower($viewName);
    return PATH."/app/view/".$settings["theme"]."/".$viewName.".php";
}
dikkat edersek, gosterilecek dosya yoluna ne yaptik tema lardan currentheme yani kullanici tarafindan hangi tema secildi ise her zaman onu koymus olduk index.php hemen oncesine ki kullanici adminde hangi temayi secerse artik son kullanici o temayi gorecek.... BESTPRACTISE...


BESTPRACTISE-57.
CSS DOSYALARININ DA DINAMIK YAPILMASI SECILEN THEME YE AIT CSS DOSYASININ DAHIL EDILMESINI SAGLAMAK 

TAbi biz app/view/index.php de link lerde style lari href uzeirnden sayfaya dahil ederken helper/template te ayarlamistik ve biz kullanici hangi temayi secerse o temanin tamamen kendine ait de style.css i olsun diye bizii css dosyalarini koydgumzu public klasoru altina tema isimlerimizle 2 tane klasoru olusturup iclerine her bir temanin kendine ozel style.css ini oraya yerlestiririz ve de ornek olarak ikisine de farkli arka planlar ekleriz simdi, 

Asgida public_url fonksiyomnumuzun css dosyalarini almasi icin biz dinamik bir sekilde kullanici hangi temayi secti ise ona ait css,js images dosyalairina erisebilmesini saglamis oluruz

function public_url($url=false){
    return URL."/public/".setting("theme")."/".$url;
    //ttp://localhost/test/php-cms-project/cms/public/style.css
}

yine kullaci artik app/view altindaki netsense-v1 veya udemy-v1 temasi altindaki index.php lerde head icinde style.css i dahil ederken 
  <link rel="stylesheet" href="<?= public_url("style.css"); ?>">

  BESTPRACTISE-57.
  BAKIM MODU OZELLIGININ OLUSTURULMASI-FALSE-TRUE MANTIGINDAKI SELECT OPTIONIN ELE ALINMASI
  Yani biz sitemizi bakim moduna alarak kullancilarin sadece bakim modu sayfasi gormesini saglayabiliriz, bakim modundan cikardigmizda da artik normal siteyi gormeye devam edebilirler
  Dolayisi ile bu islemi de biz tabi ki ayarlarimizda ekleyecegiz bunu admin/view/settings.php  de ekleyecegiz 

  SISTEMIMIZ HER ZAMAN SURDURULEBILIR OLMALDIR
  SIMBI BIR KEZ DAHA DIKKATIMIZI CEKIYOR VE BIZIM KURDGUMUZ SURDURULEBILIR SISTEM SAYESINDE SUREKLI YENILIKLERLE GELIYORUZ VE SISTEMIMIZ BUNA DIRENMIYOR SISTEMIZMIZ GELECEK YENILIKLERE TAMAMEN ACIK BIR SEKILDE YENILIKLERI KABUL EDIYOR.....HEP MANTIK BU SEKILDE OLMALI BU HARIKA BIRSEYDIR.... 


    <li>
        <label >Is Maintenance Mode Open</label>
        <div class="form-content">
            <select name="settings[maintenance]" value="<?= setting("maintenance") ?>">
            <option value="">--choose mode--</option>
            
        <option <?= (setting("maintenance") == true ? "selected":false) ?> value="<?= 1; ?>"><?php echo "Open"; ?> </option>
        <option <?= (setting("maintenance") == false ? "selected":true) ?> value="<?= 0; ?>"><?php echo "Close"; ?> </option>
                
            </select>
        </div>
    </li>

Ardindan cms/index.php ye geliyoruz ki burda ne yapiyorduk hatirlayalim, biz burda route() ile 0. index in controller daki ilk element, 1.index inde controller dan sonra gelecek olan element oldugnu ayarlamistik...   yani ana sistemi burda kurmustuk 
Admin sayfasinda isek maintenanci gostermsin bize, cunku admin olarak bizim yontememiz lazim bakim modu vs herseyi, maintenance mode sadece son kullanici icin gecerli olacak bir durum olacaktir

if(setting("maintenance")==true && route(0)!="admin"){
    $route[0]="maintenance";
}

Ardiindan app/controller altinda 
maintenance.php dosyasi olustururuz

<?php 
He template e ait ayri bakim modu olmasinda 1 tane bakim modu olsun sadece
require PATH."/app/view/maintenance-mode.php";
 
Ve app/view/maintenance-mode.php olusturuzz...
Burda dikkat edersek son kullanici nereye girerse girsin eger site bakim modunda ise hep bakim modu sayfasina gidecek o sekilde ayarladik

Birde bakim modunun title i ile, aciklamasini da kendine ozel admin de alan olusturarak olusturalim... 

O zaman admin/view/settings.php ye gideriz 

ul yi biz maintenance modunun uzerinde bitirecek sekilde yukari alip tekrar yeni bir ul acarak onun icerisine maintenance bolumu ve en alttaki button u da ayri bir ul icerisine yerlestirecegiz
   <ul>

        <li>
        <label >Is Maintenance Mode Open?</label>
        <div class="form-content">
            <select name="settings[maintenance]" value="<?= setting("maintenance") ?>">
            <option value="">--choose mode--</option>
            
        <option <?= (setting("maintenance") == true ? "selected":false) ?> value="<?= 1; ?>"><?php echo "Open"; ?> </option>
        <option <?= (setting("maintenance") == false ? "selected":true) ?> value="<?= 0; ?>"><?php echo "Close"; ?> </option>
                
            </select>
        </div>
    </li>

    <li>
            <label >Maintenance title</label>
            <div class="form-content">
                <input type="text" name="settings[maintenance-title]" value="<?= setting("maintenance-title"); ?>" id="maintenance-title">
            </div>
        </li>
        <li>
            <label >Maintenance description</label>
            <div class="form-content">
            <textarea name="settings[maintenance-description]" id="maintenance-description" cols="30" rows="10"><?= setting("maintenance-description"); ?></textarea>
            </div>
        </li>
    </ul>

    Ardindan app/view/maintenance-mode.php ye gideriz
    ve degerleri dinamik olarak admin de settings.php de girilen degerleri dinamik olarak ordan cekeriz... 

    <title><?php echo setting("maintenance-title"); ?></title>
</head>
<body>
    <h2><?php echo setting("maintenance-title"); ?></h2>
    <p>
    <?php echo setting("maintenance-description"); ?>
    </p>
</body>
?>

TEMA DOSYALARININ ENTEGRE EDILMESI 
CMS ICIN BOOTSTRAP ILE HAZIRLANMIS BIR TEMAMIZ VAR ONUN ENTEGRASYONUNU GERCEKLESTIRECEGIZ

Bir html temasini nasil parclariz, header,footer,content bunlari nasil yonetiriz bunlari ogrencegiz
tema dosyalarini 183.Tema Dosyalari Entegresi dersinin kaynak dosyalarindan erisebiliriz
Biz bu tema uzerinden sistemimizi yazdiktan sonra baska temalari da entegre ederek ihtiyaca gore baska ozellikler gerekiyorsa onlari da ekleyecegiz
1-Temanin assets klasorlerinin projemizde o temaya ait assets dosyalarini yerlestirecegimzi yere tasiriz
Oncelikle cms/public dosyasi altinda, bizim css,js,images, gibi assets dosyalarimiz bulunyor , temanin assets klasoru icindeki dosyalarin hepsini cms/public/udemy-v1 altina tasiyaagiz,
public/udemy-v1 altindaki style.css dosyasi ni da siliyoruz artik

2-temanin ana index.php dosyasini alip bizim projedeki udemy-v1 app/view/udemy-v1/index.php icerisiine kopyaliyoruz ayni sekilde 

tema index.php sini app/view/udemy-v1/index.php sine aldiktan sonra 
bu sayfada head icinde ki dahil edecegizm 1 tane css dosyasi var mi onu dahil edelim 

    <!-- <link rel="stylesheet" href="assets/styles/main.css"> -->
    <link rel=""  href="<?= public_url("styles/main.css") ?>">
   
  diger dosyalara baktgimz da hepsi cdn dosyalari yani bizim serverimizda barnmayan dosyalardir, sadece main.css imiz bizim serverimizda barniniyor  

  COK DIKKAT ETMEMIZ GEREKEN BIR DURUM!!! 
HERZAMAN ICIN HEADER-CONTAINER-FOOTER BIRBRINDEN BAGIMSIZ OLACAK VE 
OZLLIKLE CONTAINER I BIR KAC PARCAYA DA BOLEBILIRIZ AMA CONTAINER DA DINAMIKLESME UZERINE COK CALISACAGIZ.... 

Simdi burda temada soyle birsey yapilmis container ile footer ayni parent icerisinde birbiri icine girmis bir skeilde hazirlanmis, biz ise hemen footer  i kesip onun icinde kendi icinde oldugu parentinin ayni class olarak container diyerek ayri bir div icinde yazarak footeri bagimsiz hale getirdik ve tasariminda bozulmamasini saglamis olduk

Simdi app/view/udemy-v1 tema klasorumuz altinda static ismindee bir folder-klasor olsutururuz
static klasoru altina header.php ve footer.php yi olustururuz

ANA SAYFADA YANI SON KULLANICIYA SUNACAGIMZ ANA SAYFADA NELERI BIZ ADMIN SAYFASINDAN YONETEBILIRIZ
Oncelikle, ana temamiz yani son kullanicinin gorecegi ana syafada yani app/view/ altindaki aktif olan temamiz su an udemy-v1 in altindaki index.php oluyor yani 
burda title, description ve keywords var ise keywordsler adminpage den gelecek onlari zaten yapmistik ama bunu nasil kullancagiz ana tema icerisinde

BESTPRACTISE...DAHA YONETILEBLIR BIR SISTEM KURMAK
app/controller/index.php ye geliriz
burda ne yapiyoruz dikkat edelim, burda biz app altindaki view altindaki temamiza ait index.php mizin gelmesini saglayan fonksiyonu yazmistik... 


$meta=[
"title"=>setting("title"),
"description"=>setting("description"),
"keywords"=>setting("keywords")
];
require view("index");

app/view/udemy-v1 altinda static de header da title,description ve keywordsleri i $meta degiskeninden cekebiliriz
app/view/udemy-v1/static/header.php 

 <title><?php echo $meta["title"]?></title>
 artik dinamik olarak cms/admin/view/index.php den title deigsitirnce son kullanicinin oldugu app/view/udemy-v1/ temasinda bunu gorebilecegiz
 
 header.php

 <title><?php echo $meta["title"]?></title>
    <?php if(isset($meta["description"]))  ?>
    <meta name="description" content="<?=$meta["description"] ?>">
 
    <?php if(isset($meta["keywords"]))  ?>
    <meta name="keywords" content="<?=$meta["keywords"] ?>">   

app/view/udemy-v1 de    index.php mize gelir
mausu saga tiklayip show resource kaynagi goruntule dersek meta descriptionimzin geldigni gorebilriz
<title>Adem Erbas web-site</title>
    <meta name="description" content="This website is on the maintenance mode!">
    <meta name="keywords" content="TEST33">

Burda dikkat edersek title i zorunlu olarak yaptik, ama description ve keywordsu optional olarak yaptik 

LOGOMUZU DA GENEL AYARLARDA OLUSTURUP ON TARAFTA SON KULLANICI DA ONU ADMIN PANELINDEN ALACAK SEKILDE DINAMIK YAPALIM
Once nereye gidiyoruz 

admin/view/settings.php ye 
submit button in hemen uzerinde .... 

 <h1>Theme Settings</h1>
    <ul>
        <li>
        <label >Logo Title</label>
            <div class="form-content">
            <input type="text" name="settings[logo-title]" value="<?= setting("logo-title"); ?>" id="logo-title">
            </div>
        </li>
    </ul>
    <ul>    
        <li class="submit">
            <input type="hidden" name="submit" value="1"/>    
            <button type="submit">Save Changes</button>
        </li>
          </ul>    

Bu sekilde yapinca artik, logo-title i da app/settings.php deki settings datamiz icerisine yazmis oluyoruz ve de artik bu logo-title ayarini da app/view/udemy-v1/static/header.php de kullanabiliriz

<a class="navbar-brand" href="#"><?= setting("logo-title");?></a>

Artik database den aldigmiz logo bilgisini de son kullaniciya dinamik bir sekilde gosteriyoruz

BESTPRACTISE... 
BURDA SIMDI YAPILANLARA COK IYI DIKKAT EDELIM....NE YAPIYORUZ TAM OLARAK.. TAM OLARAK YAPTGIMZ ISLEM SUDUR ASLINDA 
SON KULLANICIMZA SUNDUGUMUZ WEB SITEMIZI TAMAMEN KENDI KONTROLUMUZE ALACAK BIR SISTEM KURUYORUZ YANI KULLANICIYA SUNDUGMUZ HERSEYI DINAMIK BIR SEKILDE YONETEBILECEK SEKILDE SUNABILYOURZ... MANTIGI IYI KAVRARSAK DETAYLAR DAHA IYI OTURUR... 
YAPTGIMIZ ISLEMIN HICBIRISINI EZBERE YAPMAYALIM... 
YANI BIZ DATA ILE UGRASIYORUZ DATALARI COK IYI YONETMMELIYIZ ADMIN KULLANICISINI GIRDIGI TUM DATALARI BIZ COK KOLAYCA ALARAK SON KULLANICI YA SUNAAGMIZ WEB-SITESINDE KULLANABILMEYI HEDEFLYORUZ... MANTIGIMZ BU... 
BENZER MANTIGI FRONT-END DINAMIK ISLEMLERINDE DE YAPACAGIZ ORDA DA, SON KULLANICILAIRIMZIN YAPACAGI TUM INTERAKTIF ISLEMLERI GIRECEGI DATALARI TIKALYARAK YAPMIS OLDUGU EYLEMLERIN HEPSINI DATLAARIMIZ ILE YONETECEGIZ KONTROL EDECEGIZ YANI USER FRONT-ENDDE HERHANGI BIR SEY YAPTIGI ZAMAN BIZ O YAPILAN ISLEMI ARKADA DATAMIZ ILE KONTROL EDIP O KULLANICIYA YAPMAK ISTEDGI INTERAKTIFLIGI SAGLAYACAGIZ... ISTE ANA MATNGIMIZ ASLINDA BIRBIRINE COK YAKIN.... 

DEVAM EDELIM VE APP/VIEW/UDEMY-V1 ALTINDAKI SON KULLANICIYA GOSTERDIGMIZ TEMADAKI ARAMA KISMINI DA ADMINDEN YONETMEK ISTIYORUZ.... 
ADMIN/VIEW/SETTINGS.PHP YE GELELIM

Theme settings icin actimiz ul etiketi icinde 
  <li>
    <label >Search Input Placeholder</label>
    <div class="form-content">
    <input type="text" name="settings[search-placeholder]" value="<?= setting("search-placeholder"); ?>" id="logo-title">
    </div>
  </li>


app/view/udemy-v1/static/header.php de arama ksimina
<form class="form-inline my-2 my-lg-0">
<input class="form-control mr-sm-2" type="search" placeholder="<?=setting("search-placeholder") ?>" aria-label="Search">
<button class="btn btn-outline-light my-2 my-sm-0" type="submit">Ara</button>


app/view/ de tema header imizda
Simdide logo muza tiklayinca sitenini url ine gitmesni saglayacagiz.. 

 <div class="container">
<a class="navbar-brand" href="<?= site_url(); ?>"><?= setting("logo-title");?></a>
zaten paramtreyi bos birakinca ana syfayai gidiyordu

BIRAZ DA  FOOTER A GECELIM FOOTER I DINAMIKLESTIRMEYE BASLAYALIM.... 
app/view/ de tema footer imizda bu sefer tersten yapiyoruz 
reverse engineering-intentional programming...
Yani once olusturmak istedigmz veya kullancagimz islemi yaziyoruz sonra arkada gidip onun detaylarini yaziyoruz... 

 <div class="col-12 col-md pr-5">
    <h5><?php echo setting("about")?></h5>
    <p class="small">
        <?= setting("about-description")?>
    </p>
</div>

 <li>
    <label >About</label>
        <div class="form-content">
        <input type="text" name="settings[about]" value="<?= setting("about"); ?>" id="about">
        </div>
    </li>
    <li>
    <label >About description</label>
        <div class="form-content">
        <textarea name="settings[about-description]" id="about-description" cols="30" rows="10"><?= setting("about-description"); ?></textarea>                   
        </div>
    </li>

    Bircok ayar daha ekledik header.php,footer.php ve index.php ile ilgili ama bu ayarlar nerdeyse birbirinin aynisi oludugu icin, bunlari ayri ayri yazmadik 

    SIGN-UP SAYFASININ YAPILMASI
    Temamizin sayfalari arasinda kayit-ol.html,giris-yap.html sayfalari var

    kayit-ol.html de giris-yap ve kayit ol diye en ussteki kisimda dropdown class i ile baslayan divi alarak, ana temamiizin header i icinde form etiketinin kapandigi yere yapistiririz

          <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Giriş Yap
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#">Giriş Yap</a>
                    <a class="dropdown-item" href="#">Kayıt Ol</a>
                </div>
            </div>

            header da ki form a da mr-3 class ini ekleriz 
header.php de login,signup linkleri de yazilir 

            <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Giriş Yap
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="<?=site_url("login"); ?>">Login</a>
                <a class="dropdown-item" href="<?=site_url("signup"); ?>">Signup</a>
            </div>

 SIMDI NE OLUP BITTIGINI TEKRARDAN ANLAYALIM.....
 SU ANDA LOGIN VEYA SIGNUP A TIKLAYINCA NE GELIYOR KARSIMIZA           

 http://localhost/test/php-cms-project/cms/login
 http://localhost/test/php-cms-project/cms/signup

 Controller Not Found
 geliyor neden cunku cms den sonraki login ve signup $route un 0.indexleridir ve 

 cms/index.php de 

 require (controller(route(0)));
boyle birsey oldugu icin, 0.index ornegin

app.php de biz 


function controller($controllerName){
    $controllerName=strtolower($controllerName);
   //PATH config.php icinde constant olarak root path i proje pathini veriyordu
   //PATH="C:.....test/php-cms-project/cms/"; 
   return PATH."/app/controller/".$controllerName.".php";
}
C:..../cms/app/controller/ parametreye ne veriliyorsa o en sona geliyordu ve de yani gidiyor app/controller da ariyor.. bu girilen uzantidaki .php dosyasi var mi diye ve biz login.php ve signup.php olusturmadigmiz icin.. bulamiyor tabi ki... ondan dolayi burayi iyi anlayalim..... bizim on yuzde cms den sonra herhangi bir sayfa uzantisi girdigi zaman onu app/controller altinda arayacaktir... 

function route($index){
    global $route;
     return isset($route[$index]) ? $route[$index] : false;
}

O zaman ne yapacagiz gidi app/controller altinda login.php ve signup.php sayfalarimiz i olusturalim
Peki biz controller altindaki sayfalarda hangi sayfayi cagiriyorduk tabi ki, temamizi cagiriyorduk ordan... yani app/view altindaki temamizi cagiriyorduk.... yani sistmei bu sekilde kurmustuk...ki daha yonetilebilir bir sistem olusturmak icin herseyin yeri ayri idi...

<?php 
$meta=[
    "title"=>"Sign Up"
];
require view("register");

Yani biz contrtoller altinda cagiraagmzi sayflari require edecegiz ve de ayrica o sayfalar ile ilgili spesifik data vs islemleri de yine buralarda ele alarak cok temiz bir yapi kurmus olyoruz... Yani kurulan yapi harika bir sekilde yeni gelen degisikliklere hic direnmeden isliyor...Iste asil bu projede ogrenilecek onemli noktalardan bir tanesi boyle bir sistem kurabilmektir

Ve de gidip app/view/altinda register.php sayfasi olusturacagiz.. 
VE yine ustte altta header.php ve footer php yi koyduktan sonra, gidip tema dan kayit-ol.html den container altinda sadece kayit ol formunu kapsaayan kismi alip app/view/udemy-v1/register.php sayfamiza yapistiririz... 

Simdi register.php syafamizi olustrduk, burdan veritabanina gidelim ve 1 tane users isminde tablo olusturacagiz cms veritabanimzin altinda

users isminde tablo yaptgimz icin diger tablolara ait degerlerle karismamasi icin 
user_id,user_name,user_url,user_email,user_password,user_date
seklinde kolonlarimizi yerlestriyoruz

BESTPRACTISE.... 
Simdi de register.php de form input name lerimizi degistiririz
Ve birde en son button umuzun hemen ustune bir type i hidden olan,name i submit olan ve value si "1" olan bir input koyariz ki butonumuz tiklanmis mi tiklanmamis mi burdan daha pratik kontrol edebilecegiz.... VE burda gondercegimz value bilgilerini ayrica daha spesifik islemlerde de duruma gore kullanabiliyoruz

<input type="hidden" name="submit" value="1">
        <button type="submit" class="btn btn-primary">Kayıt Ol</button>

BESTPRACTISE... 
STRUCTURE I IYI ANLAYALIM... VE DOGRU YAPI KURMANIN NE KADAR ETKILI OLDUGUNU BILELIM... PROJEYI BUYUTMEDE        
SIMDI BIZIM ON YUZDE KI TEMALARIMZI KOYDGUMUZ VE GOSTERDIGMZ YER TABI KI APP/VIEW/UDEMY-V1/REGISTER.PHP 
PEKI BURDASKI DOSYALARIMZ ILE ILGILI LOGIC LERI YAZDGIMZ YER NERESI IDI BU TA APP/CONTROLLER/REGISTER.PHP 

BU DOSYA YAPISI VE HER ISLEMIN YAPILACAGI YERIN BIRBIRINDEN AYRI OLMASI VE PROJE YI YENILIKLER GELDIKCE KOLAYCA YONETEBILMEK ISIN DOGRUSU EN AZ IYI KOD YAZMAK PROBLEMLERE COZUM BULMAK KADAR ONEMLDIR......  

REGISTER FORMUNDA GIRILEN DATALARIN KONTROLUNU BACKENDDE YAPMAK, BACKEND VALIDATION YAPMAK-BESTPRACTISE


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

    }
}

EMAIL IMIZI DE PHP INBUILD METHODU ILE CHECK EDEBILIYORUZ DOGRU FORMATTA MI DIYE... 
elseif(!filter_var($email,FILTER_VALIDATE_EMAIL))

PEKI OLUSTURDGUMUZ HATA MESAJINI NASIL EKRANA BASACAGIZ SIMDI ONA BAKALIM..... COK ONEMLI..BESTPRACTISE BURASI COOK ONEMLI...
APP/VIEW/UDEMY-V1/REGISTER.PHP 

BESTPRACTISE...ERROR-SUCCESS MESAJLARINI VERILMESI
BUNUN ICIN HELPER/TEMPLATE A GIDIP ORDA ERROR VE SUCCESS MESAJLARI
 ICIN BIRER METHODU OLUSTURURUZ
 Helper/Template

 function error(){
    global $error;
    return $error ?? false;
    //return isset($error) ? $error :false;
}
function success(){
    global $error;
    return $success ?? false;
    //return isset($success) ? $success :false;
}

ve BU FONKSIYONMLARIMIZI APP/VIEW/UDEMY-V1/REGISTER.PHP DE


<div class="col-md-4">
    <form action="" method="post">
        <h3 class="mb-3">Register</h3>
    <?php if($err=error()): ?>
        <div class="alert alert-danger" role="alert">
        <?= $err ?>
        </div> 
        <?php endif;?>   
        <?php if($success=success()): ?>
        <div class="alert alert-success" role="alert">
        <?= $err ?>
        </div> 
        <?php endif;?>


 TAYFUN ERBILEN IN YAZDIGI FONKSIYONLARDA VE PHP DE KI PROJELERDE OLAYA BAKIS ACISINDAN SUNU ANLIYORUZ, PHP KULLANIMINDA COK FAZLA, DETAYLI VE DAGINIK CALISMAMIZA SEBEP OLAN DETAYLAR VAR VE DE COK FAZLA SYNTAX I BOYLE ENTERESAN _ ALTCIZGILER VS VS GIBI SEYLER COK FAZLA VE ADAM BU TARZ ISLEMLREIN HEPSI ICIN O KADAR GUZEL OKUNABLIR FONKSIYONLAR LA BU ISLEMLERI HEP ARKADA TUTUP ON TARAFTA BOYLE GOZE HOS GELEN, OKUNABILIR VE COK GUZEL GOZUKEN BIR SISTEM YAPMISSS BENCE HARIKA BIR DUSUNCE VE YAKLASIM....COK BEGENDIM BEN....       

cmd/app/controller/register.php... de

MUKEMMEL BESPTRACTISE...HARIKA.... 
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
SIMDI BURDA ILK OLARAK AYNI USERNAME VEYA AYNI EPOST ILE KAYIT VAR MI ONA BAKARIZ VAR ISE AYNI USERNAME VEYA EPOST ADRSI ILE KAYIT YAPMAYIZ VE BIR MESAJ DONERIZ 

SELECT query with positional placeholders
$query=$db->prepare("SELECT * FROM users where user_name = ? || user_email= ?");
$query->execute(["$username,$email]);

SELECT query with named placeholders
$query=$db->prepare("SELECT * FROM users where user_name = :username || user_email= :email");
$query->execute([":username"=>$username, ":email"=>$email]);
$row=$query->fetch(PDO::FETCH_ASSOC);//dizi olarak dondursun diye FETCH_ASSOC kullaniyoruz

//Eger boyle bir member var ise hata mesaji yazdiracgiz
if($row){
    $error="This username or email is already in use, please try to another one";
}else{
    Eger $row yok ise demekki boyle bir username veya email de bir uyem, kullanicim yok o zaman artk bu kullaniciyi eklemeliyiz

VERITABANIMIZA BIZ PASSWORDU HASHLEYEREK KAYDETMEMLIYIZ BUU COOK ONEMLIDR.
$hash=password_hash($password,PASSWORD_DEFAULT);

Veritabanindaki user_url SEF(SEO-ENGINE-FRIENDLY) demektir, tayfun-erbilen sitesi icinde permalink diye bir coklu dile uygun sef-link yapimi icin bir fonksiyon var o fonksiyonu alip kullanabiliiriz.. permalink fonksiyonunu helper/app.php ye aliyoruz sonra kullanaagiz..Oraya norvecce karakterleri de ekledik
https://www.erbilen.net/php-sef-link-fonksiyonu/
$url=permalink($username);

//  $query=$db->prepare("INSERT INTO users(user_name,user_email,user_password) VALUES(?,?,?)");  

  $query=$db->prepare("INSERT INTO users SET user_name=?,user_url=?,user_email=?,user_password=?");  
  $values = [$username,$url, $email ,$hash];
  $result=$query->execute($values);
  if($result){
    $success="Your membership is created successfully, you are redirecting ";
    //Kullaniciyi 2 saniye sonra siteye yonlendirecegiz 
    header("Refresh:2,url=".site_url());
    Once successfull mesaji gorecek sonra hemen 2 saniye sonra da kullanicyi ana sayfaya yonlendirecek... 
    header("Location:site_url()"); direk yonlendir demek
    header("Refresh:2,url=".site_url());2 saniye sonra bu urle yonlendir demektir
    
  }else{
    Veritabani ile ilgili o anlik bir problem cikma durumunda veya, bizim insert islemindeki yzdimgiz degisken ismlerinde vs bir hata olusursa burya duser,sorgumuzda hata vardir demektir
    $error="An erro occured, please try again, later";
  }
}
    }
}

KULLANICI ONAYLI EMAIL REGISTER ISLEMI YAPILACAK ILERLEYEN ASAMALARDA.... 

BU ARADA KAYIT OL ISLEMI BU SEKILDE YAPARAK BITMIS OLMUYOR ILERDE EMAIL ENTEGRASYONU YAPACAGIZ VE KULLANICININ EMAIL INE BIR ONAY MAILI GIDECEK DAHAA SONRA KULLANICI ONAYLADIGI TAKDIRDE KAYDI GECERLI OLAACAK

KAYIT OLDUKTAN SONRA OTOMATIK GRIS YAPMA-LOGIN-LOGOUT SISTEMININ HAZIRLANMASI

tema dosyalarindan giris-yap.html dosyasini vs code de acip iceriisnden yine kodlari alip kullanacagiz


 CMS/APP/VIEW/LOGIN

<div class="container">
    <div class="row justify-content-md-center mt-4">
        <div class="col-md-4">
        <?php if($err=error()): ?>
        <div class="alert alert-danger" role="alert">
        <?= $err ?>
        </div> 
        <?php endif;?>   
        <?php if($succ=success()): ?>
        <div class="alert alert-success" role="alert">
        <?= $succ ?>
        </div> 
        <?php endif;?>

            <form action="" method="post" >
                <h3 class="mb-3">Login</h3>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" value="<?= post('username'); ?>" name="username" id="username"placeholder="Username...">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="<?= post('password'); ?>" class="form-control" id="password" placeholder="*******">
                </div>
                <input type="hidden" name="submit" value="login-action">
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>

SONRA CMS/APP/CONTROLLER/LOGIN

1-Dostum eger submit edilmis ise butun bu islemleri yap, yok ise hicbirsey yapma direk login forma devam et diyoruz dikkat edelim dogru anlayalim ezber yapmayalim....
2-EGer kullanici submite basar ve form alanlarini bos birakarak gonderir ise o alanlar bize empty, bos string olarak gelir, yani input lar da name ler atanmis ise o name ler key olarak post icerisine gelecektir ama, string olarak bos gelecektir ancak tabi ki bura da bir front-end validation kullaniciyi ilk olarak karsilamalidir....bu onemli...
if(post("submit")){
    $username=post("username");
    $password=post("password");

    if(empty($username)){//!$username
        $error="Username must be filled";
    }elseif(!$password){//empty($password)
        $error="Password must be filled";
    }else{
        //Artik, username ve password veritabaninda bulunup bulunmadigini kontrol edebiliriz 
     
        $query=$db->prepare("SELECT * FROM USERS WHERE user_name = ?");
        $query->execute([$username]);
        $row=$query->fetch(PDO::FETCH_ASSOC);
        //Eger boyle bir username var ise o zaman da passwordu checke edelim var mi diye
        if($row){
            $checkPassword=password_verify($password,$row["user_password"]);
            if($checkPassword){
                $success="You logged inn successfully, you are redirecting...";
                GIRIS YAPTIGIMIZA GORE ARTIK KULLANICI BILGILERINI SESSIONA ALABILIRIZ...COOK ONEMLI BU
                $_SESSION["user_id"]=$row["user_id"];
                $_SESSION["user_name"]=$row["user_name"];
  SEssionlarimizi eger bu sayfanin require edildigi herhangi bir sayfada teste edersek session bilgilierimizin geldigini gorebilirz hatta sayfamizi defalarca yenilesek bile sesssion bilgilerini yine de koruyacaktir silmeyecektir ne zamana kadar tarayici kapatilmayana kadar, yani tarayici kapanmadigi surece actimz oturum acik kalacaktir              
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


HARIKA BESTPRACTISE..... 
HEADER DA  DE ISE BESTPRACTISE BU DUZENLEMEYI YAPMALIYIZ..... COOK ONEMLI...

BIZ KULLANICI LOGIN DEN GIRDIGI DATALARI KONTROL EDIP BASARILI BIR SEKILDE GIRIS YAPTIKTAN SONRA ONUN BILGILERINDEN OZELLIKLE ID VE NAME GIBI BAZI BILGILERII SESSSIONA ATIYORUZ
SEssionlarimizi eger bu sayfanin require edildigi herhangi bir sayfada teste edersek session bilgilierimizin geldigini gorebilirz hatta sayfamizi defalarca yenilesek bile sesssion bilgilerini yine de koruyacaktir silmeyecektir ne zamana kadar tarayici kapatilmayana kadar, yani tarayici kapanmadigi surece actimz oturum acik kalacaktir    
 
helper/app  de asgidaki gibi bir fonksiyon yazariz

 function session($name){
  //  return isset($_SESSION[$name]) ? $_SESSION[$name] : false;
    return $_SESSION[$name] ?? false;
}

GIRIS YAPMIS KULLANICININ ISMINI DE HEADER DA  KULLANICI GIRIS YAPTIGI ZAMAN ARTIK LOGIN BUTONU YERINE KULLANICI ISMINI VE DROPDOWN OLARAK DA PROFILE VE LOGOUT GOSTERECEGTIZ AMA KULLANICI CIKIS YAPMIS ISE O ZAMAN DA ORDA YINE LOGIN BUTONU ALTINDA ISE SIGNUP VE SIGNIN BUTONU GOSTERILECEK


  <form class="form-inline my-2 my-lg-0 mr-3">
                <input class="form-control mr-sm-2" type="search" placeholder="<?=setting("search-placeholder") ?>" aria-label="Search">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Ara</button>
            </form>
                  <?php if(session("user_id")) : ?>
                    <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <?php echo session("user_name");?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?=site_url("profile"); ?>">Profile</a>
                    <a class="dropdown-item" href="<?=site_url("logout"); ?>">Logout</a>
                </div>
            </div> 
                 
                <?php else: ?>
                    <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Login
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="<?=site_url("login"); ?>">Login</a>
                    <a class="dropdown-item" href="<?=site_url("register"); ?>">Signup</a>
                </div>
            </div>
            <?php endif;?>   

          LOGOUT ISLEMININ YAPILMASI - HARIKA BESTPRACTISE
          APP/CONTROLLER/LOGOUT 
     LOGOUTN ISLEMI SADECE SESSION I SONLANDIRIP KULLANICIYI YONLENDIRME ISLMEI YAPACAGI ICIN LOGOUTN ILE ILGILI APP/VIEW ALTINDA HERHANGI BIR DOSYA OLMAYACAK SADECE CONTROLLER ALTINDA 1 LOGOUT DOSYASI OLACAK....    
     
     <?php 
session_destroy();
// header("Location:".isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : site_url());
header("Location:".$_SERVER["HTTP_REFERER"] ?? site_url());
//BURDA KULLANICIIYI GELDIGI  YERE GONDERIYORUZ EGER VAR ISE BIR GELDIGI YER YOK ISE O ZAMAN DA ANA SAYFAYA GONDERIYORUZ...BESTPRACTISE HARIKA BESTPRACTISE...YA
exit();//Burdan sonra kodumuz artik calismasin diye exit yaziyoruz

app/classess altinda User isminde bir class olusturup sesssion ekleme isini bu class a yaptirip app/controller altinda login.php de session ekleme islemini bu class ile yapalim manuel yapmak yerine

VE BU SESSION LARIMIZI EKLEME ISLEMI YAPAN USER CLASS INI DA HEM REGISTER HEM DE LOGIN BASARILI OLDUKTAN SONRA KULANACAGIZ

class User{

    //parametrye $data alsin bu $data session lari alsin
    public static function Login($data){
        $_SESSION["user_id"]=$data["user_id"];
        $_SESSION["user_name"]=$data["user_name"];
    }
}

APP/CONTROLLER/LOGIN.PHP DE 
 if($row){
            $checkPassword=password_verify($password,$row["user_password"]);
            if($checkPassword){
                $success="You logged inn successfully, you are redirecting...";
                //GIRIS YAPTIGIMIZA GORE ARTIK KULLANICI BILGILERINI SESSIONA ALABILIRIZ...COOK ONEMLI BU
                // $_SESSION["user_id"]=$row["user_id"];
                // $_SESSION["user_name"]=$row["user_name"];
                User::Login($row);         
                header("Refresh:2,url=".site_url());

            }else{
            $error="Your password doesn't fit, please check your password";
            }

APP/CONTROLLER/REGISTER.PHP DE 
BESTPRACTISE....REGISTER ISLEMINDE DE BIZ, ID MIZI $DB DEN LASTINSERTID YE ERISEREK ALIYORUZ...


$query=$db->prepare("INSERT INTO users SET user_name=?,user_url=?,user_email=?,user_password=?");  
  $values = [$username,$url, $email ,$hash];
  $result=$query->execute($values);
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

  REFACTORING....HARIKA BESPTRACTISE....YAPTGIMIZ ISLEMLERIN KALABALIKLIGINI CLASS ICINDE STATIC FUNCTION LAR OLUSTURARAK DAHA TEMIZ VE TEK SATIRLIK HALE GETIREBILIRIZ....BESTPRACTISE--userlclass icerisine yazdgimz refactoringi incelemeliyiz

APP/CONTROLLER/REGISTER DA


BURASININ YERINE
  $query=$db->prepare("INSERT INTO users SET user_name=?,user_url=?,user_email=?,user_password=?");  
  $values = [$username,$url, $email ,$hash];
  $result=$query->execute($values);

  USER class inda burayi olusturarak sonra asagidaki gibi daha kisa yazabiliriz... 

 public static function addUser($values){
        $query=$db->prepare("INSERT INTO users SET user_name=?,user_url=?,user_email=?,user_password=?");  
        return $query->execute($values);
    }


  $credentials = [$username,$url, $email ,$hash];
    $result=User::addUser($credentials);

    BENZER SEYI APP/CONTROLLER/LOGIN.PHP DE DE YAPARIZ

      // $query=$db->prepare("SELECT * FROM USERS WHERE user_name = ?");
        // $query->execute([$username]);
        // $row=$query->fetch(PDO::FETCH_ASSOC);
        $row=USER::findUserName($username);
       
MENU YONETIMININ HAZIRLANMASI!!!! 
186.Menu Yonetiminin Hazirlanmasi-1 kaynak dosyalarindan dosyalari indiririz
Ordaki dosyalarda admin-yeni-dosyalar altindaki manin.css i admin/public/styles/ altina kopyalariz   

Oncelikle admin panelimizde sidebar tarafina menu yonetimi diye bir menu yonetmi  ekleyecegiz... 

SU MANTIGI IYI ANLAYALIM SIMDI BIZ, ADMIN PANELINI AYARLARKEN HERSEY DEN ONCE BAZI DATALAR ELIMIZDE OLMALI EN BASTAN OLMASI GEREKEN DATALAR 
1-YA DIREK BIR .PHP DOSYASINDA HAZIR DIREK PHP DIZISIDIR VE ONU ALIP DINAMIK BIR SEKILDE KULLANIRIZ..(MANUEL BIR SEKILDE BIZ DE OLUSTURUYOR DA OLABILIRIZ)
2-YA O DATA VERITABANINDAN GELIR O DATAYI VERITABANINDAN CEKIP KULLANACAK BIR SISTEM KURARIZ 
3-YA DA BU DATA BIR DOSYA DA YAZILMISTIR BIZ BU DATAYI ALIP PARSE EDERIZ BIRTAKIM STRING  VE CHAR ISLEMLERI ILE VE KULLANABILECEK HALE GETIRIP ARDINDAN BIR DIZIYE ATARIZ VE O SEKILDE DATAMIZI ALIP KULLANIRIZ... 
4-TAMAMEN BASKA BIR SERVISDEN GELIYOR DA OLABILIRZ... BIR API VB SERVISLER DEN JSON OLARAK ALINP PHP YE CEVRIEBILRIR

PROJE TEMASINI INDIRIYORUZ 
https://github.com/tayfunerbilen/wp-admin-html-template
Burda posts.html var
content kismini asgida pagination kismina kadar aliriz
ve o kismi cms/admin/view menu.php nin content ksimina alacagiz


Front-end on yuzdeki normal menu yu ve alt menulerini tamamn dinamik yapacagiz ve bu menuleri ihtiyac olan her yerde kullanacagiz
header ve footer da kullanilan menu listelerini dinamik olarak ayarlayacagiz, amdin panelimizdeki menu yonetimi kismmindan
Simdi cms veritabanimizda menu isminde bir tablo olusturacagiz.. 
4 tane alani olacak 
menu_id(INT)
menu_title(VARCHAR): bu header menusu, footer menusu, sosial-media menusu gibi nereye ait menu ise onun title i olacak, yonetirken daha kolay olmasi icin 
menu_content(TEXT):Burda json formatinda tum menunun degeri tutulacak-
menu_date(TIMESTAMP):kaydedildigi tarih, olusturuldugu tarih 

Normalde wordpress te ornegin asagidaki gibi social media menusunde her bir link icin ayri ayri veritabani tablosunda tutuluyor ama biz asagidaki alani komple bir menu gibi dusunup, burdaki menuleri de json formatinda tuttacagz

Social Media
  facebook-icon ademErbas
  twitter-icon ademSkien
  instagram-icon adem54
  linkedin-icon  adem-developer

BU COK ISIMIZE YARAYABILIRZ...... 
  NOT..BU ARADA EGER CSS DOSYAMIZ HEADER.PHP YE GELMIYOR ISE ADMIN TARAFINDA O ZAMAN 
  CSS DOSYAMIZIN HER YUKLENMEDE YENILENMESINI SAGLAMAKK ICIN ASAGIDAKI METHOD IZLENEBILIR...BESTPRCTISE... 
     <!--styles-->
    <link rel="stylesheet" href="<?= admin_public_url("styles/main.css?v=".time()) ?>">
    CSS I CAGIRDIGMZ YERE
    function admin_public_url($url=false){
    return URL."/admin/public/".$url;
    http://localhost/test/php-cms-project/cms/admin/public/styles/main.css?v=1670168948;
    BU SEKILDE YAPARAK SUREKLI OLARAK en son daki get request in value  si olan time() degisecegi icin cunku anlik olarak o an timestamp modunda time kac ise onu verecegi icin dolayisi ile her seferinde yenilenecek 
    Yani yeni bir css dosyasi gibi okuyacagi icin degisiklikleri almasi daha kolay olacaktir
    HER SAYFA YENILENDIGINDE  UNIQ VE ORJINAL BIR DEGER GELMESI GEREKEN DURUMLARDA BU YONTEM GERCEKTEN HARIKA DIR BUNA COK IHTIYACIMIZ OLABILIR..... BESTPRACTISE.. v=time()

    cms/admin/view/add-menu.php de 
    Oncelikle biz 1 tane main menu 1 tane de submenu ekleyecek alan input alani ve label lari yerlestiriyoruz ve 1 tane submenu icin 
    addSubmenu, addMenu ve de Save gibi 3 tane de butonjmuz oluyor ve de ardinda da 

    form elementi altindaki tek ul altinda tuttugmz html elemntlerinden ul ye bir id veriyoruz 

     <ul id="menu">
     BU MANTIGI BILMEK COOK ONEMLIDIR.... BESTPRACTISE.... 
     PHP DE FRONT-END KISMINI DOGRUDAN JQUERY YA DA JAVASCRIPT KULLANIYORUZ VE DE DOGAL OLARAK BURDA ID UZERINDEN YURUYECEGIZ... YANI ONCE BIZ BIR ELEMNT ILE ILGILI ISLEM YAPARKEN O ELEMENT E ERISMEMIZ GEREKIYOR KI ARDINDAN O ELEMENT UZERINDEN HER TURLU ISLEMI YAPABILELIM DINAMIK OLARAK... EVENT HANDLING, VALUE SINI ELDE ETME, DOGRDDAN DINAMIK OLARAK CSS E DOKUNMA VS GIBI BIR SURU DINAMIK EFFEKTIF ISLEMLER YAPABILECEGIZ... 

     BESTRPACTISE--PHP ICINDE JQUERY KULLANIMI....COOOOK ONEMLI COK FAZLA IHTIYACIMZ OLACAK COOK ONEMLI!
     add-menu.php de en altta div in altinda script etiktleri acariz 

     menu ekle butonu ile ilgili bir interaktiff lik olacagi icin  menu ekle butonuna da bir id verecegiz 

     <a href="#" id="add-menu" class="menu-item-btn btn">Menü Ekle</a>
     
     <script>
    $(function(){//Bu ifade sayfam hazir oldugunda bende hazirim demek jquery de 

    })

    186.DERS MENU YONETIMININ HAZIRLANMASI...
    DERS DOSYALARI INDIRILIR menu html dosyasi icindeki kodlari kullanaagiz
</script>
}
*/





 

?>