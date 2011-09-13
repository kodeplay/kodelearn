    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l w60">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <?php echo $form->startform(); ?>
        <table class="formcontainer bm40">
            <tr>
                <td><?php echo $form->name->label(); ?></td>
                <td><?php echo $form->name->element(); ?>
                <span class="form-error"><?php echo $form->name->error(); ?></span></td>
            </tr>
            <tr>
                <td class="vatop"><?php echo $form->description->label(); ?></td>
                <td><?php echo $form->description->element(); ?>
                <span class="form-error"><?php echo $form->description->error(); ?></span></td>
            </tr>
            
            <tr>
                <td></td>
                <td>
                    <?php echo $form->save->element(); ?>
                    <span class="r">
                        <?php echo $links['cancel']?>
                    </span>
                </td>
            </tr>
        </table>
        <?php echo $form->endForm(); ?>
        
    </div><!-- content -->
    
    <div class="clear"></div>
