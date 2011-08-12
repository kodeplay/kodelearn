<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l"><?php echo $examgroup->name; ?><span id="roleOf"></span></div>
        <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <?php if ($success) {  ?>
    <div class="formMessages good">     
        <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
        <span class="clear">&nbsp;</span>
    </div>
    <?php } ?>
    <?php if ($warning) { ?>
    <div class="formMessages bad">
        <span class="fmIcon bad"></span> 
        <span class="fmText"><?php echo $warning; ?></span>
        <span class="clear">&nbsp;</span>
    </div>
    <?php } ?>
    <div class="buttons">
        <a href="<?php echo $csv_import; ?>" class="button">CSV Import</a>   
        <a class="button" onclick="$('#examresult-edit-form').submit();">Save</a>
        <a href="<?php echo $csv_import; ?>" class="button">Cancel</a>        
    </div>
    <form id="examresult-edit-form" method="post" action="<?php echo $edit_form_action; ?>">
        <table class="vm10 datatable fullwidth">
            <tr>
                <th>Student</th>
                <?php $exam_seq; ?>
                <?php foreach ($exams as $exam) { ?>
                <?php $exam_seq[] = $exam->id; ?>
                <th><?php echo $exam->name . '<br/> Out of: ' . $exam->total_marks; ?></th>
                <?php } ?>
            </tr>        
            <?php foreach ($results as $result) { ?>
            <tr <?php echo $result['invalid'] ? 'class="bad"' : ''; ?>>
                <td><?php echo $result['name']; ?></td>
                <?php 
                    foreach ($exam_seq as $e) { 
                        $ex_arr = $result['exam_marks'][$e];
                ?>
                <td>
                    <?php if ($ex_arr['student_applicable']) { ?>
                        <input type="text" name="result[<?php echo $e; ?>][<?php echo $result['user_id']; ?>]" value="<?php echo $ex_arr['marks']; ?>" />
                    <?php } else { ?>
                        n/a
                    <?php } ?>
                </td> 
                <?php } ?>
            </tr>
            <?php } ?>        
        </table>
        <input type="hidden" name="examgroup_id" value="<?php echo $examgroup->id; ?>" />
    </form>
    <div class="buttons">
        <a class="button" onclick="$('#examresult-edit-form').submit();">Save</a>
    </div>
</div><!-- content -->
