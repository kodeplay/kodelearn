<div class="pageTop withBorder hpad10">
    <div class="w60 pageTitle l">Change Password</div>
    <div class="w30 pageTitle l"></div>
</div><!-- pageTop -->

<div class="vpad40 l">
    <p class="tdBlue bm40">Change your password</p>
    <?php echo $display_msg; ?>
    <?php echo $form_changepassword->startform(); ?>
        <table class="formcontainer">
            <tr>
                <td class="tar"></td>
                <td>
                    <?php echo $name; ?>
                   
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form_changepassword->password->label(); ?></td>
                <td>
                    <?php echo $form_changepassword->password->element(); ?>
                    <span class="form-error"><?php echo $form_changepassword->password->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form_changepassword->confirm_password->label(); ?></td>
                <td>
                    <?php echo $form_changepassword->confirm_password->element(); ?>
                    <span class="form-error"><?php echo $form_changepassword->confirm_password->error(); ?></span>
                </td>
            </tr>            
            
            <tr>
                <td class="tar"></td>
                <td><?php echo $form_changepassword->change_password->element(); ?></td>
            </tr>
        </table>
        <?php echo $form_changepassword->endform(); ?>
     
</div><!-- suContainer -->



<div class="clear"></div>
