<?php if(count($attendance['event_lectures']) > 0) { ?>
<div class="tm40 bold vpad10 tac bdTop bdBottom">Your attendance for lecture: <span id="attPerc"><?php echo round($attendance['lecture_persent'],2); ?></span>%</div>
        <table class="datatable vm smallTextBoxes fullwidth">
            <tr>
                <th class="w20">Date</th>
                <th>Lecture</th>
                <th>Attendance</th>
            </tr>
            <?php foreach($attendance['event_lectures'] as $event_lecture){ ?>
            <tr>
                <td><?php echo date('M d Y',$event_lecture->eventstart); ?></td>
                <td><?php echo $event_lecture->name; ?></td>
                <td>
                    <?php if($event_lecture->present == '1'){ ?>
                        <span class="attendanceBadge present">Present</span>
                    <?php } else if($event_lecture->present == '0'){?>
                        <span class="attendanceBadge absent">Absent</span>
                    <?php } else { ?>
                        NA
                    <?php } ?>    
                </td>
            </tr>
            <?php } ?>
            
        </table>
<?php } else {
    echo "No records for lecture";
    echo "<br>";
}
if(count($attendance['event_exams']) > 0){
?>
<div class="tm40 bold vpad10 tac bdTop bdBottom">Your attendance for exam: <span id="attPerc"><?php echo round($attendance['exam_persent'],2); ?></span>%</div>
        <table class="datatable vm smallTextBoxes fullwidth">
            <tr>
                <th class="w20">Date</th>
                <th>Exam</th>
                <th>Attendance</th>
            </tr>
            <?php foreach($attendance['event_exams'] as $event_exam){ ?>
            <tr>
                <td><?php echo date('M d Y',$event_exam->eventstart); ?></td>
                <td><?php echo $event_exam->name; ?></td>
                <td>
                    <?php if($event_exam->present == '1'){ ?>
                        <span class="attendanceBadge present">Present</span>
                    <?php } else if($event_exam->present == '0'){?>
                        <span class="attendanceBadge absent">Absent</span>
                    <?php } else { ?>
                        NA
                    <?php } ?>    
                </td>
            </tr>
            <?php } ?>
            
        </table>
 <?php } else { 
    echo "<br>"; 
    echo "No records for exam";    
     
 }?>
 

