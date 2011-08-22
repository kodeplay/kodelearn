    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <div class="topbar">
            <a href="#" class="pageAction r alert">Delete selected...</a>
             <?php echo $links['add']?>
            <span class="clear">&nbsp;</span>
        </div><!-- topbar -->
        
        <table class="vm10 datatable fullwidth">
           <?php echo $table['heading']?>
           <?php foreach($table['data'] as $lecture){ ?>
            <tr>
                <td><input type="checkbox" /></td>
                <td><?php echo $lecture->name ?></td>
                <td><?php echo $lecture->course_name ?></td>
                <td><?php echo $lecture->firstname . ' ' . $lecture->lastname ?></td>
                <td><?php 
                    if($lecture->type == 'once'){
                        echo date('d M Y ', $lecture->start_date) . '<br/>';
                        echo date('h:i A ', $lecture->start_date) . ' - ' . date('h:i A ', $lecture->end_date);  
                    } else {
                        $days = unserialize($lecture->when);
                    ?>
                    <table>
                        <tr>
                            <td><?php echo date('d M Y ', $lecture->start_date) ?></td>
                            <td><?php echo date('d M Y ', $lecture->end_date) ?></td>
                        </tr>
                        <?php foreach($days as $day=>$time){ ?>
                        <?php $timing = explode(':',$time); ?>
                            <tr>
                                <td><?php echo $day ?></td>
                                <td><?php echo date('h:i A', strtotime(date('Y-m-d')) + ($timing[0] * 60)) .  ' to ' . date('h:i A', strtotime(date('Y-m-d')) + ($timing[1] * 60)) ?></td>
                            </tr>
                        <?php }?>
                    </table>
                    <?php }?>
                </td>
                <td>
                    <p><a href="#">View/ Edit</a></p>
                </td>
            </tr>
           <?php } ?>
            <tr class="pagination">
                <td class="tar pagination" colspan="6">
                    <?php echo $pagination ?>
                </td>
            </tr>
        </table>
    </div>
<?php 

/*
$days = array(
    'monday'    => '540:620',
    'tuesday'   => '590:710',
    'wednesday' => '800:920',
    'thursday'  => '750:950',
    'friday'    => '1000:1200',
    'saturday'  => '440:550',
    'sunday'    => '480:840',
);
echo '<pre>';
print_r($days);
echo (serialize($days));
echo '<br/> Every <br/>';
foreach($days as $day=>$time){
	$timing = explode(':',$time);
	echo $day . ' ---- ' . date('h:i A', strtotime(date('Y-m-d')) + ($timing[0] * 60)) .  ' to ' . date('h:i A', strtotime(date('Y-m-d')) + ($timing[1] * 60)) .  '<br/>';
}

echo '</pre>';
exit;
*/
?>    
    
    
    