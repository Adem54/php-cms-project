

<?php require admin_view("static/header");  ?>

<!--content-->
<div class="content">

    <div class="box-">
        <h1>
          Menu Manangement
            <a href="<?= admin_site_url("add-menu") ?>">Add New</a>
        </h1>
    </div>

    <div class="clear" style="height: 10px;"></div>

    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>Menu Title</th>
                    <th class="hide">Insert Date</th>
                  
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>
                       
                     
                    </td>
                    <td>
                       <span class="date">21 hours ago</span>
                     
                    </td>
               
                    <td>
                       <a href="#" class="btn">Edit</a>
                       <a href="#" class="btn">Delete</a>
                    </td>
                </tr>
             
            </tbody>
        </table>
    </div>
</div>

<?php require admin_view("static/footer");  ?>
