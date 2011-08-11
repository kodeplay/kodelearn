    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l"><?php echo $page_title; ?></div>
            <div class="pageDesc r"><?php echo $page_description; ?></div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <br/><br/>
        <div id="upcoming_exams">
            <div class="sectionTitle">Upcoming Exams</div>
            <ul>
                <?php foreach($exams as $exam) {?>
                <li <?php echo ($exam->event->eventstart < (time() + 86500))?'class="tGreen"':''?>><?php echo date('d M Y H:i ', $exam->event->eventstart)?> - <?php echo $exam->name?> - <?php echo Date::fuzzy_span($exam->event->eventstart); ?></li>
                <?php }?>
            </ul>
        </div>
        <br/><br/><br/>
        <div id="upcoming_exams">
            <div class="sectionTitle">Past Exams</div>
            <ul>
                <?php foreach($past_exams as $exam) {?>
                
                <li> <?php echo $exam->name?> 
                    <ul>
                        <?php if($marks = $exam->examresult->where('user_id', '=', $user_id)->find()->marks){ ?>
                            <li <?php echo ($marks < $exam->passing_marks)?'class="tRed"':'class="tGreen"'?>>Scored: <?php echo $marks ?> out of <?php echo $exam->total_marks ?></li>
                        <?php } else {?>
                            <li>Result not declared Yet</li>
                        <?php }?>
                    </ul>
                </li>
                <?php }?>
            </ul>            <br/>
            <div class="r"><?php echo HTML::anchor('exammarksheet', 'View Marksheet'); ?></div>
        </div>
        
    </div>