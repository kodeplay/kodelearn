<h2 class="h4 bold">Add the correct answer for your question.</h2>
<ol class="form-assist">    
    <li>Add the correct answer directly.</li>
    <li>In case there are multiple acceptable answers, seperate them using || (two pipe characters) <br/> eg. 3/2||1.5||$1.5</li>
</ol>
<?php if ($error_answer) {  ?>
<div class="formMessages w90">     
    <span class="fmIcon bad"></span> <span class="fmText" ><?php echo $error_answer; ?></span>
    <span class="clear">&nbsp;</span>
</div>
<?php } ?>
<table class="tm40 pad5cells w90">
    <tr>
        <td class="vatop"><label>Correct Answer</label></td>
        <td>
            <textarea name="attributes[answer]" class="w80"><?php echo $attribute['attribute_value']; ?></textarea>
        </td>
    </tr>
    <tr>
        <td class="vatop"><label>Explanation</label></td>
        <td>
            <textarea name="attributes[explain]" class="w80"><?php echo $attribute['explanation']; ?></textarea>
        </td>
    </tr>
</table>

