    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l">Upoad User CSV</div>
            <div class="pageDesc r"><?php echo $page_description; ?></div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <?php if($error){ ?>
        <div class="formMessages">     
                <span class="fmIcon bad"></span> <span class="fmText" ><?php echo $error['warning']?></span>
                <br/><br/><?php echo $error['description']?>
            <span class="clear">&nbsp;</span>
        </div>
        <?php } else if($success){  ?>
        <div class="formMessages">     
            <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
            <span class="clear">&nbsp;</span>
        </div>
        <?php } ?>
        <?php echo $form->startform(); ?>
            <table class="formcontainer">
                <tr>
                    <td><?php echo $form->role_id->label(); ?></td>
                    <td><?php echo $form->role_id->element(); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->batch_id->label(); ?></td>
                    <td>
                        <?php echo $form->batch_id->element(); ?>
                        <p class="tip">You can select multiple batches.</p>
                    </td>
                </tr>
                <tr>
                    <td><label>CSV File</label></td>
                    <td><input type="file" name="csv" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo $form->save->element(); ?>
                    <p class="vm40"><?php echo $links['sample'] ?></p></td>
                </tr>
            </table>
        <?php echo $form->endForm(); ?>
    </div><!-- pagecontent -->
    
    <div class="clear"></div>
        