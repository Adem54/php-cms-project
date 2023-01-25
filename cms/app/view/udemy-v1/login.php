
<?php require("static/header.php");?>

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

<?php require("static/footer.php");?>