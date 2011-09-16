<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<div class="pagecontent one_column">
    <div class="pageTop withBorder bm10">
        <div class="pageTitle l w60">Calendar</div>
        <div class="pageDesc r">
           
        </div>
        <div class="clear"></div>           
    </div><!-- pageTop --> 
    <div class="pad5 mt10" id="calendar-jumper">
        <label>Jump To: </label>        
        <select name="jump_month">                   
            <?php foreach ($months as $n=>$m) { ?>             
            <option value="<?php echo $n; ?>" <?php echo ((int)$month == (int)$n ? 'selected="selected"' : ''); ?>><?php echo $m; ?></option>
            <?php } ?>
        </select>
        &nbsp;&nbsp;
        <select name="jump_year">
            <?php foreach ($years as $y) { ?>
            <option value="<?php echo $y; ?>" <?php echo ($year == $y ? 'selected="selected"' : ''); ?>><?php echo $y; ?></option>
            <?php } ?>
        </select>&nbsp;&nbsp;
        <select name="event_type">
        	<option value="">All</option>
        	<option value="lecture">Lecture</option>
        	<option value="exam">Exam</option>
        </select>
        <a class="button" id="jumper_go">Go</a>
        <a id="current_day" class="calandar-today crsrPoint round5 h6 bold">Today</a>
    </div>     
    <div class="l w69 pad5" id="calendar-wrapper">
        <?php echo $calendar; ?>
    </div>
    <div class="r w29" id="day-events">
        <?php echo $day_events; ?>
    </div>  
</div>
<div class="lightoverlay" id="maps"> 
	<a href="#" class="ui-dialog-titlebar-close ui-corner-all" role="button"><span class="ui-icon ui-icon-closethick r">close</span></a>
	<div>
	Hi, I am Jimit
	</div>
</div>
        
