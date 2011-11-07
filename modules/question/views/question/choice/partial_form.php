<h2 class="h4 bold">Add choices depending upon the type of question you wish to create.</h2>
<ol class="form-assist">    
    <li>Multiple Choice with one correct answer - Add multiple choices and specify which one is correct.</li>
    <li>Multiple Choice with multiple correct answers - Add multiple choices and specify which ones are correct.</li>
</ol>
<?php if ($error_choices) {  ?>
<div class="formMessages w90">     
    <span class="fmIcon bad"></span> <span class="fmText" ><?php echo $error_choices; ?></span>
    <span class="clear">&nbsp;</span>
</div>
<?php } ?>
<ul id="form-answer" class="form-blocks tm40">
    <?php if ($attributes) { ?>
    <?php foreach ($attributes as $attribute) { ?>
    <li>
        <table>            
            <tr>
                <td><label>Choice: </label></td>
                <td><input type="text" name="attributes[choice][]" value="<?php echo $attribute['attribute_value']; ?>" /></td>
            </tr>
            <tr>
                <td><label>Is it correct ?: </label></td>
                <td>
                    <select name="attributes[correct][]">
                        <option value="1" <?php echo ($attribute['correctness'] == '1' ? 'selected="selected"' : ''); ?>>Yes</option>
                        <option value="0" <?php echo ($attribute['correctness'] == '0' ? 'selected="selected"' : ''); ?>>No</option>                        
                    </select>                
                </td>
            </tr>
            <tr>
                <td class="vatop"><label >Explanation: </label></td>
                <td><textarea name="attributes[explain][]"><?php echo $attribute['explanation']; ?></textarea></td>
            </tr>                       
        </table>
        <div class="rm-block">x</div>
    </li>
    <?php } ?>
    <?php } ?>
</ul>
<a id="add-choice-btn" class="button r tm5">Add a choice</a>

<!-- the answer template which will be cloned and appended to the form  -->
<table id="answer-tmpl" style="display: none">
    <tr>
        <td><label>Choice: </label></td>
        <td><input type="text" name="attributes[choice][]" disabled="disabled"/></td>
    </tr>
    <tr>
        <td><label>Is it correct ?: </label></td>
        <td>
            <select name="attributes[correct][]" disabled="disabled">
                <option value="1">Yes</option>  
                <option value="0">No</option>                
            </select>                
        </td>
    </tr>
    <tr>
        <td class="vatop"><label >Explanation: </label></td>
        <td><textarea name="attributes[explain][]" disabled="disabled"></textarea></td>
    </tr>            
</table>
<script type="text/javascript">
$(document).ready(function () {
    $("#add-choice-btn").live('click', function () { 
        $tmpl = $("#answer-tmpl").clone();
        $tmpl.removeAttr('id').removeAttr('style');                 
        $tmpl.find('input').removeAttr('disabled');
        $tmpl.find('select').removeAttr('disabled');
        $tmpl.find('textarea').removeAttr('disabled');
        $("#form-answer").append($('<li><div class="rm-block">x</div></li>').append($tmpl));                
    });
    $("#form-answer>li").live('mouseover mouseout', function (event) {                 
        if (event.type == 'mouseover') {               
            if ($(this).siblings().length > 0) { 
                $(this).children().filter('.rm-block').show();
            }
        } else if (event.type == 'mouseout') {
            $(this).children().filter('.rm-block').hide();
        }
    });
});
</script>
