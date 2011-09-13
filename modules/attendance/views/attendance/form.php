      <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l w60"><?php echo $page_title; ?></div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <div class="pageContent">
            <?php if($users){?>
            <div class="buttons">
                <a href="#" onclick="$('#attendance').submit();" class = "button">Save</a>
                <a href="<?php echo Url::site('attendance'); ?>" class = "button">Cancel</a>
            </div>
            <?php } ?>
           <form name="attendance" id="attendance" method="POST" action="<?php echo $data['add'] ?>">
            <?php if($users){?>
            <input type="hidden" name="id" id="id" value="<?php echo $data['event_id']; ?>">
            <input type="hidden" name="course_id" id="course_id" value="<?php echo $data['course_id']; ?>">
            <br/>
            <table class="vm10 datatable fullwidth">
            <tr>
                <th>
                    Name
                </th>
                <th>
                    <input type="checkbox" onclick="$('.selected').attr('checked', this.checked);" class="selected">Status
                </th>
                
            </tr>
            
                <?php foreach($users as $user){ ?>
                    <tr>
                        <td><?php echo $user->firstname." ".$user->lastname; ?></td>
                        <?php if($assigned_attendances){?>
                            <?php if(array_key_exists($user->id, $assigned_attendances) && $assigned_attendances[$user->id] == '1'){?>
                                <td><input class="selected" type="checkbox" value="<?php echo $user->id; ?>" name="selected[]" checked></td>
                            <?php } else {?>
                                <td><input class="selected" type="checkbox" value="<?php echo $user->id; ?>" name="selected[]"></td>
                            <?php }?>
                        <?php 
                        }else{
                        ?>
                            <td><input class="selected" type="checkbox" value="<?php echo $user->id; ?>" name="selected[]" checked></td>
                        <?php 
                        }
                        ?>
                    </tr>
                    
                <?php }?>
             </table>   
             <?php
             } else {
                    echo "No Students for this event";
             } ?>
            </form>
           
        </div>
    </div>    
    <div class="clear"></div>