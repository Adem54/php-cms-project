<?php require("static/header.php");?>
<!-- CONTAINER-DYNAMIC START -->
<div class="row justify-content-md-center mt-4">

<div class="container">
<div class="row justify-content-md-center mt-4">

<div class="col-md-4">
    <form action="" method="post">
        <h3 class="mb-3">Register</h3>
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
        <!-- <div class="alert alert-success" role="alert">
            Başarılı mesajı örneği..
        </div>
        <div class="alert alert-danger" role="alert">
            Hata mesajı örneği..
        </div> -->
        <div class="form-group">
            <label for="username">UserName</label>
            <input type="text" class="form-control" value="<?= post('username'); ?>" name="username" id="username" placeholder="Username....">
        </div>
        <!-- <div class="form-group">
            <label for="user-url"></label>
            <input type="user-url" class="form-control" id="user-url" placeholder="Url...">
        </div> -->
        <div class="form-group">
            <label for="email">E-post</label>
            <input type="text" class="form-control" value="<?= post('email'); ?>" name="email" id="email"placeholder="E-post....">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" value="<?= post('password'); ?>"  name="password" id="password" placeholder="*******">
        </div>
        <div class="form-group">
            <label for="password">Password Again</label>
            <input type="password" class="form-control" value="<?= post('password-again'); ?>" name="password-again" id="password-again" placeholder="*******">
        </div>
       <input type="hidden" name="submit" value="1">
        <button type="submit" class="btn btn-primary">Kayıt Ol</button>
    </form>
</div>

</div>
</div>
<!-- CONTAINER-DYNAMIC END-->
<?php require("static/footer.php");?>
