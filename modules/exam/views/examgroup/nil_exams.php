<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l">Sorry, your request could not be completed</div>        
        <div class="clear"></div>
    </div><!-- pageTop -->
    <div class="formMessages bad">
        <span class="fmIcon bad"></span> 
        <span class="fmText">No exams were found for the grading period "<?php echo $examgroup->name; ?>"</span>
        <span class="clear">&nbsp;</span>
    </div>
    <p class="tm40">
        <a class="button" href="<?php echo $create_exam; ?>">Create</a> a new next exam for this grading period
    </p> 
    <p class="tm40">
        <a class="button" href="<?php echo $back_url; ?>">Go Back</a> to where you came from.
    </p>    
    </div><!-- content -->      
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function(){
	KODELEARN.modules.get('sidebar').highlight('exam');
});
</script>