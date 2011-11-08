<h2 class="h4 bold">Add hints to help students who are struggling with the answers.</h2>
<ol class="form-assist">
    <li>Sort order - Order in which the hints will be shown to the user.</li>
    <li>Deduction - The percentage deduction in score that will happen if a student uses that hint.</li>    
</ol>
<ul id="form-hint" class="form-blocks tm40">
    <?php if ($hints) { ?>
    <?php foreach ($hints as $hint) { ?>
    <li>
        <table>            
            <tr>
                <td><label>Hint: </label></td>
                <td><input type="text" name="hints[hint][]" value="<?php echo $hint['hint']; ?>"/></td>
            </tr>
            <tr>
                <td><label>Sort Order: </label></td>
                <td><input type="text" class="w10" name="hints[sort_order][]" value="<?php echo $hint['sort_order']; ?>" /></td>
            </tr>
            <tr>
                <td><label >Marks Deduction: </label></td>
                <td><input type="text" class="w10" name="hints[deduction][]" value="<?php echo $hint['deduction']; ?>" /> %</td>
            </tr>                        
        </table>
        <div class="rm-block">x</div>
    </li>
    <?php } ?>
    <?php } ?>
</ul>
<a id="add-hint-btn" class="button r tm5">Add a hint</a>

<!-- the answer template which will be cloned and appended to the form  -->
<table id="hint-tmpl" style="display: none">
    <tr>
        <td><label>Hint: </label></td>
        <td><input type="text" name="hints[hint][]" disabled="disabled" /></td>
    </tr>
    <tr>
        <td><label>Sort Order: </label></td>
        <td><input type="text" class="w10" name="hints[sort_order][]" disabled="disabled" /></td>
    </tr>
    <tr>
        <td><label >Marks Deduction: </label></td>
        <td><input type="text" class="w10" name="hints[deduction][]" disabled="disabled" /> %</td>
    </tr>            
</table>
<script type="text/javascript">
$(document).ready(function () {
    $( "#tabs" ).tabs({ 'selected': 0 }); 
    new KODELEARN.helpers.Formblocks({
        listElem: '#form-hint',
        itemElem: '#form-hint>li',  
        addBtn: '#add-hint-btn',
        min: 1,
        onAdd: function () {
            $tmpl = $("#hint-tmpl").clone();
            $tmpl.removeAttr('id').removeAttr('style'); 
            $tmpl.find('input').removeAttr('disabled');
            $("#form-hint").append($('<li><div class="rm-block">x</div></li>').append($tmpl)); 
        }       
    });
});
</script>
