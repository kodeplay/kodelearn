<div class="pageTop withBorder hpad10">
    <div class="w60 pageTitle l">New User</div>
    <div class="w30 pageTitle l">Existing User</div>
</div><!-- pageTop -->

<div class="vpad40 l" id="suContainer">
    <p class="tdBlue bm40">Sign up and join KodeLearn Learning Management System</p>
    
     <?php echo $form_register->startform(); ?>
        <table class="formcontainer">
            <tr>
                <td class="tar"><?php echo $form_register->email->label(); ?></td>
                <td>
                    <?php echo $form_register->email->element(); ?>
                    <span class="form-error"><?php echo $form_register->email->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form_register->email_parent->label(); ?></td>
                <td>
                    <?php echo $form_register->email_parent->element(); ?>
                    <span class="form-error"><?php echo $form_register->email_parent->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form_register->firstname->label(); ?></td>
                <td>
                    <?php echo $form_register->firstname->element(); ?>
                    <span class="form-error"><?php echo $form_register->firstname->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form_register->lastname->label(); ?></td>
                <td>
                    <?php echo $form_register->lastname->element(); ?>
                    <span class="form-error"><?php echo $form_register->lastname->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form_register->password->label(); ?></td>
                <td>
                    <?php echo $form_register->password->element(); ?>
                    <span class="form-error"><?php echo $form_register->password->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form_register->confirm_password->label(); ?></td>
                <td>
                    <?php echo $form_register->confirm_password->element(); ?>
                    <span class="form-error"><?php echo $form_register->confirm_password->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form_register->batch_id->label(); ?></td>
                <td>
                    <?php echo $form_register->batch_id->element(); ?>
                    <span class="form-error"><?php echo $form_register->batch_id->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form_register->course_id->label(); ?></td>
                <td>
                    <?php echo $form_register->course_id->element(); ?>
                    <span class="form-error"><?php echo $form_register->course_id->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"></td>
                <td>
                    <?php echo $form_register->agree->element(); ?>&nbsp;
                    <?php echo $form_register->agree->label(); ?>
                    <span class="form-error"><?php echo $form_register->agree->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"></td>
                <td><?php echo $form_register->register->element(); ?></td>
            </tr>
        </table> <!-- formcontainer -->
        <?php echo $form_register->endForm(); ?>
</div><!-- suContainer -->

<div class="vpad40 l" id="lContainer">
    <p class="tdBlue bm40">Login to learn online</p>
    <?php echo $form_login->startform(); ?>
        <table class="formcontainer">
            <tr>
                <td class="tar"><?php echo $form_login->email->label(); ?></td>
                <td>
                    <?php echo $form_login->email->element(); ?>
                    <span class="form-error"><?php echo $form_login->email->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form_login->password->label(); ?></td>
                <td>
                    <?php echo $form_login->password->element(); ?>
                    <span class="form-error"><?php echo $form_login->password->error(); ?></span>
                    <p><a class="tdBlue bold" href="#">Forgot your password?</a></p>
                </td>
            </tr>
            <tr>
                <td class="tar"></td>
                <td><?php echo $form_login->remember->element() ?>&nbsp;<?php echo $form_login->remember->label(); ?></td>
            </tr>
            <tr>
                <td class="tar"></td>
                <td><?php echo $form_login->login->element(); ?></td>
            </tr>
        </table>
        <?php echo $form_login->endform(); ?>
</div><!-- lContainer -->

<div class="clear"></div>
