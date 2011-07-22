<div class="r pagecontent">
<div class="vpad40" id="Container"> 
    <?php echo $form_location->startform(); ?>
        <table class="formcontainer">
            <tr>
                <td class="tar">Location Name<?php //echo $form_location->name->label(); ?></td>
                <td>
                    <?php echo $form_location->name->element(); ?>
                    <span class="form-error"><?php echo $form_location->name->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar">Upload Map<?php //echo $form_location->image->label(); ?></td>
                <td>
                    <?php echo $form_location->image->element(); ?>
                    <span class="form-error"><?php echo $form_location->image->error(); ?></span>
                    
                </td>
            </tr>
            
            <tr>
                <td class="tar"></td>
                <td><?php echo $form_location->submit->element(); ?></td>
            </tr>
        </table>
    <?php echo $form_location->endform(); ?>
</div>

<table class="vm10 datatable fullwidth">
            <tr>
                <th><input type="checkbox" /></th>
                <th>Location Name</th>
                <th>Map</th>
                <th>Actions</th>
            </tr>
            <?php foreach($table_locations as $table_location)
            {
            ?>
            <tr>
                <td><input type="checkbox" /></td>
                <td><?php echo $table_location->name; ?></td>
                <td><?php echo $table_location->image; ?></td>
                <td>
                    <p><a href="#">View/ Edit</a></p>
                    <p><a href="#" class="tRed">Delete</a></p>
                </td>
            </tr>
            <?php 
            }
            ?>
            <tr class="pagination">
                <td class="tar pagination" colspan="6">
                    <a href="#">&laquo;</a>
                    <a href="#">1</a>
                    <a href="#" class="selected">2</a>
                    <a href="#">3</a>
                    <a href="#">&raquo;</a>
                </td>
            </tr>
        </table>


    <!-- <table border="1">
        <?php 
        //foreach($table_locations as $table_location)
        //{
            
            
        ?>
        <tr>
            <td>
                <?php //echo $table_location->name; ?>
            </td>
            <td>
                <?php //echo $table_location->image; ?>
            </td>
        </tr>
        <?php 
        //}
            
        ?>
    </table>-->    

</div>