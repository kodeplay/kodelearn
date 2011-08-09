<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l"><?php echo $examgroup->name; ?><span id="roleOf"></span></div>
        <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <div class="buttons">               
        <a class="button saveAcl" onclick="$('#examresult-edit-form').submit();">Save</a>
        <a href="#" class="button">Cancel</a>        
    </div>
    <form id="examresult-edit-form" method="post" action="<?php echo $edit_form_action; ?>">
        <table class="vm10 datatable fullwidth">
            <tr>
                <td>Student</td>
                <?php $exam_seq; ?>
                <?php foreach ($exams as $exam) { ?>
                <?php $exam_seq[] = $exam->id; ?>
                <td><?php echo $exam->name . '<br/> Out of: ' . $exam->total_marks; ?></td>
                <?php } ?>
            </tr>        
            <?php foreach ($results as $result) { ?>
            <tr>
                <td><?php echo $result['name']; ?></td>
                <?php foreach ($exam_seq as $e) { ?>
                <td><input type="text" name="result[<?php echo $e; ?>][<?php echo $result['user_id']; ?>]" value="<?php echo $result['marks'][$e]; ?>" /></td>
                <?php } ?>
            </tr>
            <?php } ?>        
        </table>
    </form>
    <div class="buttons">
        <a class="button saveAcl" onclick="$('#examresult-edit-form').submit();">Save</a>
    </div>
</div><!-- content -->
