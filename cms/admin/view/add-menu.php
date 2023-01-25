
<?php require admin_view("static/header");  ?>

<style>

    input {
        width: 20%!important;
        margin: .4rem;
    }
    a.menu-item-btn{
        margin: .4rem;
        background-color: teal;
        color: #ffff;
    }
    .sub-menu {
        margin-left: 4rem;
        margin-top: 1rem;
        margin-bottom: 2rem;
    }

    .sub-menu-btn{
        margin-left: 4rem!important;
    }
   
    a.delete-menu .fa-times  {
       font-size: 1.4rem!important;
    }
</style>
<div style="">
    <h1>Menü Ekle</h1>
    <form action="" method="post">
        <ul id="menu">
            <li>
                <div class="menu-item">
                <h2>MainMenu</h2>
                    <a href="#" style="display:inline-block;" class="delete-menu">
                        <i class="fa fa-times"></i>
                    </a>
                    <input type="text" style="display:inline-block; width=50%;" placeholder="Menü Adı" />
                    <input type="text" placeholder="Menü Linki">
                </div>
                <div class="sub-menu">
                    <h2>SubMenu</h2>
                    <ul>
                        <li>
                            <div class="menu-item">
                                <a href="#" class="delete-menu">
                                    <i class="fa fa-times"></i>
                                </a>
                                <input type="text" placeholder="Menü Adı">
                                <input type="text" placeholder="Menü Linki">
                            </div>
                        </li>
                    </ul>
                    <a href="#" class="menu-item-btn sub-menu-btn btn">Alt Menü Ekle</a>
                </div>
               
            </li>
       
        </ul>
        <div class="menu-btn">
            <a href="#" id="add-menu" class="menu-item-btn btn">Menü Ekle</a>
            <button type="submit" value="1" name="submit">Kaydet</button>
        </div>
    </form>
</div>

<script>
    $(function(){//Bu ifade sayfam hazir oldugunda bende hazirim demek jquery de yani dom(dokumanim hazir oldugunda demk)
        $("#add-menu").on("click",function(e){
            e.preventDefault();//#add-menu bir a link elemnti oldugu icin default olarak tiklandiginda sayfayi yeniler bu default ozelligini kaldirmak icn tabi ki e.preventdefault kullanilir
            console.log(e.currentTarget);
        })
    })
</script>

<?php require admin_view("static/footer");  ?>
