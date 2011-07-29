    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l">Exam Groups</div>
            <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        
        <div class="topbar">
            <?php echo $links['add_examgroup']?>
            
            <a onclick="$('#examgroup').submit();" class="pageAction r alert">Delete selected...</a>
            <span class="clear">&nbsp;</span>
        </div><!-- topbar -->
        
        <form name="examgroup" id="examgroup" method="POST" action="<?php echo $links['delete'] ?>">
        <table class="vm10 datatable fullwidth">
            <?php echo $table['heading'] ?>
            <tr class="filter" >
                 <td></td>
                 <td><input type="text" name="filter_name" value="<?php echo $filter_name ?>" /></td>
                 <td valign="middle"><a class="button" onclick="filter();">Filter</a></td>
            </tr>
            <?php foreach($table['data'] as $examgroup){ ?>
            <tr>
                <td><input type="checkbox" name="selected[]" class="selected" value="<?php echo $examgroup->id ?>" /></td>
                <td><?php echo $examgroup->name;  ?></td>
                <td>
                    <p><?php echo Html::anchor('/examgroup/edit/id/'.$examgroup->id, 'View/Edit')?></p>
                </td>
            </tr>
            <?php  } ?>
            <tr class="pagination">
                <td class="tar pagination" colspan="5">
                    <?php echo $pagination ?>
                </td>
            </tr>
        </table>
        </form>
        
    </div><!-- content -->
    
    <div class="clear"></div>
<script type="text/javascript"><!--
function filter() {
    url = '<?php echo $filter_url; ?>';
    var filter_name = $('input[name=\'filter_name\']').attr('value');
    
    if (filter_name) {
        url += '/filter_name/' + encodeURIComponent(filter_name);
    }
    
    location = url;
}
//--></script>