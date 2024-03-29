

<?php require admin_view("static/header");  ?>

<!--SETTINGS CONTENT -->
<div class="content">
<div class="box-">
        <h1>
            Settings
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <div class="box-">
        <form action="" method="POST" class="form label">
            <ul>
                <li>
                    <label >Site Title</label>
                    <div class="form-content">
                        <input type="text" name="settings[title]" value="<?= setting("title"); ?>" id="title">
                    </div>
                </li>
                <li>
                    <label >Site Description</label>
                    <div class="form-content">
                        <input type="text" name="settings[description]" value="<?= setting("description"); ?>" id="description">
                    </div>
                </li>
               
                <li>
                    <label >Site Keywords</label>
                    <div class="form-content">
                        <input type="text" name="settings[keywords]" value="<?= setting("keywords"); ?>" id="keywords">
                    </div>
                </li>
                <li>
                    <label >Site Themes</label>
                    <div class="form-content">
                        <select name="settings[theme]" value="<?= setting("theme") ?>">
                        <option value="">--choose theme--</option>
                        <?php foreach($themes as $theme):  ?>
                            <option <?= (setting("theme") == $theme ? "selected":null) ?> value="<?=  $theme ?>"><?php echo $theme ?> </option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </li>
                </ul>
                       <h1>Maintenance Settings</h1>     
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
            <h1>Theme Settings</h1>
            <ul>
                <li>
                <label >Logo Title</label>
                    <div class="form-content">
                    <input type="text" name="settings[logo-title]" value="<?= setting("logo-title"); ?>" id="logo-title">
                    </div>
                </li>
                <li>
                <label >Search Input Placeholder</label>
                    <div class="form-content">
                    <input type="text" name="settings[search-placeholder]" value="<?= setting("search-placeholder"); ?>" id="search-placeholder">
                    </div>
                </li>
               

                <li>
                <label >Welcome Title</label>
                    <div class="form-content">
                    <input type="text" name="settings[welcome-title]" value="<?= setting("welcome-title"); ?>" id="welcome-title">
                    </div>
                </li>
                <li>
                <label >Welcome description</label>
                    <div class="form-content">
                    <textarea name="settings[welcome-description]" id="welcome-description" cols="30" rows="10"><?= setting("welcome-description"); ?></textarea>                   
                    </div>
                </li>

                <li>
                <label >About description</label>
                    <div class="form-content">
                    <textarea name="settings[about-description]" id="about-description" cols="30" rows="10"><?= setting("about-description"); ?></textarea>                   
                    </div>
                </li>
                <li>
                <label >Facebook</label>
                    <div class="form-content">
                    <input type="text" name="settings[facebook]" value="<?= setting("facebook"); ?>" id="facebook">
                    </div>
                </li>
                <li>
                <label >Twitter</label>
                    <div class="form-content">
                    <input type="text" name="settings[twitter]" value="<?= setting("twitter"); ?>" id="twitter">
                    </div>
                </li>
                <li>
                <label >Instagram</label>
                    <div class="form-content">
                    <input type="text" name="settings[instagram]" value="<?= setting("instagram"); ?>" id="instagram">
                    </div>
                </li>
                <li>
                <label >Linkedin</label>
                    <div class="form-content">
                    <input type="text" name="settings[linkedin]" value="<?= setting("linkedin"); ?>" id="linkedin">
                    </div>
                </li>
            </ul>
            <ul>    
                <li class="submit">
                    <input type="hidden" name="submit" value="1"/>    
                    <button type="submit">Save Changes</button>
                </li>
          </ul>    

          
        </form>
        </div>
        </div>

    <?php require admin_view("static/footer");  ?>
