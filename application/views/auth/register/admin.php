     <?php echo $form->startform(); ?>
        <table class="formcontainer">
            <tr>
                <td class="tar"><?php echo $form->email->label(); ?></td>
                <td>
                    <?php echo $form->email->element(); ?>
                    <span class="form-error"><?php echo $form->email->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form->firstname->label(); ?></td>
                <td>
                    <?php echo $form->firstname->element(); ?>
                    <span class="form-error"><?php echo $form->firstname->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form->lastname->label(); ?></td>
                <td>
                    <?php echo $form->lastname->element(); ?>
                    <span class="form-error"><?php echo $form->lastname->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form->password->label(); ?></td>
                <td>
                    <?php echo $form->password->element(); ?>
                    <span class="form-error"><?php echo $form->password->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form->confirm_password->label(); ?></td>
                <td>
                    <?php echo $form->confirm_password->element(); ?>
                    <span class="form-error"><?php echo $form->confirm_password->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"></td>
                <td>
                    <?php echo $form->agree->element(); ?>&nbsp;
                    <?php echo $form->agree->label(); ?>
                    <span class="form-error"><?php echo $form->agree->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"></td>
                <td><?php echo $form->register->element(); ?></td>
            </tr>
        </table> <!-- formcontainer -->
        <?php echo $form->endForm(); ?>
