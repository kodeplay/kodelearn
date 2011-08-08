    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l">Exams Schedule</div>
            <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <br/><br/>
        <div id="upcoming_exams">
            <div class="sectionTitle">Upcoming Exams</div>
            <ul>
                <?php foreach($exams as $exam) {?>
                <li <?php echo ($exam->event->eventstart < (time() + 86500))?'class="tRed"':''?>><?php echo date('d M Y H:i ', $exam->event->eventstart)?> - <?php echo $exam->name?> - <?php echo Date::fuzzy_span($exam->event->eventstart); ?></li>
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
                        <li>Scored: 24 out of <?php echo $exam->total_marks ?></li>
                    </ul>
                </li>
                <?php }?>
            </ul>            <br/>
            <div class="r"><a href="#">View Marksheet</a></div>
        </div>
        
    </div>