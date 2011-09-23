<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l w60">replace_here_page_title</div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    
    <?php 
        if($flg > 0) {
    ?>   
     <table class="vm10 datatable fullwidth">
            <tr> 
                 <th>Exam</th>
                 <th>Marks Obtained</th>
                 <th>Total Marks</th>
                 <th>Passing Marks</th>
            </tr>
             <?php 
            $marks_total = 0;
            $total_marks_total = 0;
            $passing_marks_total = 0; 
            ?>
            <?php foreach($marksheets as $marksheet){ ?>
           
            <tr>
                <td>
                    <?php
                        echo $name = $marksheet->name; 
                    ?>
                </td>
                
                <?php 
                    $marks = $marksheet->marks;
                    $marks_total = $marks_total + $marks;
                    if($marks < $marksheet->passing_marks)
                    {
                ?>
                    <td class="tRed">
                        <?php 
                            echo $marks;
                        ?>
                    </td>
                <?php 
                    } else {
                ?>
                    <td>
                        <?php 
                            echo $marks;
                        ?>
                    </td>
                <?php 
                    }
                ?>
                <td>
                    <?php 
                        $total_marks = $marksheet->total_marks; 
                        echo $total_marks; 
                        $total_marks_total = $total_marks_total + $total_marks;
                    ?>
                </td>
                <td>
                    <?php 
                        $passing_marks = $marksheet->passing_marks; 
                        echo $passing_marks; 
                        $passing_marks_total = $passing_marks_total + $passing_marks;
                    ?>
                </td>
                 
            </tr>    
            <?php 
            }
            ?>
            <tr>
                <td>
                    Total
                </td>
                <td>
                    <?php echo $marks_total; ?>
                </td>
                <td>
                    <?php echo $total_marks_total; ?>
                </td>
                <td>
                    <?php echo $passing_marks_total; ?>
                </td>
            </tr>
            <tr>
                <td>
                    Percentage
                </td>
                <td colspan="3">
                    <?php 
                        $percentage = ($marks_total * 100)/$total_marks_total;
                        echo round($percentage,2);
                    ?>%
                </td>
            </tr>
        </table>
        
     <?php 
        } else {
            echo "Marksheet not available";
        }
     ?>
    </div><!-- pagecontent -->
    
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function(){
	KODELEARN.modules.get('sidebar').highlight('exam');
});
</script>
