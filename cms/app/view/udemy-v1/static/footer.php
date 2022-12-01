
<!-- FOOTER--> 
<div class="container">
<div class="row">
        <div class="col-md-12">
            <footer class="pt-4 my-md-5 pt-md-5 border-top">
                <div class="row">
                    <div class="col-12 col-md">
                        <img class="mb-2" src="https://getbootstrap.com/assets/brand/bootstrap-solid.svg" alt=""
                             width="24" height="24">
                        <small class="d-block mb-3 text-muted">© 1993-2018</small>
                    </div>
                    <div class="col-12 col-md">
                        <h5>Features</h5>
                        <ul class="list-unstyled text-small">
                            <li><a class="text-muted" href="#">Cool stuff</a></li>
                            <li><a class="text-muted" href="#">Random feature</a></li>
                            <li><a class="text-muted" href="#">Team feature</a></li>
                            <li><a class="text-muted" href="#">Stuff for developers</a></li>
                            <li><a class="text-muted" href="#">Another one</a></li>
                            <li><a class="text-muted" href="#">Last time</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md pr-5">
                        <h5>About</h5>
                        <p class="small">
                           <?= setting("about-description")?>
                        </p>
                    </div>
                    <div class="col-12 col-md">
                        <h5>Social Media</h5>
                        <ul class="list-unstyled text-small">
                         
                            <?php if($facebook=setting("facebook"))  ?>
                            <li><a class="text-muted" href="<?="https://facebook.com/".$facebook; ?>"><i class="fab fa-facebook-square"></i>&nbsp;&nbsp; <?= $facebook?></a>
                            </li>
                            <?php if($twitter=setting("twitter"))  ?>
                            <li><a class="text-muted" href="<?="https://twitter.com/". $twitter; ?>"><i class="fab fa-twitter-square"></i>&nbsp;&nbsp;<?=$twitter ?></a>
                            </li>
                            <?php if($instagram=setting("instagram"))  ?>
                            <li><a class="text-muted" href="<?="https://instagram.com/". $instagram; ?>"><i class="fab fa-instagram"></i>&nbsp;&nbsp;<?=$instagram ?> </a></li>
                            <?php if($linkedin=setting("linkedin"))  ?>
                            <li><a class="text-muted" href="<?="https://linkedin.com/". $linkedin; ?>"><i class="fab fa-linkedin"></i>
                            &nbsp;&nbsp;<?=$linkedin ?> </a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>

</div>
</body>
</html>