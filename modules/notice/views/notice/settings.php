<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l w60">replace_here_page_title</div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <div class="topbar">
        <?php require 'menu.php'; ?>
    </div><!-- topbar -->
    <?php if ($success) {  ?>
        <div class="formMessages w90">     
            <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
            <span class="clear">&nbsp;</span>
        </div>
    <?php } ?>
    <?php echo $form->startform(); ?>
    <table class="formcontainer tm40">
        <tr>
            <td><label for="status"><?php echo $form->status->label(); ?></label></td>
            <td><?php echo $form->status->element(); ?>
        </tr>
        <tr>
            <td><label for="sender_email"><?php echo $form->sender_email->label(); ?></label></td>
            <td><?php echo $form->sender_email->element(); ?>
            <span class="form-error"><?php echo $form->sender_email->error(); ?></span></td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $form->save->element(); ?></td>
        </tr>
    </table>
    <?php echo $form->endform(); ?>
    
</div><!-- pagecontent -->

<div class="clear"></div>
