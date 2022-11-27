

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
                <li class="submit">
                    <input type="hidden" name="submit" value="1"/>    
                    <button type="submit">Save Changes</button>
                </li>
            </ul>
        </form>
        </div>
        </div>

    <?php require admin_view("static/footer");  ?>
