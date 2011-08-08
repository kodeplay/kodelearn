<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l">Marksheet</div>
        <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    
   
     <table class="vm10 datatable fullwidth">
            <tr> 
                 <th>Exam</th>
                 <th>Marks Obtained</th>
                 <th>Total Marks</th>
                 <th>Passing Marks</th>
            </tr>
            <?php foreach($marksheets as $marksheet){ ?>
            <tr>
                <td>
                    <?php
                        echo $name = $marksheet->name; 
                    ?>
                </td>
                <td>
                    <?php echo $marksheet->marks; ?>
                </td>
                <td>
                    <?php echo $marksheet->total_marks; ?>
                </td>
                <td>
                    <?php echo $marksheet->passing_marks; ?>
                </td>
                 
            </tr>    
            <?php 
            }
            ?>
            
        </table>
    </div><!-- pagecontent -->
    
<div class="clear"></div>
</div>
