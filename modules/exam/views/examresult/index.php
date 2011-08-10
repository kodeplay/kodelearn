<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l">Marksheet</div>
        <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    
    <div class="sectionTitle">View Marksheet for</div>
    
    <ul>
        <?php if($examgroup){?>
            <?php foreach($examgroup as $group){ ?>
            <li class="vm10 "><a href="<?php echo URL::base() . 'exammarksheet/details/examgroup_id/' . $group->id ?>"><?php echo $group->name?></a></li>
            <?php }?>
        <?php 
        }else{
            echo "No marksheets found";
        }
        ?>
    </ul>
    
</div>