  
  <?php if($exams && (count($exams)>0)){?>
  <table class="vm10 datatable fullwidth">
        <tr>
            <th>
                Name
            </th>
            <th>
                Start
            </th>
            <th>
                End
            </th>
        </tr>
        
            <?php foreach($exams as $exam){ ?>
                <tr>
                    <td><?php echo $exam->name; ?> (<?php echo $exam->eventtype; ?>)</td>
                    <td><?php echo date('d M Y h:i A', $exam->eventstart) ?></td>
                    <td><?php echo date('d M Y h:i A', $exam->eventend) ?></td>
                </tr>
                
            <?php }?>
         </table>   
         <?php
         } else {
                echo "No records found";
         } ?>

