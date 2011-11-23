<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l"><?php echo __('Exercises'); ?></div>
        <div class="pageDesc r"><?php echo __('All exercises for this course will be listed here. Exercises are created from question banks'); ?></div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <div class="topbar">
        <?php if (Acl::instance()->is_allowed('exercise_delete')) { ?>
        <a onclick="$('#exercise').submit();" class="pageAction r alert">Delete selected...</a>
        <?php } ?> 
        <?php if (Acl::instance()->is_allowed('question_create')) { ?>
        <?php echo $links['add']; ?>
        <?php } ?> 
    </div>
    <?php if ($success) {  ?>
        <div class="formMessages w90">     
        <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
        <span class="clear">&nbsp;</span>
        </div>
    <?php } ?>
    <?php 
        $edit_permissions = Acl::instance()->is_allowed('exercise_edit');
        $attempt_permissions = Acl::instance()->is_allowed('exercise_attempt');
    ?>
    <form name="exercise" id="exercise" method="POST" class="selection-required" action="<?php echo $links['delete'] ?>">    
        <table class="vm10 datatable fullwidth">
        <?php echo $table['headings'] ?>
        <?php if ($table['total']) { ?>
        <?php foreach ($table['data'] as $exercise) { ?>
        <tr>
            <td><input type="checkbox" class="selected" name="selected[]" value="<?php echo $exercise->id ?>" /></td>
            <td><?php echo $exercise->title; ?></td>
            <td><?php echo $exercise->format; ?></td>
            <td class="tac"><?php echo $exercise->num_questions(); ?></td>
            <td class="tac"><?php echo $exercise->marks(); ?></td>
            <td class="tac"><?php echo $exercise->pub_status ? __('Published') : __('Unpublished'); ?></td>
            <td>
                <?php if ($exercise->is_attempted()) { ?>
                    <table>
                    <?php foreach ($exercise->attempts() as $attempt) { ?>
                        <tr>
                            <td><?php echo $attempt->date_repr(); ?></td>
                            <td><?php echo  $attempt->to_link(); ?></td>
                        </tr>
                    <?php } ?>
                    </table>
                <?php } else { ?>
                    <?php echo __('Not attempted'); ?>
                <?php } ?>
            </td>
            <td class="tac">
                <?php if ($edit_permissions) { ?>
                <a href="<?php echo Url::site('exercise/edit/id/'.$exercise->id); ?>">Edit</a>&nbsp;
                <?php } ?>
                <?php if ($attempt_permissions) { ?>
                    <a href="<?php echo Url::site('exercise/start/id/'.$exercise->id); ?>">Attempt</a>                    
                <?php } ?>
            </td>
        </tr>        
        <?php } ?>
        <?php } else { ?>        
        <tr>
            <td colspan="8" align="center">
                No Records Found
            </td>
        </tr>
        <?php } ?>
        </table>
    </form>
</div><!-- content -->
<div class="clear"></div>
